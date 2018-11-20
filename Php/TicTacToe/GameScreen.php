<?php
require_once __DIR__ . '/daos/UserDAO.class.php';
require_once __DIR__ . '/daos/ProxyDAO.class.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['GameID']) /* you can validate the link here */) {
    $toExplode = $_GET['GameID'];
}


$proxy = new Proxy();
$proxy->setClient();
$client = $proxy->getClient();
if (isset($_POST['poll'])) {
    $xml_array["gid"] = $_SESSION['GameId'];
    $response = $client->getGameState($xml_array);
    $value = $response->return;
    echo $value;
    exit;
}
if (isset($_POST['playerNum'])) {
    $pid = $_SESSION['Pid'];
    echo $pid;
    exit;
}
if (isset($_POST['checkGameState'])) {
    $xml_array["gid"] = $_SESSION['GameId'];
    $response = $client->getGameState($xml_array);
    $gs = $response->return;
    echo $gs;
    exit;
}
if (isset($_POST['board'])) {
    $xml_array["gid"] = $_SESSION['GameId'];
    $response = $client->getBoard($xml_array);
    $boardString = $response->return;
    if ($boardString === "ERROR-NOMOVES") {
        echo $boardString;
    }

    exit;
}

if (isset($_POST['myGo'])) {
    $_SESSION['myGo'] = 1;
    echo $_SESSION['myGo'];
    exit;
}
if (isset($_POST['whoGo'])) {
    echo $_SESSION['myGo'];
    exit;
}
if (isset($_POST['playMove'])) {
    $val = $_POST['playMove'];
    if ($_SESSION['myGo']) {
        if ($_SESSION['moves'][$val - 1] === 0) {

            if ($val > 6) {
                $x = 3;
                $y = $val - 6;
            } else if ($val > 3) {
                $x = 2;
                $y = $val - 3;
            } else {
                $x = 1;
                $y = $val;
            }
            $xml_array["x"] = $x;
            $xml_array["y"] = $y;
            $xml_array["gid"] = $_SESSION['GameId'];

            $result = $client->checksquare($xml_array);
            if (($result->return) == 0) {
                $result = $client->checksquare($xml_array);
                $xml_array["pid"] = $_SESSION['UserId'];
                $client->takeSquare($xml_array);
                $moves[$val] = $_SESSION['Pid'];
                $_SESSION['myGo'] = 0;
                $_SESSION['movesMade'] ++;
                echo $val;
            } else {
                echo 12;
            }
        } else {
            echo 12;
        }
    } else {
        echo 13;
    }
    exit;
}

