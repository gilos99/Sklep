<?php
    require_once "libs/view.php";

    class ErrorView extends View
    {   
        public function initContent() 
        {
            $this->content = '
                <center>
                    <div id="error">
                        <img id="imgError" src="/sklep/assets/error.png" width="100%" height="100%"/><br/>
                        '.$this->data["msg"].'
                    </div>
                </center>
            ';        
        }
    }
    
?>