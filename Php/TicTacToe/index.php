<?php
require_once __DIR__ . '/daos/UserDAO.class.php';
require_once __DIR__ . '/daos/ProxyDAO.class.php';
if (!isset($_SESSION)) {

    $proxy = new Proxy();
    $proxy->setClient();
    $client = $proxy->getClient();

    session_set_cookie_params(0);
    session_start();

    echo $_SESSION["UserId"];
}
if (!isset($_SESSION["UserId"])) {
    header("Location:./login.php");
} else
    echo $_SESSION["UserId"];
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

                        $response = $client->showOpenGames();
                        $toExplode = $response->return;
                        $OpenGames = explode("\n", $toExplode);

                          /*
                          // call the create new game method
                          $xml_array = null;
                          $xml_array["playerid"] = $userid;
                          $response = $client->newGame($xml_array);

                          // grab the game id for this game and store in a variable
                          $gameid = (int) $response->return;
                          // do switch stuff
                          // store userid and gameid in a session variable
                          $_SESSION["uid"] = $userid;
                          $_SESSION["gid"] = $gameid;
                          // move to the main screen page
                          ?>
                          <script>
                          window.location("mainscreen.php");
                          </script>
                         * 
                         * 
                         */
                        ?>

                        <div class="11u 12u(mobile)">
                            <header>
                                <h1>Please select an Option</h1>
                            </header>
                            <input type="submit" value="Scores" name = "scores_btn" onclick="window.open('Scores.php', '_self')">
                            <br>
                            <input type="submit" value="Leaderboard" name = "leader_btn" onclick="window.open('Leaderboard.php', '_self')">
                            <br>
                            <input type="submit" value="New Game" name = "new_btn" onclick="window.open('./GameScreen.php?GameID=0,100', '_self')">
                            <br>

                            <h3>Or select an open game below to join:</h3>

                            <br>
                            <?php
                            foreach ($OpenGames as $result) {

                                echo '<a href="./GameScreen.php?GameID=' . $result . '">' . $result . '</a>';
                                echo '<br>';
                            }
                            ?>

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

