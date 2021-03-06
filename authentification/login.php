<?php
session_start();
include("DB_Connection.php");
include("classes/users.php");

if(isset($_SESSION['userLoggedIn']))
{
	header("Location: index.php");
}

$user = new users();
include("classes/login-test.php");
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="wave.png">
	<div class="container">
		<div class="img">
		</div>
		<div class="login-content">
			<form action="login.php" method="POST">
			<?php

       			echo $user->getloginerror();
    
    		?>
				<img src="avatar.svg">
				<h2 class="title">Bienvenue!</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input type="email" class="input"  name="email" required="required">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Mot de passe</h5>
           		    	<input type="password" class="input" name="mot de passe" required="required">
            	   </div>
            	</div>
            	<a href="#">Mot de passe oublié</a>
            	<input type="submit" class="btn" value="Se connecter" name="se connecter">
				

            </form>
			
        </div>
    </div>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>
