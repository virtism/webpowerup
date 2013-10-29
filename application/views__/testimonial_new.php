<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Testimonial</title>
<?
//echo base_url();exit;
?>
</head>
<body>
<? //echo $msg;?>
<form name="user", method="post" action="<?=base_url().index_page()?>TestimonialController/creat_new/">
<table cellpadding="0" cellspacing="0" border="1" width="100%">
	<input type="hidden" name="action" value="doCreat"> 
	<tr>
		<td colspan="2">
				<h1> New Testimonial </h1>
		</td>
	</tr>
	<tr>
		<td width="150px">
				Publish  
		</td>
		<td>
				<input type="radio" name="is_publish" value="yes" checked="checked"> Yes <br>
				<input type="radio" name="is_publish" value="no"> No <br>
				
		</td>
	</tr>
	<tr>
		<td>
				Last Name  
		</td>
		<td>
				<input type="text" name="user_lname">
		</td>
	</tr>
	
	<tr>
		<td>
				Email  
		</td>
		<td>
				<input type="text" name="user_email">
		</td>
	</tr>
	<tr>
		<td>
				User Login  
		</td>
		<td>
				<input type="text" name="user_login">
		</td>
	</tr>
		<tr>
		<td>
				Password  
		</td>
		<td>
				<input type="password" name="user_password">
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="submit" value="Save"></td>
	</tr>

</table>





<h5>Email</h5>
<input type="text" name="email" value="" size="50" />

<h5>Password</h5>
<input type="password" name="password" value="" size="50" />
<div><input type="submit" value="Login" /><a href="<?=base_url().index_page()?>UsersController/signup/"> Sign Up</a></div>
</form>

</body>
</html>