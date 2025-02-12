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

    // Obtenemos el siguiente cliente basado en el ID mayor al actual
    $clienteSiguiente = $db->getClienteSiguiente($idActual);

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

    // Obtenemos el cliente anterior basado en el ID menor al actual
    $clienteAnterior = $db->getClienteAnterior($idActual);

    // Verificamos si el cliente anterior existe
    if ($clienteAnterior) {
        return $clienteAnterior;
    }

    return null;
}

// Imagen del cliente

function getClientPhoto(int $id): string
{

    $filePath = __DIR__ . '/../uploads/' . sprintf('%08d', $id) . '.jpg';
    $publicPath = 'app/uploads/' . sprintf('%08d', $id) . '.jpg';

    // Verifica si el archivo existe
    if (file_exists($filePath)) {

        return $publicPath;
    }

    // Si no existe el archivo, retorna una imagen por defecto
    return 'https://robohash.org/' . $id;
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
