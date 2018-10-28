<?php
    abstract class View
    {
        protected $header = "";
        protected $content = "";
        protected $data;

        function __construct()
        {
            $this->data = array();
        }

        public function getContent() {
            return $this->content;
        }

        public function getHeader()
        {
            return $this->header;
        }

        public function addData($key , $value)
        {
            $this->data[$key] = $value;
        }

        abstract function initContent();
    }
?>