<?php
session_start();
require 'db.php'; // conexión PDO

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv'])) {
    $idUsuario = $_SESSION['id_usuario'];
    $nombreArchivo = $_FILES['cv']['name'];
    $tmpArchivo = $_FILES['cv']['tmp_name'];
    $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

    $permitidos = ['pdf','doc','docx'];
    if (!in_array(strtolower($ext), $permitidos)) {
        die('Formato de archivo no permitido.');
    }

    // Crear carpeta para el usuario si no existe
    $carpetaUsuario = "cvs/cv_$idUsuario";
    if (!file_exists($carpetaUsuario)) {
        mkdir($carpetaUsuario, 0777, true);
    }

    // Ruta final del archivo
    $rutaFinal = "$carpetaUsuario/$nombreArchivo";

    // Mover archivo
    if (move_uploaded_file($tmpArchivo, $rutaFinal)) {
        // Actualizar ruta en la base de datos
        $stmt = $pdo->prepare("UPDATE usuarios SET cv = ? WHERE id_usuario = ?");
        $stmt->execute([$rutaFinal, $idUsuario]);

        // Actualizar sesión
        $_SESSION['cv'] = $rutaFinal;

        header('Location: perfil.php'); // Volver al perfil
        exit();
    } else {
        die('Error al subir el archivo.');
    }
}
