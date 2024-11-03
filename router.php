<?php
require_once 'app/controllers/pagos.controller.php';
require_once 'libs/response.php';
require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';
require_once 'app/controllers/auth.controller.php';

//base url para redirecciones y base tag
define('BASE_URL', '//' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . dirname ($_SERVER ['PHP_SELF']) . '/');

$action = 'listar'; //acción por defecto si no se envía ninguna
if (!empty($_GET['action'])){
    $action = $_GET['action'];
}

//tabla de ruteo

//parsea la acción para separar acción real de parámetros
$params = explode('/', $action);

switch ($params[0]){
    case 'listar':
        sessionAuthMiddleware($res); //verifica que el usuario esté logueado y setea $res->user o redirije a login
        $controller = new paymentsController($res);
        $controller->showPayments();
    break;
    case 'nueva':
        sessionAuthMiddleware($res);
        $controller = new paymentsController($res);
        $controller->addPayment();
    break;
    case 'eliminar':
        sessionAuthMiddleware($res);
        $controller = new paymentsController($res);
        $controller->deletePayment($params[1]);
    break;
    case 'showLogin':
        $controller = new authController();
        $controller->showLogin();
    break;
    case 'login':
        $controller = new authController();
        $controller->login();
    break;
    case 'logout':
        $controller = new authController();
        $controller->logout();
    break;
default:
    echo ("404 page not found");
    break;
}
