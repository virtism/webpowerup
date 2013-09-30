<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title><?=$titles?></title>

    

  <!--javascripts add /roemove     -->

<script type="text/javascript"> 

    <!-- 

    function showMe (it, box) { 

      var vis = (box.checked) ? "block" : "none"; 

      document.getElementById(it).style.display = vis;

    } 

    function hideMe (it, box) { 

      var vis = (box.checked) ? "none" : "block"; 

      document.getElementById(it).style.display = vis;

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
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<h1>Edit Promotional Boxes </h1>

<p align="center"><h2>Put data in fields ...</h2></p>

<div id="default">

<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>

 <?php

 

$attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');

echo form_open(base_url().index_page().'Edit_Promotional_Boxe/edit_promotional_boxe', $attributes); 

echo form_hidden('id',$values[0]['box_id']);

        

   $title = array('name' => 'title','id' => 'title', 'size' => '40', 'value' => set_value('title',$values[0]['box_title']));

    $title_chk ='';

   if($values[0]['box_show_title'] == 'Yes'){

      $title_chk ='TRUE'; 

   }

   

   $show_title_chk = array('name' => 'show_title', 'id' => 'show_title','value' => '1','checked' => set_checkbox('show_title','1',$title_chk), 'style' => 'margin:10px',);

   $product_options = array('1'  => '', '2'  => 'Product A', '3'  => 'Product B');

   

   $top_r =  $left_r  = $right_r  = $bottom_r  = '';

        switch ($values[0]['box_position'])

            {

            case 'Top':

                  $top_r = 'TRUE';

                  break;

            case 'Left':

                  $left_r = 'TRUE'; 

                  break;

            case 'Right':

                  $right_r = 'TRUE'; 

                  break;

            case 'Bottom':

                  $bottom_r = 'TRUE'; 

                  break;

            }

   

   $top_rd = array('name' => 'position','id' => 'position','value' => 'top','checked' => set_radio('position', '0', $top_r)); 

   $left_rd = array('name' => 'position','id' => 'position','value' => 'left','checked' => set_radio('position', '0', $left_r));

   $right_rd = array('name' => 'position','id' => 'position','value' => 'right','checked' => set_radio('position', '0', $right_r));

   $bottom_rd = array('name' => 'position','id' => 'position','value' => 'bottom','checked' => set_radio('position', '0' , $bottom_r));

        $top = '1'; $left = '5'; $right = '3'; $bottom = '1';

        switch ($values[0]['box_position'])

            {

            case 'Top':

                  $top = $values[0]['box_order'];

                  break;

            case 'Left':

                  $left = $values[0]['box_order'];

                  break;

            case 'Right':

                   $right = $values[0]['box_order'];

                  break;

            case 'Bottom':

                   $bottom = $values[0]['box_order'];

                  break;

            }

   

   $top_input = array('name' => 'top_input','id' => 'top_input', 'size' => '40','size' => '10' , 'value' => set_value('top_input', $top));

   $left_input = array('name' => 'left_input','id' => 'left_input', 'size' => '40','size' => '10' , 'value' => set_value('left_input', $left));

   $right_input = array('name' => 'right_input','id' => 'right_input', 'size' => '40','size' => '10' , 'value' => set_value('right_input', $right));

   $bottom_input = array('name' => 'bottom_input','id' => 'bottom_input', 'size' => '40','size' => '10' , 'value' => set_value('bottom_input', $bottom));

   

   $all_pages = array('name' => 'display_page','id' => 'display_page','value' => '1','checked' => set_radio('display_page', '0', TRUE));    

   $selected_pages = array('name' => 'display_page', 'id' => 'display_page','value' => '0','checked' => set_radio('display_page', '0'));

	 $every_one = ''; $reg_users = ''; $access_level = '';                

	 switch ($values[0]['box_permissions'])

		{

			case 'Every One':

				  $every_one = 'TRUE'; 

				  break;

			case 'Registered Users':

				  $reg_users = 'TRUE';

				  break;

			case 'Level of Access':

				   $access_level = 'TRUE';

				  break;

		}

   $every_one_rd = array('name' => 'permissions','id' => 'permissions','value' => 'Every One','checked' => set_radio('permissions', '0', $every_one), 'onclick' => "hideMe('roles', this)");                          

   $reg_users_rd = array('name' => 'permissions','id' => 'permissions','value' => 'Registered Users','checked' => set_radio('permissions', '0', $reg_users), 'onclick' => "hideMe('roles', this)");          

   $certain_access_level = array('name' => 'permissions','id' => 'permissions', 'value' => 'Level of Access','checked' => set_radio('permissions', '0', $access_level), 'onclick' => "showMe('roles', this)"); 

   $content = array('name'  => 'content', 'id' => 'ck_content','value'  => set_value('content', $values[0]['box_content']));  

   $publish_yes = array('name' => 'publish', 'id' => 'send_now','value' => '1','checked' => set_radio('active', '1', TRUE)); 

   $publish_no = array('name' => 'publish', 'id' => 'send_now','value' => '0','checked' => set_radio('active', '0', FALSE)); 

?>

<fieldset>

<legend>Promotional Boxe Title</legend>

         <?php echo form_input($title); ?>  <br />

         <?php echo form_checkbox($show_title_chk); ?> Show This Title <br />

         <b>Select Product To Display (Optional)</b> This will display a product in your store and automatically link to that page. <br />

         <?php echo form_dropdown('products', $products, 0); ?>  <br />



</fieldset>

<fieldset>

<legend>Position Order </legend>

         <?php echo form_radio($top_rd) ?> Top  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?php echo form_input($top_input) ?>  <br />

         <?php echo form_radio($left_rd) ?> Left &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?php echo form_input($left_input) ?>  <br />

         <?php echo form_radio($right_rd) ?> Right &nbsp; &nbsp;&nbsp; &nbsp; <?php echo form_input($right_input) ?>  <br />

         <?php echo form_radio($bottom_rd) ?> Bottom &nbsp; &nbsp;  <?php echo form_input($bottom_input) ?>  <br /> 



</fieldset> 

<fieldset>

<legend>Publish ?</legend>

  <p>

    <?php  echo form_radio($publish_no); ?> No  <br />                     

    <?php  echo form_radio($publish_yes); ?> Yes <br />    

  </p>

</fieldset>

<fieldset>

<legend>Display On Which Pages ? </legend>

         <?php echo form_radio($all_pages)?> All Pages<br />

         <?php echo form_radio($selected_pages)?>  <b>Only</b> these pages

</fieldset>

<fieldset>

<legend>Who can View this Module ?</legend>



    <?php /*?><?php  echo form_radio($every_one_rd); ?> Every One  <br />                     

    <?php  echo form_radio($reg_users_rd); ?> All Registered Users  <br />

    <?php  echo form_radio($certain_access_level); ?> Only users With certain level of access  <br /> 

	<?php */?>

   <div style="float: left; margin-left: 10px; clear: both;" > 

        <p><label> <?php  echo form_radio($every_one_rd); ?> Everyone </label> </p> 

        <p><label> <?php  echo form_radio($reg_users_rd); ?> All Registered Users </label> </p> 

        <p><label> <?php  echo form_radio($certain_access_level); ?>Only Users With a Certain Access Level &nbsp; </label></p> 

        <p style="">

            <div style="display: none;" name="roles" id="roles" > 

                <?php /*?> <?php echo form_dropdown('options_acess_level',$groups, 0 , 'size="1" multiple="MULTIPLE" style=" width:240px; height:96px; margin-left:25px; margin-bottom:10px;"') ?><?php */?>

				<select name="options_acess_level[]" id="options_acess_level" multiple="multiple" style=" width:240px; height:96px; margin-left:25px; margin-bottom:10px;">

				<?

				foreach($groups as $group)

                	{

				?>

						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>

				<? 	} ?>

				</select>

            </div>

        <p/>

	</div>   

</fieldset>  

<fieldset>

<legend>Content</legend>

         <?php echo form_textarea($content); ?>  <br />

         <?php echo display_ckeditor($ck_data['ckeditor']); ?> 

</fieldset> 

          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 

<input type="button" name="cancel" value="Cancel" />

          <?php //echo form_button(array('name' => 'cancel'),'Cancel'); ?>

<?php echo form_close();?>

</div>

</body>

</html>