<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Solicitudes pendientes</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/solicitud.js"></script>
</head>
<body>
    <nav>
        <div>
            <a href="index.php?page=talleres">Talleres</a>
            <a href="index.php?page=admin">Gestionar Solicitudes</a>
        </div>
        <div>
            <span>Admin: <?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Administrador') ?></span>
            <a href="index.php?page=logout" class="btn btn-primary">Cerrar sesión</a>
        </div>
    </nav>
    
    <main>
        <h2>Solicitudes pendientes de aprobación</h2>
        
        <div class="table-container">
            <table id="tabla-solicitudes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Taller</th>
                        <th>Solicitante</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="solicitudes-body">
                    <tr>
                        <td colspan="6" class="loader">Cargando solicitudes...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="mensaje"></div>

</body>
</html>