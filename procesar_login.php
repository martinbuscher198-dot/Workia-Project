<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar usuario por email
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si existe y la contraseña coincide
    if ($usuario && password_verify($password, $usuario['contrasena'])) {
        // Guardar sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['cv'] = $usuario['cv'];
        $stmt = $pdo->prepare("SELECT telefono FROM telefono WHERE id_usuario = ?");
        $stmt->execute([$usuario['id_usuario']]);
        $telefono = $stmt->fetch(PDO::FETCH_ASSOC);

    // Asignar siempre un valor por defecto
        $_SESSION['telefono'] = $telefono['telefono'] ?? 'No registrado';

        if($_SESSION['tipo_usuario'] === 'proovedor'){
            // Obtener id_proovedor
            $stmt = $pdo->prepare("SELECT id_proovedor FROM proovedor WHERE id_usuario = ?");
            $stmt->execute([$usuario['id_usuario']]);
            $proovedor = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($proovedor) {
                $_SESSION['id_proovedor'] = $proovedor['id_proovedor'];
            }
        }
        if($_SESSION['tipo_usuario'] === 'cliente'){
            // Obtener id_cliente
            $stmt = $pdo->prepare("SELECT id_cliente FROM cliente WHERE id_usuario = ?");
            $stmt->execute([$usuario['id_usuario']]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($cliente) {
                $_SESSION['id_cliente'] = $cliente['id_cliente'];
            }
        }
        // Redirigir al index
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.history.back();</script>";
    }
}
?>
