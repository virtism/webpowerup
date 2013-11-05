<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>
<?
//echo base_url();exit;
?>
</head>
<body>
<? //echo $msg;?>
<form name="user", method="post" action="<?=base_url().index_page()?>UsersController/signup/">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<input type="hidden" name="action" value="doSignUp"> 
	<tr>
		<td colspan="2">
				<h1> Sign Up </h1>
		</td>
	</tr>
	<tr>
		<td width="150px">
				First Name  
		</td>
		<td>
				<input type="text" name="user_fname">
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






</form>

</body>
</html>