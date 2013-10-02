<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Management </title>
    
<!--javascripts add /roemove     -->
 <script language="Javascript" type="text/javascript">
<!--

function addRow(tableID) {
 
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

//-->
function CopyTitleToPageTitle()
	{
		 var title = document.getElementById('form_fname').value;
		 document.getElementById('menu_item_txt').value = title;
	
	}	 

</script>   
<!-- end javascriptts add/remove  -->

<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h1>Registration Form </h1>

<p align="center"><h2>Edit here your form data ...</h2></p>
<div id="default">
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
    $attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
    echo form_open(base_url().index_page().'Edit_Registration_Form/edit_reg_data', $attributes); 
      echo form_hidden('id',$values[0]['form_id']); 
     // echo $values[0]['form_payment_required'].">>>>>>>>>>>>>>>>>>>>>>";
      
    $form_name = array(
              'name'        => 'form_fname',
              'id'          => 'form_fname',
            //  'maxlength'   => '100',
             // 'size'        => '50',
           //   'style'       => 'width:15%',
              'value'       => set_value('form_fname',$values[0]['form_title']),
			  'onChange' => "CopyTitleToPageTitle()"
            );
 
   $form_info_txt = array(
              'name'        => 'form_info_txt',
              'id'          => 'ck_content',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('form_info_txt',$values[0]['form_intro'])
            );
            
   $form_thank_txt = array(
              'name'        => 'form_thank_txt',
              'id'          => 'ck_content_2',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('form_thank_txt',$values[0]['form_thank_u'])
            );
                                                          
 
  // wsitch for check value
            //echo "<pre>"; echo $values[0]['form_menu_item_text'];print_r($values);			 
            
			if(isset($values[0]['form_menu']))
			{
				
				switch ($values[0]['form_menu'])
				{
				case 'Main Menu':
					   
					  break;
				case 'User Menu':
					  
					  break;
				case 'Registered Users':
					  
					  break;
				case 'Clients':
					  
					  break;
				case 'Workshops':
					  
					  break;
				case 'Services':
					   
					  break;
				case 'Symptoms':
					  
					  break;
				case 'Demo Menu':
					  
					  break;
				}
			} 

$form_main_menu_rd = array('name' => 'form_main_menu', 'id'  => 'form_main_menu', 'value' => 'Main Menu', 'checked' => set_radio('form_main_menu', '0')  );  
$form_user_menu_rd = array('name' => 'form_main_menu', 'id'  => 'form_main_menu', 'value' => 'User Menu', 'checked' => set_radio('form_main_menu', '0',TRUE)  );   
$form_reg_user_rd = array('name' => 'form_main_menu', 'id'  => 'form_main_menu', 'value' => 'Registered Users','checked' => set_radio('form_main_menu', '0')  );  
$form_clients_rd = array('name' => 'form_main_menu', 'id'  => 'form_main_menu', 'value' => 'Clients', 'checked' => set_radio('form_main_menu', '0')  );  
$form_workshops_rd = array('name' => 'form_main_menu','id' => 'form_main_menu', 'value' => 'Workshops','checked' => set_radio('form_main_menu', '0')  );   
$form_services_rd = array('name' => 'form_main_menu', 'id' => 'form_main_menu', 'value' => 'Services','checked' => set_radio('form_main_menu', '0')  );  
$form_symptoms_rd = array('name' => 'form_main_menu','id' => 'form_main_menu',  'value' => 'Symptoms','checked' => set_radio('form_main_menu', '0')  );  
$form_demo_menu_rd = array('name' => 'form_main_menu','id' => 'form_main_menu', 'value' => 'Demo Menu', 'checked' => set_radio('form_main_menu', '0')  );  
                                                                                                
 
$dont_creat_link = array('name' => 'form_main_menu','id' => 'form_main_menu',  'value' => 'Dont Create Link', 'checked' => set_radio('form_main_menu', '1',FALSE));          
            
            
            
   $form_publish_yes = array(
              'name'        => 'form_publish',
              'id'          => 'form_publish', 'value'       => '1',
              'checked'     => set_radio('form_publish', '1', TRUE)
            );  
   $form_publish_no =       array(
              'name'        => 'form_publish',
              'id'          => 'form_publish',  'value'       => '0',
              'checked'     => set_radio('form_publish', '0',FALSE)
            );
   $options_parent = array(
                  '1'  => 'Home',
                  '2'  => 'About us',
                  '3'  => 'About Company',
                  '4'  => 'None',
                );  
                
                
   $same_as_title_chk = array(
                'name'        => 'same_as_title_chk',
                'id'          => 'same_as_title_chk',
                'value'       => '1',
                'checked'     => TRUE,
                'style'       => 'margin:10px',
                );  
   $menu_item_txt = array(
              'name'        => 'menu_item_txt',
              'id'          => 'menu_item_txt',  'value'       => set_value('menu_item_txt',$values[0]['form_title'])
            );             
               
               
                
   $every_one_rd = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions', 'value'       => 'Every One',
              'checked'     => set_radio('form_permissions', '0', TRUE)
            );                          
   
   $reg_users_rd = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions',   'value'       => 'Registered Users',
              'checked'     => set_radio('form_permissions', '0', FALSE)
            ); 
            
    $certain_access_level = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions',  'value'       => 'Level of Access',
              'checked'     => set_radio('form_permissions', '0', FALSE)
            );  
            
            
    $require_payement_yes = array(
              'name'        => 'require_payement',
              'id'          => 'require_payement',   'value'       => '1',
              'checked'     => set_radio('require_payement', '0') 
            );
      
   $require_payement_no = array(
              'name'        => 'require_payement',
              'id'          => 'require_payement',     'value'       => '0',
              'checked'     => set_radio('require_payement', '0',TRUE) 
            ); 
   
   
   $show_thank_u = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',    'value'       => 'Show Thank You',
              'checked'     => set_radio('after_complete', '0', TRUE)
            ); 
                      
   $redirect_url = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',  'value'       => 'Redirect URL',
              'checked'     => set_radio('after_complete', '0', FALSE)
            ); 
   
   $add_user_group = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',   'value'       => 'Add User To Group',
              'checked'     => set_radio('after_complete', '0', FALSE)
            ); 
   
   
            
    $main_menu_chk = array(
                'name'        => 'main_menu_chk',
                'id'          => 'main_menu_chk',
                'value'       => 'main',
                'checked'     => TRUE,
                'style'       => 'margin:10px',
                ); 
    $category_menu_chk = array(
                'name'        => 'category_menu_chk',
                'id'          => 'category_menu_chk',
                'value'       => 'category',
                'checked'     =>'',
                'style'       => 'margin:10px',
                );
     $default_menu_chk = array(
                'name'        => 'default_menu_chk',
                'id'          => 'default_menu_chk',
                'value'       => 'default',
                'checked'     => '',
                'style'       => 'margin:10px',
                );  
     $email_to = array(
              'name'        => 'email_to',
              'id'          => 'email_to',   'value'       => set_value('email_to','Email TO ')
            );     

   $make_survey_yes = array(
              'name'        => 'make_survey',
              'id'          => 'make_survey', 'value'       => '1',
              'checked'     => set_radio('make_survey', '1', TRUE)
            ); 
   $make_survey_no = array(
              'name'        => 'make_survey',
              'id'          => 'make_survey', 'value'       => '0',
              'checked'     => set_radio('make_survey', '0', FALSE)
            ); 
      $options_menu = array(
                  '1'  => 'Main Menu',
                  '2'  => 'Demo 2',
                  '3'  => 'User Menu',
                );
      $publish_chk = array(
                'name'        => 'publish_chk',
                'id'          => 'publish_chk',
                'value'       => '1',
                'checked'     => TRUE,
                'style'       => 'margin:10px',
                );               
