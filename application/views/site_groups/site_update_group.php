<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">

$("div.NFRadio").live("click",function(){
		var id = $(this).next("input").attr("id");
		
		if(id == "group_code1")
		{
			$("#custom_code").fadeOut();
		}
		
		if(id == "group_code2")
		{
			$("#custom_code").fadeIn();
		}
		
		if(id == "payment_type1")
		{
			$("#one_time").fadeOut();
			$("#rec_info").fadeOut();
			$("#trial_info").fadeOut();
			$("#discountOpt").fadeOut();
			NFFix();
		}
		if(id == "payment_type2")
		{
			$("#one_time").fadeIn();
			$("#rec_info").fadeOut();
			$("#trial_info").fadeOut();
			$("#discountOpt").fadeIn();
			NFFix();
		}
		if(id == "payment_type3")
		{
			$("#one_time").fadeOut();
			$("#rec_info").fadeIn();
			$("#trial_info").fadeOut();
			$("#discountOpt").fadeIn();
			NFFix();
		}
		if(id == "payment_type4")
		{
			$("#one_time").fadeOut();
			$("#rec_info").fadeOut();
			$("#trial_info").fadeIn();
			$("#discountOpt").fadeIn();
			NFFix();
		}
		
		if(id == "is_discount1")
		{
			$("#discountValue").fadeOut();
			NFFix();
		}
		if(id == "is_discount2")
		{
			$("#discountValue").fadeIn();
			NFFix();
		}
		
		
		if(id == "radUpgrade2")
		{
			$("#upgradableDiv").fadeOut();
		}
		if(id == "radUpgrade1")
		{
			
			$("#upgradableDiv").fadeIn();
			NFFix();
		}
		
});



$(document).ready(function(e) {
	
	
	// ADD ROW DYNAMICALLY 
	var count = <?=count($fields_data);?>;
	count++;
    $("#addRow,#addRow2").click(function(){
		
		var html = '<ul class="TableData"><li><input type="text" name="items['+count+'][title]" id="" size="19" /></li><li><div  style=" position:relative; margin-top:10px; float:left"><select size="1" name="items['+count+'][type]" id="fieldType_'+count+'"  style="width:170px;"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select></div></li><li class="Serial"><input type="checkbox" name="items['+count+'][required]" id="items['+count+'][required]" value="1" /></li><li><input type="text" name="items['+count+'][order]" id="items['+count+'][order]" size="16" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
		
		
		var opts = '<div style="display:none;"><div id="CheckBoxes_'+count+'" ><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Checkbox Options</span></h1><div class="RightSideButton"><a  id="addCheckItem_'+count+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem('+count+')"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="checkItemsList_'+count+'"><ul class="TableData"><li><input type="text" name="checkbox_items['+count+'][]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span></div><a href="javascript: void(0)" class="fncy-custom-close"><input type="button" id="close_button" value="close" onClick="hideOptsValue()"/></a></div></div><div style="display:none;"><div id="RadioButtons_'+count+'"><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Radio Options</span></h1><div class="RightSideButton"><a href="javascript:void(0)" id="addRadioItem_'+count+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem('+count+')"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="radioItemsList_'+count+'"><ul class="TableData"><li><input type="text" name="radio_items['+count+'][]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span><ul class="TableData AlterRow AddFieldRow"><li><div class="AddMoreField"><a href="javascript:void(0)" id="addRadioItem"><img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addRadioItem('+count+')"/>Add More Field</a></div></li></ul></div><a href="javascript: void(0)" class="fncy-custom-close"><input type="button" id="close_button" value="close" onClick="hideOptsValue()"/></a></div></div><div style="display:none;"><div id="MultText_'+count+'"><table><tbody><tr><td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td><td><input type="text" size="10" value="40" id="textarea_width" name="textarea['+count+'][0]" class="dinput"></td></tr><tr><td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td><td><input type="text" size="10" value="5" id="textarea_height" name="textarea['+count+'][1]" class="dinput"></td></tr></tbody></table><a href="javascript: void(0)" class="fncy-custom-close"><input type="button" id="close_button" value="close" onClick="hideOptsValue()"/></a></div></div>';
		$("#field_options").append(opts);
		
		
		$("#rowDiv").append(html);
		NFFix();
		count++;
		return false;
	});
	
	
	// FORM SUBMIT
	$("#group_form").submit(function(e) {
		var flag = 1
        var groupTitle = $("#group_name").val();
		groupTitle = $.trim(groupTitle);
		
		if ( groupTitle == "" )
		{
			alert("Please enter the group title");
			flag = false;
		}
		
		// discount validation 
		if ( $("#is_discount2").is(":checked") )
		{
			
			var price = 0;
			if ($("#payment_type2").is(":checked"))
			{
				price = $("#price").val();
				
			}
			else if($("#payment_type3").is(":checked"))
			{
				price = $("#recurion_price").val();				
			}
			else if($("#payment_type4").is(":checked"))
			{
				price = $("#trial_price").val();
			}
			
			var discount = $("#discount").val();
			var diff = 0;
			if ( $("#discount_type option:selected").text() == "Fixed" ) 
			{
				diff = price - discount;
				if ( diff > 0 )
				{
				 	flag = 1;
                }
                else
				{
					alert("Discount Should be less than the price");
					flag = 0;
                }
			}
			else if ( $("#discount_type option:selected").text() == "Percentage" )
			{
				var persontage = ( price / 100 ) * discount;
				diff = price - persontage;
				if ( diff > 0 )
				{
				 	flag = 1;
                }
                else
				{
					alert("Discount Should be less than the price");
					flag = 0;
                }
			}
		}
		
		if ( flag == 0)
		{
			return false;
		}
		return true;
    });
	
});


