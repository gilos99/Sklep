<?php
    require_once "libs/view.php";

    class ShowcaseView extends View
    {   
        private $item;

        public function initContent() 
        {   

            $this->item = $this->data["item"];

            $this->content = 
            "   
                <center>
                    <div id='sc_main'>
                        <img id='sc_img' width='100%' height='100%' src='{$this->item->img}'/> <div id='sc_menu'><b>Cena : {$this->item->price} zł</b><br /> <a href='#'><div id='addcart'>Dodaj do koszyka</div></a></div><br/>
                        <div id='sc_desc'>
                            <h1>{$this->item->name}</h1> <br />
                            {$this->item->descr}
                        </div>
                    </div>
                </center>
            ";            
        }
    }
    
?>