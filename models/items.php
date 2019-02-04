<?php 
    class Item
    {
        public $id;
        public $name;
        public $price;
        public $descr;
        public $img;

        public function setItem($_id , $_name , $_price , $_descr , $_img) {
            $this->id = $_id;
            $this->name = $_name;
            $this->price = $_price;
            $this->descr = $_descr;
            $this->img = $_img;
            return $this;
        }
    }
?>