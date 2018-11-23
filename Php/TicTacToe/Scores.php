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
                        $xml_array["uid"] = $_SESSION['UserId'];
                        $response = $client->showAllMyGames($xml_array);
                        $gameString = $response->return;
                        
                        $response = $client->leagueTable();
                        $leagueTableUnsplit = $response->return;
                        $leagueTable = explode("\n",$leagueTableUnsplit);

                        $wins = 0;
                        $losses = 0;
                        $draws = 0;
                        foreach ($leagueTable as $game) {
                            $split = explode(",", $game);
                            if ($split[1] == $_SESSION['Username']) {
                                if ($split[3] == 1) {
                                    $wins++;
                                } else if ($split[3] == 3) {
                                    $draws++;
                                } else if ($split[3] == 2) {
                                    $losses++;
                                }
                            }
                            if ($split[2] == $_SESSION['Username']) {
                                if ($split[3] == 2) {
                                    $wins++;
                                } else if ($split[3] == 3) {
                                    $draws++;
                                } else if ($split[3] == 1) {
                                    $losses++;
                                }
                            }
                        }





                        /*

                          $allGames = explode("\n", $gameString);
                          foreach ($allGames as $singleGame){
                          if($singleGame == 'ERROR-NOGAMES')
                          echo 'No Game Data Available';
                          else{
                          $split = explode(",", $singleGame);
                          if($split[1] === $_SESSION['Username'])
                          {
                          $playerNum = 1;
                          }
                          else{
                          $playerNum = 2;
                          }


                          $xml_arr["gid"] = $split[0];
                          $response = $client->checkWin($xml_arr);
                          $returned = $response->return;
                          echo $xml_arr["gid"]."---".$returned."000";
                          if($playerNum == $returned)
                          $wins++;
                          else if($returned == 3)
                          $draws++;
                          else
                          $losses++;
                          }

                          }
                          //echo 'Wins: '.$wins.'\nLosses: '.$losses.'\nDraws: '.$draws;
                         * 
                         */
                        ?>

                        <div class="11u 12u(mobile)">
                            <header>
                                <h1>Result Scores</h1>
                            </header>
                            
                            <h3>Wins: <?php echo $wins?></h3>
                            <h3>Draws: <?php echo $draws?></h3>
                            <h3>Losses: <?php echo $losses?></h3>
                            
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

