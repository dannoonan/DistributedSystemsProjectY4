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
                        $usersArray = array();
                        $resultArray = array();
                        $response = $client->leagueTable();
                        $leagueTableUnsplit = $response->return;
                        $leagueTable = explode("\n",$leagueTableUnsplit);
                        foreach($leagueTable as $game){
                            if($game == 'ERROR-NOGAMES')
                               echo 'No Game Data Available';
                           else{
                            $split = explode(",", $game);
                            if(!in_array($split[1], $usersArray)){
                                array_push($usersArray, $split[1]);
                            }
                            if(!in_array($split[2], $usersArray)){
                                array_push($usersArray, $split[2]);
                            }
                           }
                        }  
                        foreach($usersArray as $user){
                            $wins = 0;
                            $losses = 0;
                            $draws = 0;
                            foreach($leagueTable as $game){
                                $split = explode(",", $game);
                                if($split[1]==$user)
                                {
                                    if($split[3]==1){
                                        $wins++;
                                    }
                                    else if($split[3]==3){
                                        $draws++;
                                    }
                                    else if($split[3]==2){
                                        $losses++;
                                    }
                                }
                                if($split[2]==$user)
                                {
                                    if($split[3]==2){
                                        $wins++;
                                    }
                                    else if($split[3]==3){
                                        $draws++;
                                    }
                                    else if($split[3]==1){
                                        $losses++;
                                    }
                                }
                            }
                            array_push($resultArray, $wins.",".$losses.",".$draws.",".$user);
                            //echo $user.'<br>Wins: '.$wins.'<br>Losses: '.$losses.'<br>Draws: '.$draws;
                            //$user = $user.'Wins: '.$wins.'\nLosses: '.$losses.'\nDraws: '.$draws;
                        }
                       
                        
                        ?>

                        <div class="11u 12u(mobile)">
                            <h3>
                                <?php
                                foreach ($resultArray as $result) {
                                
                                $split = explode(",", $result);
                                echo 'User: '. $split[3];
                                echo '<br>';
                                echo 'Wins '. $split[0].' -- Losses '. $split[1]." -- Draws ".$split[2];
                                echo '<br>';
                                echo '<br>';
                            }
                                ?>
                            </h3>
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

