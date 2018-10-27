<?php
    require_once "libs/view.php";

    class HomeView extends View
    {   
        public function initContent() 
        {
            $this->content = 
            "
                <div id='home_main'></div>
            ";            
        }
    }
    
?>
