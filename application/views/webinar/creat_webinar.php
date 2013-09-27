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
#popup2{
     color:#4E4E4E !important;
}
fieldset.group  { 
  margin: 0; 
  padding: 0; 
  margin-bottom: 1.25em; 
  padding: .125em; 
  width:900px;
  background-color:#f2f2f2 !important;
} 

fieldset.group legend { 
  margin: 0; 
  padding: 0; 
  font-weight: bold; 
  margin-left: 20px; 
  font-size: 100%; 
  color: black; 
} 

ul.checkbox  { 
  margin: 0; 
  padding: 0; 
  margin-left: 30px; 
  
} 

ul.checkbox li
{
     list-style: none; 
       float:left;
       margin-left:20px;
}

ul.checkbox li input { 
  margin-right: .25em; 
  
} 

ul.checkbox li { 
  border: 1px transparent solid; 
} 

ul.checkbox li label { 
  margin-left: ; 
} 

ul.checkbox li:hover, 

ul.checkbox li.focus  { 
  background-color: #E3E4FA !important; 
  border: 1px gray solid; 
  width: auto; 
  
} 
.checkbox li label a{
     color:#666 !important;
}      /* unvisited link */

#reminder
{
     opacity:1 !important;
}
     .meeting-time-table
     {
               
     }
     .meeting-time-table tr td 
     {
          padding-left:5px;     
     }
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

.tblAddFiels tr td{
text-align:center;
}
.labels label{
display:block;
padding:1px 0;
}
#usman tr td{
padding:10px 3px;
}
.cke_skin_kama .cke_wrapper{
width:auto !important;
}
.form_items tr td{
text-align:center;
}
#usman tr td select {
    display: block;
    margin: 0 0 0 22px;
    padding: 10px 3px;
}
.enter_date{
padding:0 0 0 10px;
margin:0 0 0 10px;

}
</style>
<? if(isset($fields)){$i = count($fields)-1;}else{$i = 0;}?>;
<? if(isset($options['Check_Boxes'])){$j = count($options['Check_Boxes'])-1;}else{$j = 0;}?>;
<? if(isset($options['Radio_Buttons'])){$k = count($options['Radio_Buttons'])-1;}else{$k = 0;}?>;


<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script src="<?=base_url()?>js/detect_timezone.js"></script>
<script src="<?=base_url()?>js/jquery.detect_timezone.js"></script>
<script type="text/javascript">
// Using JQuery selectors to add onFocus and onBlur event handlers

     
     function selectGroup(id,childs)
     {
               var checkbox = document.getElementById(id);
               
               if(childs!=0)
               {
                    if(checkbox.checked)
                    {
                         for(i=1; i<=childs; i++)
                         {
                              document.getElementById("child_"+id+'_'+i).checked=true;
                         }
                    }
                    else
                    {
                         for(i=1; i<=childs; i++)
                         {
                              document.getElementById("child_"+id+'_'+i).checked=false;
                         }
                    }
                    NFFix();
          }
     } 

