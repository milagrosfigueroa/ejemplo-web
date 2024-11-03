<?php

class paymentsView {
    public function showPayments($payments) {
        require 'templates/lista_pagos.phtml';
    }

    public function showError($error) {
        require 'templates/error.phtml';
    }
}