<?php
class Taller
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM talleres ORDER BY nombre");
        $talleres = [];
        while ($row = $result->fetch_assoc()) {
            $talleres[] = $row;
        }
        return $talleres;
    }

    public function getAllDisponibles()
    {
        $result = $this->conn->query("SELECT * FROM talleres WHERE cupo_disponible > 0 ORDER BY nombre");
        $talleres = [];
        while ($row = $result->fetch_assoc()) {
            $talleres[] = $row;
        }
        return $talleres;
    }

    public function getById($id)
    {
        $result = $this->conn->query("SELECT * FROM talleres WHERE id = " . (int)$id);
        return $result->fetch_assoc();
    }

    public function descontarCupo($tallerId)
    {
        $result = $this->conn->query("UPDATE talleres SET cupo_disponible = cupo_disponible - 1 WHERE id = " . (int)$tallerId . " AND cupo_disponible > 0");
        return $result;
    }

    public function sumarCupo($tallerId)
    {
        $result = $this->conn->query("UPDATE talleres SET cupo_disponible = cupo_disponible + 1 WHERE id = " . (int)$tallerId . " AND cupo_disponible < cupo_maximo");
        return $result;
    }
}