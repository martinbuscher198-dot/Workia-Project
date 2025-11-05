<?php
include 'header.php';
require 'db.php';
require 'servicioController.php';
require 'reservaController.php';
include 'verMensajes.php';
require 'usuarioController.php';
require 'resenaController.php';

$servicioController = new ServicioController($pdo);


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Servicio no especificado.");
}

$id_usuario = $_SESSION['id_usuario'] ?? null;
$tipo_usuario = $_SESSION['tipo_usuario'] ?? null;
$tieneReserva = false;

$id_servicio = $_GET['id'];
$servicio = $servicioController->getById($id_servicio);
if (!$servicio) die("Servicio no encontrado.");

$resenaController = new ResenaController($pdo);
$resenas = $resenaController->getByServicio($id_servicio);
$stats = $resenaController->getPromedio($id_servicio);

$promedio = $stats['promedio'] ? round($stats['promedio'], 1) : 0;
$cantidadResenas = $stats['cantidad'] ?? 0;


if($id_usuario){
    $reservaController = new ReservaController($pdo);
    $reserva = $reservaController->getByUserAndService($id_usuario, $id_servicio);
    if($reserva) $tieneReserva = true;
}

// Datos del proveedor
$proveedorDatos = null;
if (!empty($servicio['id_proovedor'])) {
    $stmt = $pdo->prepare("
        SELECT u.id_usuario, u.nombre, u.apellido, u.email, t.telefono
        FROM proovedor p
        INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
        LEFT JOIN telefono t ON u.id_usuario = t.id_usuario
        WHERE p.id_proovedor = ?
    ");
    $stmt->execute([$servicio['id_proovedor']]);
    $proveedorDatos = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle del Servicio</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #333;
        color: white;
        margin: 0;
        padding: 0;
    }
    .detalleServicio {
        display: flex;
        flex-direction: row;
        background-color: black;
        border: 1px solid cadetblue;
        border-radius: 5px;
        padding: 20px;
        width: 90%;
        max-width: 1000px;
        margin: 50px auto;
        gap: 20px;
        align-items: flex-start;
    }
    .detalleServicio img {
        width: 300px;
        height: auto;
        border-radius: 5px;
        flex-shrink: 0;
    }
    .infoServicio {
        display: flex;
        flex-direction: row; /* Cambiado a fila */
        justify-content: flex-start;
        flex: 1;
        gap: 20px;
    }
    .descripcion {
        flex: 2;
    }
    .datosProveedor {
        flex: 1;
        padding: 15px;
        border: 1px solid cadetblue;
        border-radius: 5px;
        background-color: #222;
        max-height: fit-content;
    }
    .datosProveedor h3 {
        margin-top: 0;
    }
    @media (max-width: 800px) {
        .detalleServicio {
            flex-direction: column;
            align-items: center;
        }
        .infoServicio {
            flex-direction: column;
            width: 100%;
        }
        .descripcion, .datosProveedor {
            width: 100%;
        }
        .detalleServicio img {
            width: 100%;
        }
    }
</style>
</head>
<body>
<div class="detalleServicio">
    <img src="<?php echo htmlspecialchars($servicio['imagen']); ?>" alt="Imagen del servicio">
    <div class="infoServicio">
        <div class="descripcion">
            <h2><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></h2>
            <p><strong>Precio:</strong> $<?php echo htmlspecialchars($servicio['precio']); ?></p>
            <p><strong>Descripción:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($servicio['descripcion'])); ?></p>
            <p><strong>Departamento</strong> <?php echo htmlspecialchars($servicio['departamento'] ?? 'No registrado') ?></p>
            <p><strong>Ciudad</strong> <?php echo htmlspecialchars($servicio['ciudad'] ?? 'No registrado') ?></p>
            <h3>Reseñas del Servicio</h3>
            <p><strong>Promedio:</strong> <?php echo $promedio; ?> ⭐ (<?php echo $cantidadResenas; ?> reseñas)</p>
            <?php if ($id_usuario && $tipo_usuario !== "proovedor"): ?>
    <div style="margin-top: 30px; border-top: 1px solid cadetblue; padding-top: 20px;">

<!-- Si el usuario puede dejar reseña -->
<?php if($id_usuario && $tipo_usuario !== 'proovedor'): ?>
<form action="procesar_resena.php" method="post">
    <input type="hidden" name="id_servicio" value="<?php echo htmlspecialchars($servicio['id_servicio']); ?>">
    <label>Puntuación:</label>
    <select name="valor" required>
        <option value="">Seleccione...</option>
        <option value="1">⭐</option>
        <option value="2">⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
    </select>
    <br><br>
    <label>Comentario:</label>
    <textarea name="comentario" rows="3" cols="30"></textarea>
    <br><br>
    <input type="submit" value="Enviar Reseña" style="padding:8px 15px; border:none; background:cadetblue; color:white; border-radius:5px;">
</form>
<?php endif; ?>

    </div>
<?php elseif(!$id_usuario): ?>
    <p style="margin-top:20px;">🔒 <a href="login.php" style="color:cadetblue;">Inicia sesión</a> para dejar una reseña.</p>
<?php endif; ?>


            <?php if($tipo_usuario !== "proovedor"): ?>
            <form action="reservaProducto.php" method="post" style="margin-top: 20px;">
                <input type="hidden" name="id_servicio" value="<?php echo htmlspecialchars($servicio['id_servicio']); ?>">
                <input type="submit" value="<?php echo $tieneReserva ? 'Cancelar Servicio' : 'Reservar Servicio'; ?>" 
                    style="padding:10px 20px; border-radius:5px; border:none; 
                    background-color:<?php echo $tieneReserva ? 'red' : 'green'; ?>; color:white; cursor:pointer;">
            </form>
            <?php else: ?>
            <p style="background-color: red; padding: 20px; border-radius: 20px;">No puedes reservar servicios siendo proovedor</p>
            <?php endif; ?>
        </div>

        <?php if($proveedorDatos): ?>
        <div class="datosProveedor">
            <h3>Datos del Proveedor</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($proveedorDatos['nombre'] . ' ' . $proveedorDatos['apellido']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($proveedorDatos['email']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($proveedorDatos['telefono'] ?? 'No registrado'); ?></p>
            <?php if($id_usuario && $tipo_usuario !== 'proovedor' && isset($proveedorDatos['id_usuario'])): ?>
                <a href="chat.php?id_receptor=<?php echo $proveedorDatos['id_usuario']; ?>" 
                style="display:inline-block; margin-top:10px; padding:10px 20px; background-color:cadetblue; color:white; border-radius:5px; text-decoration:none;">
                Contactar al proveedor
                </a>
            <?php endif; ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'footer.html'; ?>
</body>
</html>
