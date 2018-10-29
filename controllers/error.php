<?php 
    require_once 'libs/controller.php';
    require_once 'views/error/index.php';

    class ErrorController extends Controller
    {
        private $msg;

        public function __construct($_msg) {
            $this->msg = $_msg;
        }

        public function init()
        {
            $this->view = new ErrorView();
            $this->view->addData("msg" , $this->msg);
            $this->view->initContent();
            $this->layout = new Layout("Error");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }
?>