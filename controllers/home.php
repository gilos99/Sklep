<?php
    require_once 'libs/controller.php';
    require_once 'libs/connector.php';
    require_once 'views/home/index.php';
    require_once 'views/home/item.php';
    require_once 'views/home/showcase.php';
    require_once 'views/home/cart.php';

    class Home extends Controller
    {
        private $db_conn;

        function __construct() {
            $this->db_conn = new Connector();
        }

        public function init() 
        {
            $this->view = new HomeView();
            $this->view->initContent();
            $this->layout = new Layout("Home");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function items($num = false)
        {
            if(!$num)
            {
                $this->view = new ItemView();
                $wynik = $this->db_conn->getItems();
                $this->view->addData("items" , $wynik);
                $this->view->addData("site" , 1);
                $this->view->initContent();
                $this->layout = new Layout("Items");
                $this->layout->setView($this->view);
                $this->layout->render();
            }
            else
            {
                $this->view = new ItemView();
                $wynik = $this->db_conn->getItems();
                $this->view->addData("items" , $wynik);
                $this->view->addData("site" , $num);
                $this->view->initContent();
                $this->layout = new Layout("Items");
                $this->layout->setView($this->view);
                $this->layout->render();
            }
        }

        public function item($item)
        {
            $this->view = new ShowcaseView();
            $wynik = $this->db_conn->getItemById($item);
            $this->view->addData("item" , $wynik);
            $this->view->initContent();
            $this->layout = new Layout($wynik->name);
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function cart()
        {   
            $this->view = new CartView();
            if(isset($_SESSION["cart"]))
            {
                $this->view->addData("items" , $_SESSION["cart"]);
            }
            else
            {
                $this->view->addData("items" , array());
            }
            $this->view->initContent();
            $this->layout = new Layout("Home");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function addToCart($num)
        {
            $i = $this->db_conn->getItemById($num);
            $_SESSION["cart"][$i->id] = $i;
            header('Location: /sklep/home/item/'.$num);
        }

        public function deleteFromCart($num)
        {
            if(isset($_SESSION['cart'][$num]))
            {
                unset($_SESSION['cart'][$num]);
            }
            header('Location: /sklep/home/cart');
        }
    }
?>