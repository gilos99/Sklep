<?php
    require_once 'libs/controller.php';
    require_once 'views/home/index.php';

    class Home extends Controller
    {
        function __construct() 
        {
            $this->view = new HomeView();
            $this->view->initContent();
            $this->layout = new Layout("Home");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }
?>