if (isset($_POST['wait'])) {
    $xml_array["gid"] = $_SESSION['GameId'];
    $response = $client->getBoard($xml_array);
    $boardString = $response->return;

    if ($boardString === "ERROR-NOMOVES") {
        echo 0;
    } else {

        $allMoves = explode("\n", $boardString);
        $movesNumber = sizeof($allMoves);
        if ($movesNumber == $_SESSION['movesMade']) {
            echo 0;
        } else {
            foreach ($allMoves as $singleMove) {
                $split = explode(",", $singleMove);
                if ($split[1] == 1) {
                    $arr = $split[2];
                } else if ($split[1] == 2) {
                    $arr = 3 + $split[2];
                } else {
                    $arr = 6 + $split[2];
                }
                if ($_SESSION['moves'][$arr - 1] === 0) {
                    if ($split[0] != $_SESSION['UserId']) {
                        $_SESSION['movesMade'] ++;
                        $_SESSION['moves'][$arr - 1] = 2;
                        echo $arr;
                    }
                }
            }
        }
    }
    exit;
}
if (isset($_POST['win'])) {
    $xml_array["gid"] = $_SESSION['GameId'];
    try{
    $response = $client->checkWin($xml_array);
    }
    catch (SoapFault $e){
    print_r($client);
    // or other error handling
}
    $w = $response->return;
    if ($w === 0) {
        echo $w;
    } else {
        $xml_array["gstate"] = $w;
        $response = $client->setGameState($xml_array);
        echo $w;
    }
    exit;
}
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
                        $proxy = new Proxy();
                        $proxy->setClient();
                        $client = $proxy->getClient();
                        $xml_array["uid"] = $_SESSION['UserId'];
                        $_SESSION['moves'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                        $_SESSION['movesMade'] = 0;
                        $GameDetails = explode(",", $toExplode);
                        if ($GameDetails[0] == 0) {
                            $response = $client->newGame($xml_array);
                            $_SESSION['GameId'] = $response->return;
                            $_SESSION['Pid'] = 1;
                            echo "Finding player 2";
                            echo $_SESSION['GameId'];
                        } else {
                            $_SESSION['GameId'] = $GameDetails[0];
                            $xml_array["gid"] = $_SESSION['GameId'];
                            $response = $client->joinGame($xml_array);
                            $xml_array["gstate"] = 0;
                            $response = $client->setGameState($xml_array);
                            $_SESSION['Pid'] = 2;
                        }
                        ?>

                        <div class="board">
                            <button type="button" value="-" id="1" onclick="playMove(1);">-</button>
                            <button type="button" value="-" id="2" onclick="playMove(2);">-</button>
                            <button type="button" value="-" id="3" onclick="playMove(3);">-</button>
                            <br>
                            <button type="button" value="-" id="4" onclick="playMove(4);">-</button>
                            <button type="button" value="-"id="5" onclick="playMove(5);">-</button>
                            <button type="button" value="-" id="6" onclick="playMove(6);">-</button>
                            <br>
                            <button type="button" value="-" id="7" onclick="playMove(7);">-</button>
                            <button type="button" value="-" id="8" onclick="playMove(8);">-</button>
                            <button type="button" value="-" id="9" onclick="playMove(9);">-</button>
                        </div>
                    </div>
                </article>


            </div>

            <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
            <script>
                                $(document).ready(function () {
                                    setTimeout(function () {
                                        poll();
                                    }, 3000);
                                });

                                function poll() {
                                    var polling = true;
                                    var interval = false;
                                    $.ajax({
                                        type: 'POST',
                                        data: {poll: 1},
                                        success: function (response) {

                                            if (response == 0)
                                            {
                                                polling = false;
                                                if (interval) {
                                                    clearInterval(pollingTm);
                                                }
                                                checkPlayer();
                                            }
                                            if (polling) {
                                                interval = true;
                                                pollingTm = setTimeout(function () {
                                                    poll();
                                                }, 3000);
                                            }
                                        }
                                    });
                                }

                                function checkPlayer() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {playerNum: 1},
                                        success: function (response) {
                                            if (response == 1)
                                            {
                                                checkGame();
                                            } else if (response == 2) {
                                                alert("Wait for player 1 to make theyre move!");
                                                wait();
                                            }
                                        }
                                    });
                                }

                                function joinGame() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {join: 1},
                                        success: function (response) {
                                            if (response == 1)
                                            {
                                                wait();
                                            }
                                        }
                                    });
                                }

                                function checkGame() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {checkGameState: 1},
                                        success: function (response) {
                                            if (response == 0)
                                            {
                                                myGo();
                                            } else if (response == 3) {
                                                alert("Draw Game");
                                            } else {
                                                alert("Game Over, Player " + response + " Won!");
                                            }
                                        }
                                    });
                                }

                                function getBoard() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {board: 1},
                                        success: function (response) {
                                            var result = $.trim(response);
                                            if (result === "ERROR-NOMOVES")
                                            {
                                                myGo();
                                            } else {
                                                alert(result);
                                            }
                                        }
                                    });
                                }
                                function myGo() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {myGo: 1},
                                        success: function (response) {
                                            var result = $.trim(response);
                                            if (result == 1)
                                            {
                                                alert('Make Your Move!');
                                            }
                                        }
                                    });
                                }

                                function playMove($in) {
                                    $.ajax({
                                        type: 'POST',
                                        data: {playMove: $in},
                                        success: function (response) {
                                            $val = parseInt(response);
                                            if (response == 13)
                                            {
                                                alert('Not Your Turn Yet');
                                            } else if (response == 12) {
                                                alert('Square is already taken');
                                            }
                                            else
                                            {
                                                document.getElementById($val).innerHTML="X";
                                                alert('Move Inserted');
                                                wait();
                                                $.ajax({
                                                    type: 'POST',
                                                    data: {win: 1},
                                                    success: function (response) {
                                                        $val = response;
                                                        if (response == 0)
                                                        {
                                                            wait();
                                                        } else if (response == 3) {
                                                            alert("Draw Game");
                                                        }
                                                        else{
                                                            alert("Game Over, Player " + $val + " Won!");
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }

                                function wait() {
                                    var waiting = true;
                                    $.ajax({
                                        type: 'POST',
                                        data: {wait: 1},
                                        success: function (response) {
                                            if (response != 0)
                                            {
                                                $val = parseInt(response);
                                                document.getElementById($val).innerHTML="O";
                                                waiting = false;
                                                clearInterval(pollingTm);
                                                checkGame();
                                                /* $.ajax({
                                                 type: 'POST',
                                                 data: {win: 1},
                                                 success: function (response) {
                                                 if (response == 0)
                                                 {
                                                 myGo();
                                                 } else if (response == 3) {
                                                 alert("Draw Game");
                                                 } else {
                                                 alert("Game Over, Player " + response + " Won!");
                                                 }
                                                 }
                                                 });
                                                 */


                                            }
                                            if (waiting) {
                                                pollingTm = setTimeout(function () {
                                                    wait();
                                                }, 3000);
                                            }
                                        }
                                    });
                                }
                                function checkWin() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {win: 1},
                                        success: function (response) {
                                            alert(response);
                                            return 0;
                                        }
                                    });
                                }
                                function whoGo() {
                                    $.ajax({
                                        type: 'POST',
                                        data: {whoGo: 1},
                                        success: function (response) {
                                            if (response == 0)
                                            {
                                                wait();
                                            } else {
                                                alert("You can now make another move");
                                            }
                                        }
                                    });
                                }
            </script>

            <!-- Work -->
            <?php

            function waitForP2() {
                $proxy = new Proxy();
                $proxy->setClient();
                $client = $proxy->getClient();
                $xml_array["gid"] = $_SESSION['GameId'];

                $key = true;
                while ($key) {
                    $response = $client->getGameState($xml_array);
                    echo $response->return;

                    if ($response->return == 0) {
                        $key = false;
                    }
                    sleep(5);
                }
                startGame();
            }

            function startGame() {
                echo "Game Started";
            }
            ?>






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

