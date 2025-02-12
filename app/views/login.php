<?php

require_once 'app/controllers/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    Auth::login($_POST['usuario'], $_POST['password']);

}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

?>

<div class="container mt-2 d-flex justify-content-center align-items-center" style="height: 600px;">

    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">

        <h3 class="text-center">Iniciar Sesión</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>

        </form>

    </div>

</div>