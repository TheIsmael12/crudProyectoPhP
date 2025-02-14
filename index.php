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

if (!isset($_SESSION['orden'])) {

    $_SESSION['orden'] = 'id';

}

if (!isset($_SESSION['dir'])) {

    $_SESSION['dir'] = 'asc';

}


$orden = isset($_SESSION['orden']) ? $_SESSION['orden'] : 'id';
$dir = isset($_SESSION['dir']) ? $_SESSION['dir'] : 'asc';

$pagina = isset($_SESSION['pagina']) ? $_SESSION['pagina'] : 1;

$_SESSION['msg'] = "";

ob_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {


    if (isset($_GET['orden'])) {

        switch ($_GET['orden']) {

            case "Nuevo":
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

if (isset($_GET['ordenar'])) {

    $_SESSION['orden'] = $_GET['ordenar'] ;
    $_SESSION['dir'] = ($_SESSION['dir'] ?? 'asc') === 'asc' ? 'desc' : 'asc';

}

$orden = $_SESSION['orden'];
$dir = $_SESSION['dir'];
$pagina = $_SESSION['pagina'];
$offset = FPAG * ($pagina - 1);
$limit = FPAG;

if (ob_get_length() == 0) {

    $db = AccesoDatos::getModelo();

    $tclientes = $db->getClientes($offset, $limit, $orden, $dir);
    require_once "app/views/list.php";

}

$contenido = ob_get_clean();
$msg = $_SESSION['msg'];
require_once "app/views/principal.php";

?>