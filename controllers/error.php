<?php 
    require_once 'libs/controller.php';
    require_once 'views/error/index.php';

    class ErrorController extends Controller
    {
        function __construct($data)
        {
            $this->view = new ErrorView();
            $this->view->addData("msg" , $data);
            $this->view->initContent();
            $this->layout = new Layout("Error");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }
?>