<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>  

  <!--javascripts add /roemove     -->
<script type="text/javascript"> 
  
$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	//alert(id);
	if(id == "display_page1")
	{
		$('#pages').fadeOut();
	}	
	if(id == "display_page2")
	{
		
		
		$('#pages').fadeIn();
		NFFix();	
	}
	
	if(id == "permissions1" || id == "permissions2")
	{
		$('#groups').fadeOut();
	}	
	if(id == "permissions3")
	{
		
		
		$('#groups').fadeIn();
		NFFix();	
	}
});

</script>  
<!-- end javascriptts add/remove  -->
<!--start Ckeditor and ckfinder files-->
<!--end Ckeditor and ckfinder files-->
<style>

.posttionDiv{
	float:left; 
	width:195px; 
	margin:0 0 10px 0; 
}
.posttionDiv label{
	width:35px;
	padding-right:10px;
}
.radioDiv{
	display:inline;
	float:left;
}
.textDiv{
	float:left;
}
</style>



<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="New Form"/>
        <span>Creat Promotional Boxes</span>
    </h1>
    
</div>


<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p> 

<div class="form">

    <form action="<?=site_url()?>Edit_Promotional_Boxe/edit_promotional_boxe" name="reg_form" id="reg_form" method="post" class="niceform">
    <input type="hidden" name="id" value="<?=$values[0]['box_id'];?>"
    	<dl>
            <dt><label for="email" class="NewsletterLabel"> Promotional Boxe Title :</label></dt>
            <dd><input type="text" name="title" id="title" size="55" value="<?=$values[0]['box_title'];?>" /></dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel"></label></dt>
            <dd>
            <?php
			$chk = ( $values[0]['box_show_title'] == "Yes") ? "checked=\"checked\" " : ""; 
			?>
             <input type="checkbox" name="show_title" id="show_title" value="1" <?=$chk;?>  />   
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
               <?php
			   
				if($products)
				{ ?>
                <div  style=" position:relative; float:left">
                <select name="products" size="1" style="width:360px;"> 
                <option value="0" >Select Product</option>
                       <?php
					   foreach($products as $product)
					   { ?>
                       		<option value="<?=$product['product_id'];?>" <?php if($values[0]["box_product"] == $product['product_id']) { ?> selected="selected" <?php } ?> >
							<?=$product['product']?>
                            </option>
                       <?php
					   } ?>
               </select>
               </div>
               <?php
				} ?>
            </dd>
        </dl>
        
        <dl>  
            <dt><label for="color" class="NewsletterLabel"> Position Order :</label></dt>
            <dd>
            
            
            <?php /*?> <div class="posttionDiv">
                 <label class="check_label">Top</label>
                 
                 <div class="radioDiv">
                 <input type="radio" name="position" id="position1" value="top" <?php echo ( $values[0]['box_position'] == "Top") ? ' checked="checked" ' : "" ; ?> /> 
                 </div>
                 <div class="textDiv">
                 <input type="text" name="top_input" id="top_input" size="3" />
                 </div>
            </div><?php */?>

            <div class="posttionDiv" >
             <label class="check_label">Left</label>
             
             <div class="radioDiv">
             <input type="radio" name="position" id="position2" value="left" <?php echo ( $values[0]['box_position'] == "Left") ? ' checked="checked" ' : "" ; ?> />  
             </div>
             
             <div class="textDiv">
             <input type="text" name="left_input" id="left_input" size="3" />
             </div>
             
			</div>
            
			<div class="posttionDiv">
             <label class="check_label">Right</label>
             
             <div class="radioDiv">
             <input type="radio" name="position" id="position3" value="right" <?php echo ( $values[0]['box_position'] == "Right") ? ' checked="checked" ' : "" ; ?>/> 
             </div>
             <div class="textDiv">
             <input type="text" name="right_input" id="right_input" size="3"  />
             </div>
            </div>

            <?php /*?><div class="posttionDiv">
             <label class="check_label">Bottom</label>
             <div class="radioDiv">
             <input type="radio" name="position" id="position4" value="bottom" <?php echo ( $values[0]['box_position'] == "Bottom") ? ' checked="checked" ' : "" ; ?>/> 
             </div>
             <div class="textDiv">
             <input type="text" name="bottom_input" id="bottom_input" size="3" /> 
             </div> 
            </div><?php */?> 
            
            </dd>
        </dl>
        
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Published:<span class="star"> *</span> </label></dt>
            <dd>
            <?php
				$val = $values[0]["box_publish"];
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
            <label class="check_label">Yes</label>
             <input type="radio" name="publish" id="publish1" value="1" <?=$yes?>  />
             <label class="check_label">No</label>
             <input type="radio" name="publish" id="publish2" value="0" <?=$no?> />
            </dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Display on Pages:<span class="star"> *</span> </label></dt>
            <dd>
            <label class="check_label">All Pages</label>
             <input type="radio" value="1" name="display_page" id="display_page1"  checked="checked"/>
             <label class="check_label">Some Pages</label>
             <input type="radio" value="0" name="display_page" id="display_page2" />
             
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
            <dt><label for="email" class="NewsletterLabel">Who can see this?<span class="star"> *</span> </label></dt>
            <dd>
            <label class="check_label">Every one</label>
             <input type="radio" value="Every One" name="permissions" id="permissions1" checked="checked"/>
             <label class="check_label">Registered</label>
             <input type="radio" value="Registered Users" name="permissions" id="permissions2" />
              <label class="check_label">Other</label>
             <input type="radio" value="Level of Access" name="permissions" id="permissions3" />
             
                <div id="groups" style="display:none; clear:both;">
                     <div style=" position:relative;">
                     <select name="options_acess_level[]" multiple="multiple" size="5" >
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
              <dt><label for="color" class="NewsletterLabel">Intro Text:</label></dt>
              <dd>
              		<textarea name="content" id="ck_content" class="ckeditor" rows="10" cols="42"><?=$values[0]['box_content'];?></textarea>
              </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
           
           <div class="ButtonRow" style=" text-align:right; float:right; width:auto;">
                <a href="<?=site_url()?>Promotional_Boxes_Management" class="CancelButton">
                    <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
                </a>
                 <button type="submit" >
                    <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
                 </button>
            </div>
         
            </dd>
        </dl>
    </form>
</div>
