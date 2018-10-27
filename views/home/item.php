<?php
    require_once "libs/view.php";

    class ItemView extends View
    {   

        private $rows = "";

        public function initContent() 
        {   
            $items = $this->data["items"];

            foreach ($items as $key => $value) {
                $this->rows .= "<div id='item'><a href='/sklep/home/item/".$value->id."'><div id='item_img'><img src='".$value->img."' width='100%' height='100%'></div><div id='item_d'><b>".$value->name."</b><br />".$value->price." zł<br /></div></a></div>";
            }

            $this->content = 
            "   
                <center>
                    <div id='item_main'>
                        $this->rows
                    </div>
                </center>
            ";            
        }
    }
    
?>
