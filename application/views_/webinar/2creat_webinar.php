<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
$(function() {
$( "#webinar_date" ).datepicker();
});
function get_current_time()
{
		var newDate = new Date();
        var hidField = document.getElementById('zone');  // ID of hidden field
         hidField.value = newDate.toLocaleString();
}
</script>
<script language="Javascript" type="text/javascript">
var numMenus = <?=$menus->num_rows()?>;
function addRow(tableID) {
 
			 var table = document.getElementById(tableID);
 
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
 
			var colCount = table.rows[0].cells.length;
			   
			   var newRowCount = table.rows.length;
					  var ary_index = newRowCount;
					//  alert(colCount);
			for(var i=0; i<5; i++) {
				
				   
				var newcell = row.insertCell(i);
				  //alert(table.rows[0].cells[i].innerHTML);
					// alert(table.rows[0].cells[i].innerHTML);
			//     table.rows[0].cells[0].innerHTML ='';
				 if (i=='2'){
				 //  alert(table.rows[0].cells[i].innerHTML); 
				 newcell.innerHTML = '<select style="opacity:1;" name="'+'items['+ary_index+'][type]'+'" id="type"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select>';
				 }else{
				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				 }
			   //alert ( table.rows[0].type);
			 //  alert ( newcell.childNodes[0].name);
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) { 
					case "text":
							newcell.childNodes[0].value = "";
						   // alert(newcell.innerHTML);
						  if(newcell.childNodes[0].name == "items[1][title]"){
							 newcell.childNodes[0].name =  'items['+ary_index+'][title]';
						  }else if(newcell.childNodes[0].name == "items[1][order]"){
							 newcell.childNodes[0].name =  'items['+ary_index+'][order]';  
						  }
							break;
					case "checkbox": 
					newcell.childNodes[0].checked = false; 
					
					if(newcell.childNodes[0].name == "items[1][check]"){
						
							 newcell.childNodes[0].name =  'items['+ary_index+'][check]';
						  }else if(newcell.childNodes[0].name == "items[1][required]"){
							 newcell.childNodes[0].value = "1";
							 newcell.childNodes[0].name =  'items['+ary_index+'][required]';  
						  }
							break;
					case "select-one":
						   // newcell.innerHTML='<input type="text" id="txtItemName'+countItems+'" name="txtItemName'+countItems+'" value="" />';
							break;    
				}
			}
//                var newRowCount = table.rows.length;
//                      var ary_index = newRowCount; 
//                for(var i=1; i<=newRowCount; i++){
//                    table.rows[i].cells[2].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][title]' );
//                    table.rows[i].cells[3].getElementsByTagName('select').item(0).setAttribute('name','items['+ary_index+'][type]');
//                    table.rows[i].cells[4].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][required]');
//                    table.rows[i].cells[5].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][order]');
//                }    
												 
			

		}
 
		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
 
			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}
 
			}
			}catch(e) {
				alert(e);
			}
		}

		
 function deleteRowOne(i){
	document.getElementById('tblAddFiels').deleteRow(i)
}

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
	var page_link1 =  document.getElementById("link_only"); 
	
	
	$(page_link1).parent().removeClass('checked');
	if(page_link1.checked == true)
	{
		page_link1.checked = false;           
	}  
	
	
}	  
	
</script>

<script>
	
	 function validate()
     {

		var flagSubmit = true;
		var go_checkbox = false;
		if(document.getElementById('title').value=='')
		{
			alert("Please enter webinar title.");
			document.getElementById('title').focus;
			return false;
		}
		else if(document.getElementById('page_access_3').checked)
		{
			var len = document.webinar_data.group_access.length;
			var i = 0;
			var chosen = '';
		
			for (i = 0; i < len; i++)
			{
				if (document.webinar_data.group_access[i].selected)
				{
					 chosen = document.webinar_data.customers[i].value;
				}
			}
			if(chosen =="")
			{
				alert("Please select atleast one Group to access this webinar.");
				return false;
			}
		}
		else if(document.getElementById('page_access_1').checked || document.getElementById('page_access_2').checked || document.getElementById('page_access_3').checked)
		{
				var check_box_checked = false;
				for(i=1;i<=numMenus;i++)
				{
					var chkMenu = document.getElementById("menu_id_"+i);			
					
					if(chkMenu.checked == true)
					{
						check_box_checked = true;						
					}  		  
				}
				if(!check_box_checked)
				{
					if(!document.getElementById('link_only').checked)
					{
						alert("Please select menu or link option.");
						return false;
					}
				}
		}
		if(document.getElementById('email_to').value=='' && check_box_checked==true)
		{
			alert("Please enter webinar email.");
			document.getElementById('email_to').focus;
			return false;
			
		}
		else if(document.getElementById('webinar_date').value=='')
		{
			alert("Please enter webinar start date.");
			document.getElementById('webinar_date').focus;
			return false;
			
		}
		else if(document.getElementById('start_time').value=='')
		{
			alert("Please enter webinar start time.");
			document.getElementById('start_time').focus;
			return false;
			
		}
		return flagSubmit;
        
    }     
