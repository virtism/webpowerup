<html>
<head>
<title>Web Builder - Pages</title>
<style type="text/css">
div#actionMenu li {
	display: inline;
	list-style-type: none;
	padding-right: 20px;
}
div#actionMenu {
	margin-top:10px;
	margin-bottom:10px; 
}
</style>
<script language="javascript" type="text/javascript">
function isChecked(){
	for(i=1;i<=<?=$numRecords?>;i++){
		if(document.getElementById('chkPage'+i).checked==true){
			return true;            
		}
	}
	return false;
}
function publishPage(){    
	if(isChecked() == true){
		form = document.getElementById('frmPages');
		form.action = "<?=base_url();?>index.php/pagesController/publishPage/<?=$site_id?>";
		form.submit();
	}
	else{
		window.alert("No page(s) selected. Please select page(s) first to continue.");
		return;
	}    
}
function unpublishPage(){    
	if(isChecked() == true){
		form = document.getElementById('frmPages');
		form.action = "<?=base_url();?>index.php/pagesController/unpublishPage/<?=$site_id?>";
		form.submit();
	}
	else{
		window.alert("No page(s) selected. Please select page(s) first to continue.");
		return;
	}    
}
function deletePage(){    
	if(isChecked() == true){
		var msg = confirm("Are you sure you want to Delete?");
		if(msg)
		{
			form = document.getElementById('frmPages');
			form.action = "<?=base_url();?>index.php/pagesController/trashPage/<?=$site_id?>";
			form.submit();	
		}
		return false;
		
	}
	else{
		window.alert("No page(s) selected. Please select page(s) first to continue.");
		return;
	}    
}
function selectAllPage(){
	state = document.getElementById('chkPageAll').checked;    
	for(i=1;i<=<?=$numRecords?>;i++){        
		document.getElementById('chkPage'+i).checked=state;        
	}       
}

