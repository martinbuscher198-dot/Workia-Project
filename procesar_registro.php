<?php
require 'db.php';
require 'usuarioController.php';
require 'clienteController.php';
require 'proovedorController.php';
require 'TelefonoController.php';

$usuarios = new UsuariosController($pdo);
$clientes = new ClienteController($pdo);
$proovedores = new ProovedorController($pdo);
$telefonos = new TelefonoController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';
    $telefono = $_POST['telefono'] ?? ''; // capturamos el teléfono
    $fecha_registro = date('Y-m-d H:i:s');

    if (!$nombre || !$apellido || !$email || !$password || !$tipo_usuario) {
        die("Todos los campos son obligatorios.");
    }

    // Hashear contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Crear usuario
    $usuarios->create($nombre, $apellido, $email, $tipo_usuario, $fecha_registro, $hashed_password);
    $id_usuario = $pdo->lastInsertId();

    // Insertar teléfono usando el controlador si existe
    if (!empty($telefono)) {
        $telefonos->create($id_usuario, $telefono);
    }

    // Crear registro en la tabla correspondiente según tipo de usuario
    if ($tipo_usuario === 'cliente') {
        $clientes->create($id_usuario, $email, $nombre);
    } elseif ($tipo_usuario === 'proovedor') {
        $proovedores->create($id_usuario, $nombre, $email, 0);
    }

    header('Location: login.php');
    exit();
}
?>
