<?php
require_once 'app/models/user.model.php';
require_once 'app/views/auth.view.php';

class authController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new userModel();
        $this->view = new authView();
    }

    public function showLogin() {
        //muestro el formulario de login
        return $this->view->showLogin();
    }

    public function login() {
        if (!isset ($_POST ['email']) || empty ($_POST ['email'])) {
            return $this->view->showLogin('Falta completar el nombre de usuario');
        }
        if (!isset ($_POST ['password']) || empty ($_POST ['password'])) {
            return $this->view->showLogin('Falta completar la contraseña');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        //verifico que el usuario está en la base de datos

        $userFromDB = $this->model->getUserByEmail($email);
        //guardo el HASH

        if ($userFromDB && password_verify($password, $userFromDB->password)) {

            //guardo la sesión en el ID del usuario
            session_start();
            $_SESSION ['ID_USER'] = $userFromDB->id;
            $_SESSION ['EMAIL_USER'] = $userFromDB->email;
            $_SESSION ['LAST_ACTIVITY'] = time();

            //redirijo al home
            header ('Location: ' . BASE_URL);
        }
        else {
            return $this->view->showLogin('Credenciales incorrectas');
        }
    }

    public function logout() {
        session_start(); //busca la cookie
        session_destroy(); //borra la cookie que buscó
        header ('Location: ' . BASE_URL); //se redirije al home una vez deslogueado
    }
    
}