// REMOVE ROW DYNAMICALLY
$(".deleteRow").live("click",function(){
	
	$(this).parent().parent().remove();
	return false;
});



function hideOptsValue(id)
{

  $.fancybox.close();
   
}

var j = 0;
var old_check_id = 1;
function addCheckItem(id, radio_count)
{
	if(id == old_check_id)
	  {
		  j++;
	  }
	 if(id != old_check_id)
	  {
		 if(radio_count>0)
		 {
		 	j = radio_count+1;
		 }
		 else
		 {
		  j = 0;
		  j++;
		 }
	  } 
	var html = '<ul class="TableData"><li><input type="text" name="checkbox_items['+id+']['+j+']" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
	
	$("#checkItemsList_"+id).append(html);
	NFFix();
	old_check_id = id;
}

var k = 0;
var old_radio_id = 1;
function addRadioItem(id, radio_count)
{
	if(id == old_radio_id)
	  {
		  k++;
		 
	  }
	 if(id != old_radio_id)
	  {
		 if(radio_count>0)
		 {
		 	k = radio_count+1;
		 }else{
		  
		  k = 0;
		  k++;
		  }
		  
	  }    
	var html = '<ul class="TableData"><li><input type="text" name="radio_items['+id+']['+k+']" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
	//alert(html);
	$("#radioItemsList_"+id).append(html);
	NFFix();
	old_radio_id = id;
}

</script>
<?php
	$this->firephp->log($data[0]);
?>
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/SiteGroup.png" alt="Site Group"/>
        <span>Update Site Group</span>
    </h1>
    
</div>


