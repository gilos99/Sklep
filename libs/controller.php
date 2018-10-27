<?php
    require_once 'layouts/layout.php';

    abstract class Controller
    {
        protected $layout;
        protected $view;
        abstract function init();
    }
?>