<?php
    require_once "models/items.php";
    require_once "controllers/error.php";

    class Connector
    {
        private $host = "127.0.0.1";
        private $user = "root";
        private $password = "";
        private $db_name = "shop";
        private $mysqli;

        public function __construct()
        {
            $this->mysqli = new mysqli($this->host , $this->user , $this->password , $this->db_name);
            if($this->mysqli->connect_errno)
            {
                $error = new ErrorController("Nie można połączyć z bazą danych!");
                $error->init();
                exit();
            }
        }

        public function getItems()
        {
            $wynik = array();

            $sql = "SELECT * FROM items";

            if($result = $this->mysqli->query($sql))
            {
                while($row = $result->fetch_row())
                {
                    $item = new Item();
                    $item->setItem($row[0] , $row[1] , $row[2] , $row[3] , $row[4]);
                    array_push($wynik , $item);
                }
            }

            $result->close();

            return $wynik;
        }

        public function getItemById($id)
        {
            $wynik = new Item();
            $wynik->setItem(0 , "brak" , 0 , "brak" , "-");

            $sql = "select * from items where id = ".$id."";

            if($result = $this->mysqli->query($sql))
            {
                while ($row = $result->fetch_row()) {
                    $wynik->setItem($row[0] , $row[1] , $row[2] , $row[3] , $row[4]);
                }
            }
            
            return $wynik;
        }
    }
?>