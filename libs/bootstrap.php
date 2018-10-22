<?php

    require_once 'controllers/error.php';

    class Bootstrap
    {
        function __construct()
        {
            $url = "";

            //jeżeli istnieje zmienna uri w sciezce strony
            if(isset($_GET['uri']))
            {
                $url = $_GET['uri'];
            }
            else
            {
                $url = "home";
            }

            $url = rtrim($url , '/'); //usunięcie '/' z url

            $url = explode('/' , $url); //rozdzielenie url 

            //ustawienie defaultowej strony (jeśli url jest pusty domyślnym controllerem jest home)
            if($url[0] == "")
            {
                $url[0] = 'home';
            }

            $file = 'controllers/'.$url[0].'.php'; 

            if(file_exists($file))
            {
                require $file;
            }
            else
            {
                new ErrorController("Nie ma takiego pliku");
                exit(); // jeżeli nie ma pliku nie wykonuj dalej 
            }

            $controller = new $url[0];

            /*
                *Wywoływanie funkcji w controllerach
            */

            if(isset($url[2]))
            {
                if(method_exists($controller , $url[1]))
                {
                    $controller->{$url[1]}($url[2]);
                }
                else
                {
                    new ErrorController("Nie ma takiej funkcji");
                }
            }   
            else if(isset($url[1]))
            {
                if(method_exists($controller , $url[1]))
                {
                    $controller->{$url[1]}();
                }
                else
                {
                    new ErrorController("Nie ma takiej funkcji");
                }
            }
        }
    }
?>