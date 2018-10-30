<?php
    require_once "libs/view.php";

    class HomeView extends View
    {   
        public function initContent() 
        {
            $this->content = 
            "
                <div id='home_main'>
                    <div id='big_img'>
                        <img id='img1' src='/sklep/assets/items/kroksy.png' width='100%' height='100%'/>
                    </div>
                    <div id='small_img'>
                        <img id='img2' src='/sklep/assets/items/szalik1.jpg' width='100%' height='100%'/>
                    </div>
                    <div id='small_img'>
                        <img id='img3' src='/sklep/assets/items/kurtka1.jpg' width='100%' height='100%'/>
                    </div>
                </div>

                <script src='/sklep/scripts/gallery.js'></script>
            ";            
        }
    }
    
?>
