<?php
    require_once "libs/view.php";

    class ItemView extends View
    {   

        private $rows = "";

        public function initContent() 
        {   
            $items = $this->data["items"];

            foreach ($items as $key => $value) {
                $this->rows .= "<a href='/sklep/home/items/".$value->id."'><div id='item'><div id='item_img'><img src='".$value->img."' width='100%' height='100%'></div><div id='item_d'><b>".$value->name."</b><br />".$value->price." zł<br /></div></div></a>";
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
