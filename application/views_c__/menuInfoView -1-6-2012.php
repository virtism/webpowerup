<script type="text/javascript" language="javascript">
function resetFormControls()
{
    //jquery for radio button control
    $('div.radio span input:radio').click(function() {
        $(this).parent().parent().parent().find('div.radio span').removeClass('checked');
        $(this).parent().parent().parent().find('div.radio span input').attr('checked', false);
        
        var className = $(this).parent().attr('class');
        if(className == "")
        {
            $(this).parent().addClass("checked");
            $(this).attr('checked', true);              
        }
        else
        {
            $(this).parent().removeClass('checked'); 
            $(this).attr('checked', false);
        }
    });
    
    //jquery for select list control
    $('div.selector select').change(function() {
        $(this).parent().find('span').text($(this).find('option:selected').html()) ;   
    });    
}   
</script>
  <script>
  function get_link(id){
  	var dropdown_name = document.getElementById(id).name;
      var clink = document.getElementById(id).value;
     //alert(clink);
      var link = clink.split("_");
	  if(link[0]=='clink')
      {
         //alert("#_"+dropdown_name);
		 $("#_"+dropdown_name).show();
      }
      else
      {
          //alert(dropdown_name);
         $("#_"+dropdown_name).hide();
      }
}
function checkCustomFieldEmpty(countItems)
	{
		
		var flag =0;
		for(var i=1; i<=countItems; i++)
		{
		
			if($("#txtItemName"+i).val() == "")
			{
				alert("Caption is Required.");
				return false;
			}
			
//			var isURL = ("#custom_url_"+i);
			//alert(i);
			//alert($("#custom_url_"+i).val());
			//We will check the URL validation
			if($("#custom_url_"+i).val())
			{
				if($("#_lstItemPage"+i).val() == "")
				{
					//case is URL and Feild is empty
					//alert("case 1");
					flag = false;
				}
				else
				{
					//Ignore DROP DOWN Check and Submit Form
					flag = true;
				}
			}
			else
			{
				//alert("lstItemPage"+i);
				//In case we have Page ID and Not Custom URL
				if($("#lstItemPage"+i))
				{
//					alert($("#lstItemPage"+i).val());
					if($("#lstItemPage"+i).val() == "" || $("#lstItemPage"+i).val() == 0 )
					{
						//Page ID is not Selected and Not URL
						//alert("case 2");
						flag = false;
					}
					else
					{
						flag = true;
					}
					
				}
				//Custom URL Check for New Form Items is Addedd
				if($("#lstItemPage"+i).val() == "clink_"+i)
				{
					if($("#_lstItemPage"+i).val()== "")
					{
						flag = false
					}
					else
					{
						flag = true;
					}
					
				}				
			}
		}
		if(flag)
		{
			//alert("all ok");
			return true;
		}
		else
		{
			//alert("some empty");
			alert("Destination can't be empty.");
			return false;
		}	
	}
</script>
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function() 
{
    // Initialise the table
    $('#tblItems').tableDnD();         
    
    resetFormControls();
    
    $('#rdoPublished3').click(function(){
        $('#schedular').slideDown('slow');        
    }) 
    
    $('#rdoPublished1').click(function(){
        $('#schedular').slideUp('slow');        
    })
    
    $('#rdoPublished2').click(function(){
        $('#schedular').slideUp('slow');        
    })
    
    $('#rdoPages1').click(function(){
        $('#pages').slideUp('slow');        
    })
    
    $('#rdoPages2').click(function(){
        $('#pages').slideDown('slow');        
    }) 
    
    $('#rdoRights1').click(function(){
        $('#roles').slideUp('slow');        
    }) 
    
    $('#rdoRights2').click(function(){
        $('#roles').slideUp('slow');        
    })
    
    $('#rdoRights3').click(function(){
        $('#roles').slideDown('slow');        
    })
});

