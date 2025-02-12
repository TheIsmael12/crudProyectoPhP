<?php

function crudBorrar($id)
{
    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol'] == 1) {

        // Si el rol es 1, permitir eliminación
        $db = AccesoDatos::getModelo();
        $resu = $db->borrarCliente($id);

        if ($resu) {

            $_SESSION['msg'] = "El usuario " . $id . " ha sido eliminado.";

        } else {

            $_SESSION['msg'] = "Error al eliminar el usuario " . $id . ".";

        }

    } else {

        // Redirigir a una página de acceso denegado
        $_SESSION['error'] = "No tienes permiso para eliminar.";
        header("Location: ?orden=Lista");
    
    }

}

function crudTerminar()
{
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta()
{
    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol'] == 1) {

        // Si el rol es 1, permitir alta
        $cli = new Cliente();
        $orden = "Nuevo";
        include_once "app/views/formulario.php";

    } else {

        // Redirigir a una página de acceso denegado
        $_SESSION['error'] = "No tienes permiso para crear nuevos usuarios.";
        header("Location: ?orden=Lista");

    }

}

function crudModificar($id)
{
    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol'] == 1) {

        // Si el rol es 1, permitir modificación
        $db = AccesoDatos::getModelo();
        $cli = $db->getCliente($id);
        $orden = "Modificar";
        include_once "app/views/formulario.php";

    } else {
        // Redirigir a una página de acceso denegado
        $_SESSION['error'] = "No tienes permiso para modificar.";
        header("Location: ?orden=Lista");
    }
}

function crudDetalles($id)
{
    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1) {

        // Solo puede ver los detalles
        $db = AccesoDatos::getModelo();
        $cli = $db->getCliente($id);
        include_once "app/views/detalles.php";
    } else {
        // Redirigir a una página de acceso denegado o a la lista de clientes
        $_SESSION['error'] = "No tienes permiso para ver detalles.";
        header("Location: ?orden=Lista");
    }
}

function crudPostAlta()
{
    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol'] == 1) {

        // Guardar los datos del formulario en la sesión antes de redirigir
        $_SESSION['form_data'] = $_POST;

        // Permitir el alta solo si el rol es 1
        limpiarArrayEntrada($_POST);

        // Inicializar el cliente
        $cli = new Cliente();
        $cli->first_name    = $_POST['first_name'];
        $cli->last_name     = $_POST['last_name'];
        $cli->email         = $_POST['email'];
        $cli->gender        = $_POST['gender'];
        $cli->ip_address    = $_POST['ip_address'];
        $cli->telefono      = $_POST['telefono'];

        $db = AccesoDatos::getModelo();
        $validator = new Validator($db);

        // Validar cliente
        $errors = $validator->validateClient([
            'email' => $cli->email,
            'ip' => $cli->ip_address,
            'phone' => $cli->telefono
        ]);

        if (!empty($errors)) {
            
            $_SESSION['error'] = "Errores al dar de alta al usuario: " . implode(', ', $errors);
            header("Location: ?orden=Nuevo");
            return;
        }

        $lastInsertId = $db->addCliente($cli);

        // Insertar el cliente en la base de datos
        if ($lastInsertId) {

            $_SESSION['msg'] = "El usuario " . $cli->first_name . " se ha dado de alta.";
            // Redirigir a la página principal
            header("Location: ?orden=Detalles&id=" . $lastInsertId);

        } else {

            $_SESSION['error'] = "Error al dar de alta al usuario " . $cli->first_name . ".";

        }

    } else {
        // Redirigir a una página de acceso denegado
        $_SESSION['error'] = "No tienes permiso para crear nuevos usuarios.";
        header("Location: ?orden=Lista");
    }
}

function crudPostModificar()
{
    limpiarArrayEntrada($_POST); // Evito la posible inyección de código

    $cli = new Cliente();
    $cli->id            = $_POST['id'];
    $cli->file          = $_POST['file'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];

    $db = AccesoDatos::getModelo();
    $validator = new Validator($db);

    // Validar cliente
    $errors = $validator->validateClient([

        'id' => $cli->id,
        'email' => $cli->email,
        'ip' => $cli->ip_address,
        'phone' => $cli->telefono

    ]);

    if (!empty($errors)) {

        $_SESSION['error'] = "Errores al modificar al usuario: " . implode(', ', $errors);
        header("Location: ?orden=Modificar&id=" . $cli->id);
        return;
    }

    if ($db->modCliente($cli)) {

        // Si la inserción fue exitosa, redirigir a los detalles del nuevo cliente
        $_SESSION['msg'] = "El usuario " . $cli->first_name . " ha sido modificado.";
        header("Location: ?orden=Detalles&id=" . $cli->id);
        exit;
    } else {

        // Si hubo un error al insertar
        $_SESSION['error'] = "Error al modificar al usuario " . $cli->first_name . ".";
        header("Location: ?orden=Modificar&id=" . $cli->id); // Redirigir al formulario de nuevo cliente
        exit;
    }
}

function crudGenerarPDF($id)
{

    // Incluir la librería TCPDF
    require_once('resources/tcpdf/tcpdf.php');

    // Obtener los detalles del cliente desde la base de datos
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);

    // Crear un objeto TCPDF
    $pdf = new TCPDF();

    // Establecer información del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema');
    $pdf->SetTitle('Detalles del Cliente');
    $pdf->SetSubject('PDF Detalles del Cliente');

    // Agregar una página
    $pdf->AddPage();

    // Establecer fuente
    $pdf->SetFont('helvetica', '', 12);

    // Título
    $pdf->Cell(0, 10, 'Detalles del Cliente', 0, 1, 'C');

    // Datos del cliente

    $pdf->Ln(5);
    $pdf->Cell(0, 10, 'ID: ' . $cli->id, 0, 1);
    $pdf->Cell(0, 10, 'Nombre: ' . $cli->first_name . ' ' . $cli->last_name, 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $cli->email, 0, 1);
    $pdf->Cell(0, 10, 'Género: ' . $cli->gender, 0, 1);
    $pdf->Cell(0, 10, 'Dirección IP: ' . $cli->ip_address, 0, 1);
    $pdf->Cell(0, 10, 'Teléfono: ' . $cli->telefono, 0, 1);

    // Ruta de la imagen del cliente
    $imagePath = getClientPhoto($cli->id); // Suponiendo que esta función devuelve la ruta de la imagen

    $pdf->Image($imagePath, 10, 100, 40, 50);  // Cambia las dimensiones según sea necesario

    // Generar el PDF
    $pdf->Output('detalle_cliente_' . $cli->id . '.pdf', 'I'); // 'I' para visualizar el PDF en el navegador

}
