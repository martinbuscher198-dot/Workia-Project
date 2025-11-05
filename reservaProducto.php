<?php
require 'db.php';
require 'reservaController.php';
require 'servicioController.php';
session_start();

// Asegurarse de que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Verificar que haya un id de servicio enviado por POST
if (!isset($_POST['id_servicio']) || empty($_POST['id_servicio'])) {
    die("Servicio no especificado.");
}

$id_servicio = $_POST['id_servicio'];

$reservaController = new ReservaController($pdo);

// Verificar si ya hay una reserva existente
$reservaExistente = $reservaController->getByUserAndService($id_usuario, $id_servicio);

if ($reservaExistente) {
    // Si ya existe, cancelar la reserva
    $reservaController->cancelarReserva($id_usuario, $id_servicio);
    $mensaje = "Reserva cancelada correctamente.";
} else {
    // Si no existe, crear una nueva reserva
    $reservaController->crearReserva($id_usuario, $id_servicio);
    $mensaje = "Servicio reservado correctamente.";
}

// Redirigir de nuevo a la página del servicio con un mensaje
header("Location: detalle_servicio.php" . "?id=" . urlencode($id_servicio) . "&mensaje=" . urlencode($mensaje));
exit;
?>