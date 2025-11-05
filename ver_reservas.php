<?php
session_start();
require 'db.php';
require 'servicioController.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'proovedor') {
    die("Solo los proveedores pueden ver esta página.");
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener id_proovedor del usuario actual
$stmt = $pdo->prepare("SELECT id_proovedor FROM proovedor WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proveedor) {
    die("No se encontró el proveedor vinculado a este usuario.");
}

$id_proovedor = $proveedor['id_proovedor'];

$servicioController = new ServicioController($pdo);
$reservas = $servicioController->getReservasByProveedor($id_proovedor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Reservas</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #333;
        color: white;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
    }
    .reserva {
        background-color: #1e1e1e;
        border: 1px solid cadetblue;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .reserva strong {
        display: block;
        margin-bottom: 5px;
    }
    .volver {
        display: block;
        width: 200px;
        text-align: center;
        margin: 30px auto;
        padding: 10px;
        background-color: cadetblue;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        font-weight: bold;
    }
    .volver:hover {
        background-color: teal;
    }
</style>
</head>
<body>

<h1>📅 Usuarios que reservaron mis servicios</h1>

<?php if (empty($reservas)): ?>
    <p style="text-align:center;">Todavía no hay reservas para tus servicios.</p>
<?php else: ?>
<?php foreach ($reservas as $reserva): ?>
    <div class="reserva">
        <strong>Servicio:</strong> <?php echo htmlspecialchars($reserva['nombre_servicio']); ?><br>
        <strong>Cliente:</strong> <?php echo htmlspecialchars($reserva['nombre_cliente']); ?><br>
        <strong>Fecha de reserva:</strong> <?php echo htmlspecialchars($reserva['fecha_reserva']); ?><br>
        <!-- Botón para enviar mensaje -->
        <a href="chat.php?id_receptor=<?php echo $reserva['id_cliente']; ?>" 
           style="display:inline-block; margin-top:10px; padding:8px 12px; background-color:cadetblue; color:white; border-radius:5px; text-decoration:none; font-weight:bold;">
           💬 Enviar mensaje
        </a>
    </div>
<?php endforeach; ?>
<?php endif; ?>

<a href="index.php" class="volver">⬅️ Volver al inicio</a>
<?php include 'footer.html'; ?>
</body>
</html>
