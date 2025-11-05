<?php
require 'db.php';

class TelefonoController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_usuario, $telefono) {
        $stmt = $this->pdo->prepare("INSERT INTO telefono (id_usuario, telefono) VALUES (?, ?)");
        return $stmt->execute([$id_usuario, $telefono]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM telefono")->fetchAll();
    }

    public function getById($id_usuario, $telefono) {
        $stmt = $this->pdo->prepare("SELECT * FROM telefono WHERE id_usuario=? AND telefono=?");
        $stmt->execute([$id_usuario, $telefono]);
        return $stmt->fetch();
    }

    public function delete($id_usuario, $telefono) {
        $stmt = $this->pdo->prepare("DELETE FROM telefono WHERE id_usuario=? AND telefono=?");
        return $stmt->execute([$id_usuario, $telefono]);
    }
}
?>