<div class="form">
<? //echo "<pre>"; print_r($data); exit;?>
<form class="niceform" action="<?=base_url().index_page()?>sitegroups/do_update_site_group/" method="post" name="group_site" id="group_site" >
 <input type="hidden" name="group_id" value="<?=$group_id?>"/>
        <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel"> Group Name :</label></dt>
                <dd><input type="text" name="group_name" id="group_name" size="55" value="<? if(isset($data[0]['group_name'])){ echo $data[0]['group_name'];  } ?>" /></dd>
            </dl>
           
           
           <dl>
                <dt><label for="color" class="NewsletterLabel"> Group Code :</label></dt>
                <dd>
                   <label class="check_label">None</label>
                    <input type="radio" name="group_code" value="None" id="group_code1" <? if($data[0]['group_code']=='None'){ echo "checked=checked";} ?> />
                    
                    <label class="check_label">Use a Custom Code</label>
                    <input type="radio" name="group_code" value="custom" id="group_code2" <? if($data[0]['group_code']!='None'){ echo "checked=checked";} ?> />
                    
                    <div id="custom_code" style="clear:both; display:none;">
                    	<input type="text" size="30" name="custome_code" value="<? if($data[0]['group_code']!='None'){ echo $data[0]['group_code']; } ?>" />
                    </div>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="comments" class="NewsletterLabel">New Member Notification Email(S) :</label></dt>
                <dd>
                <label class="check_label">Comma-Seperated list of emails to notify when a new user signs up.</label>
                <textarea name="notify_emails" id="notify_emails" rows="10" cols="42"><? if(isset($data[0]['notify_emails'])){ echo $data[0]['notify_emails']; }?></textarea>
                </dd>
            </dl>
            
            
            <dl>
                <dt><label for="color" class="NewsletterLabel"> Payment Required :</label></dt>
                <dd>
                   
                    <input type="radio" name="payment_type" id="payment_type1" value="Free" <? if($data[0]['payment_method']=='Free'){ echo "checked=checked";} ?> />
                    <label class="check_label">Free</label>
                    
                    <input type="radio" name="payment_type" id="payment_type2" value="One-Time" <? if($data[0]['payment_method']=='One-Time'){ echo "checked=checked";} ?>  />
                    <label class="check_label">One-Time Payment</label>
                    
                    <input type="radio" name="payment_type" id="payment_type3" value="Recursion" <? if($data[0]['payment_method']=='Recursion'){ echo "checked=checked";} ?> />
                    <label class="check_label">Recurring</label>
                    
                    <input type="radio" name="payment_type" id="payment_type4" value="Trial" <? if($data[0]['payment_method']=='Trial'){ echo "checked=checked";} ?> />
                    <label class="check_label">Trial Membership</label>
                    <br />
					<br />
					
                    
                    <div id="one_time" style="clear:both; <? echo ($data[0]['payment_method']=='One-Time') ? "display:block;" : "display:none;"; ?> ">
                    	<span style="float:left;">$ &nbsp;</span><input type="text" size="30" id="price" name="one_time_price" value="<?=$data[0]['fixed_price'];?>" />
                    </div>
                    
                    
                   
                    <div id="rec_info" style=" <? echo ($data[0]['payment_method']=='Recursion') ? "display:block;" : "display:none;"; ?>">
                    	
                        <div style="float:left; ">
                        <span style="float:left;line-height:39px;">$ &nbsp;</span><input style="clear:both;" type="text" size="5" name="recurion_price"  id="recurion_price" value="<?=$data[0]['fixed_price'];?>" />
                        </div>
                        <div style="float:left; ">
                        <span style="float:left;padding-left:10px;">Permanent Charge</span>
						<input  type="checkbox"  name="recurion_permanent"  <? if($data[0]['recurssion_payment'] == 'Yes'){ echo 'checked'; } ?> />
                        </div>

						<div style="clear:left; float:left; margin:8px 0 0 0; height:42px; ">
                        	<div style="float:left; ">
                            <span style="float:left; padding:0 10px 0 10px; line-height:39px; width:30px;">Every</span>
                            </div>
                            <div style="float:left; ">
                            <input type="text" size="5" name="rec_cycle" value="<?=$data[0]['payment_cycle']?>">
                            </div>
                            
                            <div style="float:left; ">
                            <div style="float:left;position:relative; margin-left:10px;">
                            <select name="rec_cycle_type" id="" size="1" style="width:150px;">
                                <option <? if($data[0]['payment_cycle_type']=='days'){ echo 'selected="selected"';} ?> value="days">Days</option>
                                <option <? if($data[0]['payment_cycle_type']=='weeks'){ echo 'selected="selected"';} ?> value="weeks">Week/Weeks</option>
                                <option <? if($data[0]['payment_cycle_type']=='month'){ echo 'selected="selected"';} ?> value="month">Month/Months</option>
                                <option <? if($data[0]['payment_cycle_type']=='year'){ echo 'selected="selected"';} ?>  value="year">Year/Years</option>
                            </select>
                            </div>
                            </div>
                        </div>
                        
                        <div style="clear:left; float:left; margin:8px 0 0 0; height:42px; ">
                        	<div style="float:left; ">
                            <span style="float:left; padding:0 10px 0 10px; line-height:39px; width:30px;">For</span>
                            </div>
                            
                            <div style="float:left; ">
                            <input type="text" size="5" name="rec_duration" value="<?=$data[0]['duration']?>">
                            </div>
                            
                            <div style="float:left; ">
                            <div style="float:left;position:relative;margin:0 10px 0 10px;">
                            <select name="rec_duration_type" id="" size="1" style="width:150px;">
                                <option <? if($data[0]['duration_type']=='days'){ echo 'selected="selected"';} ?>  value="days">Days</option>
                                <option <? if($data[0]['duration_type']=='weeks'){ echo 'selected="selected"';} ?> value="weeks">Week/Weeks</option>
                                <option <? if($data[0]['duration_type']=='month'){ echo 'selected="selected"';} ?> value="month">Month/Months</option>
                                <option <? if($data[0]['duration_type']=='year'){ echo 'selected="selected"';} ?> value="year">Year/Years</option>
                            </select>
                            </div>
                            </div>
                            
                        </div>
                    </div>
                    
                   
                    
                    <div id="trial_info" style=" <? echo ($data[0]['payment_method']=='Trial') ? "display:block;" : "display:none;"; ?> ">
                    	
                        <div style="clear:left; float:left; height:42px; ">
                                <div style="float:left; ">
                                <span style="float:left; line-height:39px;">Trial Duration &nbsp;</span>
                                </div>
                                <div style="float:left; ">
                                <input type="text" size="5" name="trial_duration" id="trial_duration"  value="<?=$data[0]['duration'];?>" />
                                </div>
                                
                                <div style="float:left;">
                                <div style="position:relative; margin-left:10px;">
                                <select name="trial_duration_type" id="" size="1" style="width:150px;">
                                    <option <? if($data[0]['payment_cycle_type']=='days'){ echo 'selected="selected"';} ?>  value="days">Days</option>
                                    <option <? if($data[0]['payment_cycle_type']=='weeks'){ echo 'selected="selected"';} ?> value="weeks">Week/Weeks</option>
                                    <option <? if($data[0]['payment_cycle_type']=='month'){ echo 'selected="selected"';} ?> value="month">Month/Months</option>
                                    <option <? if($data[0]['payment_cycle_type']=='year'){ echo 'selected="selected"';} ?> value="year">Year/Years</option>
                                </select>
                                </div>
                            	</div>
                        
                        </div>
                        
                        <div style="clear:left; float:left; height:42px; ">
                            <div style="float:left; ">
                            <span style="float:left; margin:0 10px 0 0; line-height:39px;">Then charge $</span>
                            </div>
                            
                            <div style="float:left; ">
                            <input type="text" size="5" name="trial_price" id="trial_price" value="<?=$data[0]['fixed_price'];?>">
                            </div>
                           
                            <div style="float:left; ">
                            <span style="float:left; margin:0 10px 0 10px; line-height:39px;">every</span>
                            </div>
                            
                            <div style="float:left; ">
                            <input type="text" size="5" name="trial_cycle" value="<?=$data[0]['payment_cycle'];?>" >
                            </div>
                            
                            <div style="float:left; ">
                            <div style="position:relative;margin-left:10px;">
                            <select name="trial_payment_type" id="" size="1" style="width:150px;">
                                <option <? if($data[0]['duration_type']=='days'){ echo 'selected="selected"';} ?>  value="days">Days</option>
                                <option <? if($data[0]['duration_type']=='weeks'){ echo 'selected="selected"';} ?> value="weeks">Week/Weeks</option>
                                <option <? if($data[0]['duration_type']=='month'){ echo 'selected="selected"';} ?> value="month">Month/Months</option>
                                <option <? if($data[0]['duration_type']=='year'){ echo 'selected="selected"';} ?> value="year">Year/Years</option>
                            </select>
                            </div>
                            </div>
						</div>
                            
                        
                    </div>


                </dd>
            </dl>
            <? if(isset($data[0]['discount_value']) && $data[0]['discount_value']==''){ $data[0]['discount_value'] = 0;} ?>
            <div id="discountOpt" style=" <? echo ($data[0]['discount_type']!='') ? "display:block;" : "display:none;"; ?>">
             <dl>
                <dt><label for="color" class="NewsletterLabel">offer Discount to Member of the Group : </label></dt>
                <dd>
                    <label class="check_label">None </label><? //echo "---".$data[0]['discount_value'];exit;?>
                    <input type="radio" name="is_discount" id="is_discount1" value="None" <? if($data[0]['discount_value']==0) {  echo "checked=checked"; } ?> />
                    <label class="check_label">Discount </label>
                    <input type="radio" name="is_discount" id="is_discount2" value="fixed" <? if($data[0]['discount_value']!=0) {  echo "checked=checked";} ?> />
                    <div id="discountValue"  style=" <? echo ($data[0]['discount_value']!=0) ? "display:block;" : "display:none;"; ?> " >
                        <div style="float:left; width:100%; margin-top:5px;">
                        <input type="text" name="discount" id="discount" size="54" value="<?=$data[0]['discount_value']?>" />
                        </div>
                        <div  style=" position:relative; margin-top:10px; float:left; width:100%;">
                        <select size="1"  name="discount_type" id="discount_type"  style="width:360px;"> 
                                <option  <? echo ($data[0]['discount_type']=='Percentage') ? 'selected="selected"' : ""; ?> value="Percentage">Percentage</option>
                                <option <? echo ($data[0]['discount_type']=='Fixed') ? 'selected="selected"' : ""; ?> value="Fixed">Fixed</option> 
                       </select>
                       </div>
                    </div>
                  
                </dd>
            </dl>
            </div>
            
            <dl>
                <dt><label for="comments" class="NewsletterLabel">Create An intro Page for this group :</label></dt>
                <dd>
                    <label class="check_label">This will be the page that you member will first see when they login.</label>
                    <input type="radio" name="intro_page" checked="checked" value="custom" />
                </dd>
            </dl>
            <dl>
                <dt><label for="comments" class="NewsletterLabel"></label></dt>
                <dd><textarea id="page_content" name="page_content" class="ckeditor" rows="10" cols="42"><? if(isset($group_page_content)){ echo $group_page_content; }?></textarea></dd>
            </dl>
            <dl>
                <dt><label for="comments" class="NewsletterLabel"></label></dt>
                <dd>
                    <label class="check_label">OR Select an Existing Page for this Group when they LOGIN</label>
                    <input type="radio" name="intro_page" value="group_page" />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="comments" class="NewsletterLabel"></label></dt>
                <dd>
                    <div  style=" position:relative; margin-top:10px; float:left">
                    <select size="1" name="page_id" id="page_id" style="width:360px;"> 
                            <? foreach($allpages as $page){ ?>
                                <option value="<?=$page['page_id']?>"><?=$page['page_title']?></option>
                            <? } ?>
                            </select> 
                   </select>
                   </div>
               
                </dd>
            </dl>
            
            
             <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/WebinarManagement.png" alt="Webinar Management"/>
                    <span>Customized The Registration Form</span>
                </h1>
                
                <div class="RightSideButton">
                    <button id="addRow">
                        <img src="<?=base_url();?>images/webpowerup/New.png" alt="Rooms Management"/>
                    </button>
                </div>
            </div>


