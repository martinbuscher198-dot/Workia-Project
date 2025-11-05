<?php
require 'db.php'; // tu conexión PDO

$q = $_GET['q'] ?? '';
$q = trim($q);

if (!$q) {
    exit('');
}

// Buscamos servicios con nombre similar
$stmt = $pdo->prepare("SELECT id_servicio, nombre_servicio, precio, imagen 
FROM servicio WHERE nombre_servicio LIKE ? LIMIT 10");
$stmt->execute(['%' . $q . '%']);
$servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$servicios) {
    echo '<p style="color:white; padding:10px;">No se encontraron servicios</p>';
    exit;
}

// Generamos HTML
foreach ($servicios as $servicio) {
    echo '<a href="detalle_servicio.php?id=' . $servicio['id_servicio'] . '" style="display:flex; gap:10px; padding:5px; border-bottom:1px solid cadetblue; color:white;">';
    echo '<img src="' . htmlspecialchars($servicio['imagen']) . '" width="50" height="50" style="object-fit:cover;">';
    echo '<div>';
    echo '<strong>' . htmlspecialchars($servicio['nombre_servicio']) . '</strong><br>';
    echo '$' . htmlspecialchars($servicio['precio']);
    echo '</div>';
    echo '</a>';
}
?>
