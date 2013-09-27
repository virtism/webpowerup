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
 
 <form name="user", method="post" action="<?=base_url().index_page()?>UsersController/login/">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<input type="hidden" name="action" value="doLogin"> 
	<tr>
		<td colspan="2">
				<h1> Admin Home </h1>
		</td>
	</tr>
	<tr>
		<td align="left">
			<table cellpadding="0" cellspacing="0" border="0" width="300px">
				<?
				//echo "<pre>";
				//print_r($user_roles);
				//exit;
				for($i=0; $i<count($user_roles);$i++)
				{
					$function_name = strtolower(str_replace(' ','_',$user_roles[$i]["role_name"])) ;
				?>
					<tr>
						<td>
							<a href="<?=base_url().index_page()?>UsersController/<?=$function_name?>"><?=$user_roles[$i]["role_name"]?></a>
						</td>
					</tr>
				<?			
				}
				
				?>
				
				<tr>
					<td align="left">
						<a href="<?=base_url().index_page()?>PackageController/index">Package Manager</a>
					</td>
				</tr>
				<tr>
					<td align="left">
						<a href="#">Settings</a>
					</td>
				</tr>
				
			
			</table>
		</td>
		<td>
				Column Right
		
		</td>
		
	</tr>	

</table>
</form>

</body>
</html>