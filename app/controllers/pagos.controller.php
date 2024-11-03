<?php

require_once 'app/models/pagos.model.php';
require_once 'app/views/pagos.view.php';

class paymentsController {
    private $model;
    private $view;

    public function __construct($res) {
        $this->model = new paymentsModel();
        $this->view = new paymentsView($res->user);
    }

    public function showPayments() {
        //obtengo los pagos de la DB
        $payments = $this->model->getPayments();

        //mando los pagos a la vista
        return $this->view->showPayments($payments);
    }

    public function addPayment() {
        if (!isset ($_POST ['deudor']) || empty ($_POST ['deudor'])) {
            return $this->view->showError('Falta completar el nombre del deudor'); 
        }
        if (!isset ($_POST ['cuota']) || empty ($_POST ['cuota'])) {
            return $this->view->showError('Falta completar el numero de cuota'); 
        }

        $debtor = $_POST ['deudor'];
        $fee = $_POST ['cuota'];
        $capital_fee = $_POST ['cuota_capital'];
        $payment_date = $_POST ['fecha_pago'];

        $id = $this->model->insertPayment ($debtor, $fee, $capital_fee, $payment_date);

        header('Location: ' . BASE_URL);
    }

    public function deletePayment($id) {
        //obtengo el pago por id
        $payment = $this->model->getPayment($id);

        if (!$payment){
            return $this->view->showError("No existe el pago con el id= $id");
        }
        //borro el pago y redirijo
        $this->model->erasePayment($id);
        header ('Location: ' . BASE_URL);
    }

}