<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?=base_url();?>js/ckeditor/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Page</title>
<?
//echo md5(password);exit;//echo base_url();exit;
?>
</head>
<body>
<? 
//echo "<pre>";
//print_r($roles);
//exit;?>
<form name="user", method="post" action="<?=base_url().index_page()?>PageController/do_creat_new_page/">
<input type="hidden" name="action" value="creatNewPage">

<table cellpadding="0" cellspacing="0" border="0" width="70%">
	<? if(isset($errosMsg)){?>
	<tr>
		<td colspan="2"><span style="color: red;"><?echo $errosMsg?></span></td>
	</tr>
	<? }?>
	<?
	if(isset($siteInfo))
	{
		?>
			<tr>
				<td colspan="2"><h1><?=$siteInfo[0]["site_name"]?></h1></td><input type="hidden" name="site_id" value="<?=$siteInfo[0]["site_id"]?>"> 
			</tr>
			
		<?
	}
	?>
	
	<tr>
		<td colspan="2">
				<h2> New Page </h2>
		</td>
	</tr>
	<tr>
		<td width="20%">
				Page Title  
		</td>
		<td>
				<input type="text" name="page_title">
		</td>
	</tr>
	<tr>
		<td>
				Page SEO Url  
		</td>
		<td>
				<input type="text" name="page_seo_url">
		</td>
	</tr>
	
	<tr>
		<td>
				Page Code  
		</td>
		<td>
				<input type="text" name="page_code">
		</td>
	</tr>
	<tr>
		<td>
				Page Content
		</td>
		<td >
				<textarea id="page_content" name="page_content"></textarea>
		</td>
	</tr>
	<!--<tr>
		<td>
				Access Levels  
		</td>
		<td>
				<select name="user_role[]" multiple="multiple">
					<?
						for($i=0; $i<count($roles); $i++)
						{
							?>
								 <option value="<?=$roles[$i]["role_id"]?>"><?=$roles[$i]["role_name"]?></option>
							<?
						}
					?>
				</select>
		</td>
	</tr>          -->
	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="submit" value="Save"></td>
	</tr>
	</table>	 
</form>

</body>
<script type="text/javascript">
	CKEDITOR.replace( 'page_content' );
</script>
</html>