$(function() {
	$("#webinar_date").datepicker();
	$('#group_users').fancybox({
               maxWidth     : 600,
               maxHeight    : 600,
               fitToView    : false,
               width        : '70%',
               height       : '70%',
               autoSize     : false,
               closeClick   : false,
               openEffect   : 'none',
               closeEffect  : 'none',
               href         : '#popup2', 
    });
		  
	$('#show_zones').fancybox({
               maxWidth     : 600,
               maxHeight    : 600,
               fitToView    : false,
               width        : '70%',
               height       : '70%',
               autoSize     : false,
               closeClick   : false,
               openEffect   : 'none',
               closeEffect  : 'none',
			   hideOnOverlayClick:false,
			   hideOnContentClick:false,
               href  		: '#popup_show_zones', 
    });
});

	function get_current_time()
	{
			var newDate = new Date();
			var hidField = document.getElementById('hidden_time_zone');  // ID of hidden field
			hidField.value = newDate.toLocaleString();
	}
	function displayPopup()
	{
	
			var div = document.getElementById('popup2');
			div.style.display="block";
	}
	function openTimeZone()
	{
		
		var div = document.getElementById('popup_show_zones');
		div.style.display="block";
		NFFix();
		//alert('ddd');
	}
	
	function closeTimeZone()
	{
		//close_time_zone
		var display = document.getElementById('popup_show_zones');
		 display.style.display="none";     
		 $.fancybox.close();
	
	}
	function displayPopup2()
	{
		 var display = document.getElementById('popup2');
		 display.style.display="none";
		 //var display = document.getElementById('blue_tick');
		 //display.style.display="block";  
		 $('#blue_tick').fadeIn();   
		 $.fancybox.close();
	}
	
	function closepopup(id)
	{
		 $.fancybox.close();
		 //var selectedItem = document.getElementById('reg_items_type').value;
		  document.getElementById('Single-Line Text_'+id).style.display="none";
		  document.getElementById('Check Boxes_'+id).style.display="none";
		  document.getElementById('Radio Buttons_'+id).style.display="none";
		  document.getElementById('Multi-Line Text_'+id).style.display="none";
		  $.fancybox.close();
	}



	var i = <?=$i?>;
	function addItem()
	{
		
		 i++;    
		 var html = '<ul class="TableData"><li><input type="text" id="item_name_'+i+'" name="items['+i+'][title]" size="20" /></li><li><div  style=" position:relative; margin-top:10px; float:left"><select id="reg_items_type_'+i+'" size="1" name="items['+i+'][type]" style="width:180px;"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select></div></li><li class="Serial"><input type="checkbox" name="items['+i+'][required]" /></li><li><input type="text" name="items['+i+'][order]" size="20" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
		 
		var htmlDiv = '<div style="display:none"><div id="reg_popup_'+i+'"><div id="Single-Line Text_'+i+'" style="display:none"><table width="200"><tbody><tr><td><label for="text_datatype"> Text Type:</label></td><td class="dinput"><select id="text_datatype" name="text_datatype['+i+']" class="dinput" style=" "><option selected="selected" value="string">Anything</option> <option value="email">Email Address</option></select></td></tr></tbody></table></div><div id="Check Boxes_'+i+'"  style="display:none "><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/><span>Form Items</span></h1><div class="RightSideButton"><a href="javascript:void(0)" id="addCheckItem_'+i+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addCheckItem('+i+')"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="checkItemsList_'+i+'"><ul class="TableData"><li><input type="text" name="checkbox_items['+i+'][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span><ul class="TableData AlterRow AddFieldRow"><li><div class="AddMoreField"><a href="javascript:void(0)" id=""><img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addCheckItem('+i+')"/> Add More Field </a></div></li></ul></div></div><div id="Radio Buttons_'+i+'" style="display:none"><div class="RightColumnHeading"><h1><img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items" "/><span>Form Items</span></h1><div class="RightSideButton"><a href="javascript:void(0)" id="addRadioItem_'+i+'"><img src="<?=base_url();?>images/webpowerup/MoreField.png" onclick="addRadioItem('+i+')" alt="Add More Field"/></a></div></div><div class="DataGrid2" style="overflow:hidden"><ul class="TableHeader"><li>Item Title</li><li class="Actions">Action</li></ul><span id="radioItemsList_'+i+'"><ul class="TableData"><li><input type="text" name="radio_items['+i+'][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul></span><ul class="TableData AlterRow AddFieldRow"><li><div class="AddMoreField"><a href="javascript:void(0)" id="addRadioItem"><img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addRadioItem('+i+')"/> Add More Field</a></div></li></ul></div></div><div id="Multi-Line Text_'+i+'" style="display:none"><table><tbody><tr><td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td><td><input type="text" size="10" value="40" id="textarea_width" name="textarea['+i+'][0]" class="dinput"></td></tr><tr><td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td><td><input type="text" size="10" value="5" id="textarea_height" name="textarea['+i+'][1]" class="dinput"></td></tr></tbody></table></div><a href="javascript:void(0)" class="fncy-custom-close"><input type="button" id="close_button2" value="close" onClick="closepopup('+i+')"/></a></div></div>';
          
     $("#itemsList").append(html);
     $("#addPopupDiv").append(htmlDiv);	 
     NFFix();
	 $("#item_name_"+i).focus();
}


	var j = <?=$j?>;
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



	var k = <?=$k?>;
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


	//     REMOVE ITEM 
	$(".DeleteAction").live("click",function(){
		 $(this).parent().parent().remove();
	});
	
	$(".all_users").live("click",function(){
		 $("#group_users").show();
	});
	
	$("div.NFRadio").live("click",function(){
			var id = $(this).next("input").attr("id");
			
			if(id == "page_access_1")
			{
				$("#group_users").fadeOut();
				 $('#blue_tick').fadeOut();   
			}
			if(id == "page_access_2")
			{
				$("#group_users").fadeOut();
				 $('#blue_tick').fadeOut();   
			}
			if(id == "page_access_3")
			{
				$("#group_users").fadeIn();
				 $('#blue_tick').fadeOut();   
			}
	});

$(document).ready(function(e) {
   		var newDate = new Date();
		$('#hidden_time_zone').set_timezone({'default' : 'America/Los_Angeles'});
		//alert(newDate.getTimezoneOffset());
		$('#machine_time').val(newDate.toLocaleString());
     	$("#addItem,#addItem2").click(function(e) {
          //alert("hi");
        addItem();
    });
	
	$(".deleteRow").live("click",function(){     
     $(this).parent().parent().remove();
     return false;
	});
});

/****      ADD AND REMOVE ROW CODE      ****/


	var numMenus = <?=$menus->num_rows()?>;
	function addRow(tableID)
	{

	   var table = document.getElementById(tableID);
	   var rowCount = table.rows.length;
	   var row = table.insertRow(rowCount);
	   var colCount = table.rows[0].cells.length;
	   var newRowCount = table.rows.length;
	   var ary_index = newRowCount;
	   //  alert(colCount);
	   for(var i=0; i<5; i++)
	   {
			var newcell = row.insertCell(i);
			if (i=='2')
			{
				newcell.innerHTML = '<select style="opacity:1;" name="'+'items['+ary_index+'][type]'+'" id="type"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select>';
			}
			else
			{
				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			}
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
     
     
/*$(document).ready(function(e) {
     
     // ADD ROW DYNAMICALLY
     <?php
     if($mode == "new")
     {
     ?> 
     var count = 1;
     <?php
     }
     else if ($mode == "edit") 
     { ?>
     var count = <?=count($webinar_info['custom_fields_info']);?>;
     <?php     
     } ?>
     
    $("#addRow,#addRow2").click(function(){
          
          var html = '<ul class="TableData"><li><input type="text" name="items['+count+'][title]" id="" size="19" /></li><li><div  style=" position:relative; margin-top:10px; float:left"><select size="1" name="items['+count+'][type]" id="type"  style="width:170px;"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select></div></li><li class="Serial"><input type="checkbox" name="items['+count+'][required]" id="items['+count+'][required]" value="1" /></li><li><input type="text" name="items['+count+'][order]" id="items['+count+'][order]" size="16" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>';
          
          
          $("#rowDiv").append(html);
          NFFix();
          count++;
          return false;
     });
});*/

// REMOVE ROW DYNAMICALLY


$(".NFCheck").live("click",function(){
		var id = $(this).next("input").attr("id");		
		if(id == "is_paid")
		{
			$("#webinar_amount").toggle('slow');
		}
		
		
});

</script>



<?
function myfunction($products, $needle)
{
   foreach($products as $key => $product)
   {
      
       //echo $product['existing_att_id'].'=='.$needle."<br>";
       if ( $product['existing_att_id'] == $needle )
         return true;
   }
   return false;
}
     
     // echo $mode;
     //echo "<pre>";
     //print_r($webinar_info);
     
?>



<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/WebinarManagement.png" alt="Webinar Management"/>
        <span>Webinar <?php echo ($mode == "edit") ? "Ediit" : "New" ; ?></span>
    </h1>
    
    <div class="RightSideButton">
        
    </div>
</div>

<?php
     
     $user_group_options  = array('Groups'  => $groups, 'Registered Users'  => $users);
	// echo "<pre>";echo "hello";print_r($user_group_options);exit;
     
     $action = base_url().index_page().'webinar_controller/new_webinar/'.$_SESSION["site_id"];
     $form_action = "do_save";
     
     if($mode == "edit")
     {
          $action = base_url().index_page().'webinar_controller/do_edit_webinar/'.$webinar_id;
          $form_action = "do_edit";
     }
          
?>

<div class="form">
<form name="webinar_data" action="<?=$action?>" method="post" id="webinar_data" onsubmit= " return validate()" class="niceform" >
<input type="hidden" name="action" value="<?=$form_action?>">
<input type="hidden" name="hidden_time_zone" id="hidden_time_zone" >
<input type="hidden" name="machine_time" id="machine_time" >


<fieldset>
                    <dl>
                        <dt><label for="email" class="NewsletterLabel"> Webinar Title :</label></dt>
                        <dd><input type="text" name="title" value="<?=(isset($webinar_info["title"])) ? $webinar_info["title"] : ""?>" id="title" size="55" /></dd>
                    </dl>
                   <dl>
						<dt><label for="color" class="NewsletterLabel"> Is Webinar Paid :</label></dt>
						<dd>
							<input type="checkbox" id="is_paid" name="is_paid" <?  if(isset($webinar_info["is_paid"])){ echo 'checked'; } ?> />
							<label class="check_label"></label>
							<? if(empty($webinar_info["webinar_amount"])){ ?>
							<div id="webinar_amount" style="clear:both; display:none;">
							<? }else { ?>
							<div id="webinar_amount" style="clear:both;">
							<? } ?>
                    			<label for="color" class="NewsletterLabel">$</label><input type="text" size="30" name="webinar_amount" placeholder = "25"  value="<?=(!empty($webinar_info["webinar_amount"]) ? $webinar_info["webinar_amount"] : '');?>"/>
                    		</div>			
						</dd>
					</dl>                    
                    <dl>
                        <dt><label class="NewsletterLabel">Intro Text :</label></dt>
                        <dd>
                        <textarea id="ck_content" class="ckeditor" name="ck_content" rows="10" cols="42" ><?=(isset($webinar_info["form_intro"])) ? $webinar_info["form_intro"] : ""?></textarea>
                       
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label class="NewsletterLabel">Thankyou Text :</label></dt>
                        <dd><textarea class="ckeditor" id="ck_content_2" name="ck_content_2" style="width:auto !important;" rows="10" cols="42" ><?=(isset($webinar_info["form_thank_u"])) ? $webinar_info["form_thank_u"] : ""?></textarea>
                       
                        </dd>
                    </dl>
                    
                     <dl>
                        <dt><label for="color" class="NewsletterLabel">Who can see Weninar? : </label></dt>
                        <dd>
                        <?
                                   $str_check = "";
                                   $str_check_default = "";
                                   if($mode == "new")
                                   { 
                                        $str_check_default = "checked='checked'";
                                   }
                                   
                                                  
                              ?>
                            <label class="check_label">Everyone</label>
                            <input type="radio" id="page_access_1" name="webinar_access" checked="checked" value="Everyone" onClick="hideRoles()" <?=$str_check_default?> <?=(isset($webinar_info["webinar_access"]) &&  $webinar_info["webinar_access"] == "Everyone") ? "checked='checked'" : ""?> /><br/><br/>
                            <label class="check_label">Registered Users </label>
                            <input type="radio" id="page_access_2" name="webinar_access" value="Registered" onClick="hideRoles()" <?=(isset($webinar_info["webinar_access"]) &&  $webinar_info["webinar_access"] == "Registered") ? "checked='checked'" : ""?> /><br/><br/>
                            
                            <label class="check_label">Only Users With a Certain Access Level </label>
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
                            <!--<input type="radio" id="page_access_3" name="webinar_access" value="Other" onClick="showRoles()" <?=$str_check?> />-->
                            <input type="radio" id="page_access_3" class="all_users" name="webinar_access" value="Other" />
                        </dd>
                    </dl>
                    
                    <dl>
                           <dt>&nbsp;
                                 
                           </dt>
                           <dd>
                                <a id="group_users" style="display:none;" class="group_users_popup" href="#popup2" onclick="displayPopup()" >See all Groups and users.</a>
                                <img style="display:none;" id="blue_tick" src="<?=base_url().index_page()?>css/images/blue_tick.png" />
                                <span id="roles" name="roles" style=" <?=$strStyle;?>">    
                   <?                   
                    				//echo "<pre>";echo "hello";print_r($groups_users);
                   ?>
                                <div style="display:none;" >
                                <div id="popup2" style="float:left;">
                                <h1>Select Group & Users</h1>
                                <!--<form action="#" method="post" id="group_container">-->
                   <?php  
                        if(isset($groups_users) && count($groups_users)>0)
                                { 
                                        
                                for($i = 0; $i < count($groups_users); $i++)
                                {
									if(isset($groups_users[$i]['group_name']))
									{
									
										$child_count = count($groups_users[$i]['users']);
										if($groups_users[$i]['users']==0)
										{
											$child_count = 0;
										}
                                
                                ?>     
                                		<fieldset class="group"> 
                                			<legend onClick="selectGroup(<?=$i?>,<?=$child_count?>)">
                                				<input type="checkbox" id="<?=$i?>"  value="<?=$groups_users[$i]['id']?>" name="group_<?=$i?>" onClick="selectGroup(<?=$i?>,<?=$child_count?>)" />
                                            	<label for="cb1"><?=$groups_users[$i]['group_name']?></label>
                                			</legend> 
                                <?php
										if(isset($groups_users[$i]['users']) && $groups_users[$i]['users']!=0)
                                		{ 
                                ?>
                                			<ul class="checkbox">
                                <?php
											$j=0;
										foreach($groups_users[$i]['users'] as $key => $users)
										{
                                         	/*echo "<pre>";echo $key;print_r($groups_users[$i]['users']);*/
               
                                    		$j++;
                                ?>   
                                            <input type="hidden" name="group_count_<?=$i?>" id="group_count_<?=$i?>" value="<?=$i?>" />
                                            <input type="hidden" name="user_count_<?=$i?>" id="user_count_<?=$i?>" value="<?=$j?>" />
                                
                                <?
                                
											if(isset($is_edit) && $is_edit == "true")
											{
												if(isset($selected_users) && myfunction($selected_users, $key))
												 {
                                ?>
                                
                                        			<li>
                                                        <input type="checkbox" checked="checked" name="child_<?=$i?>_<?=$j?>" id="child_<?=$i?>_<?=$j?>"  value="<?=$key?>" />
                                                        <label for="cb6>"><a href="javascript:void(0)"><?=$users?></a></label>
                                                    </li> 
                                <? 				} else {
								
								?>
                                                        <li>
                                                        <input type="checkbox" name="child_<?=$i?>_<?=$j?>" id="child_<?=$i?>_<?=$j?>"  value="<?=$key?>" />
                                                        <label for="cb6>"><a href="javascript:void(0)"><?=$users?></a></label>
                                                        </li>
                                <? 						}
											} 
											if(isset($is_create) && $is_create == "true")
											{
								?>
                                                <li>
                                                    <input type="checkbox" name="child_<?=$i?>_<?=$j?>" id="child_<?=$i?>_<?=$j?>"  value="<?=$key?>" />
                                                    <label for="cb6>"><a href="javascript:void(0)"><?=$users?></a></label>
                                                </li>
                                <?                                     
											}
										}//End Foreach 
                                		echo "</ul>";
									}
									else
									{
										echo '<ul class="checkbox"><li>No user has been registerd for this group.</li></ul>';
									}
                                ?>
                                
                                	</fieldset> 
                                <?php
                                	}
                                } //End For 
								?>
                                <input type="hidden" name="group_total" id="group_total" value="<?=$i?>" />
                                <?     }     else
                                {
                                echo '<ul class="checkbox"><li>No Groups or User have been Registered.</li></ul>';
                                }
                                ?>
                                
                                <a href="javascript:void(0)" class="fncy-custom-close">
                                <input type="button" value="close" onClick="displayPopup2()"/></a>
                                </div>
                                </div>
                                <?php // echo form_dropdown('group_access[]', $user_group_options, '3' , ' multiple="MULTIPLE" id = "group_access" '); ?>
                                <!--<select name="group_access[]" id="group_access"  multiple="multiple" style="width:130px; opacity: 1;filter: alpha(opacity = 100); margin-top: 10px;">
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
                                </select>-->
                                </span>
                           </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel"> Select Menu :</label></dt>
                        <dd>
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
                                    
                                    
                                ?>
                                <input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onClick="uncheckCreateLink();"/>
                                <label class="check_label"><?=$rowMenus["menu_name"];?></label>
                                
                                <div style="border:none; height:10px; clear:both"></div>
                                
                                
                                <?php
                                    $i++;
                                    }
                                   
                                    
                                ?>                        
                         
                         
                         
                         
                         
                         <label class="check_label">or Just show me the link I will use in Email. </label>
                         <input type="radio" name="link_only" id="link_only" />
                        </dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="comments" class="NewsletterLabel">Send email only invities:</label></dt>
                        <dd><input type="checkbox" id="only_invite" name="only_invite" value="only" ><label class="check_label">Only Invities </label></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="comments" class="NewsletterLabel">Invite Non-members : <br/>(Enter E-mail Comma Sperated)</label></dt>
                        <dd><textarea id="non_group" name="non_group" rows="10" cols="42"></textarea></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="email" class="NewsletterLabel">Webinar Email To </label></dt>
                        <dd><input type="text" name="email_to" id="email_to" value="<?=(isset($webinar_info["email_to"])) ? $webinar_info["email_to"] : ""?>" size="55" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="email" class="NewsletterLabel"> Default Forms Fields </label></dt>
                    </dl>
                    
                    <dl>
                        <dt><label for="email" class="NewsletterLabel">  </label></dt>
                    </dl>
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
                   <dl>
                        <dt><label for="color" class="NewsletterLabel"><?=$webinar_info["defualt_fields_info"][$i]["field_title"]?></label></dt>
                        <dd>
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
                         <input type="checkbox" name="default_items[<?=$j?>][required]" id="f_name_required" <?=$required_checked?> />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[<?=$j?>][active]" id="f_name_active" <?=$active_checked?> />   
                         <label class="check_label">Active </label>
                         <input type="hidden" name="default_items[<?=$j?>][title]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_title"]?>">
                        <input type="hidden" name="default_items[<?=$j?>][type]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_type"]?>">
                        <input type="hidden" name="default_items[<?=$j?>][order]" value="<?=$webinar_info["defualt_fields_info"][$i]["field_sequence"]?>">
                         
                        </dd>
                    </dl>
                    <?       
                              }
     
                         } 
                         else
                         {
                         ?>
                    
                   <dl>
                        <dt><label for="color" class="NewsletterLabel"> First Name :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[1][required]" id="f_name_required" />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[1][active]" id="f_name_active"  checked="checked" />   
                         <label class="check_label">Active </label>
                         <input type="hidden" name="default_items[1][title]" value="First Name">
                        <input type="hidden" name="default_items[1][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[1][order]" value="1">
                         
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel"> Last Name  :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[2][required]" id="f_name_required"/>   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[2][active]" id="f_name_active" checked="checked"  />   
                         <label class="check_label">Active </label>
                         <input type="hidden" name="default_items[2][title]" value="Last Name">
                        <input type="hidden" name="default_items[2][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[2][order]" value="2">
                         
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel"> Email :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[3][required]" id="f_name_required"  />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[3][active]" id="f_name_active" checked="checked" />   
                         <label class="check_label">Active </label>
                        <input type="hidden" name="default_items[3][title]" value="Email">
                        <input type="hidden" name="default_items[3][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[3][order]" value="3">                         
                         
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel">Phone Number :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[4][required]" id="f_name_required" />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[4][active]" id="f_name_active" checked="checked" />   
                         <label class="check_label">Active </label>
                        <input type="hidden" name="default_items[4][title]" value="Phone Number">
                        <input type="hidden" name="default_items[4][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[4][order]" value="4">

                         
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel">Company :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[5][required]" id="f_name_required" />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[5][active]" id="f_name_active" checked="checked" />   
                         <label class="check_label">Active </label>
                         <input type="hidden" name="default_items[5][title]" value="Company">
                        <input type="hidden" name="default_items[5][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[5][order]" value="5">
                         
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color" class="NewsletterLabel">Webiste :</label></dt>
                        <dd>
                         <input type="checkbox" name="default_items[6][required]" id="f_name_required" />   
                         <label class="check_label">Required </label>
                         <input type="checkbox" name="default_items[6][active]" id="f_name_active" checked="checked"  />   
                         <label class="check_label">Active </label>
                         <input type="hidden" name="default_items[6][title]" value="Webiste">
                        <input type="hidden" name="default_items[6][type]" value="Single-Line Text">
                        <input type="hidden" name="default_items[6][order]" value="6">
                         
                        </dd>
                    </dl>
                                        
                    <? } ?>
                    
               <dl>
                   <dt>
                         <label  class="NewsletterLabel">Enter Start Date:</label>
                   </dt>
                   <dd>
                        <input type="text" id="webinar_date" name="webinar_date"  value="<? if(isset($webinar_info['start_time'])) echo $webinar_info['start_time'];?>" size="55" />
                   </dd>
            </dl>
            
           <!-- <dl>
                   <dt>
                         <label  class="NewsletterLabel">Enter Time:</label>
                   </dt>
                   <dd>
                        <input type="text" size="10" id="start_time" name="start_time" value="<? if(isset($webinar_info['start_date'])) echo $webinar_info['start_date'];?>">
                   </dd>
            </dl>-->
            
            <dl>
            <dt><label for="email" class="NewsletterLabel"> Enter Time: </label></dt>
            <dd>
            
                   
                    <!--<input  name="r_hours" type="text"  value="" size="2" maxlength="2" style="width:20px;" tabindex="9"  >
                    <input  name="r_minuts" type="text"  value="" size="2" maxlength="2" style="width:20px;" tabindex="10"  >  -->          
                	<div style="float:left; margin:0 0 0 10px;" >
                    <div style=" position:relative; float:left; ">
                     
            		<select size="1" name="r_hours" id="r_hours" style="width:80px;"> 
                       <option selected="selected" value="HH">HH</option><option  value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                    </select>      
                    </div>
                    </div>      
              <div style="float:left; margin:0 0 0 10px;" >
              <div style=" position:relative; float:left;  " >
              
            		<select size="1" name="r_minuts" id="r_minuts" style="width:80px;"> 
                       <option selected="selected"  value="MM">MM</option><option value="00">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select>
                    </select>      
                    </div>                   
             </div>
             
             <div style="float:left; margin:0 0 0 10px;" >
                    <div style=" position:relative; float:left">
            		<select size="1" name="ampm" id="ampm" style="width:80px;"> 
                        <option value="AM" selected="selected">AM</option>
                        <option value="PM">PM</option>
                    </select>      
                    </div>      
             </div>
             <br />
             <a style="float:left; padding-left:10px;" id="show_zones" href="#popup_show_zones" onclick="openTimeZone()"><b>
                <span id="time_zone_name" style="text-decoration:underline;">Central Time (US &amp; Canada)</span></b></a>
            </dd>
      </dl>
      
               <div id="popup_show_zones" style="float:left; display:none;  width:700px; height:500px;" >
                   <ul style="padding-bottom:10px;">
                       <li style="padding: 10px 0px 10px 0px;">
                       		<input type="radio"	name="show_us_intl" value="intl" id="show_international_time_zones"/><label for="email" class="NewsletterLabel"> International Time Zones </label>
                       </li>
                    
                    	<li style="padding: 10px 0px 10px 0px;">
                                <select size="10" name="time_zone_intl" id="time_zone"  style="width:auto; height:400px;"  >
                                <? for($i = 0; $i<count($times_zones); $i++){ ?>
                                    <option value="<?=$times_zones[$i]['time_zone_offset']?>"><?=$times_zones[$i]['time_zone_area']?></option>
                                <? } ?>
                                </select>
                        </li>
                    </ul>
                    <ul>
                       <li style="padding: 10px 0px 10px 0px;">
                            	<input type="radio" checked="checked" name="show_us_intl" value="us" id="show_us_time_zones"/><label for="email" class="NewsletterLabel"> US Time Zones </label>
                           </li>
                    	<li>

                                <select name="time_zone_us" size="8" style="height:300;width:290;">
                                   <option value="-08:00">(GMT-08:00) Pacific Time (US &amp; Canada); Tijuana</option>
                                   <option value="-07:00">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                   <option value="-06:00">(GMT-06:00) Central America</option>
                                   <option value="-06:00" selected="">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                   <option value="-05:00">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                </select>
						</li>
                    </ul>
                    <ul><li style="padding: 10px 0px 10px 0px;"><input type="button" id="close_time_zone" onclick="closeTimeZone()" value="Close"/></li></ul>
                 </div>
       <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/FormItems.png" alt="Form Items"/>
        <span>Form Items</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="javascript:void(0)" id="">
            <img src="<?=base_url();?>images/webpowerup/MoreField.png" alt="Add More Field" onclick="addItem()">
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
        <?
        if(isset($is_edit) && $is_edit == "true"){
               
          if(count($fields) > 0 )
          {
               $i = 0;
               foreach($fields as $row) 
               {
                   
               ?>
            		<input type="hidden" name="items[<?=$i?>][id]" size="20" value="<?=$row['id'];?>" /> 
               		<ul class="TableData">
                        <li>
                            <input type="text" name="items[<?=$i?>][title]" size="20" value="<?=$row['field_title'];?>" /> 
                        </li>               
                        <li>
                          <div  style=" position:relative; margin-top:10px; float:left">
                                <select size="1" name="items[<?=$i?>][type]" id="reg_items_type_<?=$i?>" style="width:180px;"> 
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
                            <input type="text" name="items[<?=$i?>][order]" size="20" value="<?=$row['field_sequence'];?>" />
                        </li>
                        <li class="Actions">
                            <a href="javascript:void(0)" class="DeleteAction">
                                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                            </a>
                        </li>
               		</ul>
             		<div style="display:none;"  >
                    <div id="reg_popup_<?=$i?>">
                    <? if ($row['field_type'] == "Single-Line Text") 
					{ 
					?>
                    	<div id="Single-Line Text_<?=$i?>" style="display:none">
							<?
                                $selected = $options['single_line'][$i]['option_value'];
                            ?>
                            <table width="200">
                                <tbody>
                                    <tr>
                                        <td><label for="text_datatype"> Text Type:</label></td>
                                        <td class="dinput">                          
                                           <select id="text_datatype" name="text_datatype[<?=$i?>]" class="dinput" style="">
                                                <option <?  if(isset($selected) && $selected == 'string'){?> selected="selected" <? }?> value="string">Anything</option>
                                                <option <?  if(isset($selected) && $selected == 'email'){?> selected="selected" <? }?> value="email">Email Address</option>
                                            </select>
                                        </td>
                                   </tr>
                               </tbody>
                           </table>
                    	</div>
                    <? }//if close
                     if ($row['field_type'] == "Check Boxes") 
					 {
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
                                <? 			} 
										} 
									}
								?>
                               </span>                        
                               <ul class="TableData AlterRow AddFieldRow">
                                    <li>
                                     <div class="AddMoreField">                    
                                        <a href="javascript:void(0)" id="">
                                        <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addCheckItem(<?=$i?>)"/>
                                        Add More Field
                                        </a>
                                     </div>
                                    </li>
                               </ul>
                    	  </div>
                    	</div>
                    <? }//if close
                     if ($row['field_type'] == "Radio Buttons")
					 {
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
                                                <ul class="TableData">
                                                    <li>
                                                        <input type="text" name="radio_items[<?=$i?>][<?=$k?>][title]" value="<?=$options['Radio_Buttons'][$k]['option_value']?>" size="32" />
                                                    </li>
                                                    <li class="Actions">
                                                        <a href="javascript:void(0)" class="DeleteAction">
                                                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                                                        </a>
                                                    </li>
                                                </ul>
                                <? 			} 
                                        }  
                                    }
                                ?>
                                </span>
                                <ul class="TableData AlterRow AddFieldRow">
                                    <li>
                                         <div class="AddMoreField">                    
                                            <a href="javascript:void(0)" id="addRadioItem">
                                            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addRadioItem(<?=$i?>)"/>
                                            Add More Field
                                            </a>
                                         </div>
                                    </li>
                                </ul>
                           </div>
                    	</div>
                    <? } //if close
                     if ($row['field_type'] == "Multi-Line Text") 
					 {
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
                                <tbody>
                                    <tr>
                                        <td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td>
                                        <td><input type="text" size="10" value="<?=$check[0]?>" id="textarea_width" name="textarea[<?=$i?>][0]" class="dinput"></td>
                                    </tr>
                                    <tr>
                                        <td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td>
                                        <td><input type="text" size="10" value="<?=$check[1]?>" id="textarea_height" name="textarea[<?=$i?>][1]" class="dinput"></td>
                                    </tr>
                                </tbody>
                            </table>
                      </div>
                <? } //if close?>
                	<br/><br/><br/>
                	 <a href="javascript:void(0)" class="fncy-custom-close">
                		<input type="button" id="close_button2" value="close" onClick="closepopup(<?=$i?>)"/></a>
                  </div>
                </div> 
               <?php
               $i++;
               }
          } 
     }
