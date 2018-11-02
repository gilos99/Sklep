<?php
    require_once "libs/view.php";

    class LoginView extends View
    {   
        public function initContent() 
        {

            $error = "";

            if(isset($_SESSION["login_fail"]))
            {   
                $error = "<b style='color : red;'>Nieprawidłowy login lub hasło</b>";
                unset($_SESSION["login_fail"]);
            }

            $this->content = 
            "
                <div id='login_main'>
                    <center><h1>Zaloguj się</h1></center>
                    <center><form action='/sklep/user/signin' method='POST'>
                            Nazwa użytkownika :  <input type='text' name='login'/> <br />
                            Hasło :  <input id='pass_tb' type='password' name='password'/> <br />
                            <center><input id='submit_login' type='submit' value='Zaloguj się'/></center>
                            {$error}
                    </form></center>
                </div>
            ";            
        }
    }
    
?>
