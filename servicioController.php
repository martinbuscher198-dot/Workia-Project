<?php
require 'db.php';

class ServicioController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 🔹 Crear un nuevo servicio
    public function create($id_cliente, $id_proovedor, $nombre_servicio, $precio, $imagen, $descripcion, $ciudad, $departamento) {
        $stmt = $this->pdo->prepare("
            INSERT INTO servicio (id_cliente, id_proovedor, nombre_servicio, precio, imagen, descripcion, ciudad, departamento)
            VALUES (?, ?, ?, ?, ?, ?, ? , ?)
        ");
        return $stmt->execute([
            $id_cliente ?: null, // por si no hay cliente asignado aún
            $id_proovedor,
            $nombre_servicio,
            $precio,
            $imagen,
            $descripcion,
            $ciudad,
            $departamento
        ]);
    }

    // 🔹 Obtener todos los servicios
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM servicio");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener un servicio por ID
    public function getById($id_servicio) {
        $stmt = $this->pdo->prepare("SELECT * FROM servicio WHERE id_servicio = ?");
        $stmt->execute([$id_servicio]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener servicios de un proveedor específico
    public function getByProveedor($id_proovedor) {
        $stmt = $this->pdo->prepare("SELECT * FROM servicio WHERE id_proovedor = ?");
        $stmt->execute([$id_proovedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Actualizar un servicio existente
    public function update($id_servicio, $id_cliente, $id_proovedor, $nombre_servicio, $precio, $imagen = null, $descripcion = null, $ciudad, $departamento) {
        // si imagen o descripción son nulos, no las actualizamos
        $sql = "UPDATE servicio 
                SET id_cliente = ?, id_proovedor = ?, nombre_servicio = ?, precio = ?, ciudad = ?, departamento = ?";
        $params = [$id_cliente, $id_proovedor, $nombre_servicio, $precio, $ciudad, $departamento];

        if ($imagen !== null) {
            $sql .= ", imagen = ?";
            $params[] = $imagen;
        }
        if ($descripcion !== null) {
            $sql .= ", descripcion = ?";
            $params[] = $descripcion;
        }

        $sql .= " WHERE id_servicio = ?";
        $params[] = $id_servicio;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // 🔹 Eliminar un servicio
    public function delete($id_servicio) {
        $stmt = $this->pdo->prepare("DELETE FROM servicio WHERE id_servicio = ?");
        return $stmt->execute([$id_servicio]);
    }
public function getReservasByProveedor($id_proovedor) {
    $stmt = $this->pdo->prepare("
        SELECT 
            s.id_servicio,
            s.nombre_servicio,
            c.id_cliente,
            c.nombre AS nombre_cliente,
            r.fecha_reserva
        FROM servicio s
        INNER JOIN reserva r ON s.id_servicio = r.id_servicio
        INNER JOIN cliente c ON r.id_cliente = c.id_cliente
        WHERE s.id_proovedor = ?
        ORDER BY r.fecha_reserva DESC
    ");
    $stmt->execute([$id_proovedor]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getReservasByCliente($id_cliente) {
    $stmt = $this->pdo->prepare("
        SELECT 
            s.id_servicio,
            s.nombre_servicio,
            p.id_proovedor,
            p.nombre AS nombre_proveedor,
            r.fecha_reserva
        FROM reserva r
        INNER JOIN servicio s ON r.id_servicio = s.id_servicio
        INNER JOIN proovedor p ON s.id_proovedor = p.id_proovedor
        WHERE r.id_cliente = ?
        ORDER BY r.fecha_reserva DESC
    ");
    $stmt->execute([$id_cliente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>
