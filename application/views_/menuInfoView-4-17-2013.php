
<script type="text/javascript" src="<?=base_url()?>js/drag_UI/jquery-ui.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script>
 
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

function validate()
{ 
    
    
    $('.messages').text('');
    
    if($('#txtName').val()=='')
    {
        alert('Please enter menu name');
        return 0;    
    }
    
    if($('#rdoPublished3').is(':checked'))
    {
        if($('#startDate').val()=='')
        {
            alert('Please enter publish date(s)');
            return 0;  
        }
        if($('#endDate').val()=='')
        {
            alert('Please enter publish date(s)'); 
           return 0;    
        }
    }
    
    if($('#rdoPages2').is(':checked') && $('#lstPages option:selected').val() == null )
    {
        alert('Please select menu pages');  
        return 0;   
    }
    
    if($('#rdoRights3').is(':checked') && $('#group_access option:selected').val() == null )
    {
		alert('Please select Group(s) allowed to access this page'); 
        return 0;    
    }
	
	return 1;
}


function checkCustomFieldEmpty(countItems)
{
	// alert("in funk");
	
	
	var flag =0;
	for(var i=1; i<=countItems; i++)
	{
		
		if($("#txtItemName"+i).val() == "")
		{
			alert("Caption is Required.");
			return 0;
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
		return 0;
	}
	else
	{
		//alert("all welldone");
		return 1;
	}
	
}

function show_busy()
{
	busyImg = "<img id='busy' src='<?=base_url();?>images/webpowerup/busy1.gif'> ";
	$("#response").html(busyImg);
}

</script>
<script type="text/javascript">

$("img.NFCheck").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	
});


/*$(".NFSelectOptions li a").live("mouseover",function(){
	
	  
	  var id = $(this).html();	  
	  $(this).attr('title', id);
	  $(".NFSelectRight").attr('title', id);	
		//$(this).parent("div.NFSelectRight").hide();
		if(id.length>7)
		{
			//$(".NFSelectRight").html(id.substring(0,7));	
			$(this).prev("div.NFSelectRight").html(id.substring(0,7));
		}
		else
		{
			//$(".NFSelectRight").html(id);
			$(this).prev("div.NFSelectRight").html(id);
		}
	 // console.log(id);
	  
});*/

 

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
        
		
		
		$('#pages').fadeIn('slow');  
		NFFix(); 
    } 
    
	if(id == "rdoRights1" || id == "rdoRights2")
	{
        $('#roles').fadeOut('slow');        
    }
    
	if(id == "rdoRights3" )
	{
		
        $('#roles').fadeIn('slow');   
		NFFix();     
    }
	
});



//	DRAG AND DROP JQUERY UI CODE 
$(document).ready(function(){
	
	

	// ADDING MENU ITEMS 
	var id = 0; // ?
	var countItems = $("#numItems").val();
	$("#btnAddItems,#btnAddItems2").click(function(e) {
        
		countItems++;    
	   
    //items.value++; 
	
		var id1 = id + countItems;
		var id2 = id + 1 + countItems;
	   
		<?php $max  = 7; ?>
		var html = '<span><ul class="TableData"><li><input class="NFText" id="txtItemName'+countItems+'" name="txtItemName'+countItems+'" value="" maxlength="30" size="15" type="text"></li><li><div style=" position:relative; margin-top:10px; float:left"><select size="1" onchange="get_link(this.id)" id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'"  style="width:140px;"><option value="0">Select Page</option><option value="clink_'+countItems+'" >Custom Link</option><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?php  echo $rowPages['page_title']; ?></option><?php endforeach;?></select></div><div style=" float:left; width:170px; display: none;" id="_lstItemPage'+countItems+'" ><br/><input align="left"; type="text" style="width:120px;" name="_lstItemPage'+countItems+'" /></div></li><?php if($is_main_menu){ ?><li><div style="position:relative;margin-top:10px;float:left;"><select size="1" id="parent_id'+countItems+'" name="parent_id'+countItems+'" style="width:140px;"><?php foreach($parent_array as $key => $value){?><option value="<?=$key?>"><?=$value?></option><?php }?></select></div></li><?php } ?><li style="width:60px;min-width:60px;"><label class="check_label">Yes</label><input type="radio" id="rdoItemPublished'+id1+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" /><label class="check_label">No</label><input type="radio" id="rdoItemPublished'+id2+'" name="rdoItemPublished'+countItems+'" value="No" /></li><li><div style=" position:relative; margin-top:10px; float:left"><select size="1" name="menuTarget'+countItems+'" id="menuTarget'+countItems+'" style="width:140px;"><option value="_self">Same Window</option><option value="_blank">New Window</option></select></div></li><li style="width:60px;min-width:60px;"><a href="javascript: void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span>';
		
		$("#menuItemList").append(html);
		$("#numItems").val(countItems);
		NFFix();
		
    });
	
	// removing items
	$(".DeleteAction").live("click",function(){
		$(this).parent().parent().parent().remove();
		countItems--;   
		$("#numItems").val(countItems);
	});
		
	
	// FORM VALIDATION 
	$("#frmAddMenu").submit(function(){
		var menuFieldChk = validate();
		var customFieldChk = checkCustomFieldEmpty(countItems);
		
		if( menuFieldChk == 0  )
		{
			return false;
		}
		else if(customFieldChk == 0)
		{
			return false;
		}
		return true;
	});

		
    $("#response").hide();
	$(function() {
	$("#menuItemList").sortable({  items: "span.draggable", cursor: 'move', update: function() {
			$("#response").removeClass("success");
			show_busy();
			var itemIds = $(this).sortable("toArray"); 
			
			$.post("<?=site_url();?>menusController/update_menuItems_order", { ids: itemIds }, function(rsp){
					
					if( rsp == "true")
					{
						$("#response").html("Display Order of the menu item was changed successfully");
						$("#response").addClass("success");
						$("#response").fadeIn();
					}
					else
					{
						$("#response").html("Display Order of the menu item was not changed successfully");
						$("#response").addClass("error");
						$("#response").fadeIn();
					}
					
					
				});														 
		}								  
		});
	});

});	

