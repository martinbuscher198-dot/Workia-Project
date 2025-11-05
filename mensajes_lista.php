<?php
session_start();
require 'db.php';
require 'mensajesController.php';

if (!isset($_SESSION['id_usuario'])) {
    die("Inicia sesión para ver tus mensajes.");
}

$id_usuario = $_SESSION['id_usuario'];
$mensajesController = new MensajesController($pdo);

// 🔹 Obtener lista de conversaciones únicas
$stmt = $pdo->prepare("
    SELECT 
        CASE 
            WHEN id_emisor = ? THEN id_receptor 
            ELSE id_emisor 
        END AS id_otro,
        u.nombre,
        u.apellido,
        MAX(m.fecha) AS ultima_fecha,
        SUBSTRING_INDEX(GROUP_CONCAT(m.contenido ORDER BY m.fecha DESC SEPARATOR '|||'), '|||', 1) AS ultimo_mensaje
    FROM mensajes m
    INNER JOIN usuarios u 
        ON (u.id_usuario = CASE 
                            WHEN m.id_emisor = ? THEN m.id_receptor 
                            ELSE m.id_emisor 
                          END)
    WHERE m.id_emisor = ? OR m.id_receptor = ?
    GROUP BY id_otro
    ORDER BY ultima_fecha DESC
");
$stmt->execute([$id_usuario, $id_usuario, $id_usuario, $id_usuario]);
$conversaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Mensajes</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #121212;
    color: white;
    margin: 0;
    padding: 20px;
}
h1 {
    text-align: center;
}
.conversacion {
    background-color: #1e1e1e;
    border: 1px solid cadetblue;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
}
a {
    text-decoration: none;
    color: white;
}
a:hover {
    color: cadetblue;
}
.volver {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: cadetblue;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
.volver:hover {
    background-color: teal;
}
</style>
</head>
<body>
<h1>📩 Mis conversaciones</h1>

<?php if (empty($conversaciones)): ?>
    <p>No tenés conversaciones todavía.</p>
<?php else: ?>
    <?php foreach ($conversaciones as $c): ?>
        <div class="conversacion">
            <a href="chat.php?id_receptor=<?php echo htmlspecialchars($c['id_otro']); ?>">
                <strong><?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?></strong><br>
                <small>Último mensaje: <?php echo htmlspecialchars($c['ultimo_mensaje']); ?></small><br>
                <small><em><?php echo htmlspecialchars($c['ultima_fecha']); ?></em></small>
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="index.php" class="volver">⬅️ Volver al inicio</a>

</body>
</html>
