<script type="text/javascript" language="javascript">
numMenus = <?=$menus->num_rows()?>;
submitFlag = true;
function showRoles(){
	var role = document.getElementById("roles");        
	
	if(role.style.visibility=="hidden"){
		role.style.visibility="visible";
		role.style.position="relative";
	}    
}
function hideRoles(){
	
	var role = document.getElementById("roles");        
	
	if(role.style.visibility=="visible"){
		role.style.visibility="hidden";
		role.style.position="absolute";
	}    
	$("#memberDropdown").html("");
}
function uncheckMenus()
{
		
	for(i=1;i<=numMenus;i++)
	{
		var chkMenu = document.getElementById("menu_id_"+i);
		$(chkMenu).parent().removeClass('checked');
		if(chkMenu.checked == true)
		{
			chkMenu.checked = false;    
		}  
		  
	}  
	
}
function uncheckCreateLink()
{
	
	
	var page_link1 =  document.getElementById("page_link1"); 
	var page_link2 =  document.getElementById("page_link2");
	var page_link3 =  document.getElementById("page_link3");
	
	$(page_link1).parent().removeClass('checked');
	if(page_link1.checked == true)
	{
		page_link1.checked = false;           
	}  
	
	$(page_link2).parent().removeClass('checked');
	if(page_link2.checked == true)
	{
		page_link2.checked = false;           
	} 
	
	$(page_link3).parent().removeClass('checked');
	if(page_link3.checked == true)
	{
		page_link3.checked = false;           
	} 
}

function setForm(){
	
	
	var page_link1 =  document.getElementById("page_link1");
	page_link1.checked = true;
	var page_access_1 =  document.getElementById("page_access_1");
	page_access_1.checked = true;
}

function show_busy()
{
	busyImg = "<img id='busy' src='<?=base_url();?>images/webpowerup/busy_bar.gif' width='30' height='8'  > ";
	$("#memberDropdown").html(busyImg);
}
function get_group_member()
{
	// show_busy();
	
	var group_ids = $("#group_access").val();
	//alert(group_ids);
	dataString = "groups_ids="+group_ids; 
	
	$.ajax({
		type: "POST",
		url: "<?=base_url().index_page()?>pagesController/get_groups_members",
		data: dataString,
		success: function(response){
				//alert(response);
				
				
				if(response != ""){                                               
					$("#memberDropdown").show();
					$("#memberDropdown").html(response);
					NFFix();
				}
				else
				{
					$("#memberDropdown").show();
					$("#memberDropdown").html("No member found in this group");
				}
			   
				
			}
		});
		
	
}

function validate()
{
	var page_access = document.getElementById('page_access_3');
	var other = document.getElementById('page_access_3').checked;
	var role_id = document.getElementById('role_id[]')
	var len = document.frmMenuInfo.group_access.length;	
	var i = 0;
	var chosen = '';
	if(other)
	{
		for (i = 0; i < len; i++)
		{
			if (document.frmMenuInfo.group_access[i].selected)
			{
				 chosen = document.frmMenuInfo.group_access[i].value;
			}
		}
		if(chosen =="")
		{
			alert("Please select Group(s) allowed to access this page");
			return false;
		}
		if(page_access.checked==true && role_id.value=="")
		{
			alert("Please select Role(s) allowed to access this page");
			return false;
		}
	}
	else
	{
		return true;    
	}
	
}

function showMe (it, box) { 
	var vis = (box.checked) ? "block" : "none"; 
	document.getElementById(it).style.display = vis;
} 
function hideMe (it, box) { 
	var vis = (box.checked) ? "none" : "block"; 
	document.getElementById(it).style.display = vis;
} 



$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	if(id == 'page_link1' || id == 'page_link2' || id == 'page_link3')
	{
		$("#menuInfo").find("img").removeClass("NFCheck NFh").addClass("NFCheck");
		$("#menuInfo").find("input:checkbox").attr("checked",false);		
	}
	
		//alert('alert');
	if(id == "page_link2")
	{
		$("#link").fadeIn();
		NFFix();
		
	}
	if(id == "page_link3" || id == "page_link1") 
	{
		$("#link").fadeOut();
	}
	
	
	if(id == "page_access_1" || id == "page_access_2" )
	{
		$('#roles').fadeOut();
		$("#memberDropdown").html("");
		$("#memberDropdown").hide();
		
	}
	if(id == "page_access_3")
	{
		$("#memberDropdown").fadeIn();
		$('#roles').fadeIn();
		NFFix();
	}
	
});

