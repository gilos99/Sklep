<?php
    class Layout
    {
        private $title = "Layout";
        private $contet = "";
        function __construct($_title) 
        {
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
            </head>
            <body>
                   $this->content
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