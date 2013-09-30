<table cellpadding="0" cellspacing="0" border="0" width="100%" id="usman">
	<tr>
		<td colspan="2">Go to <a href="<?=base_url().index_page()?>webinar_controller/index">Home</a> &nbsp; <a href="<?=base_url().index_page()?>webinar_controller/webinar_groups/<?=$_SESSION["site_id"]?>">Webinar Groups</a></td>
	</tr>
	
	<tr>
		<td colspan="2"><h1>New Webinar Group</h1></td>
	</tr>
	<tr>
		<td>
			Group Title
		</td>
		<td>
			<input type="text" name="webinar_group"  />
		</td>
		
	</tr>
	<tr>
		<td valign="top">
			Description
		</td>
		<td>
			<textarea cols="5" rows="10" name="description"></textarea>
		</td>
		
	</tr>
	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="2"> 
		<input type="submit" value="Save" /> &nbsp; <input type="button" value="Cancel" />
		</td>
	</tr>
	
	
</table>
 