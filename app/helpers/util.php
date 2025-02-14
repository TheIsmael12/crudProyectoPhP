<?php

// Funciones para limpiar la entrada de posibles inyecciones

function limpiarEntrada(string $entrada): string
{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}

// Función para limpiar todos elementos de un array

function limpiarArrayEntrada(array &$entrada)
{
    foreach ($entrada as $key => $value) {
        $entrada[$key] = limpiarEntrada($value);
    }
}

// Método para obtener el siguiente cliente

function obtenerSiguienteCliente($idActual)
{
    $db = AccesoDatos::getModelo();

    $orden = $_SESSION['orden'];
    $dir = $_SESSION['dir'];

    // Obtenemos el siguiente cliente basado en el ID mayor al actual
    $clienteSiguiente = $db->getClienteSiguiente($idActual, $orden, $dir);

    // Verificamos si el siguiente cliente existe
    if ($clienteSiguiente) {
        return $clienteSiguiente;
    }

    return null;
}

// Método para obtener el anterior cliente

function obtenerAnteriorCliente($idActual)
{
    $db = AccesoDatos::getModelo();

    $orden = $_SESSION['orden'];
    $dir = $_SESSION['dir'];

    // Obtenemos el cliente anterior basado en el ID menor al actual
    $clienteAnterior = $db->getClienteAnterior($idActual, $orden, $dir);

    // Verificamos si el cliente anterior existe
    if ($clienteAnterior) {
        return $clienteAnterior;
    }

    return null;
}

// Imagen del cliente

function getClientPhoto(int $id): string
{

    if (isset($id)) {


        $uploadDir = __DIR__ . '/../uploads/';
        $publicDir = 'app/uploads/';
        $fileName = sprintf('%08d', $id);

        // Verifica si el archivo existe
        $allowedExtensions = ['jpg', 'png'];

        foreach ($allowedExtensions as $ext) {

            $filePath = $uploadDir . $fileName . '.' . $ext;

            if (file_exists($filePath)) {

                return $publicDir . $fileName . '.' . $ext;
            }
        }

        // Si no existe el archivo, retorna una imagen por defecto
        return 'https://robohash.org/' . $id;
    }

    return false;
}

// Obtener flag

function getCountryFlag(string $ip): string
{
    $apiUrl = "http://ip-api.com/json/" . $ip;
    $response = @file_get_contents($apiUrl);

    if ($response) {

        $data = json_decode($response, true);

        if (isset($data['countryCode'])) {

            return "https://flagpedia.net/data/flags/icon/40x30/" . strtolower($data['countryCode']) . ".png";
        }
    }

    return "https://flagpedia.net/data/flags/icon/40x30/un.png";
}

// Subir imagen:

function subirImagen(array $file, int $id): ?string
{

    // Verifica si se ha recibido un archivo sin errores
    if (isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {

        $uploadDir = 'app/uploads/'; // Directorio donde se almacenarán las imágenes
        $tmpName = $file['tmp_name']; // Nombre temporal del archivo
        $fileName = sprintf("%08d", $id); // Nombre base del archivo sin extensión

        // Extensiones permitidas
        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        // Obtener el tipo MIME real del archivo
        $fileMimeType = mime_content_type($tmpName);

        // Verifica si el archivo es una imagen válida
        if (!array_key_exists($fileMimeType, $allowedMimeTypes)) {
            $_SESSION['error'] = "Tipo de archivo no permitido. Solo se permiten imágenes JPG y PNG.";
            return null;
        }

        // Definir la extensión correcta basada en el MIME type
        $fileExtension = $allowedMimeTypes[$fileMimeType];
        $uploadFile = $uploadDir . $fileName . '.' . $fileExtension;

        // Verifica el tamaño del archivo (menos de 500 KB)
        if ($file['size'] > 500 * 1024) {  // 500 KB en bytes
            $_SESSION['error'] = "El archivo excede el tamaño máximo permitido (500 KB).";
            return null;
        }

        // Eliminar cualquier archivo existente con el mismo nombre pero diferente extensión
        foreach (glob($uploadDir . $fileName . ".*") as $existingFile) {
            unlink($existingFile);
        }

        // Intenta mover el archivo desde su ubicación temporal al directorio final
        if (move_uploaded_file($tmpName, $uploadFile)) {
            return $uploadFile; // Retorna la ruta de la imagen si se subió correctamente
        } else {
            $_SESSION['error'] = "Error al cargar la imagen.";
        }
    }

    return null; // Si no se cargó ningún archivo o hubo algún error

}
