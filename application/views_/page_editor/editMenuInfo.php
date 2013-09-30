<?php echo doctype();?>

<html>

<head>

<title>Web Builder - Edit Menu</title>

<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>

<script type="text/javascript" language="javascript" src="<?=base_url();?>js/jquery-1.5.1.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=base_url();?>js/jquery.tablednd_0_5.js"></script>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $('#tblItems').tableDnD();
    
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
    
    if($('#rdoRights3').is(':checked') && $('#lstRoles option:selected').val() == null )
    {
        $('#menu_access_message').html('<code>Please select menu access roles.</code>');  
        submitFlag = false;     
    }
    
    return submitFlag;
}
</script>
<script language="javascript" type="text/javascript">

countItems = <?=$numItems;?>;
var id = <?=$numItems;?>;
function addMenuItem(){
    countItems++;    
    var items = document.getElementById('numItems');    
    items.value++;    
    var tbl = document.getElementById('tblItems');
    var lastRow = tbl.rows.length-1;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = '<input type="text" id="txtItemName'+countItems+'" name="txtItemName[]" value="" />';
    cell1.align = "center";
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<select id="lstItemPage'+countItems+'" name="lstItemPage[]"><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    
    cell3.innerHTML = '<input type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /><label for="rdoItemPublished'+id1+'">Yes</label> &nbsp;<input type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /><label for="rdoItemPublished'+id2+'">No</label>';
    
    cell3.align = "center"; 
    var cell4 = row.insertCell(3);     
    cell4.innerHTML = '&nbsp;';
    
    $('#tblItems').tableDnD();            
} 

function deleteRow(i)
{
    document.getElementById('tblItems').deleteRow(i);
}


</script>
</head>
<body onload="document.frmUpdateMenu.txtName.focus();">

<h1>Edit Menu Details</h1>

<?php
$menu_id = $id;
if($is_main_menu)
{
    $strAction = base_url().index_page().'menusController/updateMainMenu';
}
else
{
    $strAction = base_url().index_page().'menusController/updateMenu';   
}
?>

