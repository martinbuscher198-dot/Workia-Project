<?php
session_start();
require 'db.php';
require 'servicioController.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("error: no logueado");
}

if (!isset($_POST['id_servicio'])) {
    die("error: id faltante");
}

$id_servicio = $_POST['id_servicio'];

$servicioController = new ServicioController($pdo);

// Verificamos que el servicio pertenezca al proveedor logueado
$id_usuario = $_SESSION['id_usuario'];
$stmt = $pdo->prepare("SELECT id_proovedor FROM proovedor WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proveedor) {
    die("error: proveedor no encontrado");
}

$id_proovedor = $proveedor['id_proovedor'];

// Confirmamos que el servicio sea suyo
$stmt = $pdo->prepare("SELECT id_proovedor FROM servicio WHERE id_servicio = ?");
$stmt->execute([$id_servicio]);
$serv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$serv || $serv['id_proovedor'] != $id_proovedor) {
    die("error: servicio no pertenece al proveedor");
}

// Eliminamos el servicio
if ($servicioController->delete($id_servicio)) {
    echo "ok";
} else {
    echo "error: delete falló";
}
?>
