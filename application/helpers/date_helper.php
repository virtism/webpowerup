<?php


if( !function_exists("calculate_trail_end_date") )
{
	function calculate_trail_end_date($start_date)
	{
		$date = strtotime(  $start_date. " +1 Month");
		$end_date = date("Y-m-d H:i:s",$date);
		return $end_date;
	}
}


if( !function_exists("add_month_to_date") )
{
	function add_month_to_date($start_date)
	{
		$date = strtotime(  $start_date. " +1 Month");
		$end_date = date("Y-m-d H:i:s",$date);
		return $end_date;
	}
}

if( !function_exists("add_days_to_date") )
{
	function add_days_to_date($start_date,$day = 0)
	{
		$date = strtotime(  $start_date. " +".$day." days");
		$end_date = date("m/d/Y",$date);
		return $end_date;
	}
}

if( !function_exists("is_date_expired") )
{
	function is_date_expired($date)
	{
		$end_date = $date;
		$end_date = strtotime($end_date);
		$now_time = strtotime(date("Y-m-d H:i:s"));
		
		$diff = $end_date - $now_time;
		
		if ( $diff < 0 )
		{
			return true;
		}

		return false;
	}
}

if( !function_exists("convert_mysql_date_format") )
{

	function convert_mysql_date_format($date,$new_format = 'M. d, Y (h:i a)')
	{
		$date_sting_time = strtotime($date);
		$new_date = date($new_format, $date_sting_time);        
		return $new_date;
	}
}

?>