<div class="DataGrid2">
        <ul class="TableHeader">
            <li>Title</li>
            <li>Type </li>
            <li class="Serial">Required </li>
            <li>Order</li>
            <li class="Actions">Action</li>
        </ul>
        
        
        
        <span id="rowDiv">
        <?php
        if( isset($fields_data) && count($fields_data) > 0)
		{ 
			
			$i = 1;
			foreach( $fields_data as $item )
			{
				// echo "<pre>";	print_r($item);	die();
				$this->firephp->log($item);
		?>
            <ul class="TableData">
                <li>
                    <input type="text" name="items[<?=$i?>][title]" id="" size="19" value="<?=$item['field_title']?>" /> 
                </li>
                 <li>
                   <div  style=" position:relative; margin-top:10px; float:left">
                    <select size="1" name="items[<?=$i?>][type]" id="fieldType_<?=$i?>"  style="width:170px;"> 
                        <option <?php if ( $item['field_type'] == "Single-Line Text") { ?> selected="selected" <?php } ?> value="Single-Line Text">Single-Line Text </option>
                        <option <?php if ( $item['field_type'] == "Multi-Line Text") { ?> selected="selected" <?php } ?> value="Multi-Line Text">Multi-Line Text</option>
                        <option <?php if ( $item['field_type'] == "Check Boxes") { ?> selected="selected" <?php } ?> value="Check Boxes">Check Boxes</option>
                        <option <?php if ( $item['field_type'] == "Radio Buttons") { ?> selected="selected" <?php } ?> value="Radio Buttons">Radio Buttons</option>
                   </select>
                   </div>
                </li>
                <li class="Serial">
                <input type="checkbox" name="items[<?=$i?>][required]" id="items[<?=$i?>][required]" value="1" <?php if($item['field_required'] == 1) { echo "checked"; }?>  />
                </li>
                <li>
                    <input type="text" name="items[<?=$i?>][order]" id="items[<?=$i?>][order]" size="16" value="<?=$item['field_sequence']?>" />
                </li>
                <li class="Actions">
                     <a href="#" class="DeleteAction deleteRow">
                        <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a>
                 </li>
            </ul>
        <? 
			$i++;
			}	
		}
		?>
        </span>
        
          
        <?php /*?><ul class="TableData">
            <li class="Serial">
            <input type="checkbox" name="txtbox" id="" value=""  />  
            </li>
            <li>
                <input type="text" name="" id="" size="19" /> 
            </li>
            
             <li>
               <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" name="text" id=""  style="width:140px;"> 
                        <option value="">Select Page</option>
                        <option value="">Select option 2</option> 
                        <option value="">Select option 3</option>
                        <option value="">Select option 4</option> 
                        <option value="">Select option 5</option> 
               </select>
               </div>
            </li>
            <li class="Serial">
            <input type="checkbox" name="txtbox2" id="" value=""  />
            </li>
            <li>
                <input type="text" name="" id="" size="16" />
            </li>
            <li class="Actions">
                 <a href="#" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a>
             </li>
        </ul><?php */?>
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">
            <a href="javascript:void(0)" id="addRow2">
            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="AddMoreField"/>
            Add More Field
            </a>
         </div>
        </li>
        </ul>
        
        
        
