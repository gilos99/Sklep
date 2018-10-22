<?php
    abstract class View
    {
        protected $content = "";
        protected $data;

        function __construct()
        {
            $this->data = array();
        }

        public function getContent() {
            return $this->content;
        }

        public function addData($key , $value)
        {
            $this->data[$key] = $value;
        }

        abstract function initContent();
    }
?>