countItems = <?=$numItems;?>;

var id = <?=$numItems;?>; 
function addMenuItem()
{   
    countItems++;    
    var items = document.getElementById('numItems');    
    items.value++;    
    var tbl = document.getElementById('tblItems');
    var lastRow = tbl.rows.length-1;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = '<input type="text" id="txtItemName'+countItems+'" class="txtItemName" name="txtItemName'+countItems+'" value="" maxlength="30" />';
    cell1.align = "center";
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<div class="selector"><span style="-moz-user-select: none; font-size:11px; font-weight: bold;">Select Page</span><select onchange="get_link(this.id)"  id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'" style="opacity: 0;filter: alpha(opacity = 0);"><option value="0">Select Page</option><option  value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select></div><input align="left"; size="10px;" type="text" name="_lstItemPage'+countItems+'" id="_lstItemPage'+countItems+'"  style="display: none;"/>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell3.innerHTML = '<div class="selector"><span style="-moz-user-select: none; font-size:11px; font-weight: bold;">Select Parent</span><select id="parent_id'+countItems+'" name="parent_id'+countItems+'" style="opacity: 0;filter: alpha(opacity = 0);"><option value="0">Select Page</option><?php foreach($parent_array as $key => $value): ?><option value="<?=$key?>"><?=$value?></option><?php endforeach;?></select></div>';
    cell3.align = "center";
    var cell4 = row.insertCell(3);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell4.innerHTML = '<div class="radio"><span class="checked"><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /></span></div><label for="rdoItemPublished'+id1+'">Yes</label>&nbsp; <div class="radio"><span><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></span></div><label for="rdoItemPublished'+id2+'">No</label>';
    cell4.align = "center";
	
	
	
	var cell5 = row.insertCell(4);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell5.innerHTML = '<td align="center"><div name="dropdown_target1" id="dropdown_target1" class="selector"><span style="-moz-user-select: none;">Select Target</span><select id="menuTarget'+id2+'" name="menuTarget'+countItems+'"><option value="_self" selected="selected" >Same Window</option><option value="_blank">New Window</option></select></div></td>';
	
	var cell6 = row.insertCell(5);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell6.innerHTML = '<img src="<?=base_url();?>/images/icon-delete.png" onclick="deleteRow(this.parentNode.parentNode.rowIndex)" />';
    cell6.align = "center";
	   
    var cell7 = row.insertCell(6);
    cell7.innerHTML = '&nbsp;';
    $('#tblItems').tableDnD();   
    resetFormControls();  
}

function addMenuItem2()
{
    countItems++;    
    var items = document.getElementById('numItems');    
    items.value++;    
    var tbl = document.getElementById('tblItems');
    var lastRow = tbl.rows.length-1;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = '<input type="text" id="txtItemName'+countItems+'" class="txtItemName" name="txtItemName'+countItems+'" value="" maxlength="30" />';
    cell1.align = "center";
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<div class="selector"><span style="-moz-user-select: none; font-size:11px; font-weight: bold;">Select Page</span><select onchange="get_link(this.id)" id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'" style="opacity: 0;filter: alpha(opacity = 0);"><option value="0">Select Page</option><option  value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select></div><input align="left"; size="10px;" type="text" name="_lstItemPage'+countItems+'" id="_lstItemPage'+countItems+'"  style="display: none;"/></div>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell3.innerHTML = '<div class="radio"><span class="checked"><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /></span></div><label for="rdoItemPublished'+id1+'">Yes</label>&nbsp; <div class="radio"><span><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></span></div><label for="rdoItemPublished'+id2+'">No</label>';
    cell3.align = "center";   
    var cell4 = row.insertCell(3);
    cell4.innerHTML = '&nbsp;';
    $('#tblItems').tableDnD();   
    resetFormControls();  
}


function deleteRow(i)
{
    document.getElementById('tblItems').deleteRow(i);
}

