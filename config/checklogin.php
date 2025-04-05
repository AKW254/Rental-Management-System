<?php


function check_login()
{
	/* Use User Id As Session */
	if ((strlen($_SESSION['user_id']) == 0)) {
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "views/login.php";
		$_SESSION["user_id"] = "";
		header("Location: http://$host$uri/$extra");
	}
}