?>
<fieldset>
<legend>Form Title</legend>
         <?php echo form_input($form_name); ?> 

</fieldset>  
<fieldset>
<legend>Intro Text</legend>
         <?php echo form_textarea($form_info_txt); ?>  <br />
          <?php echo display_ckeditor($ck_data['ckeditor']); ?>

</fieldset> 
<fieldset>
<legend>'Thank You' Text</legend>
         <?php echo form_textarea($form_thank_txt); ?>  <br />
          <?php echo display_ckeditor($ck_data['ckeditor_2']); ?>

</fieldset> 
<fieldset>
<legend>Select A Menu</legend>
 <p>
 	    <?php echo form_radio($form_main_menu_rd); ?> &nbsp; Main Menu   <br />      
                <?php                        
                $strChecked = "";
                $i = 1;
                if(!isset($item_id))
                {
                    $item_id = 0;
                }
                $flagMenuSet = false;
                foreach($menus->result_array() as $rowMenus)
                {
                    $flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
                    if($flag == true)
                    {                               
                        $strChecked = 'checked="checked"'; 
                        $strClass = 'class="checked"'; 
                        $flagMenuSet = true;   
                    }
                    else
                    {
                        $strChecked = "";
                        $strClass = '';
                    }
                ?>
                <label for="menu_id_<?=$i?>">    <input type="radio"  onclick="hideMe('link', this)" id="menu_id_<?=$i?>" name="form_main_menu" value="<?=$rowMenus["menu_id"] ?> <?=$strChecked;?> " /> &nbsp; <?=$rowMenus["menu_name"];?></label> 
                
                
                <br />
                <?php
                $i++;
                }
                
                $strChecked = '';
                $strClass = '';
                if($flagMenuSet == false)
                {
                    $strChecked = 'checked="checked"';  
                    $strClass = 'class="checked"';  
                }
                ?>
  <?php echo form_radio($dont_creat_link); ?> None (Do not create a link) just show me link after page save  <br />
 Parent Item : <?php echo form_dropdown('parent', $options_parent, '4');  ?>  (Use None If you are Unsure )<br />
  
 </p>
</fieldset>  
 
