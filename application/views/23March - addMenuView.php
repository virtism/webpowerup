<script>
  function get_link(id){
  	var dropdown_name = document.getElementById(id).name;
      var clink = document.getElementById(id).value;
     //alert( clink);
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
			
			var txt_filed = document.getElementById("_lstItemPage"+i).value;
			//alert(txt_filed);
			var dropdown = document.getElementById("lstItemPage"+i).value;
			var link = dropdown.split("_");
			
			if(link[0]=='clink')
			{
				if(document.getElementById("_lstItemPage"+i).value=='')
				{
						flag = flag + 1;
				}
			}
			else
			{
				if(dropdown == 0 || dropdown == "")
				{
						flag = flag + 1;
				}
				//if(dropdown)
			}			
		}		
		if(flag > 0)
		{
			alert("Destination can't be empty.");
			return false;
		}
		else
		{
			//alert("all welldone");
			return true;
		}
		
	}
</script>
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
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript">

countItems = 0;

var id = 0; 
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
    cell2.innerHTML = '<div class="selector"><span style="-moz-user-select: none; font-size:11px; font-weight: bold;">Select Page</span><select onchange="get_link(this.id)" id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'" style="opacity: 0;filter: alpha(opacity = 0);"><option value="0">Select Page</option><option  value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select></div> <input align="left"; size="10px;" type="text" name="_lstItemPage'+countItems+'" id="_lstItemPage'+countItems+'"  style="display: none;"/>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell3.innerHTML = '<div class="radio"><span class="checked"><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /></span></div><label for="rdoItemPublished'+id1+'">Yes</label> &nbsp;<div class="radio"><span><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></span></div><label for="rdoItemPublished'+id2+'">No</label>';
    cell3.align = "center";      
}


function addSubMenuItem()
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
    cell2.innerHTML = '<div class="selector"><span style="-moz-user-select: none; font-size:11px; font-weight: bold;">Select Page</span><select onchange="get_link(this.id)" id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'" style="opacity: 0;filter: alpha(opacity = 0);"><option value="0">Select Page</option><option  value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select></div> <input align="left"; size="10px;" type="text" name="_lstItemPage'+countItems+'" id="_lstItemPage'+countItems+'"  style="display: none;"/>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
    cell3.innerHTML = '<div class="radio"><span class="checked"><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /></span></div><label for="rdoItemPublished'+id1+'">Yes</label> &nbsp;<div class="radio"><span><input style="opacity: 0;filter: alpha(opacity = 0);" type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></span></div><label for="rdoItemPublished'+id2+'">No</label>';
    cell3.align = "center";      
}



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
    
    if($('#rdoRights3').is(':checked') && $('#group_access option:selected').val() == null )
    {
        $('#menu_access_message').html('<code>Please select menu access group access.</code>');  
        submitFlag = false;     
    }
	var other = document.getElementById('rdoRights3').checked;
	var len = document.frmAddMenu.group_access.length;
	var i = 0;
	var chosen = '';
	if(other)
	{
		for (i = 0; i < len; i++)
		{
			if (document.frmAddMenu.group_access[i].selected)
			{
				 chosen = document.frmAddMenu.group_access[i].value;
			}
		}
		if(chosen =="")
		{
			//alert("Please select Group(s) allowed to access this page");
			submitFlag = false;     
		}
	
    }
    return submitFlag;
}
</script>