function validate()
{
    submitFlag = true;
    
    $('.messages').text('');
    
    if($('#txtName').val()=='')
    {
        //alert('empty');
        $('#menu_name_message').html('<code>Please enter menu name.</code>'); 
        submitFlag = false;      
    }
    
    if($('#rdoPublished3').is(':checked'))
    {
        if($('#startDate').val()=='')
        {
            //alert('startDate');
            $('#menu_pub_message').html('<code>Please enter publish date(s).</code>'); 
            submitFlag = false;  
        }
        if($('#endDate').val()=='')
        {
            //alert('endDate'); 
            $('#menu_pub_message').html('<code>Please enter publish date(s).</code>');   
            submitFlag = false;     
        }
    }
    
    if($('#rdoPages2').is(':checked') && $('#lstPages option:selected').val() == null )
    {
        //alert('hi');  
        $('#menu_pages_message').html('<code>Please select menu pages.</code>');   
        submitFlag = false;    
    }
    
    if($('#rdoRights3').is(':checked') && $('#group_access option:selected').val() == null )
    {
        $('#menu_access_message').html('<code>Please select menu group access.</code>');  
        submitFlag = false;     
    }
    
    return submitFlag;
}

</script>

<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>

<?php


$menu_id = $id;
if($is_main_menu)
{
    $strAction = base_url().'index.php/menusController/updateMainMenu';
}
else
{
    $strAction = base_url().'index.php/menusController/updateMenu';   
}
?>
<form id="frmUpdateMenu" name="frmUpdateMenu" action="<?=$strAction?>" method="post" onclick="resetFormControls()" onsubmit="return validate()"> 
    <fieldset>
        
        <input type="hidden" name="site_id" value="<?=$site_id;?>" />
        <input type="hidden" name="id" value="<?=$id;?>" />
        <input type="hidden" id="numItems" name="numItems" value="<?=$numItems;?>" />
        
        <label>Edit the Menu</label>
        
        <div class="section">
            <label>Menu Name <span class="required">&nbsp;</span></label>
            <div>
                <?php
                $strDisabled = '';
                if($is_main_menu)
                {
                    $strDisabled = 'disabled="disabled"';    
                }
                ?>
                <input type="text" name="txtName" id="txtName" value="<?=$menu_name?>" maxlength="30" <?=$strDisabled?> />
                <label class="messages" id="menu_name_message" style="padding: 0;"></label>
            </div>
        </div>
        <?php
        if(!$is_main_menu)
        {
        ?>
        <div class="section">
            <label>Menu Position <span class="required">&nbsp;</span></label>
            <div>
                <div class="radio">
                    <?php
                    $strChecked = ''; 
                    $strClass = '';
                    
                    if($menu_position=="Left"){
                        $strChecked='checked="checked"';
                        $strClass = 'class="checked"';      
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Left" name="rdoPosition" id="rdoPosition1" <?=$strChecked?> /></span>
                </div>
                <label for="rdoPosition1">Left</label>
                
                <div class="radio">
                    <?php
                    $strChecked = ''; 
                    $strClass = '';
                    
                    if($menu_position=="Right"){
                        $strChecked='checked="checked"';
                        $strClass = 'class="checked"';      
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Right" name="rdoPosition" id="rdoPosition2" <?=$strChecked?> /></span>
                </div>
                <label for="rdoPosition2">Right</label>
                
                <?php /*?><div class="radio">
                    <?php
                    $strChecked = ''; 
                    $strClass = '';
                    
                    if($menu_position=="Top"){
                        $strChecked='checked="checked"';
                        $strClass = 'class="checked"';      
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Top" name="rdoPosition" id="rdoPosition3" <?=$strChecked?> /></span>
                </div>
                <label for="rdoPosition3">Top</label><?php */?>
                
            </div>
        </div> 
        
        <div class="section">
             <label>Select Parent <span class="required">&nbsp;</span></label>
             <div>                    
                <div class="selector">
                    <span style="-moz-user-select: none;">None</span>
                    <select id="parent_menu" name="parent_menu" style="opacity: 0;filter: alpha(opacity = 0);">
                        <option value="0">None</option>
                        <?php
                        foreach($menus->result_array() as $rowMenus)
                        {
                        ?>
                        <option value="<?=$rowMenus['menu_id']?>"><?=$rowMenus['menu_name']?></option>
                        <?php    
                        }
                        ?>    
                    </select>
                </div>
            </div>
        </div>
        
        <div class="section">
            <label>Published? <span class="required">&nbsp;</span></label>
            <div>
                <table id="signup_1" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_published=="Yes"){
                                    $strChecked='checked="checked"';
                                    $strClass = 'class="checked"';    
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="Yes" name="rdoPublished" id="rdoPublished1" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoPublished1">Yes</label>
                            
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_published=="No"){
                                    $strChecked='checked="checked"';
                                    $strClass = 'class="checked"';    
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="No" name="rdoPublished" id="rdoPublished2" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoPublished2">No</label>
                            
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_published=="Schedule"){
                                    $strChecked='checked="checked"';
                                    $strClass = 'class="checked"';    
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="Schedule" name="rdoPublished" id="rdoPublished3" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoPublished3">Schedule</label> 
                            <label class="messages" id="menu_pub_message" style="padding: 0;"></label>   
                        </td>
                    </tr>
                </table>
                
                <?php
                $strStyle = '';
                if($menu_published=="Schedule")
                {
                    $strStyle = 'style="display: block;"';
                }
                else
                {
                    $strStyle = 'style="display: none;"';    
                }
                ?>    
                <div id="schedular" <?=$strStyle?>>
                <p>
                    <b>Start:</b>
                    <br />    
                    Date/Time:
                    <input id="startDate" name="startDate" type="text" value="<?=$menu_start;?>" size="25" readOnly="readOnly">
                    <a href="javascript:NewCal('startDate','ddMMyyyy',true,12)">
                        <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                    </a>
                    <?php
                    if(form_error("startDate")!='')
                    {
                        echo '<label class="error">'.form_error("startDate").'</label>';    
                    }
                    ?>
                </p>
                <p>    
                    <b>End:</b>
                    <br />    
                    Date/Time:
                    <input id="endDate" name="endDate" type="text" value="<?=$menu_end;?>" size="25" readOnly="readOnly">
                    <a href="javascript:NewCal('endDate','ddMMyyyy',true,12)">
                        <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                    </a>
                    <?php
                    if(form_error("endDate")!='')
                    {
                        echo '<label class="error">'.form_error("endDate").'</label>';    
                    }
                    ?>
                </p>
                </div>
            
            </div>
        </div> 
        
        <div class="section">
            <label>Display on which Webpages? <span class="required">&nbsp;</span></label>
            <div>
                <table id="signup_1" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                        <div class="radio">
                            <?php
                            $strChecked = ''; 
                            $strClass = '';
                            if($menu_pages=="All")
                            {
                                $strChecked = 'checked="checked"';
                                $strClass = 'class="checked"';
                            }
                            ?>
                            <span <?=$strClass?>><input type="radio" value="All" name="rdoPages" id="rdoPages1" <?=$strChecked?> /></span>
                        </div>
                        <label for="rdoPages1">All Pages</label>
                        
                        <div class="radio">
                            <?php
                            $strChecked = ''; 
                            $strClass = '';
                            if($menu_pages=="Other")
                            {
                                $strChecked = 'checked="checked"';
                                $strClass = 'class="checked"';
                            }
                            ?>
                            <span <?=$strClass?>><input type="radio" value="Other" name="rdoPages" id="rdoPages2" <?=$strChecked?> /></span>
                        </div>
                        <label for="rdoPages2">Some Pages</label>
                        <label class="messages" id="menu_pages_message"></label>
                        </td>
                    </tr>
                </table>
                
                <?
                if($menu_pages=="Other")
                {
                    $strStyle = "display: block;";
                }
                else
                {
                    $strStyle = "display: none;";
                }
                ?>
                <div id="pages" style="<?=$strStyle?>">
                    <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="margin-top: 10px; margin-bottom:10px; width:130px; opacity: 1; filter: alpha(opacity = 100)">
                    <?php
                    foreach($pages->result_array() as $rowPages)
                    {
                        $strSelected = '';
                        if($this->Menus_Model->isMenuPage($id, $rowPages['page_id']))
                        {
                            $strSelected='selected="selected"';
                        }   
                    ?>
                        <option value="<?=$rowPages['page_id']?>" <?=$strSelected;?>><?=$rowPages['page_title']?></option>
                    <?php 
                    }//end foreach;
                    ?>
                    </select>
                </div>
                
            </div>
        </div> 
        
        <div class="section">
            <label>Who can view this Menu? <span class="required">&nbsp;</span></label>
            <div>
                <table id="signup_1" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_access=="Everyone")
                                {
                                    $strChecked = 'checked="checked"';
                                    $strClass = 'class="checked"';
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="Everyone" name="rdoRights" id="rdoRights1" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoRights1">Everyone</label>
                            
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_access=="Registered")
                                {
                                    $strChecked = 'checked="checked"';
                                    $strClass = 'class="checked"';
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="Registered" name="rdoRights" id="rdoRights2" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoRights2">Registered</label>
                            
                            <div class="radio">
                                <?php
                                $strChecked = ''; 
                                $strClass = '';
                                if($menu_access=="Other")
                                {
                                    $strChecked = 'checked="checked"';
                                    $strClass = 'class="checked"';
                                }
                                ?>
                                <span <?=$strClass?>><input type="radio" value="Other" name="rdoRights" id="rdoRights3" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoRights3">Other</label>
                            <label class="messages" id="menu_access_message" style="padding: 0;"></label>
                        </td>
                    </tr>
                </table>
                <?php
                if($menu_access=="Other")
                {
                    $strStyle = 'style="display: block;"';
                }
                else
                {
                    $strStyle = 'style="display: none;"';    
                }
                ?>
                <div id="roles" <?=$strStyle?>> 
					<select name="group_access[]" id="group_access" multiple="multiple" style="width:130px; margin-top:10px;margin-bottom:10px; opacity: 1; filter: alpha(opacity = 100)">
				<?
				foreach($groups as $group)
                	{
				?>
						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>		
				<? 	} ?>
				   </select>
                   <?php /*?> <select id="lstRoles" name="lstRoles[]" multiple="multiple" style="width:130px; margin-top:10px;margin-bottom:10px; opacity: 1; filter: alpha(opacity = 100)">
                        <?php
                        foreach($roles->result_array() as $rowRoles):
                            if($this->Menus_Model->isMenuRole($id, $rowRoles['role_id']))
                            {
                                $strSelected = 'selected="selected"';
                            }
                            else
                            {
                                $strSelected = '';
                            }?>
                        <option value="<?=$rowRoles['role_id']?>" <?=$strSelected;?>><?=$rowRoles['role_name']?></option>
                        <?php 
                        endforeach;?>        
                    </select><?php */?>
                </div>
            </div>
        </div> 
        <?php
        }//is main menu end of if
        ?>
        <div class="section">
            <label>Menu Item(s)</label>
            <div>
                <!-- test -->
                <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <?php
                
                if($is_main_menu)
                {
                ?> 
                <tr>
                    <th width="37%">Caption</th>
                    <th width="18%">Destination</th>
                    <th width="20%">Parent</th>
                    <th width="25%">Published</th>
                    <th width="25%">Target Window</th>
                </tr>
                <?php
                }else
                {
                ?> 
                <tr>
                    <th width="40%">Caption</th>
                    <th width="30%">Destination</th>
                    <th width="30%">Published</th>
                    <th width="25%">Target Window</th>
                </tr>
                <?php
                }
                ?>
                
                </table>  
                <table id="tblItems" width="100%" border="0" cellpadding="3" cellspacing="0">
                    <?php
                    $id = 0;
                    $i=1;
                    foreach($menu_items->result_array() as  $rowItemInfo)
                    {
                      
					//  echo "<pre>";
					//  print_r($rowItemInfo);
				// exit;
					  
					    $id1 = $id + $i;
                        $id2 = $id + 1 + $i;
                        $id++;
                    ?>
                    <tr>
                        <td  align="center">
                            <input class="txtItemName" type="text" id="txtItemName<?=$i;?>" name="txtItemName<?=$i;?>" value="<?=$rowItemInfo["item_name"];?>" maxlength="30" />
                            
                        </td>
                        <td align="center">
						    <? 
							if($this->Menus_Model->getItemPageTitle($rowItemInfo["item_id"])== "1") 
							{ echo "here"; ?> 
                                
                               <input type="text" value="<?=$rowItemInfo["item_link"]?>"  id="_lstItemPage<?=$i;?>" name="_lstItemPage<?=$i;?>">
							   <input type="hidden" name="lstItemPage<?=$i?>" id="custom_url_<?=$i?>" value="clink_<?=$i?>" />                            <? 
							} 
							else 
							{ 
							 // echo "no in here"; 
								 
								?>
                                <input type="hidden" value=""  id="_lstItemPage<?=$i;?>" name="_lstItemPage<?=$i;?>">
								<div  class="selector">
									
									<span style="-moz-user-select: none;"><?=$this->Menus_Model->getItemPageTitle($rowItemInfo["item_id"])?></span>
									<select onchange="get_link(this.id)" class="clink_select"  id="lstItemPage<?=$i;?>" name="lstItemPage<?=$i;?>">
									<option  value="clink_<?=$i;?>" >Custom Link</option>
									<?php 
									foreach($pages->result_array() as $key=> $rowPages):
										if($this->Menus_Model->isItemPage($menu_id, $rowItemInfo["item_id"], $rowPages['page_id']))
										{
											$strSelected = 'selected="selected"';
										}
										else
										{
											$strSelected = "";
										}?>
										<option value="<?=$rowPages['page_id']?>" <?=$strSelected?>><?=$rowPages['page_title']?></option>
									<?php 
									endforeach;?>
									</select>  								 
								</div>
								<? 
							} ?>
                            <table align="center">
                                <tr>
                                    <td id="link-td">
									<?
										if(isset($rowItemInfo["item_link"]))
										{
											$link_val = $rowItemInfo["item_link"];
										}
										else
										{
											$link_val = "";
										}
									?>
          <!--<input align="left"; size="10px;" type="text" name="_lstItemPage<?=$i;?>" id="_lstItemPage<?=$i?>" value="<?=$link_val?>"  style="display: none;"/>-->
                                    </td>
                                </tr>
                            </table>
                        </td>
<?php
//echo "<pre>";
//print_r($key);
//echo "</pre>";
//print_r($rowItemInfo);
//if (trim($rowPages['page_parent']) != 0){
//}
?>
                    <?php
                if($is_main_menu)
                {
                ?> 

                        <td align="center">
                            <div class="selector">
                                <span style="-moz-user-select: none;"><?php $retr = $this->Menus_Model->getParent_title($rowItemInfo["item_id"]);
                                echo $retr['page_title'];
                                ?>
                                <? //$this->Menus_Model->getParent_title($rowItemInfo["item_id"])?></span>
                                <select id="parent_id<?=$i;?>" name="parent_id<?=$i;?>">
                                <?php 
                                
                                foreach($parent_array as $key => $value):
                                //print_r($rowPag);
                                    if($key == $retr['page_id'])
                                    {
                                        $strSelected = 'selected="selected"';
                                    }
                                    else
                                    {
                                        $strSelected = "";
                                    }
                                    
                                    ?>
                                    
                                    <option value="<?=$key?>" <?=$strSelected?> > <?=$value?></option>
                                <?php 
                                endforeach;?>
                                </select>  
                                <?php
    
								?>
                            </div>
                        </td>
                        
                        <?php
                }
						?>
                        <td align="center">
                        
                            <?php
                           /*echo "<pre>"; 
                            print_r($rowItemInfo);
                            exit();*/
                            $strChecked = '';
                            $strClass = '';
                            if($rowItemInfo["item_published"]=="Yes")
                            {
                                $strChecked='checked="checked"';
                                $strClass = 'class="checked"';
                            }
                            ?>
                            <div class="radio">
                            <span <?=$strClass?>><input type="radio" id="rdoItemPublished<?=$id1?>" name="rdoItemPublished<?=$i?>" value="Yes" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoItemPublished<?=$id1?>">Yes</label>
                            
                            <?php
                            $strChecked = '';
                            $strClass = '';
                            if($rowItemInfo["item_published"]=="No")
                            {
                                $strChecked='checked="checked"';
                                $strClass = 'class="checked"';
                            }
                            ?>
                            <div class="radio">
                            <span <?=$strClass?>><input type="radio" id="rdoItemPublished<?=$id2?>" name="rdoItemPublished<?=$i?>" value="No" <?=$strChecked?> /></span>
                            </div>
                            <label for="rdoItemPublished<?=$id2?>">No</label>
                        </td>
                        
                         <td align="center">
                         	<div name="dropdown_target1" id="dropdown_target1" class="selector">
                            	<span style="-moz-user-select: none;">Select Target</span>
                                
                                
                                <select id="menuTarget<?=$i?>" name="menuTarget<?=$i?>">
									<?php
									
                                        $selected= '';
                                        if( $rowItemInfo["item_target"] == "_self" )
                                        {
                                            $selected=' selected="selected" ';
                                        }
                                    ?>
                                    <option value="_self" <?=$selected?> >Same Window</option>
									<?php
                                        $selected= '';
                                        if( $rowItemInfo["item_target"] == "_blank" )
                                        {
                                            $selected=' selected="selected" ';
                                        }
                                    ?>

                                    <option value="_blank" <?=$selected?> >New Window</option>
                                </select>
							</div>
                         </td>
                        
                        <td>  
                            <img src="<?=base_url();?>/images/icon-delete.png" onclick="deleteRow(this.parentNode.parentNode.rowIndex)" />
                        </td>
                       
                    	</tr>
                        <?php
                        $i++;  
                    }
                    ?>
                    <?php
//echo "<pre>";
//print_r($key);
//echo "</pre>";
//print_r($rowItemInfo);
//if (trim($rowPages['page_parent']) != 0){
//}
?>
                    
                    <tr>
                        <td colspan="4" align="left">
                             &nbsp; &nbsp; &nbsp; &nbsp; 
                             <?php
     if(!$is_main_menu)
        {
			
?>
                            
                             <a href="javascript: void(0)" onclick="addMenuItem2()">Click here to Add a Menu Item.</a>
                             <?php
        }else
        { 
?> 
                           <a href="javascript: void(0)" onclick="addMenuItem()">Click here to Add a Menu Item.</a>        
<?php
        }
?>
                        </td>
                    </tr>
                </table>
                
            
            </div>
        </div>  
        
        <div class="section">
            <div>
                <input type="button" onclick="javascript: history.go(-1);" value="CANCEL" /> <input type="submit" onclick=" return checkCustomFieldEmpty(countItems)" value="UPDATE" />
            </div>
        </div>               
          
    </fieldset>
</form>
