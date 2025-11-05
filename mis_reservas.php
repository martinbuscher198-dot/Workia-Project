<?php
session_start();
require 'db.php';
require 'servicioController.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    die("Solo los clientes pueden ver esta página.");
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener id_cliente del usuario actual
$stmt = $pdo->prepare("SELECT id_cliente FROM cliente WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    die("No se encontró el cliente vinculado a este usuario.");
}

$id_cliente = $cliente['id_cliente'];

$servicioController = new ServicioController($pdo);
$reservas = $servicioController->getReservasByCliente($id_cliente);
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
.btn-cancelar, .btn-mensaje {
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 10px;
    margin-right: 10px;
}
.btn-cancelar {
    background-color: crimson;
    color: white;
}
.btn-cancelar:hover {
    background-color: darkred;
}
.btn-mensaje {
    background-color: cadetblue;
    color: white;
}
.btn-mensaje:hover {
    background-color: teal;
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
<script>
function cancelarReserva(id_servicio) {
    if(confirm("¿Seguro que querés cancelar esta reserva?")) {
        const formData = new FormData();
        formData.append('id_servicio', id_servicio);

        fetch('cancelar_reserva.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === "ok") {
                alert("Reserva cancelada ✅");
                document.getElementById("reserva-" + id_servicio).remove();
            } else {
                alert("❌ Ocurrió un error al cancelar la reserva.");
            }
        })
        .catch(err => console.error(err));
    }
}

</script>
</head>
<body>

<h1>📅 Mis Reservas</h1>

<?php if(empty($reservas)): ?>
    <p style="text-align:center;">No tenés reservas activas.</p>
<?php else: ?>
    <?php foreach($reservas as $reserva): ?>
        <div class="reserva" id="reserva-<?php echo $reserva['id_servicio']; ?>">
            <strong>Servicio:</strong> <?php echo htmlspecialchars($reserva['nombre_servicio']); ?><br>
            <strong>Proveedor:</strong> <?php echo htmlspecialchars($reserva['nombre_proveedor']); ?><br>
            <strong>Fecha de reserva:</strong> <?php echo htmlspecialchars($reserva['fecha_reserva']); ?><br>
            <button class="btn-cancelar" onclick="cancelarReserva(<?php echo $reserva['id_servicio']; ?>)">❌ Cancelar</button>
            <a href="chat.php?id_receptor=<?php 
                // Obtenemos el id_usuario del proveedor desde su id_proovedor
                $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM proovedor WHERE id_proovedor = ?)");
                $stmt->execute([$reserva['id_proovedor']]);
                $usuarioProveedor = $stmt->fetch(PDO::FETCH_ASSOC);
                echo $usuarioProveedor['id_usuario'];
            ?>" 
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