</script>
</head>
<body>
<table width="95%" align="center" width="960" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td><h1 style="padding: 0px;">Manage My Pages</h1></td>
</tr>
<tr>
	<td>
	<?php     
	if($records->num_rows()>0){?>
	
	<table width="680" border="0" cellpadding="0" cellspacing="5" style="margin-top: 15px;"> 
	<tr>
		<td colspan="3">
			<form id="frmSetAsHomepage" name="frmSetAsHomepage" method="post" action="<?=base_url();?>index.php/pagesController/setAsHomepage/<?=$site_id?>">
				Your current homepage is: 
				<select id="page_id_home" name="page_id_home" onChange="this.form.submit()">                    
					<?php 
					foreach($pages_list->result_array() as $row_pages_list)
					{
						if($this->Pages_Model->isHomepage($row_pages_list["page_id"]))
						{
							$strSelected = 'selected="selected"';
						}
						else
						{
							$strSelected = ""; 
						}    
					?>
					<option value="<?=$row_pages_list['page_id'];?>" <?=$strSelected;?>><?=$row_pages_list['page_title'];?></option>
					<?php    
					}
					?>
				</select>
			</form>
		</td>
		<td colspan="2">
			<form id="frmSearchPage" name="frmSearchPage" method="post" action="<?=base_url();?>index.php/pagesController/searchPage/<?=$site_id?>/0">
				Search: 
				<input id="page_title" name="page_title" type="text" value="<?=$search_page_title;?>" />
				<input type="submit" value="Go!" />
			</form>       
		</td>  
	</tr> 
	<tr>
		<td align="left" colspan="3">
			<div id="actionMenu">
			<ul>
				<li><a href="<?=base_url();?>index.php/pagesController/basic_info/<?=$site_id?>">New</a></li>
				<li><a href="javascript: void(0)" onClick="publishPage()">Publish</a></li>
				<li><a href="javascript: void(0)" onClick="unpublishPage()">UnPublish</a></li>
				<li><a href="javascript: void(0)" onClick="deletePage()">Trash</a></li>
			</ul>
			</div>
		</td>
		<td align="left" colspan="2">&nbsp;</td>
	</tr>    
	</table>
	<table width="680" border="1" cellspacing="0" cellpadding="0">
	<tr>
	</tr>
	<tr>
		<th width="5%">
			<form id="frmPages" name="frmPages" method="post" action="<?=base_url();?>index.php/pagesController/index/<?=$site_id?>/0">
				<input type="checkbox" value="0" name="chkPageAll" id="chkPageAll" onClick="selectAllPage()" />
		</th>
		<th align="left" width="25%" style="padding-left: 5px;">Title</th>
		<th width="20%">Access Level</th>
		<th width="15%">Status</th>
		<th>Last Modified</th>
	</tr>
	<?php 
	$intCount = 0;
	foreach($records->result_array() as $row):
		$intCount++;
	?>
	<tr>
		<td align="center">
			<?php
			$strDisabled = '';
			if($this->Pages_Model->isHomepage($row["page_id"]))
			{
				$strDisabled = 'disabled="disabled"';
			}
			?>
			<input type="checkbox" value="<?php echo $row['page_id'];?>" name="chkPage[]" id="chkPage<?php echo $intCount;?>" <?=$strDisabled?> />
		</td>
		<td style="padding-left: 5px;">
			<a target="_blank" href="<?=base_url();?>index.php/page_editor/index/<?=$site_id?>/<?php echo $row['page_id'];?>">
				<?php echo $row['page_title'];?>
			</a>
		</td>
		<td align="center">
			<?php 
				if($row['page_access'] == "Other")
				{
					echo $this->Pages_Model->get_page_access_title($row['page_id']);	
				}
				else
				{
					echo $row['page_access'];
				}
				
			?>
		</td>
		<td align="center"><?php echo $row['page_status'];?></td>
		<td align="center">
		<?php
		$page_modified_date = strtotime($row['page_modified_date']);
		$page_modified_date = date('M. d, Y (h:i a)', $page_modified_date);        
		?>
		<?php echo $page_modified_date;?></td>  
	</tr>
	<?php endforeach;?>
	<?php while($intCount<$pageLimit){
	$intCount++;?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td> 
	</tr>
	<?php
	}?>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="680">
	<tr>
		<td align="center" colspan="5" style="padding-top: 20px;"><?php echo $paging;?><br />
		Display # 
		<select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
			<option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
			<option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
			<option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
		</select>
		Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
		</td>        
	</tr>    
	</table>
	</form>
	<?php 
	}
	else{?>
	<table width="680" border="0" cellpadding="0" cellspacing="5">   
	<tr>
		<td align="left" colspan="3">
			<div id="actionMenu">
			<ul>
				<li><a href="<?=base_url();?>index.php/pagesController/basic_info">New</a></li>
				<li><a href="javascript: void(0)" onClick="publishPage()">Publish</a></li>
				<li><a href="javascript: void(0)" onClick="unpublishPage()">UnPublish</a></li>
				<li><a href="javascript: void(0)" onClick="return deletePage()">Trash</a></li>
			</ul>
			</div>
		</td>
		<td align="right" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<form id="frmSetAsHomepage" name="frmSetAsHomepage" method="post" action="<?=base_url();?>index.php/pagesController/setAsHomepage/<?=$site_id?>" >
				Your current homepage is:      
				<select id="page_id_home" name="page_id_home">                    
					<?php 
					foreach($pages_list->result_array() as $row_pages_list){?>
					<option value="<?=$row_pages_list['page_id'];?>"><?=$row_pages_list["page_title"];?></option>
					<?php    
					}?>
				</select>
			</form>
		</td>
		<td colspan="2">
			<form id="frmSearchPage" name="frmSearchPage" method="post" action="<?=base_url();?>index.php/pagesController/searchPage/<?=$site_id?>/0">
			Search: <input id="page_search" name="page_search" type="text" value="<?=$search_page_title;?>" />
			<input type="submit" value="Go!" />
			</form>
		</td>  
	</tr>
	</table>
	<table width="680" border="1" cellpadding="0" cellspacing="0" style="margin-top:15px;">
	<tr> 
		<th width="5%"><input type="checkbox" value="0" name="chkPageAll" id="chkPageAll" /></th>
		<th align="left" width="25%" style="padding-left: 5px;">Title</th>
		<th width="20%">Access Level</th>
		<th width="15%">Status</th>
		<th>Last Modified</th>
	</tr>
	<?php 
	$intCount = 0;    
	while($intCount<$pageLimit){
	$intCount++;?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td> 
	</tr>
	<?php
	}?>
	</table>
	<table width="680" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" colspan="5" style="padding-top: 20px;"><?php echo $paging;?><br />
		Display # 
		<select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
			<option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
			<option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
			<option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
		</select>
		Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
		</td>        
	</tr>    
	</table>
	<?php    
	}?>    
	</td>
</tr>

</table>

</body>
</html>