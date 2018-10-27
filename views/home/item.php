<?php
    require_once "libs/view.php";

    class ItemView extends View
    {   

        private $rows = "";
        private $sites = 0;

        public function initContent() 
        {   
            $items = $this->data["items"];
            $length = count($items);

            $first = ($this->data["site"] - 1) * 16;
            $last = $first + 16;

            foreach ($items as $key => $value) {
                if($key >= $first && $key < $last)
                {
                    $this->rows .= "<div id='item'><a href='/sklep/home/item/".$value->id."'><div id='item_img'><img src='".$value->img."' width='100%' height='100%'></div><div id='item_d'><b>".$value->name."</b><br />".$value->price." zł<br /></div></a></div>";
                }
            }

            $this->sites = $length / 16;

            $nums = '';

            for ($i=0; $i < $this->sites; $i++) { 
                $nums .= "<div id='num_btn'><a href='/sklep/home/items/".($i + 1)."'>".($i + 1)."</a></div>";
            }

            $this->content = 
            "   
                <center>
                    <div id='item_main'>
                        <div id='items_grid'>
                            $this->rows
                        </div>
                    </div>
                    <div id='numbers'>
                        <center>
                            $nums
                        </center>
                    </div>
                </center>
            ";            
        }
    }
    
?>
