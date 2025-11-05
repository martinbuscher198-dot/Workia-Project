<?php
require 'db.php';

class RecibeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_cliente, $id_resena) {
        $stmt = $this->pdo->prepare("INSERT INTO recibe (id_cliente, id_resena) VALUES (?, ?)");
        return $stmt->execute([$id_cliente, $id_resena]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM recibe")->fetchAll();
    }

    public function getById($id_cliente, $id_resena) {
        $stmt = $this->pdo->prepare("SELECT * FROM recibe WHERE id_cliente=? AND id_resena=?");
        $stmt->execute([$id_cliente, $id_resena]);
        return $stmt->fetch();
    }

    public function delete($id_cliente, $id_resena) {
        $stmt = $this->pdo->prepare("DELETE FROM recibe WHERE id_cliente=? AND id_resena=?");
        return $stmt->execute([$id_cliente, $id_resena]);
    }
}
?>
