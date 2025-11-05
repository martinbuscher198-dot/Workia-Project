<?php
require 'db.php';

class ResenaController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear reseña
    public function create($id_cliente, $id_servicio, $calificacion, $comentario) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO resena (id_cliente, id_servicio, calificacion, comentario) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$id_cliente, $id_servicio, $calificacion, $comentario]);
    }

    // Obtener todas las reseñas
    public function getAll() {
        return $this->pdo->query("SELECT * FROM resena")->fetchAll();
    }

    // Obtener reseñas por servicio
    public function getByServicio($id_servicio) {
        $stmt = $this->pdo->prepare("SELECT * FROM resena WHERE id_servicio = ?");
        $stmt->execute([$id_servicio]);
        return $stmt->fetchAll();
    }

    // Calcular promedio de calificaciones por servicio
    public function getPromedio($id_servicio) {
        $stmt = $this->pdo->prepare("SELECT AVG(calificacion) as promedio, COUNT(*) as cantidad FROM resena WHERE id_servicio = ?");
        $stmt->execute([$id_servicio]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar reseña
    public function update($id_resena, $calificacion, $comentario) {
        $stmt = $this->pdo->prepare(
            "UPDATE resena SET calificacion=?, comentario=? WHERE id_resena=?"
        );
        return $stmt->execute([$calificacion, $comentario, $id_resena]);
    }

    // Borrar reseña
    public function delete($id_resena) {
        $stmt = $this->pdo->prepare("DELETE FROM resena WHERE id_resena=?");
        return $stmt->execute([$id_resena]);
    }
}
?>