<form id="frmUpdateMenu" name="frmUpdateMenu" onsubmit="return validate()" action="<?=$strAction?>" method="post">    

        <input type="hidden" id="numItems" name="numItems" value="<?=$numItems;?>" />
        
        <input type="hidden" id="site_id" name="site_id" value="<?=$site_id?>" />
        
        <input type="hidden" name="id" value="<?=$id;?>" /> 
        
        <input type="hidden" name="fancy" value="1" />
        
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
        <td width="20%" valign="top"><b>Menu Name <span style="color: red">*</span></b></td>
        <td valign="top">
            <?php
            $strDisabled = '';
            if($is_main_menu)
            {
                $strDisabled = 'disabled="disabled"';    
            }
            ?>
            <input type="text" name="txtName" id="txtName" value="<?=$menu_name?>" <?=$strDisabled?> />
            <label class="messages" id="menu_name_message" style="padding: 0;"></label>
            <br /><br />  
        </td>
    </tr>
    <?php
    if(!$is_main_menu)
    {
    ?>  
    <tr>
        <td valign="top"><b>Menu Position <span style="color: red">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';
            if($menu_position=="Left")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPosition1" name="rdoPosition" value="Left" <?=$strChecked?> /> 
            <label for="rdoPosition1">Left</label>
            
            <?php
            $strChecked = '';
            if($menu_position=="Right")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPosition2" name="rdoPosition" value="Right" <?=$strChecked?> /> 
            <label for="rdoPosition2">Right</label>
            
            <?php
            $strChecked = '';
            if($menu_position=="Top")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPosition3" name="rdoPosition" value="Top" <?=$strChecked?> /> 
            <label for="rdoPosition3">Top</label>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Published? <span style="color: red">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';
            if($menu_published=="Yes")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPublished1" name="rdoPublished" value="Yes" <?=$strChecked?> />
            <label for="rdoPublished1">Yes</label>
            
            <?php
            $strChecked = '';
            if($menu_published=="No")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPublished2" name="rdoPublished" value="No" <?=$strChecked?> />
            <label for="rdoPublished2">No</label>
            
            <?php
            $strChecked = '';
            $strDisplay = 'display: none';
            if($menu_published=="Schedule")
            {
                $strChecked='checked="checked"';
                $strDisplay = 'display: block';     
            }
            ?>
            <input type="radio" id="rdoPublished3" name="rdoPublished" value="Schedule" <?=$strChecked?>  />
            <label for="rdoPublished3">Schedule</label>
            <label class="messages" id="menu_pub_message" style="padding: 0;"></label>
            
            <div id="schedular" style="<?=$strDisplay?>;margin: 10px 0 0 5px">
            <p>
                <b>Start:</b>
                <br />    
                Date/Time:<input id="startDate" name="startDate" type="text" value="" size="25" readOnly="readOnly"><a href="javascript:NewCal('startDate','ddMMyyyy',true,12)"><img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
            </p>
            <p>    
                <b>End:</b>
                <br />    
                Date/Time:<input id="endDate" name="endDate" type="text" value="" size="25" readOnly="readOnly"><a href="javascript:NewCal('endDate','ddMMyyyy',true,12)"><img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
            </p>
            </div>
            
            <br /><br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Display on Which Pages? <span style="color: red">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked='';
            if($menu_pages=="All")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoPages1" name="rdoPages" value="All" <?=$strChecked?> />
            <label for="rdoPages1">All</label>
            
            <?php
            $strChecked='';
            $strDisplay = 'display: none;';  
            if($menu_pages=="Other")
            {
                $strChecked='checked="checked"';
                $strDisplay = 'display: block;';            
            }
            ?>
            <input type="radio" id="rdoPages2" name="rdoPages" value="Other" <?=$strChecked?>  />
            <label for="rdoPages2">Some</label>
            <label class="messages" id="menu_pages_message" style="padding: 0;"></label>
            
            <div id="pages" style="<?=$strDisplay?>">
            <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="width:130px; margin: 10px 0 0 5px">
                <?php 
                foreach($pages->result_array() as $rowPages)
                {
                    $strSelected = '';
                    if($this->Menus_Model->isMenuPage($id, $rowPages['page_id']))
                    {
                        $strSelected='selected="selected"';
                    }
                ?>
                <option value="<?=$rowPages['page_id']?>" <?=$strSelected?>><?=$rowPages['page_title']?></option>
                <?php 
                }
                ?>        
            </select>
            </div>
            
            <br /><br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Who Can View This Menu? <span style="color: red">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked='';
            if($menu_access=="Everyone")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoRights1" name="rdoRights" value="Everyone" <?=$strChecked?> />
            <label for="rdoRights1">Everyone</label>
            
            <?php
            $strChecked='';
            if($menu_access=="Registered")
            {
                $strChecked='checked="checked"';    
            }
            ?>
            <input type="radio" id="rdoRights2" name="rdoRights" value="Registered" <?=$strChecked?> />
            <label for="rdoRights2">Registered</label>
            
            <?php
            $strChecked='';
            $strDisplay = 'display: none;';  
            if($menu_access=="Other")
            {
                $strChecked='checked="checked"';  
                $strDisplay = 'display: block;';    
            }
            ?>
            <input type="radio" id="rdoRights3" name="rdoRights" value="Other" <?=$strChecked?> />
            <label for="rdoRights3">Other</label>
            <label class="messages" id="menu_access_message" style="padding: 0;"></label>
            
            <div id="roles" style="display: none;">    
            <select id="lstRoles" name="lstRoles[]" multiple="multiple" style="width:130px; margin: 10px 0 0 5px">
                <?php 
                foreach($roles->result_array() as $rowRoles):
                ?>
                <option value="<?=$rowRoles['role_id']?>"><?=$rowRoles['role_name']?></option>
                <?php 
                endforeach;
                ?>        
            </select>
            </div>
            
            <br /><br />
        </td>
    </tr>
    <?php
    }//is main menu end of if
    ?>
    <tr>
        <td valign="top"><b>Menu Items</b></td>
        <td valign="top">
            <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <th width="30%">Item</th>
                <th width="30%">Destination</th>
                <th>Published</th>
            </tr>
            </table>
            <table id="tblItems" width="100%" border="0" cellpadding="3" cellspacing="0"> 
            <?php 
            $idd = 0;
            $i=1;
            foreach( $menu_items->result_array() as $rowItemInfo )
            {
                $id1 = $idd + $i;
                $id2 = $idd + 1 + $i;
                $idd++;
            ?>
            <tr id="rowItem<?=$i;?>">
                <td width="30%" align="center">
                    <input type="text" id="txtItemName<?=$i;?>" name="txtItemName<?=$i;?>" value="<?=$rowItemInfo["item_name"];?>" />
                </td>
                <td width="30%" align="center">
                    <select id="lstItemPage<?=$i;?>" name="lstItemPage<?=$i;?>">
                    <?php 
                    foreach( $pages->result_array() as $rowPages )
                    {
                        $strSelected = "";
                        if($this->Menus_Model->isItemPage($id, $rowItemInfo["item_id"], $rowPages['page_id']))
                        {
                            $strSelected = 'selected="selected"';
                        }
                        ?>
                        <option value="<?=$rowPages['page_id']?>" <?=$strSelected;?>><?=$rowPages['page_title']?></option>
                    <?php 
                    }
                    ?>
                    </select>
                </td>
                <td align="center">
                    <?php
                    $strChecked="";  
                    if( $rowItemInfo["item_published"]=="Yes" )
                    {
                        $strChecked='checked="checked"';
                    }
                    ?>
                    <input type="radio" id="rdoItemPublished<?=$id1?>" name="rdoItemPublished<?=$i?>" value="Yes" <?=$strChecked?> />
                    <label for="rdoItemPublished<?=$id1?>">Yes</label>
                    
                    <?php
                    $strChecked="";        
                    if( $rowItemInfo["item_published"]=="No" )
                    {
                        $strChecked='checked="checked"';
                    }
                    ?>
                    <input type="radio" id="rdoItemPublished<?=$id2?>" name="rdoItemPublished<?=$i?>" value="No" <?=$strChecked?> />
                    <label for="rdoItemPublished<?=$id2?>">No</label> 
                </td>
                <td><img src="<?=base_url();?>/images/icon-delete.png" onclick="deleteRow(this.parentNode.parentNode.rowIndex)" /></td>
            </tr>
            <?php
                $i++;
            }//end foreach;
            ?> 
            <tr>
                <td colspan="3">
                    <a href="javascript: void(0)" onclick="addMenuItem()" style="font-size: 12px;">Click here to Create a New Menu Item.</a>
                </td>
            </tr>
            </table>
            
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="button" value="Cancel" onclick="parent.$.fancybox.close();" />
            &nbsp; <input type="submit" value="Update" />
        </td>
    </tr>
</table>
</form>

 
</body>
</html>