$("img.NFCheck").live("click",function(){
	
	var id = $(this).next("input").attr("id");
	
	$("#page_link1,#page_link2,#page_link3").attr("checked",false);
	$("#page_link1,#page_link2,#page_link3").prev().removeClass("NFRadio NFh").addClass("NFRadio");
	
	
});

/*$(document).ready(function(e) {
	
});*/
</script>
<script type="text/javascript">

$(document).ready(function() {
  
	$("#create_menu").fancybox({
		'width'                : '60%',
		'height'            : '95%',
		'autoScale'            : false,
		'transitionIn'        : 'none',
		'transitionOut'        : 'none',
		'type'                : 'iframe' 
	});
	
	$("a.edit_menu").fancybox({
		'width'                : '60%',
		'height'            : '95%',
		'autoScale'            : false,
		'transitionIn'        : 'none',
		'transitionOut'        : 'none',
		'type'                : 'iframe'
	});
	
	

});
</script>
<?php

$strOnLoad = '';
if($action != 'edit')
{
	$strOnLoad = 'setForm()';
}
				 
?>
<?php /*?><body onLoad="<?=$strOnLoad?>"><?php */?>

<div class="RightColumnHeading">
	<h1>
		<span>Create a New Page : Menu & Access (Step 2)</span>
	</h1>
</div>
<div class="clr"></div>