</div>
             
             <dl>
                <dt>
                </dt>
                <dd>
                </dd>
             </dl>
             
             
            
           <!--	THIS IS THE ADVANCE OPTION FOR THE GROUP -->
           
            <!--DYNAMIC OLD CODE -->
            <?php 
		// THIS IS THE MORE OPTIONS FOR THE GROUPS 
		/*?><tr>
			<td> 
				<h3>More Options for your Group - Please Select Appropriately</h3>
			</td>
		</tr>
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td width="25px">Yes</td>
						<td width="25px">No</td>
						<td>
							 
						</td>
					</tr>
					<? 
						if(isset($permissions_array) && !empty($permissions_array))
						{
							for($i=0;$i<count($permissions_array);$i++ )
							{
								?>
									<tr>
										<td ><input type="radio" name="<?=$permissions_array[$i]["value"]?>" value="Yes"> </td>
										<td ><input type="radio" name="<?=$permissions_array[$i]["value"]?>" value="No" checked="checked"></td>
										<td><?=$permissions_array[$i]["title"]?></td>
										
									</tr>			
								<?
							}
						}
					
					
					?>
					
				</table>
			</td>
		</tr>
        <?php */?>
			<!--DYNAMIC OLD CODE -->        
            
           <!--<dl>
                <dt><label for="color" class="NewsletterLabel"> 
                More Options for your Group - Please Select Appropriately :</label></dt>
                <dd>
                 <ul class="RadiobuttonList">
                    <li> Yes</li>
                    <li> No</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio1" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio1" id="" value="" /></li>
                    <li>Enable Facebook Login</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio2" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio2" id="" value="" /></li>
                    <li>Can Upload Files</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio3" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio3" id="" value="" /></li>
                    <li>Can Submit Trouble Tickets</li>
                 </ul>
                  <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio4" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio4" id="" value="" /></li>
                    <li>Can Post Comments on Pages</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio5" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio5" id="" value="" /></li>
                    <li>Member Wishes to be Notified of Updates</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio6" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio6" id="" value="" /></li>
                    <li>Member Reward Points Enabled</li>
                 </ul>
                 <ul class="RadiobuttonList">
                    <li> <input type="radio" name="radio7" id="" value="" checked="checked" /></li>
                    <li> <input type="radio" name="radio7" id="" value="" /></li>
                    <li>Member Can Submit Testimonies</li>
                 </ul>
                                           
                </dd>
            </dl>-->
           
           <!--	THIS IS THE ADVANCE OPTION FOR THE GROUP -->
            <? //echo $data[0]['group_type'];?>
            <dl>
                <dt><label for="comments" class="NewsletterLabel">Show on Registration <br/> Pages :</label></dt>
                <dd>
                    <label class="check_label" >Yes</label>
                    <input type="radio" name="on_registration" value="Yes" <? if(isset($data[0]['group_type']) && $data[0]['group_type']=='Registration'){	echo $select = "checked='checked'"; }?>   />
                    <label class="check_label">No</label>
                    <input type="radio" name="on_registration" value="Link" <? if(isset($data[0]['group_type']) && $data[0]['group_type']!='Registration'){	echo $select = "checked='checked'"; }?>/>
                </dd>
            </dl>
            
            
            <!--<dl>
                <dt><label for="comments" class="NewsletterLabel">
                </label></dt>
                <dd>
                <label class="check_label">
                Actual Link to Sign Uo : The link Below can be used in emails,posts are 
