<?php
require 'db.php';

class ClienteController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_usuario, $email, $nombre) {
        $stmt = $this->pdo->prepare("INSERT INTO cliente (id_usuario, email, nombre) VALUES (?, ?, ?)");
        return $stmt->execute([$id_usuario, $email, $nombre]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM cliente")->fetchAll();
    }

    public function getById($id_cliente) {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
        $stmt->execute([$id_cliente]);
        return $stmt->fetch();
    }

    public function update($id_cliente, $id_usuario, $email, $nombre) {
        $stmt = $this->pdo->prepare("UPDATE cliente SET id_usuario=?, email=?, nombre=? WHERE id_cliente=?");
        return $stmt->execute([$id_usuario, $email, $nombre, $id_cliente]);
    }

    public function delete($id_cliente) {
        $stmt = $this->pdo->prepare("DELETE FROM cliente WHERE id_cliente=?");
        return $stmt->execute([$id_cliente]);
    }
}
?>
