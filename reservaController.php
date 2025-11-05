<?php
class ReservaController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear reserva
    public function crearReserva($id_usuario, $id_servicio) {
        // Obtener id_cliente desde id_usuario
        $sqlCliente = "SELECT id_cliente FROM cliente WHERE id_usuario = ?";
        $stmtCliente = $this->pdo->prepare($sqlCliente);
        $stmtCliente->execute([$id_usuario]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            die("Este usuario no está asociado a un cliente.");
        }

        $id_cliente = (int)$cliente['id_cliente'];
        $id_servicio = (int)$id_servicio;

        $sql = "INSERT INTO reserva (id_cliente, id_servicio, fecha_reserva) VALUES (?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_cliente, $id_servicio]);
    }

    // Verificar si ya existe la reserva
    public function getByUserAndService($id_usuario, $id_servicio) {
        $sqlCliente = "SELECT id_cliente FROM cliente WHERE id_usuario = ?";
        $stmtCliente = $this->pdo->prepare($sqlCliente);
        $stmtCliente->execute([$id_usuario]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) return false;

        $id_cliente = (int)$cliente['id_cliente'];
        $id_servicio = (int)$id_servicio;

        $sql = "SELECT * FROM reserva WHERE id_cliente = ? AND id_servicio = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_cliente, $id_servicio]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cancelar reserva
    public function cancelarReserva($id_usuario, $id_servicio) {
        $sqlCliente = "SELECT id_cliente FROM cliente WHERE id_usuario = ?";
        $stmtCliente = $this->pdo->prepare($sqlCliente);
        $stmtCliente->execute([$id_usuario]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) return;

        $id_cliente = (int)$cliente['id_cliente'];
        $id_servicio = (int)$id_servicio;

        $sql = "DELETE FROM reserva WHERE id_cliente = ? AND id_servicio = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_cliente, $id_servicio]);
    }
}
?>
