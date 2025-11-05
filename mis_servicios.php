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
$servicios = $servicioController->getByProveedor($id_proovedor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Servicios</title>
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
    .servicio {
        background-color: #1e1e1e;
        border: 1px solid cadetblue;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    .servicio img {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .btn-eliminar {
        background-color: crimson;
        border: none;
        padding: 8px 14px;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 10px;
    }
    .btn-eliminar:hover {
        background-color: darkred;
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
function eliminarServicio(id) {
    if (confirm("¿Seguro que querés eliminar este servicio?")) {
        const formData = new FormData();
        formData.append('id_servicio', id);

        fetch('eliminar_servicio.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            console.log("Respuesta del servidor:", data);
            if (data.trim() === "ok") {
                alert("Servicio eliminado con éxito ✅");
                document.getElementById("servicio-" + id).remove();
            } else {
                alert("❌ Ocurrió un error al eliminar el servicio: " + data);
            }
        })
        .catch(err => console.error(err));
    }
}
</script>
</head>
<body>

<h1>🛠️ Mis Servicios Publicados</h1>

<?php if (empty($servicios)): ?>
    <p style="text-align:center;">No tenés servicios publicados todavía.</p>
<?php else: ?>
    <?php foreach ($servicios as $servicio): ?>
        <div class="servicio" id="servicio-<?php echo $servicio['id_servicio']; ?>">
            <img src="<?php echo htmlspecialchars($servicio['imagen']); ?>" width="200" height="150" alt="Imagen del servicio"><br>
            <strong><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></strong><br>
            <span>Precio: $<?php echo htmlspecialchars($servicio['precio']); ?></span><br>
            <small><?php echo htmlspecialchars($servicio['descripcion']); ?></small><br>
            <button class="btn-eliminar" onclick="eliminarServicio(<?php echo $servicio['id_servicio']; ?>)">🗑️ Eliminar</button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="index.php" class="volver">⬅️ Volver al inicio</a>
<?php include 'footer.html'; ?>
</body>
</html>
