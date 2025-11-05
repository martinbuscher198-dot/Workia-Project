<?php
require 'db.php';

class AdministradorController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_usuario, $nombre, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO administrador (id_usuario, nombre, email) VALUES (?, ?, ?)");
        return $stmt->execute([$id_usuario, $nombre, $email]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM administrador")->fetchAll();
    }

    public function getById($id_administrador) {
        $stmt = $this->pdo->prepare("SELECT * FROM administrador WHERE id_administrador = ?");
        $stmt->execute([$id_administrador]);
        return $stmt->fetch();
    }

    public function update($id_administrador, $id_usuario, $nombre, $email) {
        $stmt = $this->pdo->prepare("UPDATE administrador SET id_usuario=?, nombre=?, email=? WHERE id_administrador=?");
        return $stmt->execute([$id_usuario, $nombre, $email, $id_administrador]);
    }

    public function delete($id_administrador) {
        $stmt = $this->pdo->prepare("DELETE FROM administrador WHERE id_administrador=?");
        return $stmt->execute([$id_administrador]);
    }
}
?>
