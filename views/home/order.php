<?php
    require_once "libs/view.php";

    class OrderView extends View
    {   
        public function initContent() 
        {
            $items = $this->data["items"];
            $price = 0;
            $count = count($items);

            foreach ($items as $key => $value) {
                $price += $value->price;
            }

            $this->header = "<script src='/sklep/scripts/lib.js'></script>";

            $error = "";

            if(isset($_SESSION["order_fail"]))
            {
                $error = "<b style='color : red;'>Wypełnij wszytkie wymagane pola!</b>";
                unset($_SESSION["order_fail"]);
            }

            $this->content = 
            "
                <div id='order_main'>
                    <center>
                    <br />
                    <h1>Złóż zamówienie</h1>
                    </center>

                    <form action='/sklep/home/submitOrder' method='POST'>
                        Imie : <input type='text' name='imie' > <br />
                        Nazwisko : <input type='text' name='nazwisko'> <br />
                        Adres : <input type='text' name='adres'> <br />
                        E-mail : <input type='text' name='email' > <br />
                        Bank : <select name='bank'>
                            <option>M-bank</option>
                            <option>PKO</option>
                            <option>PEKAO</option>
                            <option>Santander</option>
                            <option>Alior bank</option>
                        </select><br />
                        <input type='hidden' name='price' value='{$price}' >
                        <center><input id='submit_order' type='submit' value='Wyślij'></center>
                        $error
                    </form>
                    <div id='order_info'>
                        <p>Cena : $price zł </p>
                        <p>Ilość produktów : $count</p>
                    </div>
                    
                </div>
            ";            
        }
    }
    
?>
