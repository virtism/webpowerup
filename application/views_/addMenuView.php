<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jscolor/jscolor.js"></script>

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

<script language="javascript" type="text/javascript">
countItems = 0;
var id = 0; 


function addMenuItem()
{
	countItems++;    
    var items = document.getElementById('numItems');    
    items.value++; 
	
	var id1 = id + countItems;
    var id2 = id + 1 + countItems;
    id++;
	
	var html = '<ul class="TableData"><li><input class="NFText" id="txtItemName'+countItems+'" name="txtItemName'+countItems+'" value="" maxlength="30" size="18" type="text"></li><li><div style=" position:relative; margin-top:10px; float:left"><select size="1" onchange="get_link(this.id)" id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'"  style="width:165px;"><option value="0">Select Page</option><option value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=str_replace("'",'',$rowPages['page_title'])?></option><?php endforeach;?></select></div><div style=" float:left; display: none;" id="_lstItemPage'+countItems+'" ><br /><input align="left"; type="text" name="_lstItemPage'+countItems+'" /></div></li><li style="width:60px;min-width:60px;" ><label class="check_label">Yes</label><input type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /><br /><br /><label class="check_label">No</label><input type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></li><li><div style=" position:relative; margin-top:10px; float:left"><select size="1" name="menuTarget'+countItems+'" id="menuTarget'+countItems+'" style="width:160px;"><option value="_self">Same Window</option><option value="_blank">New Window</option></select></div></li><li style="width:60px;min-width:60px;"><a href="javascript: void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
	$("#menuItemList").append(html);
	NFFix();
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
        $('#menu_access_message').html('<code>Please select menu access roles.</code>');  
        submitFlag = false;     
    }
	var len = document.frmAddMenu.group_access.length;
	var i = 0;
	var chosen = '';
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
<script type="text/javascript">
$(".DeleteAction").live("click",function(){
	$(this).parent().parent().remove();
});

$("img.NFCheck").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	
});

$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	// alert("asdasd");
	if(id == "rdoPublished3")
	{
		$("#schedular").fadeIn();
	}
	if(id == "rdoPublished1" || id == "rdoPublished2")
	{
		$("#schedular").fadeOut();
	}
	
	if(id == "rdoPages1")
	{
        $('#pages').fadeOut('slow');        
    }
    
	if(id == "rdoPages2")
	{
        
		/*var commonWidth = 205;
		var commonHeight = "90px";
		$("#pages").children().children("div:nth-child(2n+1)").css({
		   width : 205,
		   height:"10px"
		   
		});
		 
		 $("#pages").children().children("div:nth-child(2)").css({
		   width : commonWidth+5,
		   height:commonHeight
		   
		}); 
		$("#pages").children().children("div:nth-child(2)").children("div").css({
		   width : "5px",
		   height:"82px"
		});
		$("#pages").children().children("div:nth-child(2)").children("select").css({
		   width : commonWidth-5,
		   height:commonHeight,
		   position: 'static'
		  
		});*/
		
		
		$('#pages').fadeIn('slow');  
		NFFix(); 
    } 
    
	if(id == "rdoRights1" || id == "rdoRights2")
	{
        $('#roles').fadeOut('slow');        
    }
    
	if(id == "rdoRights3" )
	{
		/*var commonWidth = 205;
		var commonHeight = "90px";
		
		$("#roles").children().children("div:nth-child(2n+1)").css({
		   width : 205,
		   height:"10px"
		   
		});
		 
		 $("#roles").children().children("div:nth-child(2)").css({
		   width : commonWidth+5,
		   height:commonHeight
		   
		}); 
		$("#roles").children().children("div:nth-child(2)").children("div").css({
		   width : "5px",
		   height:"82px"
		});
		$("#roles").children().children("div:nth-child(2)").children("select").css({
		   width : commonWidth-5,
		   height:commonHeight,
		   position: 'static'
		  
		});*/
		
        $('#roles').fadeIn('slow');   
		NFFix();     
    }
	
});


</script>

<div class="RightColumnHeading">
    <h1>
    	<img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="New Form"/>
        <span>Create a Menu</span>
    </h1>
</div>
<div class="clr"></div>

