<!--start Ckeditor and ckfinder files-->
<script type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js" ></script>
<script type="text/javascript" src="<?=base_url()?>ckfinder/ckfinder.js"></script>

<script language="Javascript" type="text/javascript">
<!--

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

</script>   

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

                <label class="check_label">Registration Menu</label>
                <input type="radio" name="form_main_menu" id="form_main_menu" value="0" checked="checked" /> 
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
                 
                <label class="check_label"><?=$rowMenus["menu_name"];?></label>  
                <input type="radio"  onclick="hideMe('link', this)" id="menu_id_<?=$i?>" name="form_main_menu" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> class="hide_the_pages" />
                
                <br /><br />
                <?php
                $i++;
                }
                
                
                ?>
            
            	<br><br>
                <label class="check_label">   None (Do not create a link) just show me link after page save </label>
                <input type="radio" name="form_main_menu" id="noLink" value="none" /> 
                
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
	$chk3 = "";
	if ($chk == "Show Thank You")
	{
		$chk1 = " checked=\"checked\"";
		$chk2 = "";
		$chk3 = "";
	}
	else if ($chk == "Redirect URL")
	{
		$chk1 = "";
		$chk2 = " checked=\"checked\"";
		$chk3 = "";
	}
	else if ($chk == "Add User To Group")
	{
		$chk1 = "";
		$chk2 = "";
		$chk3 = " checked=\"checked\"";
	}
	?>
      <dt><label for="color" class="NewsletterLabel">Action After Completion ? : </label></dt>
      <dd>
        <label class="check_label">Show 'Thank You' Text  </label>
        <input type="radio" name="after_complete" id="after_complete1" value="Show Thank You" <?=$chk1?> />
       <label class="check_label">Redirect To A URL </label>
        <input type="radio" name="after_complete" id="after_complete2" value="Redirect URL" <?=$chk2?> />
        <br />
        <label class="check_label">Add User To Group Than show 'Thank u text' Taxt </label>
        <input type="radio" name="after_complete" id="after_complete3" value="Add User To Group" <?=$chk3?> />
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
        <a href="#">
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
            
        <ul class="TableData">
            <li>
                <input type="text" name="" id="" size="22" /> 
            </li>
            
             <li>
               <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" name="text" id=""  style="width:180px;"> 
                        <option value="">Single-Line Text</option>
                        <option value="">Select option 2</option> 
                        <option value="">Select option 3</option>
                        <option value="">Select option 4</option> 
                        <option value="">Select option 5</option> 
               </select>
               </div>
            </li>
            <li class="Serial">                    </li>
            <li>
                <input type="text" name="" id="" size="20" />
            </li>
            <li class="Actions">
                 <a href="#" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a>
             </li>
        </ul>
        
        <ul class="TableData AlterRow AddFieldRow">
        <li>
         <div class="AddMoreField">                    
            <a href="#">
            <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="Add More Field"/>
            Add More Field
            </a>
         </div>
        </li>
        </ul>
        
        <dl>
              <dt style="width:400px;">
              <label for="color" class="NewsletterLabel">Make This A Survey (STORE AND SHOW RESELTS): </label></dt>
              <dd style="width:300px;">
                <label class="check_label">Yes</label>
                <input type="radio" name="Survey" id="" value="" />
               <label class="check_label">No</label>
                <input type="radio" name="Survey" id="" value="" />
             </dd>
        </dl>
        
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
        
</form>
</div>