<form onclick="resetFormControls()" id="frmAddMenu" name="frmAddMenu" onsubmit="return validate()" action="<?=base_url();?>index.php/menusController/addMenu/<?=$site_id?>" method="post"> 
    <fieldset>
        <input type="hidden" id="numItems" name="numItems" value="0" />
        <input type="hidden" id="site_id" name="site_id" value="<?=$site_id?>" />
        
        <label>Create a Menu</label>
        
        <div class="section">
            <label>Menu Name <span class="required">&nbsp;</span></label>
            <div>
                <input type="text" name="txtName" id="txtName" value="" maxlength="30" />
                <label class="messages" id="menu_name_message" style="padding: 0;"></label>
            </div>
            
        </div>
        
        <div class="section">
            <label>Menu Position <span class="required">&nbsp;</span></label>
            <div>
                <div class="radio">
                    <span class="checked"><input type="radio" value="Left" name="rdoPosition" id="rdoPosition1" checked="checked" /></span>
                </div>
                <label for="rdoPosition1">Left</label>
                
                <div class="radio">
                    <span><input type="radio" value="Right" name="rdoPosition" id="rdoPosition2" /></span>
                </div>
                <label for="rdoPosition2">Right</label>
                
                <div class="radio">
                    <span><input type="radio" value="Top" name="rdoPosition" id="rdoPosition3" /></span>
                </div>
                <label for="rdoPosition3">Top</label>
            </div>
        </div>
        
        <div class="section">
             <label>Select Parent</label>
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
                                <span class="checked"><input type="radio" value="Yes" name="rdoPublished" id="rdoPublished1" checked="checked" /></span>
                            </div>
                            <label for="rdoPublished1">Yes</label>
                            
                            <div class="radio">
                                <span><input type="radio" value="No" name="rdoPublished" id="rdoPublished2" /></span>
                            </div>
                            <label for="rdoPublished2">No</label>
                            
                            <div class="radio">
                                <span><input type="radio" value="Schedule" name="rdoPublished" id="rdoPublished3" /></span>
                            </div>
                            <label for="rdoPublished3">Schedule</label> 
                            <label class="messages" id="menu_pub_message" style="padding: 0;"></label>   
                        </td>
                    </tr>
                </table>
                
                <div id="schedular" style="display: none;">
                <p>
                    <b>Start:</b>
                    <br />    
                    Date/Time:
                    <input id="startDate" name="startDate" type="text" value="" size="25" readOnly="readOnly">
                    <a href="javascript:NewCal('startDate','ddMMyyyy',true,12)">
                        <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                    </a>
                </p>
                <p>    
                    <b>End:</b>
                    <br />    
                    Date/Time:
                    <input id="endDate" name="endDate" type="text" value="" size="25" readOnly="readOnly">
                    <a href="javascript:NewCal('endDate','ddMMyyyy',true,12)">
                        <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                    </a>
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
                            <span class="checked"><input type="radio" value="All" name="rdoPages" id="rdoPages1" checked="checked" /></span>
                        </div>
                        <label for="rdoPages1">All Pages</label>
                        
                        <div class="radio">
                            <span><input type="radio" value="Other" name="rdoPages" id="rdoPages2" /></span>
                        </div>
                        <label for="rdoPages2">Some Pages</label>
                        <label class="messages" id="menu_pages_message" style="padding: 0;"></label>
                        </td>
                    </tr>
                </table>
                
                <div id="pages" style="display: none;">
                    <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="margin-top: 10px; margin-bottom:10px; width:130px; opacity: 1; filter: alpha(opacity = 100)">
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
                
            </div>
        </div> 
        
        <div class="section">
            <label>Who can view this Menu? <span class="required">&nbsp;</span></label>
            <div>
                <table id="signup_1" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="radio">
                                <span class="checked"><input type="radio" value="Everyone" name="rdoRights" id="rdoRights1" checked="checked" /></span>
                            </div>
                            <label for="rdoRights1">Everyone</label>
                            
                            <? if($template_name!='gymnastic'){ ?>
				
								<div class="radio">
									<span><input type="radio" value="Registered" name="rdoRights" id="rdoRights2" /></span>
								</div>
								<label for="rdoRights2">Registered</label>
								<? if(isset($groups) && !empty($groups)){ ?>
										<div class="radio">
											<span><input type="radio" value="Other" name="rdoRights" id="rdoRights3" /></span>
										</div>
										<label for="rdoRights3">Other</label>
										<label class="messages" id="menu_access_message" style="padding: 0;"></label>
								<? 
								}
								else
								{  
					
										//$site_id = $this->uri->segment(3);
								?>
										<a  href="<?=base_url()?>index.php/sitegroups/new_site_group/m" >No Group Exists Click To Create Group!</a>
							 <? }					
							} ?>	
                        </td>
                    </tr>
                </table>
				<? if($template_name!='gymnastic')
				{ 
				
				
					if(isset($groups) && !empty($groups)){ ?>
							<div id="roles" style="display: none;">  
							  <select  name="group_access[]" id="group_access" multiple="multiple" style="width:130px; margin-top:10px;margin-bottom:10px; opacity: 1; filter: alpha(opacity = 100)">
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
									?>
									<option value="<?=$rowRoles['role_id']?>"><?=$rowRoles['role_name']?></option>
									<?php 
									endforeach;
									?>        
								</select><?php */?>
							</div>
				<?  }
                } ?>      
            </div>
        </div> 
        
        <div class="section">
            <label>Menu Item(s)</label>
            <div>
                <!-- Default view Of Create Menu -->
                
                <table id="tblItems" width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                        <th width="40%">Caption</th>
                        <th width="30%">Destination</th>
                        <th width="30%">Published</th>
                    </tr>
                    <tr>
                        <td align="center">
                            <a href="javascript: void(0)" onclick="addMenuItem()">Click here to Add a Menu Item.</a>  
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>  
                    </tr>
                </table>
            
            </div>
        </div>  
        
        <div class="section">
            <div>
                <input type="button" value="Cancel" onclick="javascript: history.go(-1); " /> <input type="submit" onclick=" return checkCustomFieldEmpty(countItems)"  value="CREATE" />
            </div>
        </div>               
          
    </fieldset>
</form>
