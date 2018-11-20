<?php
require_once __DIR__ . '/daos/UserDAO.class.php';
require_once __DIR__ . '/daos/ProxyDAO.class.php';
?>
<html>
    <html>
        <head>
            <meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><title>TicTacToe</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
            <link rel="stylesheet" href="assets/css/main.css">
            <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
            <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
        </head>
        <body class="">

            <!-- Nav -->
            <nav id="nav">
                <ul class="container">
                    <li><a href="./index.php">Home</a></li>
                    <?php
                    ?>
                </ul>
            </nav>

            <!-- Home -->
            <div class="wrapper style1 first">
                <article class="container 75%" id="login">
                    <div class="row">

                        <?php
                        if (!isset($_SESSION)) {
                        session_start();
                        }

                        $proxy = new Proxy();
                        $proxy->setClient();
                        $client = $proxy->getClient();
                        
                        
                        ?>

                        <div class="11u 12u(mobile)">
                            
                        </div>
                    </div>
                </article>
            </div>

            <!-- Work -->






            <div class="wrapper style4" id ="register">
                <article id="contact" class="container 75%">
                    <header>
                    </header>

                    <footer>

                    </footer>
                </article>
            </div>

            <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/skel-viewport.min.js"></script>
            <script src="assets/js/util.js"></script>
            <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
            <script src="assets/js/main.js"></script>



        </body>
    </html>

