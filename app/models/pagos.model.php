<?php

class paymentsModel {
    private $db;

    public function __construct() {
        $this->db = new PDO ('mysql:host=localhost;dbname=db_payment;charset=utf8', 'root', '');
    }

    public function getPayments() {
        //Ejecuto la consulta
        $query = $this->db->prepare ('SELECT * FROM pagos');
        $query->execute();

        //obtengo los datos en un arreglo de objetos
        $payments = $query->fetchAll(PDO::FETCH_OBJ);

        return $payments;
    }

    public function getPayment($id) {
        $query = $this->db->prepare('SELECT * FROM pagos WHERE id = ?');

        $query->execute([$id]);

        $payment = $query->fetch(PDO::FETCH_OBJ);

        return $payment;
    }

    public function insertPayment($debtor, $fee, $capital_fee, $payment_date) {
        $query = $this->db->prepare('INSERT INTO pagos(deudor, cuota, cuota_capital, fecha_pago) VALUES (?, ?, ?, ?)'); 

        $query->execute([$debtor, $fee, $capital_fee, $payment_date]);

        $id = $this->db->lastInsertId();

        return $id;
    }

    public function erasePayment($id) {
        $query = $this->db->prepare('DELETE FROM pagos WHERE id = ?');

        $query->execute([$id]);
    }
}