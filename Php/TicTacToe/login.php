<?php
    require_once __DIR__.'/daos/UserDAO.class.php'; 
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
                                        if (!isset ($_SESSION)) {
						session_start();
					}
					
		if( isset( $_POST["uname"] ) ) {
			$user = $_POST["uname"];
			$pass = $_POST["pword"];
			
			try {
				$proxy = new Proxy();
                                $proxy->setClient();
                                $client = $proxy->getClient();
                                
			
				/*$response = $client->getRandomWord();
				echo (string) $response->return;*/
				$xml_array["username"] = $user;
				$xml_array["password"] = $pass;
                                
                                
				
				$response = $client->login($xml_array);
				$userid = $response->return;
				
				switch($userid) {
					case -2:
					case -1:
						echo "<h4>Error connecting to system. Please try again later.</h4>";
						break;
					case 0:
						echo "<h4>Invalid credentials. Please retry.</h4>";
						break;
					default:
                                             
                                            $userDAO = new UserDAO();
                                            $user= $userDAO->setUser($userid);
                                            $_SESSION["UserId"] = $user->getUserId();
                                            $_SESSION["Username"] = $xml_array["username"];
                                            echo  $_SESSION["UserId"];
                                            header("Location:./index.php?");
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
						<?php
				}
			
			} catch(Exception $e) {
				echo $e->getMessage();
			}
			
		} else {
                    
                }
		?>
						<div class="11u 12u(mobile)">
							<header>
								<h1>Welcome to <strong>TicTacToe</strong>.</h1>
							</header>
							<form action="login.php" method="post">
                                                        <input type="text" name="uname" id="uname" placeholder="Please enter your username">
                                                        <input type="password" name="pword" id="pword" placeholder="Please enter your password">
                                                        
                                                        <input type="submit" value="Login" name = "login_btn">
							</form>


						</div>
					</div>
				</article>
			</div>

		<!-- Work -->
			

		
			

		
			<div class="wrapper style4" id ="register">
				<article id="contact" class="container 75%">
					<header>
						<h2>No Account?</h2>
						<p>Register now!</p>
					</header>
					<div>
						<div class="row">
							<div class="12u">

							<input type="button" value="Register Now" onclick="window.open('Register.php', '_self')">
			
							</div>
						</div>
						
					</div>
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
		
	