<?php
require 'db.php';

class UsuariosController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear usuario
    public function create($nombre, $apellido, $email, $tipo_usuario, $fecha_registro, $contrasena, $cv = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (nombre, apellido, email, tipo_usuario, fecha_registro, contrasena, cv) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$nombre, $apellido, $email, $tipo_usuario, $fecha_registro, $contrasena, $cv]);
    }

    // Obtener todos los usuarios
    public function getAll() {
        return $this->pdo->query("SELECT * FROM usuarios")->fetchAll();
    }

    // Obtener por ID
    public function getById($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id_usuario=?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch();
    }

    // Actualizar usuario
    public function update($id_usuario, $nombre, $apellido, $email, $tipo_usuario, $fecha_registro, $contrasena) {
        $stmt = $this->pdo->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, email=?, tipo_usuario=?, fecha_registro=?, contrasena=? 
            WHERE id_usuario=?
        ");
        return $stmt->execute([$nombre, $apellido, $email, $tipo_usuario, $fecha_registro, $contrasena, $id_usuario]);
    }

    // Eliminar usuario
    public function delete($id_usuario) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id_usuario=?");
        return $stmt->execute([$id_usuario]);
    }
}
?>
