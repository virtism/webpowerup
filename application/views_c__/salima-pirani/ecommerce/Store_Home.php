 <div id="dashboard">
   <div id="dbyourstorebox2">
       <div id="toproundedbox2">
          <img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" width="482px" />
           </div>
           <div style="">
              <?=$message?>
           </div>
     <?php    
          $attributes = array('class' => '', 'id' => 'store_setting' , 'name' => 'store_setting', 'style'=>'padding: 0px; border-radius: 0px;
    border-style: none; height: 206px; margin: 0px;');
          echo form_open(base_url().'index.php/shop/settings',$attributes);
          echo form_hidden('action','setStore');  
      ?>                                              <div id="midforbox2">
                                                        <div id="headingyourstore">
                                                                Store Settings
                                                        </div>
                                                        <div id="dbyourstoretxtarea">
                                                        
                                                                <div id="addproduct" >
                                                                  <label for="stor_settings_enable">Store Enable</label>  <input type="radio" name="required" value="Yes"  <?php if($store_settings['required']=='Yes'){ echo 'checked="checked"';} ?> >  
                                                                  <label for="stor_settings_enable">Disable Store</label>  <input type="radio" name="required" value="No"  <?php if($store_settings['required']=='No'){ echo 'checked="checked"'; } ?> >     
                                                                <!--<a style="text-decoration: underline;" href="<?=base_url()?>index.php/shop/disable_store">Disable Store (For This Site)</a>  -->
                                                                </div>

                                                               <div id="addcatagory" >
                                                                     
                                                                      <label for="stor_settings_enable">Products List View</label>  <input type="radio" name="product_view" value="List View"  <?php if($store_settings['product_view']=='List View'){ echo 'checked="checked"'; } ?> >  
                                                                      <label for="stor_settings_enable">Products Grid View</label>  <input type="radio" name="product_view" value="Grid View"  <?php if($store_settings['product_view']=='Grid View'){ echo 'checked="checked"'; } ?>>     
                                                                </div>
                                                                <div id="manageorder" >
                                                                     <label for="stor_settings_enable">Products Per Page : </label>   <input type="text" name="product_per_page" id="" value="<?php echo $store_settings['product_per_page']; ?>" size = "5"  maxlength="2" style="width: 40px;">
                                                                     <label for="stor_settings_enable"> Links Per Page : </label>   <input type="text" name="link_per_page" id="" value="<?php echo $store_settings['link_per_page']; ?>" size = "5"  maxlength="2" style="width: 40px;">
                                                                </div>
                                                               <div id="manageorder" style="text-decoration: underline;">
                                                                 <?php
                                                                 
                                                                 echo form_submit('submit','Save Settings');
                                                                 echo form_close(); 
                                                                    ?>     
                                                               </div>  
                                                        </div>  
                                                    </div>
                                                    <div id="botroundedbox2">
                                                                <img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" width="482px" />
         </div>
  </div>
                                                        
 </div>
                             
                            

                            

