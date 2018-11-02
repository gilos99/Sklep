<?php
    require_once "models/items.php";
    require_once "controllers/error.php";

    class Connector
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new PDO('mysql:host=127.0.0.1;dbname=shop;charset=utf8' , 'root' , '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        public function addOrder($order)
        {
            $sql = "INSERT INTO zamowienia (imie , nazwisko , adres , bank , rabat , price) VALUES (:name , :surname , :adress , :bank , :rabat , :price);";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name' , $order->name);
            $stmt->bindParam(':surname' , $order->surname);
            $stmt->bindParam(':adress' , $order->adress);
            $stmt->bindParam(':bank' , $order->bank);
            $stmt->bindParam(':rabat' , $order->rabat);
            $stmt->bindParam(':price' , $order->price);
            $stmt->execute();
            $last = $this->conn->lastInsertId();

            $items = $_SESSION["cart"];

            foreach ($items as $key => $value) {
                $sql = "INSERT INTO item_order (id_zamowienia , id_produktu) VALUES ('{$last}' , '{$value->id}');";
                $this->conn->query($sql);
            }

            unset($_SESSION["cart"]);
        }

        public function getItems()
        {
            $wynik = array();

            $sql = "SELECT * FROM items";

            $stmt = $this->conn->query($sql);

            while($row = $stmt->fetch())
            {
                $item = new Item();
                $item->setItem($row["id"] , $row["name"] , $row["price"] , $row["descr"] , $row["img"]);
                array_push($wynik , $item);
            }

            return $wynik;
        }

        public function getItemById($id)
        {
            $wynik = new Item();
            $wynik->setItem(0 , "brak" , 0 , "brak" , "-");

            $sql = "select * from items where id = ".$id."";

            $stmt = $this->conn->query($sql);

            while($row = $stmt->fetch())
            {
                $wynik->setItem($row["id"] , $row["name"] , $row["price"] , $row["descr"] , $row["img"]);
            }

            return $wynik;
        }
    }
?>