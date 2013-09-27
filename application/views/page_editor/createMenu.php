<?php echo doctype();?>

<html>

<head>



<title>Web Builder - Add Menu</title>



<style type="text/css">

code {

    font-size: 11px;

    color: red;

}

</style>



<script language="javascript" type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>   



<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>



<script language="javascript" type="text/javascript">



countItems = 0;



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

    cell2.innerHTML = '<select id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'"><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select>';

    cell2.align = "center";

    var cell3 = row.insertCell(2);

    cell3.innerHTML = '<label><input type="radio" id="rdoItemPublished'+countItems+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" />Yes</label> <label><input type="radio" id="rdoItemPublished'+countItems+'" name="rdoItemPublished'+countItems+'" value="No" />No</label>';

    cell3.align = "center";      

}



var id = 0; 





$(document).ready(function() {

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

</head>

<body style="margin-left:15px;" onLoad="document.frmAddMenu.txtName.focus();">



<h1>Create a Menu</h1>



<form id="frmAddMenu" name="frmAddMenu" onSubmit="return validate()" action="<?=base_url().index_page()?>menusController/addMenu/<?=$site_id?>" method="post">

    

        <input type="hidden" id="numItems" name="numItems" value="0" />

        

        <input type="hidden" id="site_id" name="site_id" value="<?=$site_id?>" />

        

        <input type="hidden" name="fancy" value="1" />

        

<table> 

    <tr>

        <td width="30%" valign="top"><b>Menu Name <span style="color: red">*</span></b></td>

        <td valign="top">

            <input type="text" name="txtName" id="txtName" value="" />

            <label class="messages" id="menu_name_message" style="padding: 0;"></label>

            <br /><br />  

        </td>

    </tr>  

    <tr>

        <td valign="top"><b>Menu Position <span style="color: red">*</span></b></td>

        <td valign="top">

            <input type="radio" id="rdoPosition1" name="rdoPosition" value="Left" checked="checked" /> 

            <label for="rdoPosition1">Left</label>

            

            <input type="radio" id="rdoPosition2" name="rdoPosition" value="Right" /> 

            <label for="rdoPosition2">Right</label>

            

            <input type="radio" id="rdoPosition3" name="rdoPosition" value="Top" /> 

            <label for="rdoPosition3">Top</label>

            <br /><br />

        </td>

    </tr>

    <tr>

        <td valign="top"><b>Published? <span style="color: red">*</span></b></td>

        <td valign="top">

            <input type="radio" id="rdoPublished1" name="rdoPublished" value="Yes" checked="checked" />

            <label for="rdoPublished1">Yes</label>

            

            <input type="radio" id="rdoPublished2" name="rdoPublished" value="No" />

            <label for="rdoPublished2">No</label>

            

            <input type="radio" id="rdoPublished3" name="rdoPublished" value="Schedule"  />

            <label for="rdoPublished3">Schedule</label>

            <label class="messages" id="menu_pub_message" style="padding: 0;"></label>

            

            <div id="schedular" style="display: none;margin: 10px 0 0 5px">

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

            <input type="radio" id="rdoPages1" name="rdoPages" value="All"  checked="checked" />

            <label for="rdoPages1">All</label>

            

            <input type="radio" id="rdoPages2" name="rdoPages" value="Other"  />

            <label for="rdoPages2">Some</label>

            <label class="messages" id="menu_pages_message" style="padding: 0;"></label>

            

            <div id="pages" style="display: none;">

            <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="width:130px; margin: 10px 0 0 5px">

                <?php 

                foreach($pages->result_array() as $rowPages)

                {

                ?>

                <option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option>

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

            <input type="radio" id="rdoRights1" name="rdoRights" value="Everyone"  checked="checked" />

            <label for="rdoRights1">Everyone</label>

            

            <input type="radio" id="rdoRights2" name="rdoRights" value="Registered" />

            <label for="rdoRights2">Registered</label>

            

            

            

            

            <? if(isset($groups) && !empty($groups))
					{ ?>
                    <input type="radio" id="rdoRights3" name="rdoRights" value="Other" />

            		<label for="rdoRights3">Other</label>

           			 <label class="messages" id="menu_access_message" style="padding: 0;"></label>
                    <? 
					}
					else
					{  
					?>
						<a  href="<?=base_url().index_page()?>sitegroups/new_site_group/m" >No Group Exists Click To Create Group!</a>
                     <?php
					}		
					?>
                    
					<!--	group ilst 	-->
					<? 
                        if(isset($groups) && !empty($groups)){ ?>		
                                <div id="roles" style="display: none;clear:both;width:360px;">    
                                    	<div  style=" position:relative; margin-top:10px; float:left; width:360px;">
                                        <select size="5" name="group_access[]" id="group_access" multiple="multiple" style="width:360px; margin-top:10px;margin-bottom:10px; ">
                                        <?
                                        foreach($groups as $group)
                                        {
                                        ?>
                                                <option value="<?=$group['id']?>"><?=$group['group_name']?></option>		
                                        <?
										} ?>
                                   		</select>
                                        </div>	
                                </div>
                    <?  
							}
                    ?>      

                      <br /><br />

        </td>

    </tr>

    <tr>

        <td valign="top"><b>Menu Items</b></td>

        <td valign="top">

            <table id="tblItems" width="100%" border="0" cellpadding="3" cellspacing="0">

            <tr>

                <th width="40%">Item</th>

                <th width="30%">Destination</th>

                <th>Published</th>

            </tr>

            <tr>

                <td colspan="3">

                    <a href="javascript: void(0)" onClick="addMenuItem()" style="font-size: 12px;">Click here to Create a New Menu Item.</a>

                </td>

            </tr>

            </table>

            

            <br /><br />

        </td>

    </tr>

    <tr>

        <td>&nbsp;</td>

        <td>

            <input type="button" value="Cancel" onClick="parent.$.fancybox.close();" />

            &nbsp; <input type="submit" value="Create" />

        </td>

    </tr>

</table>

</form>



</body>

</html>

