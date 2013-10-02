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
<? 
//echo "<pre>";
//print_r($roles);
//exit;?>
<form name="user", method="post" action="<?=base_url().index_page()?>UsersController/newuser/">
<input type="hidden" name="action" value="creatNewUser">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="center">
			<h1><?=$pageData[0]["page_title"]?></h1>
		</td>
	</tr>	
	<tr>
		<td align="center">
			<table cellpadding="0" cellspacing="0"  border="0">
				<tr>
					<?
						 for($i=0; $i<count($pages); $i++)
						 {
					?>
								<td align="left" style="padding-left: 10px;"><a href="<?=base_url().index_page()?>SiteController/loadpage/<?=$pages[$i]["page_id"]?>"><?=$pages[$i]["page_title"]?></a></td>
					<?	} ?>	
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
				<? echo stripcslashes($pageData[0]["page_content"]);?>
		</td>
	</tr>
</table>	 
</form>

</body>
</html>