<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPendientes()
    {
        $result = $this->conn->query("SELECT solicitudes.id, talleres.nombre AS taller, usuarios.username AS usuario, usuarios.username AS solicitante, solicitudes.fecha_solicitud
        FROM solicitudes JOIN talleres ON solicitudes.taller_id = talleres.id JOIN usuarios ON solicitudes.usuario_id = usuarios.id WHERE solicitudes.estado = 'pendiente'");

        $solicitudes = [];
        while ($row = $result->fetch_assoc()) {
            $solicitudes[] = $row;
        }
        return $solicitudes;
    }

    public function getById($id)
    {
        $result = $this->conn->query("SELECT * FROM solicitudes WHERE id = " . (int)$id);
        return $result->fetch_assoc();
    }

    public function crear($tallerId, $usuarioId)
    {
        return $this->conn->query("INSERT INTO solicitudes (taller_id, usuario_id, estado) VALUES (" . (int)$tallerId . ", " . (int)$usuarioId . ", 'pendiente')");
    }

    public function aprobar($id)
    {
        return $this->conn->query("UPDATE solicitudes SET estado = 'aprobada' WHERE id = " . (int)$id . " AND estado = 'pendiente'");
    }

    public function rechazar($id)
    {
        return $this->conn->query("UPDATE solicitudes SET estado = 'rechazada' WHERE id = " . (int)$id . " AND estado = 'pendiente'");
    }

    public function existe($tallerId, $usuarioId)
    {
        $result = $this->conn->query("SELECT id FROM solicitudes WHERE taller_id = " . (int)$tallerId . " AND usuario_id = " . (int)$usuarioId . " AND estado IN ('pendiente', 'aprobada')");
        return $result->num_rows > 0;
    }
}