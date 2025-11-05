<?php
require 'db.php';
require 'servicioController.php';
require 'proveeController.php';
session_start();

$servicioController = new ServicioController($pdo);
$proveeController = new ProveeController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_servicio = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $departamento = $_POST['departamento'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $id_proovedor = $_SESSION['id_proovedor'] ?? null;

    if (!$id_proovedor) {
        die("No estás logueado como proveedor.");
    }

    $imagenGuardada = null;
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
        $imagenGuardada = "imagenes/$imagen";
    } else {
        die("La imagen es obligatoria.");
    }

    $servicioController->create(null, $id_proovedor, $nombre_servicio, $precio, $imagenGuardada, $descripcion, $ciudad, $departamento);
    $servicio_id = $pdo->lastInsertId();
    $proveeController->create($id_proovedor, $servicio_id);

    header('Location: index.php');
    exit();
}
?>
