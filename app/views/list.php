<?php

    $error = $_SESSION['error'] ?? '';

?>

<div class="container my-5">
    <!-- Formulario para añadir cliente -->
    <div class="d-flex justify-content-between mb-4">
        <h2>Clientes</h2>
        <form>
            <button type="submit" name="orden" value="Nuevo" class="btn btn-primary d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill me-2" viewBox="0 0 16 16">
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                </svg>
                Añadir Cliente
            </button>
        </form>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Tabla de clientes -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="?orden=id" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'id'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        First Name
                        <a href="?orden=first_name" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'first_name'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        Email
                        <a href="?orden=email" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'email'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        Gender
                        <a href="?orden=gender" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'gender'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        IP Address
                        <a href="?orden=ip_address" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'ip_address'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        Teléfono
                        <a href="?orden=telefono" class="btn btn-link">
                            <i class="fa fa-filter"></i>
                            <?php if (isset($_GET['orden']) && $_GET['orden'] == 'telefono'): ?>
                                <i class="fa <?php echo (isset($_GET['dir']) && $_GET['dir'] == 'desc') ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tclientes as $cli): ?>
                    <tr>
                        <td><?= $cli->id ?> </td>
                        <td><?= $cli->first_name ?> </td>
                        <td><?= $cli->email ?> </td>
                        <td><?= $cli->gender ?> </td>
                        <td><?= $cli->ip_address ?> </td>
                        <td><?= $cli->telefono ?> </td>
                        <td class="d-flex justify-content-center">
                            <a class="btn btn-sm btn-danger me-2" href="#" onclick="confirmarBorrar('<?= $cli->first_name ?>','<?= $cli->id ?>');" title="Borrar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </a>
                            <a class="btn btn-sm btn-warning me-2" href="?orden=Modificar&id=<?= $cli->id ?>" title="Modificar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                            <a class="btn btn-sm btn-primary" href="?orden=Detalles&id=<?= $cli->id ?>" title="Detalles">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Botones de paginación -->

    <!-- Botones de paginación -->
    <div class="d-flex justify-content-center mt-4">
        <form class="d-flex">
            <!-- Botón "Primero" -->
            <button class="btn btn-outline-primary me-2" name="pag" value="1" <?= ($pagina == 1) ? 'disabled' : '' ?>>
                Primero
            </button>

            <!-- Botón "Anterior" -->
            <button class="btn btn-outline-primary me-2" name="pag" value="<?= max($pagina - 1, 1) ?>" <?= ($pagina == 1) ? 'disabled' : '' ?>>
                &lt;
            </button>

            <!-- Botón "Siguiente" -->
            <button class="btn btn-outline-primary me-2" name="pag" value="<?= min($pagina + 1, $totalPaginas) ?>" <?= ($pagina == $totalPaginas) ? 'disabled' : '' ?>>
                &gt;
            </button>

            <!-- Botón "Último" -->
            <button class="btn btn-outline-primary" name="pag" value="<?= $totalPaginas ?>" <?= ($pagina == $totalPaginas) ? 'disabled' : '' ?>>
                Último
            </button>

            <!-- Agregar el parámetro "orden" en cada botón -->
            <input type="hidden" name="orden" value="<?= htmlspecialchars($orden) ?>" />
        </form>
    </div>

</div>