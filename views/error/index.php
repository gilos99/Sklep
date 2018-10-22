<?php
    require_once "libs/view.php";

    class ErrorView extends View
    {   
        public function initContent() 
        {
            $this->content = $this->data["msg"];        
        }
    }
    
?>