<?php

require_once 'app/helpers/util.php';
require_once 'app/helpers/validator.php';

require_once 'app/config/configDB.php';

require_once 'app/models/Cliente.php';
require_once 'app/models/AccesoDatos.php';

require_once 'app/controllers/crudclientes.php';
require_once 'app/controllers/auth.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {

    $contenido = '';
    $msg = '';
    require_once "app/views/principal.php";
    require_once "app/views/login.php";
    exit();
    
}

//---- PAGINACIÓN ----

define('FPAG', 10); // Número de filas por página

$midb = AccesoDatos::getModelo();
$totalfilas = $midb->numClientes();
$totalPaginas = ceil($totalfilas / FPAG);

if (!isset($_SESSION['pagina'])) {

    $_SESSION['pagina'] = 1;

}

$pagina = isset($_SESSION['pagina']) ? $_SESSION['pagina'] : 1;

$_SESSION['msg'] = "";

ob_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (isset($_GET['orden'])) {

        switch ($_GET['orden']) {

            case "Nuevo":
                $_SESSION['form_data'] = '';
                crudAlta();
                break;
            case "Borrar":
                if (isset($_GET['id'])) crudBorrar($_GET['id']);
                break;
            case "Modificar":
                if (isset($_GET['id'])) crudModificar($_GET['id']);
                break;
            case "Detalles":
                if (isset($_GET['id'])) crudDetalles($_GET['id']);
                break;
            case "GenerarPDF":
                if (isset($_GET['id'])) crudGenerarPDF($_GET['id']);
                break;
            case "Terminar":
                session_destroy();
                header("Location: index.php");
                exit();
                break;
        }
    }
} else {

    if (isset($_POST['orden'])) {

        switch ($_POST['orden']) {
            case "Nuevo":
                crudPostAlta();
                break;
            case "Modificar":
                crudPostModificar();
                break;
        }

    }

}

if (isset($_GET['pag'])) {

    $_SESSION['pagina'] = $_GET['pag'];

}

$pagina = $_SESSION['pagina'];
$offset = FPAG * ($pagina - 1);
$limit = FPAG;

if (ob_get_length() == 0) {

    $db = AccesoDatos::getModelo();

    // Obtener el campo por el cual ordenar (por defecto 'id')
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'id';
    
    // Asegurarse de que la columna de ordenación es válida
    $columnas_validas = ['id', 'first_name', 'email', 'gender', 'ip_address', 'telefono'];
    
    if (!in_array($orden, $columnas_validas)) {

        $orden = 'id'; // Si el campo de orden es inválido, usar 'id' por defecto

    }

    $tclientes = $db->getClientes($offset, $limit, $orden);
    require_once "app/views/list.php";

}

$contenido = ob_get_clean();
$msg = $_SESSION['msg'];
require_once "app/views/principal.php";

?>