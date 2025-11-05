<?php
require 'db.php';

class ProveeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_proovedor, $id_servicio) {
        $stmt = $this->pdo->prepare("INSERT INTO provee (id_proovedor, id_servicio) VALUES (?, ?)");
        return $stmt->execute([$id_proovedor, $id_servicio]);
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM provee")->fetchAll();
    }

    public function getById($id_proovedor, $id_servicio) {
        $stmt = $this->pdo->prepare("SELECT * FROM provee WHERE id_proovedor=? AND id_servicio=?");
        $stmt->execute([$id_proovedor, $id_servicio]);
        return $stmt->fetch();
    }

    public function delete($id_proovedor, $id_servicio) {
        $stmt = $this->pdo->prepare("DELETE FROM provee WHERE id_proovedor=? AND id_servicio=?");
        return $stmt->execute([$id_proovedor, $id_servicio]);
    }
}
?>
