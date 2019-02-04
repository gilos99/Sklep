<?php
    require_once "libs/view.php";

    class HomeView extends View
    {   
        public function initContent() 
        {
            $this->content = 
            "
                <div id='home_main'>
                   <img src='/sklep/assets/images/biurko.png' width='100%' height='100%'>
                </div>

            ";            
        }
    }
    
?>
