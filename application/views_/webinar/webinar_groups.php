
 <?
	//echo "<pre>";
//	print_r($allSites);
	//exit;
 ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td colspan="2">
			<a href="<?=base_url().index_page()?>webinar_controller/index/<?=$_SESSION["site_id"]?>">Home</a>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<h1>Webinar Groups Management</h1>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2"><a href="<?=base_url().index_page()?>webinar_controller/new_webinar_group/<?=$_SESSION["site_id"]?>">New Webinar Group </a></td>    
	</tr>
	<tr>
		<td colspan="2">
		
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td><b>Sr.No</b></td>
					<td><b>Webinar Title</b></td>
					<td><b>Description</b></td>
					<td><b>Action</b></td>
					
				</tr>
				<tr>
					<td>1</td>
					<td>Title 1</td>
					<td>This is Test Webinar Group</td>
					<td>Edit | Disbale | Delete </td>
					
				</tr>
				
				<tr>
					<td>2</td>
					<td>Title 2</td>
					<td>This is Test Webinar Group</td>
					<td>Edit | Disbale | Delete </td>
					
				</tr>
				
				<tr>
					<td colspan="6">
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
