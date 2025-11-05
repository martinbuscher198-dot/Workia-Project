<?php
require 'db.php';

class ProovedorController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_usuario, $nombre, $email, $cantidad_servicios) {
        $stmt = $this->pdo->prepare("INSERT INTO proovedor (id_usuario, nombre, email, cantidad_servicios) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_usuario, $nombre, $email, $cantidad_servicios]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM proovedor")->fetchAll();
    }

    public function getById($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM proovedor WHERE id_usuario=?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch();
    }

    public function update($id_proovedor, $id_usuario, $nombre, $email, $cantidad_servicios) {
        $stmt = $this->pdo->prepare("UPDATE proovedor SET id_usuario=?, nombre=?, email=?, cantidad_servicios=? WHERE id_proovedor=?");
        return $stmt->execute([$id_usuario, $nombre, $email, $cantidad_servicios, $id_proovedor]);
    }

    public function delete($id_proovedor) {
        $stmt = $this->pdo->prepare("DELETE FROM proovedor WHERE id_proovedor=?");
        return $stmt->execute([$id_proovedor]);
    }
}
?>
