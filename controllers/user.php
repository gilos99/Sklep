<?php
    require_once 'libs/controller.php';
    require_once 'views/user/login.php';
    require_once 'views/user/register.php';
    require_once 'libs/connector.php';

    class User extends Controller
    {
        private $db_conn;
        public function __construct() {
            $this->db_conn = new Connector();
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

        public function signin()
        {
            $login = $_POST["login"];
            $password = $_POST["password"];

            if($this->db_conn->isUserValid($login , $password))
            {   
                $_SESSION["user"] = $this->db_conn->getUser($login , $password);
                header('Location: /sklep/home');
            }
            else
            {
                $_SESSION["login_fail"] = true;
                header('Location: /sklep/user/login');
            }
        }

        public function logout()
        {
            unset($_SESSION["user"]);
            header('Location: /sklep/home');
        }

        public function signup()
        {
            $login = $_POST["login"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $password_r = $_POST["repeat_pw"];

            if($password == $password_r)
            {
                if(!$this->db_conn->isLoginExist($login))
                {
                    $user = new UserModel();
                    $user->login = $login;
                    $user->password = $password;
                    $user->email = $email;
                    $this->db_conn->createUser($user);
                    header('Location: /sklep/home');
                }
                else
                {
                    $_SESSION["register_fail"] = "Użytkownik o podanym loginie już istnieje";
                    header('Location: /sklep/user/register');
                }
            }
            else
            {
                $_SESSION["register_fail"] = "Podane hasła nie pasują do siebie";
                header('Location: /sklep/user/register');
            }

        }

    }   

?>