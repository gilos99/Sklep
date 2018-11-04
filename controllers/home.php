<?php
    require_once 'libs/controller.php';
    require_once 'libs/connector.php';
    require_once 'views/home/index.php';
    require_once 'views/home/item.php';
    require_once 'views/home/showcase.php';
    require_once 'views/home/cart.php';
    require_once 'views/home/order.php';
    require_once 'models/order.php';
    require_once 'models/comment.php';

    class Home extends Controller
    {
        private $db_conn;
        private $s_text;

        function __construct() {
            $this->db_conn = new Connector();
            $this->s_text = "";
        }

        public function init() 
        {
            unset($_SESSION["items"]);
            $this->view = new HomeView();
            $this->view->initContent();
            $this->layout = new Layout("Sklep");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function items($num = false)
        {

            if(!isset($_SESSION["items"]))
            {
                $_SESSION["items"] = $this->db_conn->getItems();
            }

            if(!$num)
            {
                $this->view = new ItemView();
                $this->view->addData("items" , $_SESSION["items"]);
                $this->view->addData("site" , 1);
                $this->view->initContent();
                $this->layout = new Layout("Sklep");
                $this->layout->setView($this->view);
                $this->layout->render();
            }
            else
            {
                $this->view = new ItemView();
                $this->view->addData("items" , $_SESSION["items"]);
                $this->view->addData("site" , $num);
                $this->view->initContent();
                $this->layout = new Layout("Sklep");
                $this->layout->setView($this->view);
                $this->layout->render();
            }
        }

        public function item($item)
        {
            $this->view = new ShowcaseView();
            $wynik = $this->db_conn->getItemById($item);
            $comments = $this->db_conn->getCommentsByItemId($item);
            $this->view->addData("comments" , $comments);
            $this->view->addData("item" , $wynik);
            $this->view->initContent();
            $this->layout = new Layout($wynik->name);
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function itemsRefresh()
        {
            unset($_SESSION["items"]);
            header('Location: /sklep/home/items');
        }

        public function cart()
        {   
            unset($_SESSION["items"]);
            $this->view = new CartView();
            if(isset($_SESSION["cart"]))
            {
                $this->view->addData("items" , $_SESSION["cart"]);
            }
            else
            {
                $this->view->addData("items" , array());
            }
            $this->view->initContent();
            $this->layout = new Layout("Koszyk");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function addToCart($num)
        {
            $i = $this->db_conn->getItemById($num);
            $_SESSION["cart"][$i->id] = $i;
            header('Location: /sklep/home/item/'.$num);
        }

        public function deleteFromCart($num)
        {
            if(isset($_SESSION['cart'][$num]))
            {
                unset($_SESSION['cart'][$num]);
            }
            header('Location: /sklep/home/cart');
        }

        public function search()
        {
            $itm = $this->db_conn->getItems();

            if(isset($_POST["text"]))
            {
                $this->s_text = $_POST["text"];

                if($this->s_text != NULL && $this->s_text != "")
                {
                    $filtered_items = array_values(array_filter($itm , function($x){
                        return $this->containsText(strtoupper($x->name) , strtoupper($this->s_text));
                    }));
                }
                    
                unset($_SESSION["items"]);
    
                $_SESSION["items"] = $filtered_items;
            }

            header('Location: /sklep/home/items');
        }

        public function order()
        {
            $this->view = new OrderView();
            if(!isset($_SESSION["cart"]))
            {
                $_SESSION["cart"] = array();
            }
            $this->view->addData("items" , $_SESSION["cart"]);
            $this->view->initContent();
            $this->layout = new Layout("Złóż zamówienie");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function submitOrder()
        {
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $adres = $_POST["adres"];
            $bank = $_POST["bank"];
            $rabat = $_POST["rabat"];

            $price = 0;

            foreach ($_SESSION["cart"] as $key => $value) {
                $price += $value->price;
            }

            if(isset($imie) && isset($nazwisko) && isset($adres) && isset($bank))
            {
                if($imie == "" || $nazwisko == "" || $adres == "")
                {
                    $_SESSION["order_fail"] = true;
                    $this->order();
                    exit();
                }
            }

            $order = new Order();
            $order->name = $imie;
            $order->surname = $nazwisko;
            $order->adress = $adres;
            $order->bank = $bank;
            $order->price = $price;
            if(isset($rabat))
            {
                $order->rabat = $rabat;
            }
            else
            {
                $order->rabat = " ";
            }

            $this->db_conn->addOrder($order);

            echo "<script>alert(\"Złożono zamówienie!\");</script>";

            header('Location: /sklep/home');
        }

        public function addcomment()
        {
            $item = json_decode($_POST["item"]);
            $user = json_decode($_POST["user"]);
            $text = $_POST["text"];

            $comment = new Comment();
            $comment->item = $item;
            $comment->user = $user;
            $comment->text = $text;

            $this->db_conn->createComment($comment);

            header('Location: /sklep/home/item/'.$item->id);
        }

        private function containsText($string , $txt)
        {
            if(strpos($string , $txt) !== false)
            {
                return true;
            } 
            return false;
        }

    }
?>