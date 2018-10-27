<?php
    class Layout
    {
        private $title = "Layout";
        private $contet = "";
        private $year;

        function __construct($_title) 
        {
            $this->year = date("Y");
            $this->title = $_title;
        }

        public function render() 
        {
ECHO <<< END
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8" />
                <title>$this->title</title>
                <link rel="stylesheet" type="text/css" href="/sklep/styles/style.css">
            </head>
            <body>
                <div id="titlebar">
                    <center><p>Sklep</p></center>
                </div>
                <div id="nav">
                    <center>
                        <table id="navtable">
                            <tr>
                                <td>
                                    <a href="/sklep/home">Strona Główna</a>
                                    <a href="/sklep/home/items">Produkty</a>
                                    <a href="/sklep/home/cart">Koszyk</a>
                                </td>
                            </tr>
                        </table>
                    </center>
                </div>
                <div id="main">
                    $this->content
                </div>
                <footer>&copy; Jan Gil $this->year</footer>
            </body>
            </html>
END;
        }

        public function setView($view)
        {
            $this->content = $view->getContent();
        }
    }
?>