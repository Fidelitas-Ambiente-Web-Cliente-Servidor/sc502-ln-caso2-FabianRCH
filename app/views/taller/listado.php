<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Talleres</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
</head>
<body>

    <nav>
        <div>
            <a href="index.php?page=talleres">Talleres</a>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=admin">Gestionar Solicitudes</a>
            <?php endif; ?>
        </div>
        <div>
            <span><?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Usuario') ?></span>
            <a href="index.php?page=logout" class="btn btn-primary">Cerrar sesión</a>
        </div>
    </nav>

    <main>
        <h3>Talleres disponibles</h3>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cupo máximo</th>
                        <th>Cupo disponible</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="talleres-body">
                    <tr>
                        <td colspan="6" class="loader">Cargando talleres...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="mensaje"></div>

</body>
</html>