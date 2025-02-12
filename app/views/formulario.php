<?php

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

// Recuperar datos del formulario de la sesión si existen
$form_data = $_SESSION['form_data'] ?? [];

?>

<div class="container my-5">

    <div class="d-flex justify-content-between mb-4">
        <h2>Editar cliente</h2>
        <button class="btn btn-primary" onclick="location.href='./'">
            Volver
        </button>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="d-grid gap-3">
        <!-- Imagen del cliente -->
        <div class="text-center mb-4">
            <label for="photo">Imagen:</label>
            <br>
            <img class="rounded" width="100" height="120" src="" alt="<?= $cli->first_name; ?> Photo">
            <input type="file" name="photo" />
        </div>

        <!-- Campos del formulario -->
        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" name="id" readonly value="<?= $cli->id ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" value="<?= isset($form_data['first_name']) ? $form_data['first_name'] : $cli->first_name; ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="last_name">Apellido:</label>
            <input type="text" id="last_name" name="last_name" value="<?= isset($form_data['last_name']) ? $form_data['last_name'] : $cli->last_name; ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($form_data['email']) ? $form_data['email'] : $cli->email; ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="gender">Género:</label>
            <input type="text" id="gender" name="gender" value="<?= isset($form_data['gender']) ? $form_data['gender'] : $cli->gender; ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="ip_address">Dirección IP:</label>
            <input type="text" id="ip_address" name="ip_address" value="<?= isset($form_data['ip_address']) ? $form_data['ip_address'] : $cli->ip_address; ?>" class="form-control" />
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?= isset($form_data['telefono']) ? $form_data['telefono'] : $cli->telefono; ?>" class="form-control" />
        </div>

        <!-- Botones de envío -->
        <div class="d-flex float-end">
            <input type="submit" name="orden" value="<?= $orden ?>" class="btn btn-primary btn-custom" />
        </div>

    </form>

    <?php
    if ($orden == "Modificar") {
    ?>

        <div class="d-flex justify-content-center mt-4">
            <?php
            // Obtener el cliente anterior y siguiente
            $clienteAnterior = obtenerAnteriorCliente($cli->id);
            $clienteSiguiente = obtenerSiguienteCliente($cli->id);
            ?>

            <?php if ($clienteAnterior): ?>
                <a href="?orden=Modificar&id=<?= $clienteAnterior->id ?>" class="btn btn-primary me-2">
                    Anterior
                </a>
            <?php else: ?>
                <span class="btn btn-secondary me-2" disabled>Anterior</span>
            <?php endif; ?>

            <?php if ($clienteSiguiente): ?>
                <a href="?orden=Modificar&id=<?= $clienteSiguiente->id ?>" class="btn btn-primary">
                    Siguiente
                </a>
            <?php else: ?>
                <span class="btn btn-secondary" disabled>Siguiente</span>
            <?php endif; ?>
        </div>

    <?php
    }
    ?>

</div>