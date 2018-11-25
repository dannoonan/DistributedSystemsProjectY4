<?php
require_once __DIR__ . '/daos/UserDAO.class.php';
require_once __DIR__ . '/daos/ProxyDAO.class.php';
?>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><title>GradeAce</title>
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
                if (!isset($_SESSION)) {
                    session_start();
                }

                if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != '') {
                    //printf("<li><a href=\"./createTask.php\" class=\"\">Create Task</a></li>");
                    printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
                } else {
                    printf("<li><a href=\"./login.php\" class=\"\">Login</a></li>");
                }
                ?>
            </ul>
        </nav>

        <!-- Home -->
        <div class="wrapper style1 first">
            <article class="container 75%" id="login">
                <div class="row">

                    <div class="11u 12u(mobile)">
                        <header>
                            <h1>Welcome to <strong>GradeAce</strong>.</h1>
                            <?php
                            if (!isset($_POST) || count($_POST) == 0) {
                                printf("<h2>Create an account by filling in the details below.</h2>");
                            }
                            ?>
                        </header>
                        <?php
                        
                        //when the register button is pressed after the form has been filled
                        if (isset($_POST['register_btn'])) {

                            //Takes in all the information is entered
                            $FirstName = ($_POST['FirstName']);
                            $LastName = ($_POST['LastName']);
                            $Username = ($_POST['Username']);
                            $Password = ($_POST['Password']);

                            $userDAO = new UserDAO();

                            //ensures the passwords match
                            //Ensures the emails is not already in use
                            //Creates the new user and adds to users table in database
                            $user = new User();
                            $user->setFirstName($FirstName);
                            $user->setLastName($LastName);
                            $user->setUsername($Username);
                            $user->setPassword($Password);
                            
                                $proxy = new Proxy();
                                $proxy->setClient();
                                $client = $proxy->getClient();
			
				/*$response = $client->getRandomWord();
				echo (string) $response->return;*/
				$xml_array["username"] = $Username;
				$xml_array["password"] = $Password;
				$xml_array["name"] = $FirstName;
				$xml_array["surname"] = $LastName;
				
				$response = $client->register($xml_array);
				$intResponse = $response->return;
  
                            
                        }
                        
                        
                        ?>


                            <!-- Form for entering new user information -->
                            <form action="Register.php" method="post">

                                <input type="text" name="FirstName" placeholder="Please enter your first name">
                                <input type="text" name="LastName" placeholder="Please enter your last name">
                                <input type="text" name="Username" placeholder="Please enter your username">
                                <input type="password" name="Password" placeholder="Please enter your password">
                                
                                <input type="submit" value="Register" name="register_btn">
                                <h4>(Once Registered please log in)</h4>
                            </form>

                    </div>
                </div>
            </article>
        </div>
        <div class="wrapper style4" id ="register">
            <article id="contact" class="container 75%">
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