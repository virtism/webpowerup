<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<?
//echo md5(password);exit;//echo base_url();exit;
?>
</head>
<body>
<? //echo $msg;?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<input type="hidden" name="action" value="doLogin"> 
	<tr>
		<td colspan="4">
				<h1>User Management </h1>
		</td>
	</tr>
	<tr>
		<td>
				<a href="<?=base_url().index_page()?>UsersController/newuser/">New User</a>  
		</td>
		<td>
				<!--<a href="#">Permissions</a>   -->
		</td>
<!--		<a href="#">Roles</a>-->
	</tr>	
	

</table>
</form>

</body>
</html>