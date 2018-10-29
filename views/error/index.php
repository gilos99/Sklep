<?php
    require_once "libs/view.php";

    class ErrorView extends View
    {   
        public function initContent() 
        {
            $e_msg = $this->data["msg"];

            $this->content = "
                <center>
                    <div id='error'>
                        <img id='imgError' src='/sklep/assets/error.png' width='100%' height='100%'/><br/>
                        {$e_msg}
                    </div>
                </center>
            ";        
        }
    }
    
?>