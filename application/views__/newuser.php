
<form name="user", method="post" action="<?=base_url().index_page()?>UsersController/newuser/">
<input type="hidden" name="action" value="creatNewUser">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<? if(isset($errosMsg)){?>
	<tr>
		<td colspan="2"><span style="color: red;"><?echo $errosMsg?></span></td>
	</tr>
	<? }?>
	
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
	<? if(isset($request_from) && $request_from == "sitesignup" ) { ?>
	<input type="hidden" name="request_from" value="<?=$request_from?>">
	<tr>
		<td>Packages</td>
		<td>
			<select name="package_id">
				<? for($i = 0; $i<count($packages); $i++) { ?>
						 <option value="<?=$packages[$i]["package_id"]?>"><?=$packages[$i]["package_name"]?></option>
			<? }?>	
			</select>
		</td>
	</tr>         
	
	<? } else {?>
	<tr>
		<td>
				Role
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
	</tr>
	<? }?>
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
		<td colspan="2"><input type="submit" name="submit" value="Creat User"></td>
	</tr>
	</table>	 
</form>  