</script>



<?
	$action = base_url().index_page().'webinar_controller/new_webinar/'.$_SESSION["site_id"];
	$form_action = "do_save";
	
	if($mode == "edit")
	{
		$action = base_url().index_page().'webinar_controller/do_edit_webinar/'.$webinar_id;
		$form_action = "do_edit";
	}
	
	//echo "<pre>";
	//print_r($webinar_info);
	
?>


<form name="webinar_data" action="<?=$action?>" method="post" id="webinar_data" onsubmit= " return validate()">
<input type="hidden" name="action" value="<?=$form_action?>">
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="usman">
	<tr>
		<td colspan="2">Go to <a href="<?=base_url().index_page()?>webinar_controller/index/<?=$_SESSION["site_id"]?>">Home</a> <!--&nbsp; <a href="<?=base_url().index_page()?>webinar_controller/webinar_groups/<?=$_SESSION["site_id"]?>">Webinar Groups</a>-->  </td>
	</tr>
	
	<tr>
		<td colspan="2"><h1><?=$title?></h1></td>
	</tr>
	
	<tr>
		<td>
			Webinar Title
		</td>
		<td>
			<input type="text" name="title" size="66" value="<?=(isset($webinar_info["title"])) ? $webinar_info["title"] : ""?>" id="title"/>
		</td>
	
	</tr>
	<tr>
		<td valign="top">
			Intro Text
		</td>
		<td>