?> <?
          if(isset($is_create) && $is_create == "true"){
          ?>
         
        <ul class="TableData"><li><input type="text" name="items[0][title]" size="20" /></li><li><div  style=" position:relative; margin-top:10px; float:left"><select id="reg_items_type_0" onchange="showPopup()" size="1" name="items[0][type]"  style="width:180px;"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select></div></li><li class="Serial"><input type="checkbox" name="items[0][required]" /></li><li><input type="text" name="items[0][order]" size="20" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
               </span>
   
     

  <style>
               .dinput
               {
                    overflow:hidden !important;
                    display:inline !important;
               }
               </style>
  <div style="display:none;"  >
    <div id="reg_popup_0">
    <div id="Single-Line Text_0" style="display:none">
        <table width="200">
        <tbody><tr>
            <td><label for="text_datatype"> Text Type:</label></td>
            <td class="dinput">
          
       <select id="text_datatype" name="text_datatype[0]" class="dinput" style="">
            <option selected="selected" value="string">Anything</option>
            <option value="email">Email Address</option>
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
        <ul class="TableData"><li><input type="text" name="checkbox_items[0][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
        </span>
        
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="javascript:void(0)" id="">
            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field" onclick="addCheckItem(0)"/>
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
        <ul class="TableData"><li><input type="text" name="radio_items[0][0][title]" size="32" /></li><li class="Actions"><a href="javascript:void(0)" class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/></a></li></ul>
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
    </div>
    
    <div id="Multi-Line Text_0" style="display:none;">
        <table>
        <tbody><tr>
            <td align="right"><label for="textarea_width" class="dinput">Width (columns): </label></td>
            <td><input type="text" size="10" value="40" id="textarea_width" name="textarea[0][0]" class="dinput"></td>
        </tr>
        <tr>
            <td align="right"><label for="textarea_height" class="dinput">Height (rows): </label></td>
            <td><input type="text" size="10" value="5" id="textarea_height" name="textarea[0][1]" class="dinput"></td>
        </tr>
        </tbody></table>
    </div>
    
<br/>
<br/><br/>
    <a href="javascript:void(0)" class="fncy-custom-close">
<input type="button" id="close_button2" value="close" onClick="closepopup(0)"/></a>
    </div>
    </div> 
   
<? }?> 
</span>
      <ul class="TableData AlterRow AddFieldRow">
            <li>
                 <div class="AddMoreField">                    
                    <a href="javascript:void(0)" id="addItem2">
                    <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field"/>
                    Add More Field
                    </a>
                 </div>
            </li>
       </ul> 
	     
       <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
                <div class="ButtonRow">
                    <a href="<?=base_url().index_page();?>webinar_controller/new_webinar/<?=$site_id?>" >
                        <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
                    </a>
                    <button type="submit">
                        <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
                    </button>
                </div>
            </dd>
        </dl>  
</fieldset>
<div id="addPopupDiv">
</div>                
</form>
</div>