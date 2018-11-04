<?php
    require_once "libs/view.php";

    class ShowcaseView extends View
    {   
        private $item;

        public function initContent() 
        {   
            $this->item = $this->data["item"];
            $comments = $this->data["comments"];
            $this->header = "<script src='/sklep/scripts/lib.js'></script>";

            $komentarze = "";

            if(count($comments) > 0)
            {
                foreach ($comments as $key => $value) {
                    $komentarze .= "<div class='comment'><p><b><div style='float : left; margin-left : 10px;'>{$value->user->login}</div></b></p><br />{$value->text}</div>";
                }
            }
            else
            {
                $komentarze = "<b><br />Brak komentarzy</b>";
            }

            $name = strtoupper($this->item->name);

            $add_comment = "";

            if(isset($_SESSION["user"]))
            {
                $user = $_SESSION["user"];

                $s_user = json_encode($user);
                $s_item = json_encode($this->item);

                $add_comment = 
                "<div id='add_comment'>
                    <form action='/sklep/home/addcomment' method='POST'>
                        <br />
                        <b>{$user->login}</b> <br />
                        <input type='hidden' name='item' value='{$s_item}'>
                        <input type='hidden' name='user' value='{$s_user}'>
                        <textarea id='ta_comment' maxlength='400' name='text'></textarea> <br /></br>
                        <input id='comm_sub' type='submit' value='Dodaj komentarz'>
                    </form>
                </div>";
            }

            $this->content = 
            "   
                <center>
                    <div id='sc_main'>
                        <img id='sc_img' width='100%' height='100%' src='{$this->item->img}'/> <div id='sc_menu'><b>Cena : {$this->item->price} zł</b><br /> <a href='/sklep/home/addToCart/{$this->item->id}'><div id='addcart' onclick=\"showAlert('Dodaj do koszyka')\">Dodaj do koszyka</div></a></div><br/>
                        <div id='sc_desc'>
                            <h1>{$name}</h1> <br />
                            {$this->item->descr}
                            <h1>KOMENTARZE</h1> <br />
                            $add_comment
                            $komentarze
                        </div>
                    </div>
                </center>
                <script src='/sklep/scripts/sc.js'></script>
            ";            
        }
    }
    
?>