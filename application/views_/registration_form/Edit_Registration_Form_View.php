<style type="text/css">
#fancybox-close {
	position: absolute;
	top: -15px;
	right: -15px;
	width: 30px;
	height: 30px;
	background: transparent url('fancybox.png') -40px 0px;
	cursor: pointer;
	z-index: 1103;
	display: none !important;
}
</style>

<!--start Ckeditor and ckfinder files-->
<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js" ></script>

<script language="Javascript" type="text/javascript">
<!--


function displayPopup2(id)
{
  $.fancybox.close();
  document.getElementById('Single-Line Text_'+id).style.display="none";
  document.getElementById('Check Boxes_'+id).style.display="none";
  document.getElementById('Radio Buttons_'+id).style.display="none";
  document.getElementById('Multi-Line Text_'+id).style.display="none";
  document.getElementById('reg_popup_'+id).style.display="none";
  $.fancybox.close();
   
}
function addRow(tableID) 
{
 
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
                 newcell.innerHTML = '<select name="'+'items['+ary_index+'][type]'+'" id="type"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select>';
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
 
function deleteRow(tableID) 
{
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

        
function deleteRowOne(i)
{
    document.getElementById('tblAddFiels').deleteRow(i)}

//-->
function CopyTitleToPageTitle()
{
		 var title = document.getElementById('form_fname').value;
		 document.getElementById('menu_item_txt').value = title;
	
	}	 


/**** 	ADD AND REMOVE ROW CODE 	****/

//	ADD ITEM 

var a = <?=count($fields)-1;?>;
function addItem()
{
	a++;    
	var html = '<ul class="TableData"><li><input type="text" name="items['+a+'][title]" size="19" /></li><li><div  style=" position:relative; margin-top:10px; float:left"><select id="reg_items_type_'+a+'" size="1" name="items['+a+'][type]" style="width:175px;"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select></div></li><li class="Serial"><input type="checkbox" name="items['+a+'][required]" /></li><li><input type="text" name="items['+a+'][order]" size="19" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
 var htmlDiv = '<div style="display:none"><div id="reg_popup_'+a+'"><div id="Single-Line Text_'+a+'" style="display:none"><table width="200"><tbody><tr><td><label for="text_datatype"> Text Type:</label></td><td class="dinput"><select id="text_datatype" name="text_datatype['+a+']" class="dinput" style=" "><option selected="selected" value="string">Anything</option> <option value="email">Email Address</option></select></td></tr></tbody></table></div><div id="Check Boxes_'+a+'"  style="display:none "><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Form Items</span></h1><div class="RightSideButton"><a href="javascript:void(0)" id="addCheckItem_'+a+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem('+a+')"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="checkItemsList_'+a+'"><ul class="TableData"><li><input type="text" name="checkbox_items['+a+'][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span><ul class="TableData AlterRow AddFieldRow"><li><div class="AddMoreField"><a href="javascript:void(0)" id=""><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem('+a+')"/>  </a></div></li></ul></div></div><div id="Radio Buttons_'+a+'" style="display:none"><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items" "/><span>Form Items</span></h1><div class="RightSideButton"><a href="javascript:void(0)" id="addRadioItem_'+a+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" onclick="addRadioItem('+a+')" alt="Add More Field"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="radioItemsList_'+a+'"><ul class="TableData"><li><input type="text" name="radio_items['+a+'][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span><ul class="TableData AlterRow AddFieldRow"><li><div class="AddMoreField"><a href="javascript:void(0)" id="addRadioItem"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem('+a+')"/> </a></div></li></ul></div></div><div id="Multi-Line Text_'+a+'" style="display:none"><table><tbody><tr><td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td><td><input type="text" size="10" value="40" id="textarea_width" name="textarea['+a+'][0]" class="dinput"></td></tr><tr><td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td><td><input type="text" size="10" value="5" id="textarea_height" name="textarea['+a+'][1]" class="dinput"></td></tr></tbody></table></div><a href="#" class="fncy-custom-close"><input type="button" id="close_button" value="close" onClick="displayPopup2('+a+')"/></a></div></div>';
	 	
	$("#itemsList").append(html);
	$("#addPopupDiv").append(htmlDiv);
	
	NFFix();
}

var j = <?=count($options['Check_Boxes'])-1?>;
var old_check_id = 1;
function addCheckItem(id)
{
	if(id == old_check_id)
	  {
		  j++;
	  }
	 if(id != old_check_id)
	  {
		  j = 0;
		  j++;
	  } 
	var html = '<ul class="TableData"><li><input type="text" name="checkbox_items['+id+']['+j+'][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
	
	$("#checkItemsList_"+id).append(html);
	NFFix();
	old_check_id = id;
}

var k = <?=count($options['Radio_Buttons'])-1?>;
var old_radio_id = 1;
function addRadioItem(id)
{
	if(id == old_radio_id)
	  {
		  k++;
	  }
	 if(id != old_radio_id)
	  {
		  k = 0;
		  k++;
	  }    
	var html = '<ul class="TableData"><li><input type="text" name="radio_items['+id+']['+k+'][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
	
	
	$("#radioItemsList_"+id).append(html);
	NFFix();
	old_radio_id = id;
}

//	REMOVE ITEM 
$(".DeleteAction").live("click",function(){
	var delBtn = $(this);
	var id = delBtn.parent().parent().prev().attr("value");
	//alert(id);
	//return false;
	if( id != null )
	{
		
		dataString = "id="+id;
		$.ajax({
		type: "POST",
		url: "<?=site_url()?>Edit_Registration_Form/delete_field/",
		data: dataString,
		success: function(data){
			if(data == 'true')
			{
				 delBtn.parent().parent().prev().remove();                                               
				 delBtn.parent().parent().remove();
			}
		}
		});
	}
        
	
});




$(document).ready(function(e) {
    
	$("#addItem,#addItem2").click(function(e) {
        addItem();
    });

	
	
});

/**** 	ADD AND REMOVE ROW CODE 	****/

$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	//var cls = $(this).next("input").attr("class");
	//alert(id);
	var newId = id.substring(0,8);
	
	if(newId == "menu_id_" || id == "form_main_menu")
	{
		$('#pages').fadeOut();
	}
	
	if(id == "noLink")
	{
		
		$('#pages').fadeIn();
		NFFix();
	}
	
	
	if(id == "form_permissions1" || id == "form_permissions2")
	{
		$('#groups').fadeOut();
	}
	if(id == "form_permissions3")
	{
		
		$('#groups').fadeIn();
		NFFix();
	}
	
	if(id == "require_payement1")
	{
		$("#require_payement_text").fadeIn();
	}
	if(id == "require_payement2")
	{
		$("#require_payement_text").fadeOut();
	}
	
	if(id == "after_complete1")
	{
		$('#pagesDiv').fadeOut();
	}
	if(id == "after_complete2")
	{
		$('#pagesDiv').fadeIn();
		NFFix();
	}
	
	
	
});	

</script>    
<!-- end javascriptts add/remove  -->

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="New Form">
        <span>Edit Registration Form</span>
    </h1>
   
</div>
<div class="clr"></div>


<div class="form">


<form class="niceform" action="<?=site_url()?>Edit_Registration_Form/edit_reg_data" id="reg_form" name="reg_form" method="post" >
<input type="hidden" name="id" value="<?=$values[0]['form_id']?>" >			 
<dl>
       <dt>
             <label  class="NewsletterLabel">Form Title : <span class="star">*</span></label>
       </dt>
       <dd>
            <input type="text" name="form_fname" id="form_fname" onChange="CopyTitleToPageTitle()" value="<?=$values[0]['form_title'];?>" size="55" />
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Intro Text : <span class="star">*</span></label>
       </dt>
       <dd>
            <textarea name="form_info_txt" id="ck_content" class="ckeditor" rows="10" cols="42"><?=$values[0]['form_intro'];?></textarea>
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Thankyou Text : <span class="star">*</span></label>
       </dt>
       <dd>
            <textarea name="form_thank_txt" id="ck_content_2" class="ckeditor" rows="10" cols="42"><?=$values[0]['form_thank_u'];?></textarea>
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Select a Menu : <span class="star">*</span></label>
       </dt>
       <dd>

                
                <input type="radio" name="form_main_menu" id="form_main_menu" value="0" checked="checked" /> 
                <label class="check_label">Registration Menu</label>
<br><br>
				<?php  
			
                                
                $strChecked = "";
                $i = 1;
                if(!isset($item_id))
                {
                    $item_id = 0;
                }
                foreach($menus->result_array() as $rowMenus)
                {
                    
                    if($rowMenus["menu_id"] == $values[0]["menu_id"])
                    {                               
                        $strChecked = 'checked="checked"'; 
                         
                    }
                    else
                    {
                        $strChecked = "";
                    }
                ?>
                 
                <input type="radio"  onclick="hideMe('link', this)" id="menu_id_<?=$i?>" name="form_main_menu" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> class="hide_the_pages" />
                <label class="check_label"><?=$rowMenus["menu_name"];?></label>
                <br /><br />
                <?php
                $i++;
                }
                
                
                ?>
            
            	<br><br>
                <input type="radio" name="form_main_menu" id="noLink" value="none" /> 
                <label class="check_label">   None (Do not create a link) just show me link after page save </label>
                
                 <div style="display: none; clear:both; " id="pages">
                    <div  style=" position:relative;">
                    <select name="page[]" multiple="multiple" size="5" >
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
      <dt><label for="color" class="NewsletterLabel">Menu Item Text: </label></dt>
      <dd>
        
        <input type="checkbox" name="same_as_title_chk" id="same_as_title_chk" value="1" >
       <label class="check_label">Same as Title Page</label>
     </dd>
</dl>

<dl>
      <dt><label for="color" class="NewsletterLabel"></label></dt>
      <dd>
        <input type="text" name="menu_item_txt" id="menu_item_txt" size="55" value="<?=$values[0]['form_title']?>" >
     </dd>
</dl>

<dl>
    <dt><label for="email" class="NewsletterLabel">Who can see this slide?:<span class="star"> *</span> </label></dt>
    <dd>
    <label class="check_label">Every one</label>
     <input type="radio" value="Every One" name="form_permissions" id="form_permissions1" checked="checked"/>
   
     <label class="check_label">Registered</label>
     <input type="radio" value="Registered Users" name="form_permissions" id="form_permissions2" />
      <label class="check_label">Other</label>
     <input type="radio" value="Level of Access" name="form_permissions" id="form_permissions3" />
     
        <div id="groups" style="display:none; clear:both;">
             <div style=" position:relative;">
             <select name="group_access[]" multiple="multiple" size="5" >
                <?php 
                foreach($groups as $group)
                {
                ?>
                    <option value="<?=$group['id']?>"><?=$group['group_name']?></option>
                <?php 
                }
                ?>
            </select>
            </div>
        </div>
    
    </dd>
</dl>

<dl>
    <dt><label for="email" class="NewsletterLabel">Require Payement (On Completion):<span class="star"> *</span> </label></dt>
    <dd>
    <?php
	$chk = $values[0]["form_payment_required"];
	if ($chk == 1)
	{
		$yes_chk = " checked=\"checked\"";
		$no_chk = "";
	}
	else
	{
		$yes_chk = "";
		$no_chk = " checked=\"checked\"";
	}
	?>
    <label class="check_label">Yes</label>
     <input type="radio" value="1" name="require_payement" id="require_payement1" <?=$yes_chk?> />
   
     <label class="check_label">No</label>
     <input type="radio" value="0" name="require_payement" id="require_payement2" <?=$no_chk?> />
     
     
     <div id="require_payement_text" style="display:none; clear:both; ">
         <label class="check_label" style="line-height:30px;">$</label><input type="text" size="4" name="payment_qty" value="" id="payment_qty" />
	 </div>
    
    </dd>
</dl>

<dl>
	<?php
	 
	$chk = $values[0]["form_complete_action"];
	
	$chk1 = "";
	$chk2 = "";
	if ($chk == "Show Thank You")
	{
		$chk1 = " checked=\"checked\"";
		$chk2 = "";
	}
	else if ($chk == "Redirect URL")
	{
		$chk1 = "";
		$chk2 = " checked=\"checked\"";
	}
	else if ($chk == "Add User To Group")
	{
		$chk1 = "";
		$chk2 = "";
	}
	?>
      <dt><label for="color" class="NewsletterLabel">Action After Completion ? : </label></dt>
      <dd>
        <label class="check_label">Show 'Thank You' Text  </label>
        <input type="radio" name="after_complete" id="after_complete1" value="Show Thank You" <?=$chk1?> />
       <label class="check_label">Redirect To A URL </label>
        <input type="radio" name="after_complete" id="after_complete2" value="Redirect URL" <?=$chk2?> />
       
     </dd>
</dl>

<dl>
<?php
	$val = $values[0]["form_publish"];
	if($val == 1)
	{
		$yes = " checked=\"checked\"";
		$no = "";
	}
	else
	{
		$yes = "";
		$no = " checked=\"checked\"";
	}
	
?>
      <dt><label for="color" class="NewsletterLabel">Publish : </label></dt>
      <dd>
        <label class="check_label">Yes</label>
        <input type="radio" name="form_publish" id="form_publish1" value="1" <?=$yes?>  />
       <label class="check_label">No</label>
        <input type="radio" name="form_publish" id="form_publish2" value="0" <?=$no?> />
     </dd>
</dl>  

<dl>
    <dt><label for="email" class="NewsletterLabel">Email Form To </label></dt>
    <dd><input type="text" name="email_to" id="email_to" size="55" value="<?=$values[0]["form_email_to"];?>" /></dd>
</dl>
        
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="javascript:void(0)" id="addItem" >
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field"/>
        </a>
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
        <span id="itemsList">   
        <?php
		if(count($fields) > 0 )
		{
			$i = 0;
			foreach($fields as $row) 
			{
			
			?>
            <input type="hidden" name="items[<?=$i?>][id]" size="20" value="<?=$row['field_id'];?>" /> 
			<ul class="TableData">
			<li>
				<input type="text" name="items[<?=$i?>][title]" size="19" value="<?=$row['field_title'];?>" /> 
			</li>
			
			 <li>
			   <div  style=" position:relative; margin-top:10px; float:left">
				<select size="1" name="items[<?=$i?>][type]" id="reg_items_type_<?=$i?>" style="width:175px;"> 
						<option value="Single-Line Text" <?php if ($row['field_type'] == "Single-Line Text") { echo 'selected="selected"'; } ?> >Single-Line Text </option>
                        <option value="Multi-Line Text" <?php if ($row['field_type'] == "Multi-Line Text") { echo 'selected="selected"'; } ?> >Multi-Line Text</option>
                        <option value="Check Boxes" <?php if ($row['field_type'] == "Check Boxes") { echo 'selected="selected"'; } ?> >Check Boxes</option>
                        <option value="Radio Buttons" <?php if ($row['field_type'] == "Radio Buttons") { echo 'selected="selected"'; } ?> >Radio Buttons</option>
			   </select>
			   </div>
			</li>
			<li class="Serial">
            <input type="checkbox" name="items[<?=$i?>][required]" <?php echo ( $row['field_required'] == "Yes" ) ? 'checked="checked" ' : "" ; ?>   />
            </li>
			<li>
				<input type="text" name="items[<?=$i?>][order]" size="19" value="<?=$row['field_sequence'];?>" />
			</li>
			<li class="Actions">
				 <a href="javascript:void(0)" class="DeleteAction">
					<img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a>
			 </li>
			</ul>
             <div style="display:none;"  >
    <div id="reg_popup_<?=$i?>">
    <? if ($row['field_type'] == "Single-Line Text") { ?>
    <div id="Single-Line Text_<?=$i?>" style="display:none">
            <?
	$selected = $options['single_line'][$i]['option_value'];
	?>
        <table width="200">
        <tbody><tr>
            <td><label for="text_datatype"> Text Type:</label></td>
            <td class="dinput">
          
       <select id="text_datatype" name="text_datatype[<?=$i?>]" class="dinput" style=" ">
            <option <?  if(isset($selected) && $selected == 'string'){?> selected="selected" <? }?> value="string">Anything</option>
            <option <?  if(isset($selected) && $selected == 'email'){?> selected="selected" <? }?> value="email">Email Address</option>
        </select>
            </td>
        </tr>
</tbody>
</table>

    </div>
	<? }
	if ($row['field_type'] == "Check Boxes") {
	?>
        <div id="Check Boxes_<?=$i?>"  style="display:none; ">
    <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a  id="addCheckItem_0">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem(<?=$i?>)"/>
        </a>
    </div>
</div>


<div class="DataGrid2" style="overflow:hidden">

        <ul class="TableHeader">
            <li>Item Title</li>
            <li class="Actions">Action</li>
        </ul>
         
        <span id="checkItemsList_<?=$i?>">   
          <?
          if(isset($options['Check_Boxes']))
		  {
		     for($j=0; $j< count($options['Check_Boxes']); $j++)
			 {
				 if($row['field_title'] == $options['Check_Boxes'][$j]['field_title'])
				 {	  
		  ?>
        <ul class="TableData"><li><input type="text" name="checkbox_items[<?=$i?>][<?=$j?>][title]" value="<?=$options['Check_Boxes'][$j]['option_value']?>" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
        <? } } }?>
        </span>
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem(<?=$i?>)"/>
           
            </a>
         </div>
        </li>
        </ul>

    </div>
    </div>
    <? }
	if ($row['field_type'] == "Radio Buttons") {
	?>
     <div id="Radio Buttons_<?=$i?>"  style="display:none; ">
    <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="javascript:void(0)" id="addRadioItem_0">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem(<?=$i?>)"/>
        </a>
    </div>
</div>


<div class="DataGrid2" style="overflow:hidden">

        <ul class="TableHeader">
            <li>Item Title</li>
            <li class="Actions">Action</li>
        </ul>
         
         <span id="radioItemsList_<?=$i?>">   
          <?
          if(isset($options['Radio_Buttons']))
		  {
		     for($k=0; $k< count($options['Radio_Buttons']); $k++)
			 {	
			    if($row['field_title'] == $options['Radio_Buttons'][$k]['field_title'])
				 {  
		  ?>  
        <ul class="TableData"><li><input type="text" name="radio_items[<?=$i?>][<?=$k?>][title]" value="<?=$options['Radio_Buttons'][$k]['option_value']?>" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
        <? } }  }?>
        </span>
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="addRadioItem">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addRadioItem(<?=$i?>)"/>
          
            </a>
         </div>
        </li>
        </ul>

    </div>
    </div>
    <? } 
	if ($row['field_type'] == "Multi-Line Text") {
	?>
    <div id="Multi-Line Text_<?=$i?>" style="display:none;">
         <?
	      $check = array();
          if(isset($options['Multi_line']))
		  {
			  $check = explode(",",$options['Multi_line'][$i]['option_value']);
		  }
		  
		  ?>
        <table>
        <tbody><tr>
            <td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td>
            <td><input type="text" size="10" value="<?=$check[0]?>" id="textarea_width" name="textarea[<?=$i?>][0]" class="dinput"></td>
        </tr>
        <tr>
            <td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td>
            <td><input type="text" size="10" value="<?=$check[1]?>" id="textarea_height" name="textarea[<?=$i?>][1]" class="dinput"></td>
        </tr>
        </tbody></table>
    </div>
<? }?>
    
<br/>
<br/><br/>
    <a href="#" class="fncy-custom-close">
<input type="button" id="close_button" value="close" onClick="displayPopup2(<?=$i?>)"/></a>
    </div>
    </div> 
			<?php
			$i++;
			}
		} ?>
        </span>    
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="addItem2">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field"/>
            
            </a>
         </div>
        </li>
        </ul>
        
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
           
           <div class="ButtonRow" style=" text-align:right; float:right; width:auto;">
                <a href="#" class="CancelButton">
                    <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
                </a>
                <a href="#" class="SaveButton">
                 <button type="submit" >
                    <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
                 </button>
                </a> 
            </div>
         
            </dd>
        </dl>
       
</div>
  <!--<div style="display:none;"  >
    <div id="reg_popup_0">
    <div id="Single-Line Text_0" style="display:none">
    <?
	$selected = $options['single_line'][0]['option_value'];
	?>
        <table width="200">
        <tbody><tr>
            <td><label for="text_datatype"> Text Type:</label></td>
            <td class="dinput">
          
       <select id="text_datatype" name="text_datatype[0]" class="dinput" style=" ">
            <option <?  if(isset($selected) && $selected == 'string'){?> selected="selected" <? }?> value="string">Anything</option>
            <option <?  if(isset($selected) && $selected == 'email'){?> selected="selected" <? }?> value="email">Email Address</option>
        </select>
            </td>
        </tr>
</tbody>
</table>

    </div>
        <div id="Check Boxes_0"  style="display:none; ">
    <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="javascript:void(0)" id="addItem3">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field onclick="addCheckItem(0)"/>
        </a>
    </div>
</div>


<div class="DataGrid2" style="overflow:hidden">

        <ul class="TableHeader">
            <li>Item Title</li>
            <li class="Actions">Action</li>
        </ul>
         
        <span id="itemsList2"> 
          <?
          if(isset($options['Check_Boxes']))
		  {
		     for($i=0; $i< count($options['Check_Boxes']); $i++)
			 {	  
		  ?>
        <ul class="TableData"><li><input type="text" name="checkbox_items[0][<?=$i?>][title]" value="<?=$options['Check_Boxes'][$i]['option_value']?>" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
        <? } }?>
        </span>
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="addItem4">
            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field onclick="addCheckItem(0)"/>
            Add More Field
            </a>
         </div>
        </li>
        </ul>

    </div>
    </div>
    
     <div id="Radio Buttons_0"  style="display:none; ">
    <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="javascript:void(0)" id="addItem5">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field onclick="addRadioItem(0)"/>
        </a>
    </div>
</div>


<div class="DataGrid2" style="overflow:hidden">

        <ul class="TableHeader">
            <li>Item Title</li>
            <li class="Actions">Action</li>
        </ul>
         
         <span id="itemsList3"> 
            <?
          if(isset($options['Radio_Buttons']))
		  {
		     for($i=0; $i< count($options['Radio_Buttons']); $i++)
			 {	  
		  ?>  
        <ul class="TableData"><li><input type="text" name="radio_items[0][<?=$i?>][title]" value="<?=$options['Radio_Buttons'][$i]['option_value']?>" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
        <? } }?>
        </span>
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="addItem6">
            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field onclick="addRadioItem(0)"/>
            Add More Field
            </a>
         </div>
        </li>
        </ul>

    </div>
    </div>
    
    <div id="Multi-Line Text_0" style="display:none;">
       <?
	      $check = array();
          if(isset($options['Multi_line']))
		  {
			  $check = explode(",",$options['Multi_line'][0]['option_value']);
		  }
		  
		  ?>
        <table>
        <tbody><tr>
            <td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td>
            <td><input type="text" size="10" value="<?=$check[0]?>" id="textarea_width" name="textarea[0][0]" class="dinput"></td>
        </tr>
        <tr>
            <td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td>
            <td><input type="text" size="10" value="<?=$check[1]?>" id="textarea_height" name="textarea[0][1]" class="dinput"></td>
        </tr>
        </tbody></table>
    </div>
    
<br/>
<br/><br/>
    <a href="#" class="fncy-custom-close">
<input type="button" id="close_button" value="close" onClick="displayPopup2(0)"/></a>
    </div>
    </div> -->
        <div id="addPopupDiv">
</div>       
</form>
</div>