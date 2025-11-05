<?php
require 'db.php';
require 'resenaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $id_servicio = $_POST['id_servicio'] ?? null;
    $valor = $_POST['valor'] ?? null;
    $comentario = $_POST['comentario'] ?? '';

    if (!$id_usuario) die("Debes iniciar sesión para dejar una reseña.");
    if (!$id_servicio || !$valor) die("Datos incompletos.");

    // Obtener id_cliente vinculado al usuario
    $stmt = $pdo->prepare("SELECT id_cliente FROM cliente WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cliente) die("No se encontró un cliente asociado a este usuario.");
    $id_cliente = $cliente['id_cliente'];

    $resenaController = new ResenaController($pdo);
    $resenaController->create($id_cliente, $id_servicio, $valor, $comentario);

    header("Location: detalle_servicio.php?id=" . $id_servicio);
    exit();
}
?>
