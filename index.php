<?php
include 'header.php';
require 'db.php';
require 'servicioController.php';
include 'verMensajes.php';

$servicioController = new ServicioController($pdo);
$servicios = $servicioController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="footer.css">
<title>Servicios</title>
<style>
html, body {
    margin: 0;
    padding: 0;
    min-height: 100vh; /* altura mínima de la ventana */
    display: flex;
    flex-direction: column;
}

ul.serviciosLista {
    flex: 1; /* esto hace que la lista ocupe todo el espacio disponible */
}

footer {
    background-color: #007BFF;
    color: white;
    text-align: center;
    padding: 20px;
}
</style>
</head>
<style>
    .servicios{
        background-color: black;
        color: white;
        border: 1px solid cadetblue;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        display: inline-block;
        text-align: center;
        text-decoration: none; /* Para el enlace */
    }
    #tituloServicios{
        text-align: center;
        color: white;
    }
    ul.serviciosLista {
        list-style: none;
        padding: 0;
    }
    ul.serviciosLista li {
        display: inline-block;
    }
</style>
<body>
<h1 id="tituloServicios">Servicios Disponibles</h1>
<div style="flex:1;">
<ul class="serviciosLista">
<?php foreach ($servicios as $servicio): ?>
    <li>
        <a class="servicios" href="detalle_servicio.php?id=<?php echo $servicio['id_servicio']; ?>">
            <img src="<?php echo htmlspecialchars($servicio['imagen']); ?>" width="200" height="150" alt="Imagen del servicio"><br>
            <strong><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></strong><br>
            Precio: $<?php echo htmlspecialchars($servicio['precio']); ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
</div>
<?php include 'footer.html'; ?>
</body>
</html>
