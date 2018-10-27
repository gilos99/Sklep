<?php 
    require_once 'libs/controller.php';
    require_once 'views/error/index.php';

    class ErrorController extends Controller
    {
        private $data;

        function __constructor($_data) {
            $this->data = $_data;
        }

        public function init()
        {
            $this->view = new ErrorView();
            $this->view->addData("msg" , $this->data);
            $this->view->initContent();
            $this->layout = new Layout("Error");
            $this->layout->setView($this->view);
            $this->layout->render();
        }
    }
?>