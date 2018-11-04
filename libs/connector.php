<?php
    require_once "models/items.php";
    require_once "controllers/error.php";
    require_once "models/user.php";
    require_once "models/comment.php";
    require_once "models/items.php";

    class Connector
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new PDO('mysql:host=127.0.0.1;dbname=shop;charset=utf8' , 'root' , '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        public function getUserById($id)
        {
            $sql = "SELECT * FROM user WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id' , $id);
            $stmt->execute();

            $user = new UserModel();

            $row = $stmt->fetch();

            $user->id = $row["id"];
            $user->login = $row["login"];
            $user->password = $row["password"];
            $user->email = $row["email"];

            return $user;
        }

        public function getUser($login , $password)
        {
            $sql = "SELECT * FROM user where login = :login and password = :password";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':login' , $login);
            $stmt->bindParam(':password' , md5($password));
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
            $stmt->bindParam(":password" , md5($user->password));
            $stmt->bindParam(":email" , $user->email);
            $stmt->execute();
        }

        public function isUserValid($login , $password)
        {
            $sql = "select * from user where login = :login and password = :password";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":login" , $login);
            $stmt->bindParam(":password" , md5($password));
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

        public function getCommentsByItemId($id)
        {
            $comments = array();

            $sql = "SELECT * FROM comment where id_item = {$id}";
            $stmt = $this->conn->query($sql);

            while($row = $stmt->fetch())
            {
                $comment = new Comment();
                $comment->id = $row["id"];
                $comment->item = $this->getItemById($row["id_item"]);
                $comment->user = $this->getUserById($row["id_user"]);
                $comment->text = $row["text"];
                array_push($comments , $comment);
            }

            return $comments;
        }

        public function createComment($comment)
        {
            $sql = "INSERT INTO comment (id_item , id_user , text) VALUES (:id_item , :id_user , :text)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_item' , $comment->item->id);
            $stmt->bindParam(':id_user' , $comment->user->id);
            $stmt->bindParam(':text' , $comment->text);
            $stmt->execute();
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