<fieldset>
<legend>Menu Item Text</legend>
  <p>
          <?php echo form_checkbox($same_as_title_chk);  ?> Same As Title Page <br />
          <?php echo form_input($menu_item_txt); ?> <br />  
  </p>


</fieldset>

<fieldset>
<legend>Who can see this Form ?</legend>
  <p>
    <?php  echo form_radio($every_one_rd); ?> Every One  <br />                     
    <?php  echo form_radio($reg_users_rd); ?> All Registered Users  <br />
    <?php  echo form_radio($certain_access_level); ?> Only users With certain level of access  <br /> 
  </p>


</fieldset>

<fieldset>
<legend>Require Payement (On Completion)</legend>
  <p>
    <?php  echo form_radio($require_payement_yes); ?> N0  <br />                     
    <?php  echo form_radio($require_payement_no); ?> Yes <br />
    
  </p>


</fieldset>

<fieldset>
<legend>Action After Completion ?</legend>
  <p>
    <?php  echo form_radio($show_thank_u); ?> Show 'Thank You' Text  <br />                     
    <?php  echo form_radio($redirect_url); ?> Redirect To A URL <br />
     <?php  echo form_radio($add_user_group); ?> Add User To Group Than show 'Thank u text' Taxt <br />    
  </p>


</fieldset>
  

<fieldset>
<legend>Publish</legend>
        <p> <?php  echo form_radio($form_publish_yes); ?> Yes  <br />
            <?php  echo form_radio($form_publish_no); ?>   No  </p> 
          
          
</fieldset>

<fieldset>
<legend>Email Form TO</legend>
        <p> <?php echo form_input($email_to); ?> <br />   </p> 
          
          
</fieldset>

<fieldset>
<legend> Form Items</legend>
        <p>
        
<table width="83%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr bgcolor="#F3F3F3">
        <td width="5%">&nbsp;  </td> 
        <td width="37%"> TITLE</td>
        <td width="18%"> TYPE</td>
        <td width="8%">REQUIRED</td>
        <td width="15%">ORDER</td>
        <td width="36%"> DELETE</td>
        </tr>
        <tr>
   <table width="1025" border="0" cellspacing="1" cellpadding="3" id="tblAddFiels">
 <?php 
// echo "<pre>";
//  print_r($fields);  
   $total_rec = count($fields);
    for ($i=0; $i<$total_rec; $i++){
 
 ?>   
 
  <tr>
    <th width="56"><input type="checkbox" name="items[<?php echo $i; ?>][check]" id="check" /></th>
    
    <th width="320"><input name="items[<?php echo $i; ?>][title]" type="text" id="title" size="50" value=" <?php echo $fields[$i]['field_title']; ?> " /></th>
    <th width="183">
      <select name="items[<?php echo $i; ?>][type]" id="type">
      <option value="Single-Line Text" <?php if($fields[$i]['field_required']== 'Single-Line Text'){ ?> selected="selected" <?php } ?> >Single-Line Text </option>
      <option value="Multi-Line Text" <?php if($fields[$i]['field_required']== 'Multi-Line Text'){ ?> selected="selected" <?php } ?>>Multi-Line Text</option>
      <option value="Check Boxes" <?php if($fields[$i]['field_required']== 'Check Boxes'){ ?> selected="selected" <?php } ?>>Check Boxes</option>
      <option value="Radio Buttons" <?php if($fields[$i]['field_required']== 'Radio Buttons'){ ?> selected="selected" <?php } ?>>Radio Buttons</option>
    </select></th>
    <th width="87"><input type="checkbox" name="items[<?php echo $i; ?>][required]" id="crequired" <?php if($fields[$i]['field_required']== 'Yes'){ ?> checked="checked" <?php } ?>  /></th>
    <th width="80"><input name="items[<?php echo $i; ?>][order]" type="text" id="order" size="10" value="<?php echo $fields[$i]['field_sequence']; ?>" /></th>
  <!--  <th width="214"> <input type="button" value="Delete" onclick="deleteRowOne(this.parentNode.parentNode.rowIndex)"> </th> -->
  <input type="hidden" name="items[<?php echo $i; ?>][id]" value="<?php echo $fields[$i]['field_id']; ?>"> 
  </tr>
<?php
    }                                                      
?>
  
</table>




        </tr>
        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
       <tr bgcolor="#F3F3F3">
       <td colspan="5"></td>
       </tr> 
       </table>


        
        </p> 
          
      
<!--<INPUT type="button" value="Add Row" onclick="addRow('tblAddFiels')" /> &nbsp; <INPUT type="button" value="Delete Selected Row" onclick="deleteRow('tblAddFiels')" />--> 
            
</fieldset>

<fieldset>
<legend>Make This A Survey (STORE AND SHOW RESELTS)</legend>
        <p> <?php  echo form_radio($make_survey_yes); ?> Yes  <br />
            <?php  echo form_radio($make_survey_no); ?>   No  </p> 
          
          
</fieldset>

          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?> 
</div>
</body>
</html>