<div class="InnerMain">
<?php
if($action=='edit')
{
	$strAction = base_url().index_page().'pagesController/edit_page_menu';
}
else
{
	$strAction = base_url().index_page().'pagesController/save_page_menu';   
}
$main_menu_id=0;
?>
	<form id="frmMenuInfo" name="frmMenuInfo" action="<?=$strAction?>" method="post" onSubmit="return validate()" class="niceform">
		<fieldset>
			<input type="hidden" name="site_id" value="<?=$site_id?>" />
			<input type="hidden" name="page_id" value="<?=$page_id?>" />
			<input type="hidden" name="item_name" value="<?=$item_name?>" />
			
			
			<dl>
				<dt>
					<label for="page_title" class="NewsletterLabel">Select Menu(s) <span class="star">*</span></label>
				</dt>
				<dd>
					<div id="menuInfo">
					
					<a id="create_menu" href="<?=base_url().index_page()?>page_editor/createMenu/<?=$site_id?>">Create New Menu</a>
					<br />
				
					<?php                        
					$strChecked = "";
					$i = 1;
					if(!isset($item_id))
					{
						$item_id = 0;
					}
					$flagMenuSet = false;
					// $this->firephp->log($menus->result_array());
					foreach($menus->result_array() as $rowMenus)
					{
						
						$flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
						if($flag == true)
						{                               
							$strChecked = 'checked="checked"'; 
							$flagMenuSet = true;   
						}
						else
						{
							$strChecked = "";
							
						}
						
						if($rowMenus['menu_name'] == 'Main Menu')
						{
							$main_menu_id = $rowMenus['menu_id'];
						}
						echo '<p></p>';
						?>
						<input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onChange="hideMe('link', this)" />
						<label class="check_label"><?=$rowMenus["menu_name"];?></label>
						<br><br>
						<?php
						$i++;
					
					}
					
					
					$strChecked = '';
					$strClass = '';
					if($flagMenuSet == false)
					{
						$strChecked = 'checked="checked"';  
					}
					?>
					
					<input type="radio" id="page_link1" name="page_link" value="Create" onChange="hideMe('link', this)"  onclick="uncheckMenus()" <?=$strChecked?> /> 
					<label class="check_label">None (Don't Create a Menu item) Just show me the URL after the page has been created.</label>
					
					
					<input type="hidden" name="main_menu_id" value="<?=$main_menu_id?>" />

					<br><br>
					
					<input type="radio" id="page_link2" name="page_link" value="Top"  /> 
					<label class="check_label">Top Navigation (Select Parent :  for sub menu of top menu)</label>
					<br><br>
					<div id="link" style="clear:both;width:200px; display: none;" >
						<div style=" position:relative; padding-top:10px; ">
						<select size="1" name="parent_id" id="drop"  style="width:200px;"> 
								<?php
								foreach($page as $key => $val)
								{ ?>
									<option value="<?=$key?>"><?=$val?></option>
								<?php
								} ?>
						</select>
						</div>
					</div>

					
				   
	  
					
					<input type="radio" id="page_link3" name="page_link" value="Footer" onClick="uncheckMenus()" onChange="hideMe('link', this)" /> 
					<label class="check_label">Footer Links</label>
				   
					</div>
				</dd>
			</dl>
			
			
			
			<?php 
			
			if($_SESSION['page_type'] == "Normal")
			{ 
			?>
			<dl>
				   <dt>
				   <label for="page_title" class="NewsletterLabel">Who can see this page? <span class="star">*</span></label>
				   </dt>
				   <dd>
				   <?php
					if($this->input->post("page_access"))
					{
						$page_access = $this->input->post("page_access");
					}
					else
					{
						$page_access = "";
					}
					if($page_access == "Everyone" || $page_access=='')
					{
						$strChecked = 'checked="checked"';
					}
					else
					{
						$strChecked = "";
					}
					?>
				   <input type="radio" id="page_access_1" name="page_access" value="Everyone" onClick="hideRoles()" <?=$strChecked;?> />
				   <label class="check_label">Everyone</label>
				   &nbsp;
				   <?php
					if($page_access == "Registered")
					{
						$strChecked = 'checked="checked"';
					}
					else
					{
						$strChecked = "";
					}
					?>
					<input type="radio" id="page_access_2" name="page_access" value="Registered" onClick="hideRoles()" <?=$strChecked;?> />
					<label class="check_label">Registered</label>
					<? if($template_name!='gymnastic')
					{
					?>
						<?php
						if($page_access == "Other")
						{
							$strChecked = 'checked="checked"';
						}
						else
						{
							$strChecked = "";
						}
						?>
						<? if(isset($groups) && !empty($groups))
						{ ?>
							<input type="radio" id="page_access_3" name="page_access" value="Other" onClick="showRoles()" <?=$strChecked;?> />
							<label class="check_label">Other</label>
							
							<?php
							if($page_access == 'Other'){
								$strStyle=" display:block; ";
							}
							else{
								$strStyle=" display:none; ";    
							}
							?>
							
							<div id="roles" name="roles" style=" <?=$strStyle;?>">  
								<div  style=" position:relative;">  
								<select name="group_access[]" id="group_access" multiple="multiple"  size="5">
								<?
								foreach($groups as $group)
									{
								?>
										<option value="<?=$group['id']?>"><?=$group['group_name']?></option>		
								<? 	} ?>
								</select>
								</div>
							</div>
								<?php 
								}
						else
						{  //echo "<pre>"; echo $_SERVER['PATH_INFO'];exit;
								
									$page_id = $this->uri->segment(4);
								?>
									<a  href="<?=base_url().index_page()?>sitegroups/new_site_group/<?=$page_id?>" >No Group Exists Click To Create Group!</a>
						<?
						} ?>
						   
						 <?php
						 } ?> 
						
				   </dd>
			</dl>
			<dl>
				   <dt>&nbsp;
						
				   </dt>
				   <dd>
						<div id="memberDropdown" style="display:none;">
					   
						</div>
				   </dd>
			</dl>
			
			<?php 
			} 
			else if($_SESSION['page_type'] == "private")
			{ 
			?>
				<input type="hidden" name="group_access" value="<?php if(isset($_SESSION['group_access'])){ echo $_SESSION['group_access']; }?>">
				<input type="hidden" name="members" value="<?php if(isset($_SESSION['members'])){ echo $_SESSION['members']; } ?>">
				<input type="hidden" name="page_access" value="Other">
			<?php 
			} ?>
			
			<dl>
				   <dt>&nbsp;
						 
				   </dt>
				   <dd>
						<div class="ButtonRow">
							<input type="button" value="Back" onClick="document.getElementById('frmEditBasicInfo').submit();" /> 
							&nbsp;
							<input type="submit" value="Continue" />
						</div>
				   </dd>
			</dl>
			
			
						
			   
		</fieldset>
	</form>
</div>

<form id="frmEditBasicInfo" action="<?=base_url().index_page()?>pagesController/basic_info/<?=$site_id?>" method="post" style="visibility: hidden;">
	<input type="hidden" name="site_id" value="<?=$site_id?>" /> 
	<input type="hidden" name="page_id" value="<?=$page_id?>" />
	<input type="hidden" name="item_name" value="<?=$item_name?>" />
	<?php
	if(!isset($item_id))
	{
		$item_id = '0';
	}
	?>
	<input type="hidden" name="item_id" value="<?=$item_id?>" />  
</form>


