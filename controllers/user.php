<?php
    require_once 'libs/controller.php';
    require_once 'views/user/login.php';
    require_once 'views/user/register.php';

    class User extends Controller
    {
        public function __construct() {

        }

        public function init()
        {
            header('Location: /sklep/home');
        }

        public function login()
        {
            $this->view = new LoginView();
            $this->view->initContent();
            $this->layout = new Layout("Zaloguj się");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function register()
        {
            $this->view = new RegisterView();
            $this->view->initContent();
            $this->layout = new Layout("Zarejestruj się");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }   

?>