<?php

    include_once 'controllers/error.php';

    class Bootstrap
    {
        function __construct()
        {
            $uri = "";

            if(isset($_GET["uri"]))
            {
                $uri = $_GET["uri"];
            }

            if($uri == "")
            {
                $uri = "home";
            }

            $uri = rtrim($uri , '/');
            $url = explode('/' , $uri);
            
            $file = 'controllers/'.$url[0].'.php';

            if(file_exists($file))
            {
                include_once $file;
            }
            else
            {
                $error = new ErrorController("Nie ma takiej strony!");
                $error->init();
                exit();
            }

            $controller = new $url[0];

            if(isset($url[1]))
            {
                if(isset($url[2]))
                {
                    if(method_exists($controller , $url[1]))
                    {
                        $controller->{$url[1]}($url[2]);
                    }
                    else
                    {
                        $error = new ErrorController("Nie ma takiej strony!");
                        $error->init();
                        exit();
                    }
                }
                else
                {
                    if(method_exists($controller , $url[1]))
                    {
                        $controller->{$url[1]}();
                    }
                    else
                    {
                        $error = new ErrorController("Nie ma takiej strony!");
                        $error->init();
                        exit();
                    }
                }
            }
            else
            {
                $controller->init();
            }

        }
    }
?>