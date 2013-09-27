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
               
            for(var i=0; i<colCount; i++) {
                var ary_index = i+1; 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            //   alert ( newcell.childNodes[0].type);
             //  alert ( newcell.childNodes[0].name);
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) { 
                    case "text":
                            newcell.childNodes[0].value = "";
                          if(newcell.childNodes[0].name = "items[1][title]"){
                             newcell.childNodes[0].name =  'items['+ary_index+'][title]';
                          }else if(newcell.childNodes[0].name = "items[1][order]"){
                             newcell.childNodes[0].name =  'items['+ary_index+'][order]';  
                          }
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                    if(newcell.childNodes[0].name = "items[1][title]"){
                             newcell.childNodes[0].name =  'items['+ary_index+'][title]';
                          }else if(newcell.childNodes[0].name = "items[1][order]"){
                             newcell.childNodes[0].name =  'items['+ary_index+'][order]';  
                          }
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;    
                }
            }
                var newRowCount = table.rows.length;
                      var ary_index = newRowCount; 
                for(var i=1; i<=newRowCount; i++){
                    table.rows[i].cells[2].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][title]' );
                    table.rows[i].cells[3].getElementsByTagName('select').item(0).setAttribute('name','items['+ary_index+'][type]');
                    table.rows[i].cells[4].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][equired]');
                    table.rows[i].cells[5].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][order]');
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

//-->


</script>   
<!-- end javascriptts add/remove  -->

<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h1>Create A New Form </h1>

<p align="center"><h2>Complete your visit</h2></p>

