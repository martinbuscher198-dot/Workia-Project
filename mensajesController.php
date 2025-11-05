<?php
require 'db.php';

class MensajesController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear mensaje
    public function create($contenido, $id_emisor, $id_receptor) {
        $stmt = $this->pdo->prepare("
            INSERT INTO mensajes (contenido, id_emisor, id_receptor, fecha)
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute([$contenido, $id_emisor, $id_receptor]);
    }

    // Obtener conversación entre dos usuarios
    public function getConversacion($id_emisor, $id_receptor) {
        $stmt = $this->pdo->prepare("
            SELECT m.*, u.nombre, u.apellido
            FROM mensajes m
            INNER JOIN usuarios u ON m.id_emisor = u.id_usuario
            WHERE (m.id_emisor = ? AND m.id_receptor = ?)
               OR (m.id_emisor = ? AND m.id_receptor = ?)
            ORDER BY m.fecha ASC
        ");
        $stmt->execute([$id_emisor, $id_receptor, $id_receptor, $id_emisor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
