<?php


if( !function_exists("is_login") )
{
   function is_login()
	{
		//checks if session user_info is set
		if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return;
		}
	}
}

if( !function_exists("string_minimizer") )
{
	function string_minimizer($string,$allowed_length = 50)
	{
		if( strlen($string) > $allowed_length )
		{
			$min_string = substr($string, 0 , $allowed_length);
			$min_string .= "...";
		}
		else
		{
			$min_string = $string;
		}
		return $min_string;
	}
}





?>