<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
    $attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
    echo form_open(base_url().'index.php/Create_Registration_Form/create_contact', $attributes); 
        
    $form_name = array(
              'name'        => 'form_fname',
              'id'          => 'form_fname',
            //  'maxlength'   => '100',
             // 'size'        => '50',
           //   'style'       => 'width:15%',
              'value'       => set_value('form_fname','Form Title')
            );
 
   $form_info_txt = array(
              'name'        => 'form_info_txt',
              'id'          => 'ck_content',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('form_info_txt','<p>Form Information</p>')
            );
            
   $form_thank_txt = array(
              'name'        => 'form_thank_txt',
              'id'          => 'ck_content_2',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('form_thank_txt','<p>Form Information</p>')
            );
            
   $form_main_menu_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Main Menu',
              'checked'     => set_radio('form_main_menu', '0')
            ); 
   $form_user_menu_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'User Menu',
              'checked'     => set_radio('form_main_menu', '0')
            );
   $form_reg_user_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Registered Users',
              'checked'     => set_radio('form_main_menu', '0')
            );
   $form_clients_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Clients',
              'checked'     => set_radio('form_main_menu', '0')
            );
   $form_workshops_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Workshops',
              'checked'     => set_radio('form_main_menu', '0')
            );
   $form_services_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Services',
              'checked'     => set_radio('form_main_menu', '0')
            );

   $form_symptoms_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Symptoms',
              'checked'     => set_radio('form_main_menu', '0')
            );
   $form_demo_menu_rd = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Demo Menu',
              'checked'     => set_radio('form_main_menu', '0')
            );                                                                                     
 
     $dont_creat_link = array(
              'name'        => 'form_main_menu',
              'id'          => 'form_main_menu',
            //  'maxlength'   => '100',
            //  'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => 'Dont Create Link',
              'checked'     => set_radio('form_main_menu', '1',FALSE)
            );          
            
            
            
   $form_publish_yes = array(
              'name'        => 'form_publish',
              'id'          => 'form_publish',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '1',
              'checked'     => set_radio('form_publish', '1', TRUE)
            );  
   $form_publish_no =       array(
              'name'        => 'form_publish',
              'id'          => 'form_publish',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '0',
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
              'id'          => 'menu_item_txt',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('menu_item_txt','Menu Item Text')
            );             
               
               
                
   $every_one_rd = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Every One',
              'checked'     => set_radio('form_permissions', '0', FALSE)
            );                          
   
   $reg_users_rd = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Registered Users',
              'checked'     => set_radio('form_permissions', '0', FALSE)
            ); 
            
    $certain_access_level = array(
              'name'        => 'form_permissions',
              'id'          => 'form_permissions',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Level of Access',
              'checked'     => set_radio('form_permissions', '0', FALSE)
            );  
            
            
    $require_payement_yes = array(
              'name'        => 'require_payement',
              'id'          => 'require_payement',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '1',
              'checked'     => set_radio('require_payement', '1', TRUE)
            ); 
   $require_payement_no = array(
              'name'        => 'require_payement',
              'id'          => 'require_payement',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '0',
              'checked'     => set_radio('require_payement', '0', FALSE)
            ); 
   
   
   $show_thank_u = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Show Thank You',
              'checked'     => set_radio('after_complete', '0', FALSE)
            ); 
                      
   $redirect_url = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Redirect URL',
              'checked'     => set_radio('after_complete', '0', FALSE)
            ); 
   
   $add_user_group = array(
              'name'        => 'after_complete',
              'id'          => 'after_complete',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => 'Add User To Group',
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
              'id'          => 'email_to',
            //  'maxlength'   => '100',
            //  'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('email_to','Email TO ')
            );     

   $make_survey_yes = array(
              'name'        => 'make_survey',
              'id'          => 'make_survey',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '1',
              'checked'     => set_radio('make_survey', '1', TRUE)
            ); 
   $make_survey_no = array(
              'name'        => 'make_survey',
              'id'          => 'make_survey',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '0',
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
          <?php echo display_ckeditor($ckeditor); ?>

</fieldset> 
<fieldset>
<legend>'Thank You' Text</legend>
         <?php echo form_textarea($form_thank_txt); ?>  <br />
          <?php echo display_ckeditor($ckeditor_2); ?>

</fieldset> 
<fieldset>
<legend>Select A Menu</legend>
 <p>
    <?php  echo form_radio($form_main_menu_rd); ?> Main Menu  <br />                     
    <?php  echo form_radio($form_user_menu_rd); ?> User Menu  <br />
    <?php  echo form_radio($form_reg_user_rd); ?> Registered Users  <br />
    <?php  echo form_radio($form_clients_rd); ?> Clients  <br />
    <?php  echo form_radio($form_workshops_rd); ?> Workshops  <br />
    <?php  echo form_radio($form_services_rd); ?> Services  <br />
    <?php  echo form_radio($form_symptoms_rd); ?> Symptoms  <br />
    <?php  echo form_radio($form_demo_menu_rd); ?> Demo Menu  <br />
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
  <tr>
    <th width="56"><input type="checkbox" name="items[1][check]" id="check" /></th>
    <th width="320"><input name="items[1][title]" type="text" id="title" size="50" /></th>
    <th width="183">
      <select name="items[1][type]" id="type">
      <option value="ingle-Line Text">Single-Line Text </option>
      <option value="Multi-Line Text">Multi-Line Text</option>
      <option value="Check Boxes">Check Boxes</option>
      <option value="Radio Buttons">Radio Buttons</option>
    </select></th>
    <th width="87"><input type="checkbox" name="items[1][equired]" id="crequired" /></th>
    <th width="80"><input name="items[1][order]" type="text" id="order" size="10" /></th>
  <!--  <th width="214"> <input type="button" value="Delete" onclick="deleteRowOne(this.parentNode.parentNode.rowIndex)"> </th> -->
  </tr>

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
          
      
<INPUT type="button" value="Add Row" onclick="addRow('tblAddFiels')" /> &nbsp; <INPUT type="button" value="Delete Selected Row" onclick="deleteRow('tblAddFiels')" /> 
            
</fieldset>

<fieldset>
<legend>Make This A Survey (STORE AND SHOW RESELTS)</legend>
        <p> <?php  echo form_radio($make_survey_yes); ?> Yes  <br />
            <?php  echo form_radio($make_survey_no); ?>   No  </p> 
          
          
</fieldset>

          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?>
</body>
</html>