<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
 <?
	//echo "<pre>";
//	print_r($allSites);
	//exit;
 ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!--<tr>
		<td colspan="2">
			<a href="<?=base_url().index_page()?>webinar_controller/webinar_groups/<?=$_SESSION["site_id"]?>">Webinar Groups</a>
		</td>
	</tr>-->
	<tr>
		<td colspan="2">
			<h1>Webinar Management</h1>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2"><a href="<?=base_url().index_page()?>webinar_controller/new_webinar/<?=$_SESSION["site_id"]?>">Create New Webinar </a></td>    
	</tr>
	<tr>
		<td colspan="2">
		<div class="head_area"><table width="990">
<tr>
					<th width="91"><b>Sr.No</b></th>
					<th width="131"><b>Webinar Title</b></th>
					<th width="292"><b>Aceess Level</b> </th>
					<th width="138"><b>Email To</b></th>
					<th width="169"><b>Created Date</b></th>
					<th width="141"><b>Action</b></th>
					
		  </tr>
</table></div>
			<table cellpadding="0" cellspacing="0" border="0" width="990" class="site_builder">
				
				<?
					if(count($all_webinars) > 0)
					{
						
						for($i=0;$i<count($all_webinars);$i++)
						{
							//	echo "<pre>";
							//	print_r($all_webinars[$i]);
							//	exit;
							
				?>
							<tr>
								<td width="96"><?=$i+1?></td>
								<td width="134"><?=$all_webinars[$i]["title"]?></td>
								<td width="298"><?=$all_webinars[$i]["webinar_access"]?></td>
								<td width="146"><?=($all_webinars[$i]["email_to"])? $all_webinars[$i]["email_to"] : "N/A"?></td>
								<td width="169"><?=date("Y-m-d",strtotime($all_webinars[$i]["create_date"]))?></td>
								<td width="147"> <a href="<?=base_url().index_page()?>webinar_controller/do_edit_webinar/<?=$all_webinars[$i]["id"]?>"> Edit </a> | <a href="<?=base_url().index_page()?>webinar_controller/do_delete_webinar/<?=$all_webinars[$i]["id"]?>" onclick="return do_delete();"> Delete </a> </td>
								
							</tr>
				<?
						
						}
					}	
				?>			
			
				<tr>
					<td colspan="6">&nbsp;
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
<script type="text/javascript">
	function do_delete()
	{
		msg = confirm("Are you sure you want to Delete?");
		if(msg)
		{
			return true;
		}
		return false;
	}
</script>
