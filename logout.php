<?php
	session_start();

	session_destroy();

	setcookie("user_email" , "" , time()-60*5);
	header("Location:login.php?success=" . urlencode("Sikeresen kijelentkezett!"));
	exit();
?>