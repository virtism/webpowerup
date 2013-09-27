<style>
dt{
	width:250px;
}
dd{
	width:500px;
}
.miniLbl{
	padding-left:30px;
}

</style>
<script>
	// getting ajax call for state on base of country selected	
	function get_ajax_states()
	{
		var country_id = document.getElementById('country').value;
		var path =  "<?=base_url().index_page()?>shop/ajax_call_states/";
		var dataString = "country_id = "+country_id;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#state_option").html(' ');
				//alert(data);
				//$("#customers_detail").show();
				$("#state_option").html(data);
				//alert("success");
			}
		});
	}
</script>
<div class="RightColumnHeading">
    <h1>
        <span>Store Setting</span>
    </h1>
</div>

<div class="clr"></div>
 <form id="store_setting" name="store_setting" method="post" class="niceform" action="<?=site_url()?>shop/settings" enctype="multipart/form-data" >
<div class="InnerMain" >
<? //echo "<pre>"; print_r($store_settings); 
?>
<input type="hidden" name="action" value="setStore" />
<input type="hidden" name="user_id" value="<?=$user_data[0]["user_id"]?>" />




	<dl>
       <dt>
             <label  class="NewsletterLabel">Store status</label>
       </dt>
       <dd>
            <label class="check_label">Enable</label>
			<input type="radio" name="required" id="" value="Yes"  <?php if(isset($store_settings['required']) && $store_settings['required'] =='Yes'){ echo 'checked="checked"';} ?> />
            
            <label class="check_label">Disable</label>
			<input type="radio" name="required" id="" value="No" <?php if(isset($store_settings['required']) && $store_settings['required'] =='No'){ echo 'checked="checked"'; } ?> /> 
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Enter Paypal Account Id</label>
             <div class="miniLbl">(sample_1310921532_biz@acb.com)</div>
       </dt>
       <dd>
            <input type="text" id="required_paypal" name="required_paypal" size="55" value="<?php if(isset($store_settings['paypal_id'])){ echo $store_settings['paypal_id'];} ?>" />
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Products View Style</label>
       </dt>
       <dd>
            <label class="check_label">List View</label>
			<input type="radio" name="product_view" value="List View"  <?php if(isset($store_settings['product_view']) && $store_settings['product_view']=='List View'){ echo 'checked="checked"'; } ?> />
            
            <label class="check_label">Grid View</label>
			<input type="radio" name="product_view" value="Grid View"  <?php if(isset($store_settings['product_view'])&& $store_settings['product_view'] =='Grid View'){ echo 'checked="checked"'; } ?> />
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Products Per Page</label>
       </dt>
       <dd>
            <input type="text" name="product_per_page" id="" value="<?php if(isset($store_settings['product_per_page'])) echo $store_settings['product_per_page']; ?>" size="10" />
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Links Per Page</label>
       </dt>
       <dd>
            <input type="text" name="link_per_page" id="" value="<?php if(isset($store_settings['link_per_page'])) echo $store_settings['link_per_page']; ?>" size="10" />
       </dd>
	</dl>
 </div>  
 
 
   <!----Admin Details----->
    
    <div class="RightColumnHeading">
        <h1>
            <span>Details</span>
        </h1>
	</div>
    
    <div class="clr"></div>
    
    <div class="InnerMain" >
    <div class="DoubleColumn">
                <? //echo "<pre>"; print_r($countries);  ?>
                  <div class="ColumnA">
                    <ul>
                     <li> 
                     <label class="NewsletterLabel">First Name:</label>
                   	 <input type="text" id="fname" name="fname" size="20" value="<?php if(isset($user_data[0]["user_fname"])){  echo $user_data[0]["user_fname"];}?>" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Last Name:</label>
                     <input type="text" id="lname" name="lname" size="20" value="<?php if(isset($user_data[0]["user_lname"])){  echo $user_data[0]["user_lname"];}?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Company:</label>
                     <input type="text" id="company" name="company" size="20" value="<?php if(isset($user_data[0]["company"])){  echo $user_data[0]["company"];}?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Email:</label>
                     <input type="text" id="email" name="email" size="20" value="<?php if(isset($user_data[0]["user_email"])){  echo $user_data[0]["user_email"];}?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Phone Number:</label>
                     <input type="text" id="pnumber" name="pnumber" size="20" value="<?php if(isset($user_data[0]["pnumber"])){  echo $user_data[0]["pnumber"];}?>" /></li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> <label class="NewsletterLabel">Street address: </label>
                     <input type="text" id="saddress" name="saddress" size="20" value="<?php if(isset($user_data[0]["street_address"])){  echo $user_data[0]["street_address"];}?>" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Country:</label>
                     
                      <div id="" style="position:relative; float:left; height:40px !important;">
                     <select id="country" name="country" style="width:150px;" size="1" >
							<? foreach($countries as $country) 
                            {
                                echo "<option value=".$country["countries_name"].">".$country["countries_name"]."</option>";
                            }
                            ?>													
                     </select>
                     </div>
                     
                     </li>
                     <li>
                     <label class="NewsletterLabel">State/Province:</label>
                     
                     <div id="state_option" style="position:relative; float:left; height:40px !important; ">
                      <select id="state" name="state" style="width:150px;" size="1">
							<? foreach($states as $state) 
                            {
                                echo "<option value=".$state["zone_name"].">".$state["zone_name"]."</option>";
                            }
                            ?>													
                     </select>
                     
                    </div>
                  	
                     </li>
                     <li>
                     <label class="NewsletterLabel">City:</label>
                      <input type="text" id="city" name="city" size="20" value="<?php if(isset($user_data[0]["city"])){  echo $user_data[0]["city"];}?>" /></li>
                     <li>
                     <label class="NewsletterLabel">ZIP/Postal Code:</label>
                      <input type="text" id="zcode" name="zcode" size="20" value="<?php if(isset($user_data[0]["zcode"])){  echo $user_data[0]["zcode"];}?>" /></li>
                    </ul>
                </div>
                
            </div>
 	
 
 </div>
  
    <!----Logo Upload----->
    
    <div class="RightColumnHeading">
        <h1>
            <span>Upload Store Logo</span>
        </h1>
	</div>

	<div class="clr"></div>
    <div class="InnerMain" >
        <input type="hidden" name="site_id" value="<?=$site_id?>" />
        <input type="hidden" name="code" value="<?=date('his')?>" />
        
          <dl>
           <dt>
                 <label  class="NewsletterLabel">Upload Logo Image</label>
           </dt>
           <dd>
		   <? 
		   	$upload_path  = base_url().'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/logo/';  
			if(isset($store_settings['store_logo']) && !empty($store_settings['store_logo']))
			{
				$image_name_array = explode('.',$store_settings['store_logo']);
				$thumbnail_name = $image_name_array[0]."_thumb.".$image_name_array[1];
			?>
            	<div style="float:right; padding-right:60px; "><img src="<?=$upload_path.$thumbnail_name?>" /></div>
                <input type="hidden" name="hidden_filename" value="<?=$store_settings['store_logo']?>" />
			<? 
			}
			?>
               <div class="uploader" >
                    <input type="file" name="logo_image" id="logo_image" size="19" style="opacity: 0;">
                    <span class="filename" style="-moz-user-select: none;">No file selected</span>
                    <span class="action" style="-moz-user-select: none;">Choose File</span>
               </div>
               
                
           </dd>
        </dl>
    
        <dl>
           <dt>
                 <label  class="NewsletterLabel">Published ?</label>
           </dt>
           <dd>
                <? 
                  if(isset($store_settings['publish']) && $store_settings['publish']=='Yes')
                    {
                ?>
                       <input type="checkbox" name="logo_check" id="logo_check" value="Yes" checked="checked"/> Yes 
                <? } 
                else 
                {?>
                  <input type="checkbox" name="logo_check" id="logo_check" value="Yes"/> Yes 
                <? }?>
                
           </dd>           
        </dl>
   </div>
   <div class="ButtonRow">
        <button type="submit">
            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
        </button>
   </div>
</form>