<!--			 <input type="text" name="ck_content_data" id="ck_content"  />-->
			 <textarea id="ck_content" name="ck_content" rows="5" cols="20"><?=(isset($webinar_info["form_intro"])) ? $webinar_info["form_intro"] : ""?></textarea>
			 <?=display_ckeditor($ck_data['ckeditor'])?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			Thank You Text
		</td>
		<td>
			 <!--<input type="text" name="ck_content_2_data" id="ck_content_2"  />-->
			  <textarea id="ck_content_2" name="ck_content_2" rows="5" cols="20"><?=(isset($webinar_info["form_thank_u"])) ? $webinar_info["form_thank_u"] : ""?></textarea>
			 <?=display_ckeditor($ck_data['ckeditor_2'])?>
		</td>
	</tr>
	
	 <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">
			Who can See Webinar ?	                                 
		</td>
		<td>
		<?
			$str_check = "";
			$str_check_default = "";
			if($mode == "new")
			{ 
				$str_check_default = "checked='checked'";
			}
			
						
		?>
			<label>
				<input type="radio" id="page_access_1" name="webinar_access" checked="checked" value="Everyone" onClick="hideRoles()" <?=$str_check_default?> <?=(isset($webinar_info["webinar_access"]) &&  $webinar_info["webinar_access"] == "Everyone") ? "checked='checked'" : ""?> /> Everyone
			</label>    <br>
			<label>
				<input type="radio" id="page_access_2" name="webinar_access" value="Registered" onClick="hideRoles()" <?=(isset($webinar_info["webinar_access"]) &&  $webinar_info["webinar_access"] == "Registered") ? "checked='checked'" : ""?> />Registered Users
			</label>        <br>
			<?
				$strStyle = "visibility: hidden; position: absolute;"; 
				if($mode == "edit")
				{
					if($webinar_info["webinar_access"] == "Other")
					{
						$str_check = "checked='checked'";
						$strStyle = "";
						?>
							<script type="text/javascript">
								showRoles();
							</script>
						<?
					}
				}	

			?>
			
			<label>
				<input type="radio" id="page_access_3" name="webinar_access" value="Other" onClick="showRoles()" <?=$str_check?> /> Only Users With a Certain Access Level
			</label>            <br>
			
			<span id="roles" name="roles" style="<?=$strStyle;?>">    
			<? //$group_users?>
			  <select name="group_access[]" id="group_access"  multiple="multiple" style="width:130px; opacity: 1;filter: alpha(opacity = 100); margin-top: 10px;">
					<?
					foreach($groups as $group)
					{
						$str_checked = "";
						if($mode == "edit")
						{
							//echo count($webinar_info["groups_info"])."<br>";
							
							for($i=0 ; $i<count($webinar_info["groups_info"]);$i++)
							{
								//echo $webinar_info["groups_info"][$i]["id"]."-----".$group['id'];
								if(isset($webinar_info["groups_info"][$i]["id"]) && trim($webinar_info["groups_info"][$i]["id"]) == trim($group['id']))
								{
									$str_checked = "selected='selected'";
								}
							}
						}
					
						
						
					?>
						<option  value="<?=$group['id']?>" <?=$str_checked?>><?=$group['group_name']?></option>		
					<? } ?>
				</select>
		</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">
			Select Menu
		</td>
		<td>

			<?php                        
				
				$i = 1;
				if(!isset($item_id))
				{
					$item_id = 0;
				}
				$flagMenuSet = false;
				foreach($menus->result_array() as $rowMenus)
				{
					$strChecked = "";
					if($mode=="edit")
					{
						for($j=0; $j<count($webinar_info["menus_info"]); $j++)
						{
							//echo ""
							if(isset($webinar_info["menus_info"][$j]["menu_id"]) && $webinar_info["menus_info"][$j]["menu_id"] == $rowMenus["menu_id"] )
							{
								$strChecked = 'checked="checked"'; 	
							}
						}
					}
					
					/*$flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
					if($flag == true)
					{                               
						$strChecked = 'checked="checked"'; 
						$strClass = 'class="checked"'; 
						$flagMenuSet = true;   
					}
					else
					{
						$strChecked = "";
						$strClass = '';
					}
					
					if($rowMenus['menu_name'] == 'Main Menu'){
						$main_menu_id = $rowMenus['menu_id'];
					}*/
					//echo $strChecked;
				?>
				<input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onClick="uncheckCreateLink();"/> <?=$rowMenus["menu_name"];?>
				 <br>
				<?php
					$i++;
					}
				   
					$strChecked = '';
					$strClass = '';
					if($flagMenuSet == false)
					{
						$strChecked = 'checked="checked"';  
						$strClass = 'class="checked"';  
					}
				?>
				OR 
				<br /> 
				<input type="radio" name="link_only" id="link_only" onclick="uncheckMenus()"  />  Just show me the link I will use in Email.
		</td>
	</tr>
	<tr> 
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
    	<td>
        	<legend>Invite Non-members (Enter E-mail Comma Sperated)</legend>
        </td>
    	<td >        
        	<textarea id="non_group" name="non_group" ></textarea>		
        </td>
    </tr>
    <tr> 
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>
			Webinar Email To 	
		</td>
		<td>
			<input type="text"  name="email_to" id="email_to" value="<?=(isset($webinar_info["email_to"])) ? $webinar_info["email_to"] : ""?>" /> 
		</td>
	</tr>
	<br />
	<tr>
		<td colspan="2"><b>Default Forms Fields</b></td>
	</tr>
	<br />
	
	<?
		if($mode == "edit" && count($webinar_info["defualt_fields_info"]) > 0)
		{ 
			//echo "<pre>";
			//print_r($webinar_info["defualt_fields_info"]);
			//exit;
			for($i = 0; $i<count($webinar_info["defualt_fields_info"]);$i++)
			{
				$j = $i+1;
	?>
				<tr>
					<td>
						<?=$webinar_info["defualt_fields_info"][$i]["field_title"]?>		
					</td>
					<td>
						<?
							$required_checked = "";
							$active_checked = "";
							
							if($webinar_info["defualt_fields_info"][$i]["field_required"] == "Yes")
							{
								$required_checked = "checked = 'checked'";
							}
							
							if($webinar_info["defualt_fields_info"][$i]["field_delete"] == "0")
							{
								$active_checked = "checked = 'checked'";
							}
							
							
							
						?>
						<input type="checkbox" name="default_items[<?=$j?>][required]" id="f_name_required" <?=$required_checked?> /> Required &nbsp;  <input type="checkbox" name="default_items[<?=$j?>][active]" id="f_name_active" <?=$active_checked?> /> Active	
						<input type="hidden" name="default_items[<?=$j?>][title]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_title"]?>">
						<input type="hidden" name="default_items[<?=$j?>][type]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_type"]?>">
						<input type="hidden" name="default_items[<?=$j?>][order]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_sequence"]?>">
						
					</td>  
				</tr>	
				
	<?  	}
	
		} else {
	 ?>
	<tr>
		<td>
			First Name		
		</td>
		<td>
			<input type="checkbox" name="default_items[1][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[1][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_f_name" id="web_f_name" value=""  />-->
			<input type="hidden" name="default_items[1][title]" value="First Name">
			<input type="hidden" name="default_items[1][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[1][order]" value="1">
			
		</td>  
	</tr>	
	<tr>
		<td>
			Last Name		
		</td>
		<td>
			<input type="checkbox" name="default_items[2][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[2][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_l_name" id="web_l_name" value=""  />-->
			<input type="hidden" name="default_items[2][title]" value="Last Name">
			<input type="hidden" name="default_items[2][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[2][order]" value="2">
		</td>  
	</tr>
	<tr>
		<td>
			Email		
		</td>
		<td>
			<input type="checkbox" name="default_items[3][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[3][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_email" id="web_email" value=""  />-->
			<input type="hidden" name="default_items[3][title]" value="Email">
			<input type="hidden" name="default_items[3][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[3][order]" value="3">
		</td>  
	</tr>
	<tr>
		<td>
			Phone Number		
		</td>
		<td>
			<input type="checkbox" name="default_items[4][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[4][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_telephone" id="web_telephone" value=""  />-->
			<input type="hidden" name="default_items[4][title]" value="Phone Number">
			<input type="hidden" name="default_items[4][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[4][order]" value="4">
		</td>  
	</tr>
	<tr>
		<td>
			Company 		
		</td>
		<td>
			<input type="checkbox" name="default_items[5][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[5][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_company" id="web_company" value=""  />-->
			<input type="hidden" name="default_items[5][title]" value="Company">
			<input type="hidden" name="default_items[5][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[5][order]" value="5">
		</td>  
	</tr>
	<tr>
		<td>
			Webiste 		
		</td>
		<td>
			<input type="checkbox" name="default_items[6][required]" id="f_name_required" /> Required &nbsp;  <input type="checkbox" name="default_items[6][active]" id="f_name_active" checked="checked" /> Active	
			<!--<input type="text" name="web_website" id="web_website" value=""  />-->
			<input type="hidden" name="default_items[6][title]" value="Webiste">
			<input type="hidden" name="default_items[6][type]" value="Single-Line Text">
			<input type="hidden" name="default_items[6][order]" value="6">
		</td>  
	</tr>
	<? }?>
	<br />
	<tr>
		<td colspan="2"> <b>Add More Feilds</b></td>
	</tr>
	<br />
	<tr>
		<td colspan="2">
			<fieldset>
				<legend> Form Items</legend>
				<p>
					
			<table width="100%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
					<tr bgcolor="#F3F3F3">
					<td width="5%">&nbsp;  </td> 
					<td width="50%"> TITLE</td>
					<td width="20%"> TYPE</td>
					<td width="8%">REQUIRED</td>
					<td width="15%">ORDER</td>
					<!--<td width="36%"> DELETE</td>  -->
					</tr>
					<tr>
						  <table width="100%" border="0" cellspacing="1" cellpadding="3" id="tblAddFiels">
							  
							  <? if($mode == "edit")
							   { 
							  		for($i = 0 ; $i<count($webinar_info["custom_fields_info"]); $i++ )
									{
										$j = $i+1;
										$str_checked_f = "";
										$custom_required = "";
									//	echo "<pre>";
									//	print_r($webinar_info["custom_fields_info"]);
										
										//echo $webinar_info["custom_fields_info"][$i]["field_type"];exit;
							  ?>
									  <tr>
										<td width="56"><input style="opacity:1;" type="checkbox" name="items[<?=$j?>][check]" id="check" /></td>
										<td width="320"><input style="opacity:1;" name="items[<?=$j?>][title]" type="text" id="title" size="50" value="<?=$webinar_info["custom_fields_info"][$i]["field_title"]?>" /></td>
										<td width="183">
										<?
											if($webinar_info["custom_fields_info"][$i]["field_type"] == "Single-Line Text")
											{
												$str_checked_f = "checked = 'checked'"; 
											}
											else if($webinar_info["custom_fields_info"][$i]["field_type"] == "Multi-Line Text")
											{
												$str_checked_f = "checked = 'checked'";
											}
											else if($webinar_info["custom_fields_info"][$i]["field_type"] == "Check Boxes")
											{
												$str_checked_f = "checked = 'checked'";
											}
											else if($webinar_info["custom_fields_info"][$i]["field_type"] == "Radio Buttons")
											{
												//echo "here";exit;
												$str_checked_f = "checked = 'checked'";
											}
											//echo "out";exit;
										?>
											<select name="items[<?=$j?>][type]" id="type" style="opacity:1;">
											  <option value="Single-Line Text" <?=($webinar_info["custom_fields_info"][$i]["field_type"] == "Single-Line Text" ) ? "selected='selected'" : "" ?>>Single-Line Text </option>
											  <option value="Multi-Line Text" <?=($webinar_info["custom_fields_info"][$i]["field_type"] == "Multi-Line Text" ) ? "selected='selected'" : "" ?> >Multi-Line Text</option>
											  <option value="Check Boxes" <?=($webinar_info["custom_fields_info"][$i]["field_type"] == "Check Boxes" ) ? "selected='selected'" : "" ?>>Check Boxes</option>
											  <option value="Radio Buttons" <?=($webinar_info["custom_fields_info"][$i]["field_type"] == "Radio Buttons" ) ? "selected='selected'" : "" ?>>Radio Buttons</option>
											</select>
										</th>
										<?
											if($webinar_info["custom_fields_info"][$i]["field_required"] == "Yes")
											{
												$custom_required = "checked = 'checked' ";
											}
										?>
										<td width="87"><input type="checkbox" style="opacity:1;" name="items[<?=$j?>][required]" id="items[<?=$j?>][required]" value="1" <?=$custom_required?>   /></td>
										<td width="80"><input style="opacity:1;" name="items[<?=$j?>][order]" type="text" id="order" size="10" value="<?=$webinar_info["custom_fields_info"][$i]["field_sequence"]?>"  /></td>
									  <!--  <th width="214"> <input type="button" value="Delete" onclick="deleteRowOne(this.parentNode.parentNode.rowIndex)"> </th> -->
									  </tr>
							  <? 	
							  		}
							  	} else {?>
							  <tr>
								<td width="56"><input style="opacity:1;" type="checkbox" name="items[1][check]" id="check" /></td>
								<td width="320"><input style="opacity:1;" name="items[1][title]" type="text" id="title" size="50" /></td>
								<td width="183">
								  <select name="items[1][type]" id="type" style="opacity:1;">
								  <option value="Single-Line Text">Single-Line Text </option>
								  <option value="Multi-Line Text">Multi-Line Text</option>
								  <option value="Check Boxes">Check Boxes</option>
								  <option value="Radio Buttons">Radio Buttons</option>
								</select></th>
								<td width="87"><input type="checkbox" style="opacity:1;" name="items[1][required]" id="items[1][required]" value="1"  checked /></td>
								<td width="80"><input style="opacity:1;" name="items[1][order]" type="text" id="order" size="10" /></td>
							  <!--  <th width="214"> <input type="button" value="Delete" onclick="deleteRowOne(this.parentNode.parentNode.rowIndex)"> </th> -->
							  </tr>
							  
							  <? }?>
			
							</table>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
				   <tr bgcolor="#F3F3F3">
				   	<td colspan="5">
						<table  >
							<tr>
							<td  >Enter Start Date:</td>
							  <td  ><input id="webinar_date" name="webinar_date" type="text" ></td>
							  <td style="padding-left:25px;">Enter Time</td>
							  <td><input type="text" size="10" id="start_time" name="start_time"></td>
								<?php /*?><td width="136">
										<select style="opacity:1;" name="reminder" id="reminder">
										
												<option value="1">1  Hour Before</option>
												<option value="3">3  Hour Before</option>
												<option value="6">6  Hour Before</option>
												<option value="24">24 Hour Before</option>
										</select>
							  </td>
							  <td width="334"><input type="text" name="zone" id="zone" onClick="get_current_time()" size="40"></td>  <?php */?>
							</tr>
					  </table>					
					</td>
				   </tr> 
				   </table>				
				</p> 
					  
			 <div style="margin-bottom: 10px;">     
				<a href="javascript:void(0);" onclick="addRow('tblAddFiels')"> Add More Field </a>&nbsp; <a href="javascript:void(0);" onclick="deleteRow('tblAddFiels')"> Delete Selected Row</a>  
			</div>           
			</fieldset>

		</td>
		
	</tr>
	 
	<tr>
		<td colspan="2"><input type="submit" value="Save" /> &nbsp; <input type="button" value="Cancel" /> </td>
	</tr>
</table>
</form>