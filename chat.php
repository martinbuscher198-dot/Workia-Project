<?php
session_start();
require 'db.php';
require 'mensajesController.php';

$mensajesController = new MensajesController($pdo);

// ⚙️ Requiere que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Inicia sesión para usar el chat.");
}

// IDs de emisor y receptor (por ejemplo: proveedor y cliente)
$id_emisor = $_SESSION['id_usuario'];
$id_receptor = $_GET['id_receptor'] ?? null;

if (!$id_receptor) {
    die("Receptor no especificado.");
}

// Enviar mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['contenido'])) {
    $contenido = trim($_POST['contenido']);
    $mensajesController->create($contenido, $id_emisor, $id_receptor);
}

// Obtener conversación
$mensajes = $mensajesController->getConversacion($id_emisor, $id_receptor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #121212;
    color: white;
    margin: 0;
    padding: 0;
}
.chat-container {
    width: 90%;
    max-width: 800px;
    margin: 40px auto;
    background-color: #1e1e1e;
    border-radius: 10px;
    padding: 20px;
}
.mensajes {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #333;
    padding: 10px;
    background-color: #222;
    border-radius: 8px;
}
.mensaje {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
}
.mensaje.propietario {
    background-color: #0066cc;
    align-self: flex-end;
    margin-left: auto;
}
.mensaje.ajeno {
    background-color: #333;
}
.mensaje small {
    color: #aaa;
    font-size: 12px;
}
form {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}
input[type="text"] {
    flex: 1;
    padding: 10px;
    border-radius: 5px;
    border: none;
}
button {
    padding: 10px 20px;
    background-color: cadetblue;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: teal;
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
<div class="chat-container">
    <h2>Chat con usuario #<?php echo htmlspecialchars($id_receptor); ?></h2>
    <div class="mensajes">
        <?php foreach ($mensajes as $m): ?>
            <div class="mensaje <?php echo $m['id_emisor'] == $id_emisor ? 'propietario' : 'ajeno'; ?>">
                <strong><?php echo htmlspecialchars($m['nombre'] . ' ' . $m['apellido']); ?></strong><br>
                <?php echo nl2br(htmlspecialchars($m['contenido'])); ?><br>
                <small><?php echo htmlspecialchars($m['fecha']); ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST">
        <input type="text" name="contenido" placeholder="Escribe tu mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
</div>

<a href="index.php" class="volver">Volver al inicio</a>

</body>
</html>
