<script type="text/javascript">
$(document).ready(function(e) {
	
    $("#listTbl tr:even").css("background-color","#F3F4F8");
	$("#listTbl tr:odd").css("background-color","#FFFFFF");
});

function do_delete()
{
	var msg = confirm("Are you sure you want to Delete?");
	if(msg)
	{
		return true;
	}
	return false;
}

</script>

<style>
.mainContentDiv{
	width:90%;
	clear:both;
	margin:50px auto;
	color:#4E4E4E;
}
.mainContentDiv label{
	height:30px;
	line-height:30px;
}
.clr{
	clear:both;
}

#listTbl{
	border:solid 1px #D2E1EF;
	border-top:none;
}
#listTbl tr{
	line-height:25px;
	height:25px;
}
#listTbl tr th{
	text-align:center;
	font-weight:bold;
	font-size:14px;
	line-height:47px;
	height:47px;
	background:url("../../images/webpowerup/GridBar.png") repeat-x scroll 0 0 transparent;
	
}


</style>

<div class="RightColumnHeading">
    <h1>
        <span>Site Management</span>
    </h1>
    <div class="RightSideButton">
    <a href="<?=base_url().index_page()?>SiteController/creatnewsite/"><img alt="New" src="<?=base_url()?>images/webpowerup/New.png"> </a>
  </div>
</div>
<div class="clr"></div>

<div class="mainContentDiv">

<table cellpadding="0" cellspacing="0" border="1" width="100%" id="listTbl" >

	
	<?php /*?>
	<tr>

		<td align="right" colspan="5">
        	<a href="<?=base_url().index_page()?>SiteController/creatnewsite/"><img alt="New" src="<?=base_url()?>images/webpowerup/New.png"></a>
        </td>

	</tr>
	<?php */?>

	
		
		
			
				<tr>
					<th align="center" width="6%">#</th>
					<th align="center" width="19%">Site Title</th>
					<th align="center" width="20%">Site Domain </th>
					<!--<th width="23%">&nbsp;</th>-->
					<th align="center" width="18%">Create Date</th>
					<th align="center" width="41%">Action</th>
				</tr>

					
			
		
			

				

				<? for($i=0;$i<count($allSites);$i++) {
				
					
					
					
					
					//echo $allSites[$i]["site_domain"];
				?>
              <tr>
					<td width="6%" align="center"><?=$i+1?></td>
					<td width="19%" align="center"><?=$allSites[$i]["site_name"]?></td>
					<td width="20%" align="center"><?=$allSites[$i]["site_url"]?></td>
					<?php /*?><td width="2%" align="center">&nbsp;<?=$allSites[$i]["site_description"]?></td><?php */?>
					<td width="18%" align="center"><?=date("d-M-Y",strtotime($allSites[$i]["site_create_date"]))?></td>
					<td width="41%" align="center">
                    
                    	<!--	this is the preview link for the live			-->
                    	<a target="_blank" href="http://<?=$allSites[$i]["site_domain"].'.webpowerup.com'?>">Preview</a>
						
                        <!--	this is the preview link for the remote server 	-->
						<?php /*?><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$allSites[$i]["site_id"]?>">Preview</a><?php */?>
                        
                        &nbsp;|&nbsp;
                        <a href="<?=base_url().index_page()?>SiteController/sitehome/<?=$allSites[$i]["site_id"]?>">Manage</a>&nbsp;|&nbsp;<a href="<?=base_url().index_page()?>SiteController/soft_delete/<?=$allSites[$i]["site_id"]?>" onclick="return do_delete()">Delete</a>
                        </td>

				</tr>

				<? }?>

</table>


</div>


