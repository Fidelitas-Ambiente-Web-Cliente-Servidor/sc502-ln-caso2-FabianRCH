<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }
    
    public function getTalleresJson()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }
        
        $talleres = $this->tallerModel->getAllDisponibles();
        header('Content-Type: application/json');
        echo json_encode($talleres);
    }
    
    public function solicitar()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'error' => 'Sesion no iniciada']);
            return;
        }
        
        $tallerId = $_POST['taller_id'] ?? 0;
        $usuarioId = $_SESSION['id'];

        $taller = $this->tallerModel->getById($tallerId);

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'error' => 'Taller sin cupos disponibles']);
            return;
        }

        if ($this->solicitudModel->existe($tallerId, $usuarioId)) {
            echo json_encode(['success' => false, 'error' => 'No se puede solicitar el mismo taller 2 veces']);
            return;
        }

        if ($this->solicitudModel->crear($tallerId, $usuarioId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo registrar la solicitud']);
        }
    }
}