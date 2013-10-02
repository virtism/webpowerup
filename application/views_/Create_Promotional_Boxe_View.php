<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>  
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
<!--end Ckeditor and ckfinder files-->
<div class="RightColumnHeading">
    <h1>
        <img src="images/CreateResponder.png" alt="New Form"/>
        <span>Creat Promotional Boxes</span>
    </h1>
    
</div>
<div class="form">
    <form action="<?=base_url().index_page()?>Create_Promotional_Boxe/create_promotional_boxe" name="reg_form" id="reg_form" method="post" class="niceform">
    
    	<dl>
            <dt><label for="email" class="NewsletterLabel"> Promotional Boxe Title :</label></dt>
            <dd><input type="text" name="title" id="title" size="55" /></dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel"></label></dt>
            <dd>
             <input type="checkbox" name="Position" id="show_title" value="show_title" checked="checked" />   
             <label class="check_label">Show this title </label>
            </dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel"></label></dt>
            <dd> 
             <label class="check_label">
             Select Product To Display (Optional) This will display a product in your store and automatically
              link to that page. 
             </label>
            
            </dd>
        </dl>
        
         <dl>
              <dt><label for="color" class="NewsletterLabel"></label></dt>
              <dd>
                <div  style=" position:relative; float:left">
                <select size="1" name="text" id=""  style="width:360px;"> 
                        <option value="">Select Product</option>
                        <option value="">Select option 2</option> 
                        <option value="">Select option 3</option>
                        <option value="">Select option 4</option> 
                        <option value="">Select option 5</option> 
               </select>
               </div>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"> Position Order :</label></dt>
            <dd>
             <label class="check_label">Top</label>
             <input type="radio" name="Position" id="" value=""/> 
             <input type="text" name="" id="" size="3" />
               
             <label class="check_label">Left</label>
             <input type="radio" name="Position" id="" value="" checked="checked" />  
             <input type="text" name="" id="" size="3" />
              
             <label class="check_label">Right</label>
             <input type="radio" name="Position" id="" value=""/> 
             <input type="text" name="" id="" size="3" />
               
             <label class="check_label">Right</label>
             <input type="radio" name="Position" id="" value=""/> 
             <input type="text" name="" id="" size="3" />  
             
             </dd>
        </dl>
        
        
         <dl>
            <dt><label for="color" class="NewsletterLabel"> Publihed:</label></dt>
            <dd>
             <label class="check_label">Yes</label>
             <input type="radio" name="Publihed" id="" value="" checked="checked" />   
             <label class="check_label">No</label>
             <input type="radio" name="Publihed" id="" value=""/>   
             
             </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel">Display On Which Pages ?: </label>
            </dt>
            <dd>
             <label class="check_label">All Pages</label>
             <input type="radio" name="Publihed" id="" value="" checked="checked" />   
              <label class="check_label">Only these Pages</label>
             <input type="radio" name="Publihed" id="" value=""/>   
            
             </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel">Who can view this Module? </label>
            </dt>
            <dd>
             <label class="check_label">Every One</label>
             <input type="radio" name="Publihed" id="" value="" />   
             <label class="check_label">Registered</label>
             <input type="radio" name="Publihed" id="" value=""/>   
             <label class="check_label">Other</label>
              <input type="radio" name="Publihed" id="" value="" checked="checked" /> 
             </dd>
        </dl>
        
        <dl>
              <dt><label for="color" class="NewsletterLabel">Intro Text:</label></dt>
              <dd><textarea name="comments" id="comments" rows="10" cols="42"></textarea></dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
           
           <div class="ButtonRow" style=" text-align:right; float:right; width:auto;">
                <a href="#" class="CancelButton">
                    <img src="images/CancelRed.png" alt="search Button"/>
                </a>
                <a href="#" class="SaveButton">
                    <img src="images/SaveGreen.png" alt="SaveGreen"/>
                </a> 
            </div>
         
            </dd>
        </dl>
    </form>
</div>
<div id="default">
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>  
 <?php
 
$attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
echo form_open(base_url().index_page().'Create_Promotional_Boxe/create_promotional_boxe', $attributes); 
        
   $title = array('name' => 'title','id' => 'title', 'size' => '40', 'value' => set_value('title','Promotional Boxes Title'));
   $show_title_chk = array('name' => 'show_title', 'id' => 'show_title','value' => '1','checked' => '', 'style' => 'margin:10px',);
   $product_options = array('1'  => 'Select Product', '2'  => $products);
   
   $top_rd = array('name' => 'position','id' => 'position','value' => 'top','checked' => set_radio('position', '0')); 
   $left_rd = array('name' => 'position','id' => 'position','value' => 'left','checked' => set_radio('position', '0', TRUE));
   $right_rd = array('name' => 'position','id' => 'position','value' => 'right','checked' => set_radio('position', '0'));
   $bottom_rd = array('name' => 'position','id' => 'position','value' => 'bottom','checked' => set_radio('position', '0'));
   
   $top_input = array('name' => 'top_input','id' => 'top_input', 'style'=>'width:50px;' , 'value' => set_value('top_input','1'));
   $left_input = array('name' => 'left_input','id' => 'left_input', 'style'=>'width:50px;', 'value' => set_value('left_input','5'));
   $right_input = array('name' => 'right_input','id' => 'right_input', 'style'=>'width:50px;' , 'value' => set_value('right_input','3'));
   $bottom_input = array('name' => 'bottom_input','id' => 'bottom_input', 'style'=>'width:50px;' , 'value' => set_value('bottom_input','1'));
   
   $all_pages = array('name' => 'display_page','id' => 'display_page','value' => '1','checked' => set_radio('display_page', '0', TRUE), 'onclick' => "hideMe('pages', this)");
   $selected_pages = array('name' => 'display_page', 'id' => 'display_page','value' => '0','checked' => set_radio('display_page', '0'), 'onclick' => "showMe('pages', this)" );
   
   $every_one_rd = array('name' => 'permissions','id' => 'permissions','value' => 'Every One','checked' => set_radio('permissions', '0', TRUE), 'onclick' => "hideMe('roles', this)");                          
   $reg_users_rd = array('name' => 'permissions','id' => 'permissions','value' => 'Registered Users','checked' => set_radio('permissions', '0', FALSE), 'onclick' => "hideMe('roles', this)");          
   $certain_access_level = array('name' => 'permissions','id' => 'permissions', 'value' => 'Level of Access','checked' => set_radio('permissions', '0', FALSE), 'onclick' => "showMe('roles', this)"  ); 
  
   $content = array('name'  => 'content', 'id' => 'ck_content','value'  => set_value('content','<p>put  Information here ...</p>'));  
   $publish_yes = array('name' => 'publish', 'id' => 'send_now','value' => '1','checked' => set_radio('active', '1', TRUE)); 
   $publish_no = array('name' => 'publish', 'id' => 'send_now','value' => '0','checked' => set_radio('active', '0', FALSE)); 
   
  
  
   
      
    
?>
<fieldset>
<legend>Promotional Boxe Title</legend>
         <?php echo form_input($title); ?>  <br />
         <?php echo form_checkbox($show_title_chk); ?> Show This Title <br />
         <b>Select Product To Display (Optional)</b> This will display a product in your store and automatically link to that page. <br />
         <?php //echo form_dropdown('products', $product_options, '1'); ?>  <br />
			   <?php /*echo form_dropdown('products',$products, 0 )*/ print_r($products); ?>
               <select id="products" name="products">
               		<option value="">Select Product</option>
                    
               </select>
</fieldset>
<fieldset>
<legend>Position              Order </legend>
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
  <div style="float: left; margin-left: 10px; clear: both;" > 
        <p><label> <?php echo form_radio($all_pages)?> All Pages</label> </p> 
        <p><label> <?php echo form_radio($selected_pages)?> <b>Only</b> these pages </label> </p> 
        <p style="">
            <div style="display: none;" name="roles" id="pages" > 
               <?php echo form_dropdown('page',$page, 0 , 'size="1" multiple="MULTIPLE" style=" width:240px; height:96px; margin-left:25px; margin-bottom:10px;"') ?>
            </div>
        <p/>
 </div> 
           
</fieldset>
<fieldset>
<legend>Who can View this Module ?</legend>
<!--  <p>
    <?php // echo form_radio($every_one_rd); ?> Every One  <br />                     
    <?php // echo form_radio($reg_users_rd); ?> All Registered Users  <br />
    <?php // echo form_radio($certain_access_level); ?> Only users With certain level of access  <br /> 
  </p>  -->
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
          <?php  echo display_ckeditor($ck_data['ckeditor']); ?>
</fieldset> 
          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?> 
</div>