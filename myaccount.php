<?php
session_start();

include("connection.php");
include("functions.php");

// Check login
$user_data = check_login($con);

function multiplying($name){
    $quan = "";
    $result = $name * $quan;
    return $result;
}

if(!loggedIn()){
    header("Location:index.php?err=" . urlencode("Be kell jelentkeznie a fiók megtekintése lehetőséghez!!"));
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Account</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>
<div class="container">
<br>

    	<div class="jumbotron">
			<h2>Welcome <?php  if(isset($_SESSION['user_email'])) {echo $_SESSION['user_email'];} else echo $_COOKIE['user_email']; ?></h2>
		</div>

    </div><!-- /.container -->

</body>
</html>