//
</script>
<style>
span.draggable{
	display:block;
}
</style>

                    
<div class="RightColumnHeading">
    <h1>
    	<img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="New Form"/>
        <span>Create a Menu</span>
    </h1>
</div>
<div class="clr"></div>

<div id="response" ></div>


<div class="InnerMain2">
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

	<form onclick="" id="frmAddMenu" name="frmAddMenu"  action="<?=$strAction?>" method="post" class="niceform"> 
    <fieldset>
        <input type="hidden" name="site_id" value="<?=$site_id;?>" />
        <input type="hidden" name="id" value="<?=$id;?>" />
        <input type="hidden" id="numItems" name="numItems" value="<?=$numItems;?>" />
        
      
        
        <dl>
            <dt>
                 <label for="page_title" class="NewsletterLabel">Menu Name <span class="star">*</span></label>
            </dt>
            <dd>
            <?php
                $strDisabled = '';
                if($is_main_menu)
                {
                    $strDisabled = 'disabled="disabled"';    
                }
                ?>
                <input type="text" name="txtName" id="txtName" value="<?=$menu_name?>" maxlength="30" <?=$strDisabled?> size="55" />
                <label class="messages" id="menu_name_message" style="padding: 0;"></label>
            </dd>
        </dl>
        <?php
        if(!$is_main_menu)
        {
        ?>
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Menu Position</label>
               </dt>
               <dd>
               		<?php
                    $strChecked = ''; 
                    if($menu_position=="Left"){
                        $strChecked='checked="checked"';
                    }
                    ?>
               
                    <label class="check_label">Left</label>
					<input type="radio" value="Left" name="rdoPosition" id="rdoPosition1" <?=$strChecked?> />
                    
                    <?php
                    $strChecked = ''; 
                    if($menu_position=="Right"){
                        $strChecked='checked="checked"';
                    }
                    ?>
                    
                    <label class="check_label">Right</label>
					<input type="radio" value="Right" name="rdoPosition" id="rdoPosition2" <?=$strChecked?> />
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
               		<?php
					$strChecked = ''; 
					if($menu_published=="Yes")
					{
						$strChecked='checked="checked"';
					}
					?>
                    <label class="check_label">Yes</label>
					<input type="radio" value="Yes" name="rdoPublished" id="rdoPublished1" <?=$strChecked?> />
                    
                    <?php
					$strChecked = ''; 
					if($menu_published=="No")
					{
						$strChecked='checked="checked"';
					}
					?>
                    <label class="check_label">No</label>
					<input type="radio" value="No" name="rdoPublished" id="rdoPublished2" <?=$strChecked?> />
                    
                    <?php
					$strChecked = ''; 
					if($menu_published=="Schedule"){
						$strChecked='checked="checked"';
						
					}
					?>
                    <label class="check_label">Schedule</label>
					<input type="radio"  name="rdoPublished" id="rdoPublished3" <?=$strChecked?> />
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
                    <div id="schedular" <?=$strStyle?> >
                    
                    <div style="width:380px; height:100px; clear:both;">
                        <div style="float:left; clear:left; font-weight:bold; width:50px; padding:12px 0 0 15px;">Start:</div>
                        <div style="float:left; ">
                            &nbsp; Date/Time:
                            <input id="startDate" name="startDate" type="text" value="<?=$menu_start;?>" size="25" readOnly="readOnly">
                            
                            <a href="javascript:NewCal('startDate','ddMMyyyy',true,12)">
                                <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                            </a>
                        </div>
                          
                        <div style="float:left; clear:left; font-weight:bold; width:50px; padding:12px 0 0 15px;">End:</div>
                        <div style="float:left;">    
                            &nbsp; Date/Time:
                            <input id="endDate" name="endDate" type="text" value="<?=$menu_end;?>" size="25" readOnly="readOnly">
                            
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
	                <?php
					$strChecked = ''; 
					if($menu_pages=="All")
					{
						$strChecked = 'checked="checked"';
					}
					?>
                    <label class="check_label">All Pages</label>
					<input type="radio" value="All" name="rdoPages" id="rdoPages1" <?=$strChecked?> />
                    
                    <?php
					$strChecked = ''; 
					if($menu_pages=="Other")
					{
						$strChecked = 'checked="checked"';
					}
					?>
                    <label class="check_label">Some Pages</label>
					<input type="radio" value="Other" name="rdoPages" id="rdoPages2" <?=$strChecked?> />
                    
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
                    <div id="pages" style="<?=$strStyle?> clear:both;">
                        <div  style=" position:relative; margin-top:15px; float:left;">
                        <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" >
                            <?php 
                            foreach($pages->result_array() as $rowPages)
                            {
								$selected = "";
								if(in_array($rowPages['page_id'],$selected_pages))
								{
									$selected = " selected=\"selected\" ";
								}
                            ?>
                            <option value="<?=$rowPages['page_id']?>"  <?=$selected;?> ><?=$rowPages['page_title']?></option>
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
					<?php
                    $strChecked = ''; 
                    if($menu_access=="Everyone")
                    {
                        $strChecked = 'checked="checked"';
                    }
                    ?>
                    <label class="check_label">Everyone</label>
					<input type="radio" value="Everyone" name="rdoRights" id="rdoRights1" <?=$strChecked?> />
                    <? if($template_name!='gymnastic')
					{ ?>
					<?php
                    $strChecked = ''; 
                    if($menu_access=="Registered")
                    {
                        $strChecked = 'checked="checked"';
                    }
                    ?>
                    <label class="check_label">Registered</label>
					<input type="radio" value="Registered" name="rdoRights" id="rdoRights2" <?=$strChecked?> />
                    
                    <? if(isset($groups) && !empty($groups))
					{ ?>
					<?php
                    $strChecked = ''; 
                    if($menu_access=="Other")
                    {
                        $strChecked = 'checked="checked"';
                    }
                    ?>
                    <label class="check_label">Other</label>
					<input type="radio" value="Other" name="rdoRights" id="rdoRights3" <?=$strChecked?> />
                    <label class="messages" id="menu_access_message" style="padding: 0;"></label>
                    <? 
					}
					else
					{  
					?>
						<a  href="<?=base_url().index_page()?>sitegroups/new_site_group/" >No Group Exists Click To Create Group!</a>
                     <?php
					}		
					} ?>
                    
                    <?php
					if($menu_access=="Other")
					{
						$strStyle = 'display: block;';
					}
					else
					{
						$strStyle = 'display: none;';    
					}
					?>
					<!--	group ilst 	-->
					<? if($template_name!='gymnastic')
                    { 
                        if(isset($groups) && !empty($groups)){ ?>		
                                <div id="roles" style=" <?=$strStyle?> clear:both;width:360px;">    
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
        <?php
		} //is main menu end of if
		?>
        <div class="RightColumnHeading">
        	<h1>
            	<img src="<?=base_url();?>images/webpowerup/MenuItems.png" alt="Menu Items"/>
                <span>Menu Items</span>
            </h1>
            
            <div class="RightSideButton">
            	<a href="javascript: void(0)" id="btnAddItems" >
                	<img src="<?=base_url();?>images/webpowerup/AddMenuItem.png" alt="Add Menu Item"/>
                </a>
            </div>
        </div>

        
        <div class="DataGrid2">
        <ul class="TableHeader">
            <li>Caption</li>
            <li>Destination </li>
            <?php
			if($is_main_menu)
			{
			?>
            <li>Parent </li>
            <?php
            } ?>
            <li style="width:60px;min-width:60px;" >Published </li>
            <li>Target Window</li>
            <li style="width:60px;min-width:60px;" >Action</li>
        </ul>
		
        <!--	MENU ITEM 	-->
        <div id="menuItemList">
       
        <?php
		$id = 0;
		$i=1;
		/*echo "<pre>";
		print_r($rowItemInfo);
		exit;*/
		foreach($menu_items->result_array() as  $rowItemInfo)
		{
			
		echo "<span id=\"".$rowItemInfo['item_id']."\" class=\"draggable\" >";
		  
			$id1 = $id + $i;
			$id2 = $id + 1 + $i;
			$id++;
		?>
        	<ul class="TableData">
            <li>
                <div  style=" position:relative;float:left; width:160px;">
                    <input type="text" size="15" id="txtItemName<?=$i;?>" name="txtItemName<?=$i;?>" value="<?=$rowItemInfo["item_name"];?>" /> 
                </div>
            </li>
            
             <li>
				 <?php

				 $max = 7;				 
                if($this->Menus_Model->getItemPageTitle($rowItemInfo["item_id"])== "1") 
                { ?> 
                    
                   <input type="text" size="15" value="<?=$rowItemInfo["item_link"]?>"  id="_lstItemPage<?=$i;?>" name="_lstItemPage<?=$i;?>">
                   <input type="hidden" name="lstItemPage<?=$i?>" id="custom_url_<?=$i?>" value="clink_<?=$i?>" />                            <? 
                } 
                else 
                { 
                     
                ?>
                  <input type="hidden" value=""  id="_lstItemPage<?=$i;?>" name="_lstItemPage<?=$i;?>">
                   
                   <div style=" position:relative; margin-top:10px; float:left;" >
                     <select size="1"  id="lstItemPage<?=$i;?>" name="lstItemPage<?=$i;?>" style="width:140px;"> 
                     <?php
							/**/ ?>
                            <option value="0">Select Page</option>
                            <option value="clink_'+countItems+'" >Custom Link</option>
							<?php foreach($pages->result_array() as $rowPages) 
							{ 
								if($this->Menus_Model->isItemPage($menu_id, $rowItemInfo["item_id"], $rowPages['page_id']))
								{
									$strSelected = 'selected="selected"';
								}
								else
								{
									$strSelected = "";
								}
							?>
                            <option   value="<?=$rowPages['page_id']?>" <?=$strSelected?>  title="<?=$rowPages['page_title']?>">
                            <?php 
								
								echo $rowPages['page_title'];							 
                            	/*if(strlen($rowPages['page_title']) > $max)
                            	 {
				 					echo $page_title_trim = substr($rowPages['page_title'], 0, $max) . '...';
				 				 }
				 				 else
				 				 { 
				 				 	echo $rowPages['page_title'];
				 				 }	*/
				 			?>
				 			</option>
							<?php } ?>
							
                     </select>
                    </div>
                <?php
                }
				?>
               
            </li>
			<?php
            if($is_main_menu)
            {
            ?>             
            	 <li>
                 <div style=" position:relative; margin-top:10px; float:left;" >
                     <select size="1" id="parent_id<?=$i;?>" name="parent_id<?=$i;?>" style="width:140px;"> 
						 <?php
							foreach($parent_array as $key => $value)
							{
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
							} ?>
                       		 
                 	</select>
                    </div>
                 </li>
            <?php
            } ?>
            <li style="width:60px;min-width:60px;">
				<?php
                $strChecked = '';
                if($rowItemInfo["item_published"]=="Yes")
                {
                    $strChecked='checked="checked"';
                }
                ?>
                <label class="check_label">Yes</label>
                <input type="radio" id="rdoItemPublished<?=$id1?>" name="rdoItemPublished<?=$i?>" value="Yes" <?=$strChecked?> />
                  
                <?php
				$strChecked = '';
				if($rowItemInfo["item_published"]=="No")
				{
					$strChecked='checked="checked"';
				}
				?>
                <label class="check_label">No</label>
                <input type="radio" id="rdoItemPublished<?=$id2?>" name="rdoItemPublished<?=$i?>" value="No" <?=$strChecked?> />
            </li>
            
            <li>
                <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" id="menuTarget<?=$i?>" name="menuTarget<?=$i?>"  style="width:150px;"> 
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
            </li>
            
            <li style="width:60px;min-width:60px;">
                 <a href="javascript: void(0)" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                 </a>
             </li>
        </ul>
        
        <?php
		echo "</span>";
		$i++;
		} ?>
       
        
        </div>
        <!--	MENU ITEM 	-->
         
    	<ul class="TableData AlterRow AddFieldRow">
            <li>
             <div class="AddMoreField">                    
                <a href="javascript: void(0)"id="btnAddItems2" >
                <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field"/>
                Add a Menu Item
                </a>
             </div>
            </li>
        </ul>
        </div> 
        
        <div class="clr"></div>
        
        <div class="ButtonRow">
            <a href="#">
            	<img alt="Cancel" src="<?=base_url();?>images/webpowerup/CancelRed.png">
			</a>
            <button type="submit">
                <img alt="Save" src="<?=base_url();?>images/webpowerup/SaveGreen.png">
            </button>
        </div>
                       
          
    </fieldset>
</form>

</div>

