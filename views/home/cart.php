<?php
    require_once "libs/view.php";

    class CartView extends View
    {   
        public function initContent() 
        {
            $itemy = $this->data['items'];

            $content = "";

            foreach ($itemy as $key => $value) {
                $content .= "<div id='cart_item' class='i_cart'><img src='$value->img' width='100%'  height='100%'/><div id='cart_item_name'>$value->name</div><div id='cart_item_price'>$value->price zł</div> <div id='delete_btn'><a href='/sklep/home/deleteFromCart/{$value->id}'>X</a></div></div>";
            }   

            $this->content = 
            "
                <center>
                    <div id='cart_main'>
                        $content
                    </div>
                </center>
                <script src='/sklep/scripts/cart.js'></script>
            ";            
        }
    }
    
?>
