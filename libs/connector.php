<?php
    require_once "models/items.php";
    require_once "controllers/error.php";
    require_once "models/user.php";

    class Connector
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new PDO('mysql:host=127.0.0.1;dbname=shop;charset=utf8' , 'root' , '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        public function getUser($login , $password)
        {
            $sql = "SELECT * FROM user where login = :login and password = :password";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':login' , $login);
            $stmt->bindParam(':password' , $password);
            $stmt->execute();

            $user = new UserModel();
            
            $row = $stmt->fetch();

            $user->id = $row["id"];
            $user->login = $row["login"];
            $user->password = $row["password"];
            $user->email = $row["email"];

            return $user;
        }

        public function createUser($user) {
            $sql = "INSERT INTO user (login , password , email) VALUES (:login , :password , :email)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":login" , $user->login);
            $stmt->bindParam(":password" , $user->password);
            $stmt->bindParam(":email" , $user->email);
            $stmt->execute();
        }

        public function isUserValid($login , $password)
        {
            $sql = "select * from user where login = :login and password = :password";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":login" , $login);
            $stmt->bindParam(":password" , $password);
            $stmt->execute();

            $i = 0;

            while($row = $stmt->fetch())
            {
                $i++;
            }

            return $i > 0;
        }

        public function isLoginExist($login)
        {
            $sql = "select * from user where login = :login";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":login" , $login);
            $stmt->execute();

            $i = 0;

            while($row = $stmt->fetch())
            {
                $i++;
            }

            return $i > 0;
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