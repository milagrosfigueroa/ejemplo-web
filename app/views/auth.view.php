<?php

    class authView {
        private $user = null;

        public function showLogin($error = '') {
            require 'templates/form_login.phtml';
        }

        public function showSignup($error = '') {
            require 'templates/error.phtml';
        }
    }