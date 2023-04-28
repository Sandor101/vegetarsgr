<?php

function loggedIn(){
    if(isset($_SESSION['user_email']) || isset($_COOKIE['user_email'])){
        return true;
    }else return false;
}

function rnd($length)
{
	
	$rn = "";
	
	if($length<5)
	{
		$length = 5;
	}
	
	$len = rand(4,$length);
	
	for($i = 0; $i < $len; $i++ )
	{
		$rn .= rand(0,9);
	}
	
	return $rn;
}

?>