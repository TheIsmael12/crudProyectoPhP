<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>CRUD CLIENTES</title>
    <link href="web/css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="web/js/funciones.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- OpenLayers CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v6.15.1/dist/ol.css" type="text/css">

    <!-- OpenLayers JS -->
    <script src="https://cdn.jsdelivr.net/npm/ol@v6.15.1/dist/ol.js"></script>

    <!-- FontAwesome 6 CDN (versión más reciente) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>

    <div id="container" class="mx-auto">

        <div id="header" class="text-center py-4">

            <h1>Proyecto Ismael versión 1.1</h1>

            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="d-flex justify-content-end p-2">
                    <a href="?orden=Terminar" class="btn btn-danger">Cerrar sesión</a>
                </div>
            <?php endif; ?>
            
        </div>

        <?php if ($msg): ?>
            <div class="container alert alert-primary d-flex align-items-center" role="alert">
                <div>
                    <?= $msg ?>
                </div>
            </div>
        <?php endif; ?>

        <div id="content">
            <?= $contenido ?>


        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>