ages to send a visitor directly to signup for this Group. Link Here 
                </label>
                </dd>
            </dl>
            <dl>
                <dt><label for="comments" class="NewsletterLabel"></label></dt>
                <dd>
                <span style="text-align:center; font-size:13px; width:100%; float:left;">or</span>
                </dd>
            </dl>-->
            
            
            <!--<dl>
                <dt><label for="comments" class="NewsletterLabel">Show on Registration <br/> Pages :</label></dt>
                <dd>
                    <label class="check_label">Select a Menu</label>
                    <input type="radio" name="selectmenu" id="" value="" checked="checked" />
                    <label class="check_label">Main Menu</label>
                    <input type="radio" name="selectmenu" id="" value="" />
                     <label class="check_label">fff</label>
                    <input type="radio" name="selectmenu" id="" value="" />
                </dd>
            </dl>-->
            
            <dl>
                <dt><label for="comments" class="NewsletterLabel">
                Allow This Group To upgradeable to another Group :</label></dt>
                <dd>
                
                <?php 
						$i = 0;
						foreach($query_upgradables as $opt)
						{ 
							if(array_key_exists("selected",$opt))
							{
								$i++;
							}
						}
						if($i > 0)
						{
							$checked1 = " checked=\"checked\" ";
							$checked2 = "";
						}
						else
						{
							$checked2 = " checked=\"checked\" ";
							$checked1 = "";
						}
				  ?>
                    <label class="check_label">Yes</label>
                    <input type="radio" <?=$checked1?> name="is_upgradable" value="1" id="radUpgrade1" />
                    <label class="check_label">No</label>
                    <input type="radio" <?=$checked2?> name="is_upgradable" value="0" id="radUpgrade2" />
                    <br />

                    <div id="upgradableDiv" style="display:none; clear:both;"> 
					<?php 
                      
                      if( count($query_upgradables)  > 0 )
                      { ?>
                      	  <div  style=" position:relative; margin-top:10px; float:left;">
                          <select multiple="multiple" name="upgradable_groups[]"  size="4"  style="width:360px;" >
                          <?php 
                          foreach($query_upgradables as $row)
                          { ?>
                          
                            <option
                            <?php 
                    
								if(array_key_exists("selected",$row))
								{
									echo " selected='selected' ";
								}
								
							?> 
                            value="<?php echo $row['id']; ?>"><?php echo $row['group_name']; ?></option>
                            
                          <?php 
                          } ?>
                          </select>
                          </div>
                      <?php
                      }
                      else 
                      {
                          echo "No option found. First create groups";
                      }
                      ?>
                     
                      </div>
                </dd>
            </dl>
            
            
            <dl>
                <dt><label for="comments" class="NewsletterLabel">
                Select Page for Join Group Button:</label></dt>
                <dd>
                    <select name="group_join_button_page_id" size="1" style="width:360px;">
                    	<option value="0">Select Page</option>
						<? foreach($allpages as $page)
                        { ?>
                        <option <? if(isset($button_page_id) && $button_page_id!=0 && $button_page_id==$page['page_id']) { echo 'selected=selected'; }?> value="<?=$page['page_id']?>">
                          <?=$page['page_title']?>
                        </option>
                        <? } ?>
                      </select>
                </dd>
            </dl>
            


        <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
               
               <div class="ButtonRow">
                    <a href="<?=site_url()?>sitegroups/index" >
                        <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt=""/>
                    </a>
                
                
                <button type="submit">
                    <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="Save"/>
                </button>
                
                </div>
                </dd>
                
            </dl>

             
            
        </fieldset>
