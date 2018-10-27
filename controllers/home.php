<?php
    require_once 'libs/controller.php';
    require_once 'libs/connector.php';
    require_once 'views/home/index.php';
    require_once 'views/home/item.php';
    require_once 'views/home/showcase.php';

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

        public function items($item = false)
        {
            if(!$item)
            {
                $this->view = new ItemView();
                $wynik = $this->db_conn->getItems();
                $this->view->addData("items" , $wynik);
                $this->view->initContent();
                $this->layout = new Layout("Items");
                $this->layout->setView($this->view);
                $this->layout->render();
            }
            else
            {
                $this->view = new ShowcaseView();
                $wynik = $this->db_conn->getItemById($item);
                $this->view->addData("item" , $wynik);
                $this->view->initContent();
                $this->layout = new Layout($wynik->name);
                $this->layout->setView($this->view);
                $this->layout->render();
            }
        }

        public function cart()
        {
            $this->view = new HomeView();
            $this->view->initContent();
            $this->layout = new Layout("Home");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }
?>