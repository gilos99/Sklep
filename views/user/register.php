<?php
    require_once "libs/view.php";

    class RegisterView extends View
    {   
        public function initContent() 
        {

            $error = "";

            if(isset($_SESSION["register_fail"]))
            {
                $e = $_SESSION["register_fail"];
                $error = "<b style='color : red;'>{$e}</b>";
            }

            $this->content = 
            "
                <div id='login_main'>
                    <center><h1>Zarejestruj się</h1></center>
                    <center>   
                        <form action='/sklep/user/signup' method='POST'>
                            Nazwa użytkownika :  <input type='text' name='login'/> <br />
                            Email :  <input id='email_reg' type='text' name='email'/> <br />
                            Hasło :  <input id='pass_tb' type='password' name='password'/> <br />
                            Powtórz hasło :  <input id='repass_tb' type='password' name='repeat_pw'/> <br />
                            <center>
                                <input id='submit_reg' type='submit' value='Zarejestruj się'/>
                            </center>
                            {$error}
                        </form>
                    </center>
                </div>
            ";            
        }
    }
    
?>