<div id="field_options">

<!--	Checkbox option 		-->	
<div style="display:none;">
	<div id="CheckBoxes_0" >
   
            <div class="RightColumnHeading">
            <h1>
            <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
            <span>Form Items</span>
            </h1>
            
            <div class="RightSideButton">
            <a  id="addCheckItem_0">
                <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem(0)"/>
            </a>
            </div>
            </div>
        
        
            <div class="DataGrid2" style="overflow:hidden">
            
            <ul class="TableHeader">
                <li>Item Title</li>
                <li class="Actions">Action</li>
            </ul>
             
            <span id="checkItemsList_0">   
            
                <ul class="TableData">
                    <li><input type="text" name="checkbox_items[0][0][]" size="32" /></li>
                    <li class="Actions">
                        <a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a>
                    </li>
                </ul>
            
            </span>
            
            
            
            
            </div>
            
           <a href="javascript: void(0)" class="fncy-custom-close">
                <input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
           </a> 
    </div>
</div>
 
<!--	radio OPTIONS 		--> 
<div style="display:none;">
    <div id="RadioButtons_0">
                <div class="RightColumnHeading">
                    <h1>
                        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
                        <span>Form Items</span>
                    </h1>
                    <div class="RightSideButton">
                        <a href="javascript:void(0)" id="addRadioItem_0">
                            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem(0)"/>
                        </a>
                    </div>
                </div>
                
                
                <div class="DataGrid2" style="overflow:hidden">
                        <ul class="TableHeader">
                            <li>Item Title</li>
                            <li class="Actions">Action</li>
                        </ul>
                         
                         <span id="radioItemsList_0">   
                        <ul class="TableData"><li><input type="text" name="radio_items[0][0][]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
                        </span>
                        
                        
                        <ul class="TableData AlterRow AddFieldRow">
                        <li>
                         <div class="AddMoreField">                    
                            <a href="javascript:void(0)" id="addRadioItem">
                            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addRadioItem(0)"/>
                            Add More Field
                            </a>
                         </div>
                        </li>
                        </ul>
                    </div>
                    
                    <a href="javascript: void(0)" class="fncy-custom-close">
                        <input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
                   </a> 
        </div>
</div>

