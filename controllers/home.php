<?php
    require_once 'views/home/index.php';
    require_once 'views/home/item.php';
    require_once 'views/home/showcase.php';
    require_once 'views/home/cart.php';
    require_once 'views/home/order.php';
    require_once 'models/order.php';
    require_once 'models/comment.php';

    class Home extends Controller
    {
        private $s_text;
        private $items;

        function __construct() {
            $this->s_text = "";
            $this->items = array((new Item())->setItem(1 , "Biurko" , 40 , "Biurko gamingowe." , "/sklep/assets/images/biurko.png") , (new Item())->setItem(2 , "Krzesło" , 20 , "Krzesło takie do siedzenia." , "/sklep/assets/images/krzeslo.png") , (new Item())->setItem(3 , "Łóżko" , 70 , "Łóżko drewniane." , "/sklep/assets/images/lozko.png") , (new Item())->setItem(4 , "Stolik" , 20 , "Stół do kawy." , "/sklep/assets/images/stol.png") , (new Item())->setItem(5 , "Szafa" , 120 , "Szafka na ubrania." , "/sklep/assets/images/szafka.png"));
        }

        public function init() 
        {
            unset($_SESSION["items"]);
            $this->view = new HomeView();
            $this->view->initContent();
            $this->layout = new Layout("Meblexpol");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function items($num = false)
        {

            if(isset($_SESSION["email"]))
            {
                echo $_SESSION["email"];
                unset($_SESSION["email"]);
            }

            if(!isset($_SESSION["items"]))
            {
                $_SESSION["items"] = $this->items;
            }

            if(!$num)
            {
                $this->view = new ItemView();
                $this->view->addData("items" , $_SESSION["items"]);
                $this->view->addData("site" , 1);
                $this->view->initContent();
                $this->layout = new Layout("Meblexpol");
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
            $wynik = $this->items[$item - 1];
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
                $this->view->addData("items" , $this->items);
            }
            $this->view->initContent();
            $this->layout = new Layout("Koszyk");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function addToCart($num)
        {
            $n = (Integer)$num;
            $i = $this->items[$num - 1];
            $_SESSION["cart"][$i->id] = $i;
            header('Location: /sklep/home/item/'.$n);
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
            $itm = $this->items;

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
            $this->view->addData("items" , $_SESSION["cart"]);
            $this->view->initContent();
            $this->layout = new Layout("Koszyk");
            $this->layout->setView($this->view);
            $this->layout->render();
        }

        public function submitOrder()
        {
            $o = new Order();
            $o->name = $_POST["imie"];
            $o->last_name = $_POST["nazwisko"];
            $o->address = $_POST["adres"];
            $o->email = $_POST["email"];
            $o->price = $_POST["price"];
            $o->items = $_SESSION["cart"];

            if($this->sendOrderEmail($o))
            {
                unset($_SESSION["cart"]);
                $_SESSION["email"] = "<script>alert('Złożono zamówienie!')</script>";
            }
            else
            {
                echo "Something went wrong!";
                $_SESSION["email"] = "<script>alert('Wykryto problem z połączeniem! Spróbuj jeszcze raz!')</script>";
            }
            header("Location: /sklep/home/items");
        }

        private function sendOrderEmail($order)
        {
            require_once "mailer/src/PHPMailer.php";
            require_once "mailer/src/Exception.php";
            require_once "mailer/src/SMTP.php";

            ini_set("SMTP","ssl://smtp.gmail.com"); 
            ini_set("smtp_port","465"); 
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            $success = false;

            try
            {
                $mail->CharSet = 'UTF-8';
                $mail->SMTPAuth = true;
                $mail->Host = "smtp.gmail.com"; 
                $mail->SMTPSecure = "ssl";
                $mail->Username = "testphpemail123123@gmail.com"; 
                $mail->Password = "zaq1@WSX"; 
                $mail->Port = "465";
                $mail->From = "testphpemail123123@gmail.com";
                $mail->isSMTP();  
                $rec1="testphpemail123123@gmail.com";
                $mail->AddAddress($rec1);
                $mail->Subject  = "Nowe zamówienie";

                $products = "";

                foreach ($order->items as $key => $value) {
                    $products .= 
                    "
                    <tr>
                        <td>{$value->name}</td>
                        <td>{$value->price} zł</td>
                    <tr/>

                    ";
                }

                $mail->Body     = "

                    <html>
                        <head>

                        </head>
                        <body>
                            <table>
                                <tr>
                                    <th>Imie </th>
                                    <td>{$order->name}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{$order->email}</td>
                                </tr>
                                <tr>
                                    <th>Adres</th>
                                    <td>{$order->address}</td>
                                </tr>
                                <tr>
                                    <th>Produkty</th>
                                </tr>
                                {$products}
                                <tr>
                                    <th>SUMA</th>
                                    <td>{$order->price} zł</td>
                                </tr>
                            </table>
                        </body>
                    </html>
            
                ";
                $mail->isHTML(true);
                $mail->WordWrap = 200;
                $success = $mail->Send();
            }
            catch(phpmailerException $e )
            { 
                echo $e->errorMessage();
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

            return $success;
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