<div class="InnerMain2">

	<form onclick="resetFormControls()" id="frmAddMenu" name="frmAddMenu" onsubmit="return validate()" action="<?=base_url().index_page()?>menusController/addMenu/<?=$site_id?>" method="post" class="niceform"> 
    <fieldset>
        <input type="hidden" id="numItems" name="numItems" value="0" />
        <input type="hidden" id="site_id" name="site_id" value="<?=$site_id?>" />
        
      
        
        <dl>
            <dt>
                 <label for="page_title" class="NewsletterLabel">Menu Name <span class="star">*</span></label>
            </dt>
            <dd>
                <input type="text" name="txtName" id="txtName" value="" maxlength="30" size="55" />
                <label class="messages" id="menu_name_message" style="padding: 0;"></label>
            </dd>
        </dl>
        
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Menu Position</label>
               </dt>
               <dd>
                    <label class="check_label">Left</label>
					<input type="radio" value="Left" name="rdoPosition" id="rdoPosition1" checked="checked" />
                    
                    <label class="check_label">Right</label>
					<input type="radio" value="Right" name="rdoPosition" id="rdoPosition2" />
               </dd>
        </dl>        
        
        <?php /*?><dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Select Parent</label>
               </dt>
               <dd>
                    <div  style=" position:relative; margin-top:10px; float:left">
                        <select size="1" id="parent_menu" name="parent_menu" style="width:360px;"> 
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
               </dd>
        </dl><?php */?>
        
        
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Published?</label>
               </dt>
               <dd>
                    <label class="check_label">Yes</label>
					<input type="radio" value="Yes" name="rdoPublished" id="rdoPublished1" checked="checked" />
                    
                    <label class="check_label">No</label>
					<input type="radio" value="No" name="rdoPublished" id="rdoPublished2" />
                    
                    <label class="check_label">Schedule</label>
					<input type="radio"  name="rdoPublished" id="rdoPublished3" />
                    
                    <div id="schedular" style="display:none;">
                    
                    <div style="width:380px; height:100px; clear:both;">
                        <div style="float:left; clear:left; font-weight:bold; width:50px; padding:12px 0 0 15px;">Start:</div>
                        <div style="float:left; ">
                            &nbsp; Date/Time:
                            <input id="startDate" name="startDate" type="text" value="" size="25" readOnly="readOnly">
                            
                            <a href="javascript:NewCal('startDate','ddMMyyyy',true,12)">
                                <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                            </a>
                        </div>
                          
                        <div style="float:left; clear:left; font-weight:bold; width:50px; padding:12px 0 0 15px;">End:</div>
                        <div style="float:left;">    
                            &nbsp; Date/Time:
                            <input id="endDate" name="endDate" type="text" value="" size="25" readOnly="readOnly">
                            
                            <a href="javascript:NewCal('endDate','ddMMyyyy',true,12)">
                                <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                            </a>
                        </div>
                   		
                    </div>
                    
                    
                    
                    </div>
                    
               </dd>
        </dl>
        
        
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Display on which Webpages?</label>
               </dt>
               <dd>
                    <label class="check_label">All Pages</label>
					<input type="radio" value="All" name="rdoPages" id="rdoPages1" checked="checked" />
                    
                    <label class="check_label">Some Pages</label>
					<input type="radio" value="Other" name="rdoPages" id="rdoPages2"  />
                    
                    
                    <div id="pages" style="display: none; clear:both;">
                        <div  style=" position:relative; margin-top:15px; float:left;">
                        <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="width:360px;">
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
                    
               </dd>
        </dl>
        
        <dl>
               <dt>
                    <label for="page_title" class="NewsletterLabel">Who can view this Menu?</label>
               </dt>
               <dd>
                    <label class="check_label">Everyone</label>
					<input type="radio" value="Everyone" name="rdoRights" id="rdoRights1" checked="checked" />
                    <? if($template_name!='gymnastic')
					{ ?>
                    <label class="check_label">Registered</label>
					<input type="radio" value="Registered" name="rdoRights" id="rdoRights2" />
                    
                    <? if(isset($groups) && !empty($groups))
					{ ?>
                    <label class="check_label">Other</label>
					<input type="radio" value="Other" name="rdoRights" id="rdoRights3" />
                    <label class="messages" id="menu_access_message" style="padding: 0;"></label>
                    <? 
					}
					else
					{  
					?>
						<a  href="<?=base_url().index_page()?>sitegroups/new_site_group/m" >No Group Exists Click To Create Group!</a>
                     <?php
					}		
					} ?>
                    
					<!--	group ilst 	-->
					<? if($template_name!='gymnastic')
                    { 
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
                    <?  }
                    } ?>                    
               </dd>
        </dl>  
         <table width="590" border="0" cellpadding="3" cellspacing="3">       
              <tr>
                <td width="141" align="right" ><label for="page_title" class="NewsletterLabel">Primary Color :</label> </td>
                <td width="111">
                <input type="text" name="prime_view_color" id="prime_view_color" onmousemove="document.getElementById('prime_view_color').color.showPicker()" onmouseover="document.getElementById('prime_view_color').color.hidePicker()" style="border: solid 1px #CCC; margin: 0 0 10px 15px;width: 60px; height: 35px;background-color: <?=(array_key_exists('primary_color',$groups)) ?  $groups['menu_primary_color'] : 'FFFFFF';?>;" class="color {valueElement:'prim_color' } none color_field" autocomplete="off" readonly="readonly" />
                <input type="hidden"  name="prim_color" id="prim_color" value="<?=(array_key_exists('primary_color',$groups)) ?  $groups['menu_primary_color'] : 'FFFFFF';?>"  >
                
                </td>
                <td width="10" rowspan="3">&nbsp;</td>
                <td width="141" align="right" class="NewsletterLabel"><label for="page_title" class="NewsletterLabel">Primary Text : </label> </td>                                                                                                                                                                                                                                                                                                
                <td width="139"><input type="text" name="prim_view_txt" id="prim_view_txt"  onmousemove="document.getElementById('prim_view_txt').color.showPicker()" onmouseover="document.getElementById('prim_view_txt').color.hidePicker()" style="border: solid 1px #CCC; margin: 0 0 10px 15px;width: 60px; height: 35px; background-color: <?=(array_key_exists('primary_txt',$groups)) ?  $groups['menu_txt_color'] : 'FFFFFF';?>;" class="color {valueElement:'prim_txt' } none color_field"  autocomplete="off" readonly="readonly" />
                 <input type="hidden" name="prim_txt" id="prim_txt"  value="<?=(array_key_exists('primary_txt',$groups)) ?  $groups['menu_txt_color'] : 'FFFFFF';?>"  >
                </td>
              </tr>
            </table>      
        
        <div class="RightColumnHeading">
        	<h1>
            	<img src="<?=base_url();?>images/webpowerup/MenuItems.png" alt="Menu Items"/>
                <span>Menu Items</span>
            </h1>
            
            <div class="RightSideButton">
            	<a href="javascript: void(0)" onclick="addMenuItem()" >
                	<img src="<?=base_url();?>images/webpowerup/AddMenuItem.png" alt="Add Menu Item"/>
                </a>
            </div>
        </div>

        
        <div class="DataGrid2">
        <ul class="TableHeader">
            <li>Caption</li>
            <li>Destination </li>
            <li style="width:60px;min-width:60px;"  >Published </li>
            <li>Target Window</li>
            <li style="width:60px;min-width:60px;"  >Action</li>
        </ul>
		
        <!--	MENU ITEM 	-->
        <div id="menuItemList">
        	<!--<ul class="TableData">
            <li>
            <div  style=" position:relative;float:left; width:160px;">
                <input type="text" name="" id="" size="18" /> 
                </div>
            </li>
            
             <li>
               <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" name="text" id=""  style="width:160px;"> 
                        <option value="">Single-Line Text</option>
                        <option value="">Select option 2</option> 
                        <option value="">Select option 3</option>
                        <option value="">Select option 4</option> 
                        <option value="">Select option 5</option> 
               </select>
               </div>
            </li>
            <li class="Actions">
                <label class="check_label">Yes</label>
                 <input type="radio" name="Publihed" id="" value="" checked="checked" />
                 <br /><br />   
                 <label class="check_label">No</label>
                 <input type="radio" name="Publihed" id="" value=""/> 

            </li>
            <li>
                 <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" name="text" id=""  style="width:160px;"> 
                        <option value="">Single-Line Text</option>
                        <option value="">Select option 2</option> 
                        <option value="">Select option 3</option>
                        <option value="">Select option 4</option> 
                        <option value="">Select option 5</option> 
               </select>
               </div>
            </li>
            <li class="Actions">
                 <a href="#" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a>
             </li>
        </ul>-->
        </div>
        <!--	MENU ITEM 	-->
         
    	<ul class="TableData AlterRow AddFieldRow">
            <li>
             <div class="AddMoreField">                    
                <a href="javascript: void(0)" onclick="addMenuItem()" >
                <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field"/>
                Add a Menu Item
                </a>
             </div>
            </li>
        </ul>
        </div> 
        
        <div class="clr"></div>
        
        <div class="btnBlue">
            <input type="button" value="Cancel" onclick="javascript: history.go(-1); " /> <input type="submit" onclick=" return checkCustomFieldEmpty(countItems)"  value="Create" />
        </div>
                       
          
    </fieldset>
</form>

</div>