<div class="container my-5">

    <!-- Botón Volver -->

    <div class="d-flex justify-content-between mb-4">

        <h2>Detalles del cliente</h2>

        <div class="d-fex">
            <button class="btn btn-success" onclick="location.href='index.php?orden=GenerarPDF&id=<?= $cli->id ?>'">
                Generar PDF
            </button>
            <button class="btn btn-primary" onclick="location.href='./'">
                Volver
            </button>
        </div>

    </div>

    <!-- Tabla de Detalles del Cliente -->

    <table class="table table-bordered">
        <tr>
            <td><strong>ID:</strong></td>
            <td><input type="number" name="id" value="<?= $cli->id ?>" readonly class="form-control"></td>
        </tr>
        <tr>
            <td><strong>Imagen:</strong></td>
            <td>
                <img class="photo" class="rounded" width="180" height="200" src="<?= getClientPhoto($cli->id) ?>" alt="Foto del cliente">
            </td>
        </tr>
        <tr>
            <td><strong>First Name:</strong></td>
            <td><input type="text" name="first_name" value="<?= $cli->first_name ?>" readonly class="form-control"> </td>
        </tr>
        <tr>
            <td><strong>Last Name:</strong></td>
            <td><input type="text" name="last_name" value="<?= $cli->last_name ?>" readonly class="form-control"></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><input type="email" name="email" value="<?= $cli->email ?>" readonly class="form-control"></td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td><input type="text" name="gender" value="<?= $cli->gender ?>" readonly class="form-control"></td>
        </tr>
        <tr>
            <td>
                <strong>IP Address:</strong>
                <img src="<?= getCountryFlag($cli->ip_address) ?>" alt="Flag" width="30" />
            </td>
            <td>
                <input type="text" name="ip_address" value="<?= $cli->ip_address ?>" readonly class="form-control">
            </td>
        </tr>
        <tr>
            <td><strong>Telefono:</strong></td>
            <td><input type="tel" name="telefono" value="<?= $cli->telefono ?>" readonly class="form-control"></td>
        </tr>
    </table>

    <!-- Mapa de Ubicación -->

    <div id="map" style="width: 100%; height: 400px;"></div>

    <!-- Siguientes clientes -->

    <div class="d-flex justify-content-center mt-4">

        <?php $clienteAnterior = obtenerAnteriorCliente($cli->id); ?>
        <?php $clienteSiguiente = obtenerSiguienteCliente($cli->id); ?>

        <?php if ($clienteAnterior): ?>
            <a href="?orden=Detalles&id=<?= $clienteAnterior->id ?>" class="btn btn-primary me-2">
                Anterior
            </a>
        <?php else: ?>
            <span class="btn btn-secondary me-2" disabled>Anterior</span>
        <?php endif; ?>

        <?php if ($clienteSiguiente): ?>
            <a href="?orden=Detalles&id=<?= $clienteSiguiente->id ?>" class="btn btn-primary">
                Siguiente
            </a>
        <?php else: ?>
            <span class="btn btn-secondary" disabled>Siguiente</span>
        <?php endif; ?>

    </div>

</div>

<!-- Script para Google Maps -->

<script>
    function initMap() {

        // Coordenadas (usar las del cliente)
        const clienteLocation = {
            lat: <?= $cli->lat ?>,
            lng: <?= $cli->long  ?>
        };

        // Crear el mapa centrado en la ubicación del cliente
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: clienteLocation
        });

        // Agregar un marcador en la ubicación del cliente
        const marker = new google.maps.Marker({
            position: clienteLocation,
            map: map,
            title: "Ubicación del cliente"
        });

    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQoTZVjkwQGdhSqLg4ddZzi4-gNPiM9Ow&callback=initMap">
</script>