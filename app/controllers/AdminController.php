<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    public function getSolicitudesJson()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        $solicitudes = $this->solicitudModel->getPendientes();
        header('Content-Type: application/json');
        echo json_encode($solicitudes);
    }

    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No admin']);
            return;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        $solicitud = $this->solicitudModel->getById($solicitudId);

        if ($this->solicitudModel->aprobar($solicitudId)) {
            $this->tallerModel->descontarCupo($solicitud['taller_id']);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo aprobar']);
        }
    }

    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No admin']);
            return;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo rechazar']);
        }
    }

}