<!--	textarea OPTIONS 		-->
<div style="display:none;">
	<div id="MultText_0">
    <table>
    <tbody>
    <tr>
        <td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td>
        <td><input type="text" size="10" value="40" id="textarea_width" name="textarea[0][0]" class="dinput"></td>
    </tr>
    <tr>
        <td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td>
        <td><input type="text" size="10" value="5" id="textarea_height" name="textarea[0][1]" class="dinput"></td>
    </tr>
    </tbody>
    </table>
    <a href="javascript: void(0)" class="fncy-custom-close">
    <input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
    </a> 
    </div>
</div>

<?
//echo "<pre>";print_r($fields_data_options);
	//		exit;
	
	 if( isset($fields_data_options) && count($fields_data_options) > 0)
		{ 
			
			$i = 1;
			$j =0;			//echo "<pre>";print_r($fields_data);
			foreach($fields_data_options as $options)
			{
			  ?>
					<div style="display:none;">
                      <div id="MultText_<?=$i?>">
                                <table>
                          <tbody>
                              <tr>
                              <td align="right"><label class="dinput" for="textarea_width">Width (columns): </label></td>
                              <td><input type="text" size="10" value="40" id="textarea_width" name="textarea[<?=$i?>][]" class="dinput"></td>
                            </tr>
                                    <tr>
                              <td align="right"><label class="dinput" for="textarea_height">Height (rows): </label></td>
                              <td><input type="text" size="10" value="5" id="textarea_height" name="textarea[<?=$i?>][]" class="dinput"></td>
                            </tr>
                                  </tbody>
                        </table>
                            <a class="fncy-custom-close" href="javascript: void(0)">
                        	<input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
                        </a></div>
                    </div>
			
                	<div style="display:none;">
                      <div id="CheckBoxes_<?=$i?>" >
                                <div class="RightColumnHeading">
                          <h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Checkbox Options</span></h1>
                          <div class="RightSideButton"><a  id="addCheckItem_<?=$i?>"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem(<?=$i?>, <?=count($options['fields_data_options'])?>)"/></a></div>
                        </div>
                        <div class="DataGrid2" style="overflow:hidden">
                          <ul class="TableHeader">
                            <li>Item Title</li>
                            <li class="Actions">Action</li>
                          </ul>
                          <span id="checkItemsList_<?=$i?>">
                          <? if(isset($options['fields_data_options']) && count($options['fields_data_options'])>0 && !empty($options['fields_data_options']) && $options['field_type']=='Check Boxes'){ 
						  
						  	foreach($options['fields_data_options'] as $fields)
								{ ?>
                                  <ul class="TableData">
                                    <li>
                                      <input type="text" name="checkbox_items[<?=$i?>][<?=$j?>]" size="32" value="<? if(isset($fields['option_value'])){ echo $fields['option_value']; }?>" />
                                    </li>
                                    <li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li>
                                </ul>
                           <? $j++; }
						   } $j = 0;?>
                           </span>
                          </div>
                        <a href="javascript: void(0)" class="fncy-custom-close">
                        <input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
                        </a>
                     </div>
                   </div>
               
                	<div style="display:none;">
                      <div id="RadioButtons_<?=$i?>" >
                                <div class="RightColumnHeading">
                          <h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Checkbox Options</span></h1>
                          <div class="RightSideButton"><a  id="addRadioItem_<?=$i?>"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem(<?=$i?>, <?=count($options['fields_data_options'])?>)"/></a></div>
                        </div>
                        <div class="DataGrid2" style="overflow:hidden">
                          <ul class="TableHeader">
                                    <li>Item Title</li>
                                    <li class="Actions">Action</li>
                                  </ul>
                          <span id="radioItemsList_<?=$i?>">
                          <? if(isset($options['fields_data_options']) && count($options['fields_data_options'])>0 && !empty($options['fields_data_options']) && $options['field_type']=='Radio Buttons'){ 
						  
						  	foreach($options['fields_data_options'] as $fields)
								{ ?>
                                  <ul class="TableData">
                                    <li>
                                      <input type="text" name="radio_items[<?=$i?>][<?=$j?>]" size="32" value="<? if(isset($fields['option_value'])){ echo $fields['option_value']; }?>" />
                                    </li>
                                    <li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li>
                                </ul>
                           <? $j++; }
						   } $j = 0;?>
                           </span>
                          </div>
                        <a href="javascript: void(0)" class="fncy-custom-close">
                        <input type="button" id="close_button" value="close" onClick="hideOptsValue()"/>
                        </a>
                     </div>
                   </div>
                <?
			  
             $i++;       
	 		} 	
		} 
?>

</div>
        
        
        
        
 </form>
 </div>
