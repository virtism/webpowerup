<!--start Ckeditor and ckfinder files-->
<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<!--end Ckeditor and ckfinder files-->

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="Creat Responder"/>
        <span>Create an Autoresponder Management</span>
    </h1>
</div>
    


<div class="form">
 <form action="<?=base_url().index_page()?>Edit_Autoresponder/edit_autoresponder/<?=$site_id?>" method="post" class="niceform" onsubmit="return check_group_selected()">
 <input type="hidden" value="<?=$values[0]['respond_id']?>" name="id">
        <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Autoresponder Name</label></dt>
                <dd><input type="text" name="name" id="name" size="60" value="<?=$values[0]['respond_name'];?>" /></dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel">Autoresponder Group </label></dt>
                <dd>
                     <div style=" float:left; width:100%; position:relative; margin-top:10px">
                    <? // echo "<pre>";print_r($all_groups); ?>
                    <select size="1" name="user_group" id="user_group" style="width:163px">
						<option value="0">Select Group</option>
						<?  for($i = 0; $i<count($all_groups); $i++){ ?>
            
                            <option <?=( $values[0]['respond_group'] == $all_groups[$i]['id'] ) ? 'selected="selected"' : '' ; ?> value="<?=$all_groups[$i]['id']?>"><?=$all_groups[$i]['group_name']?></option>
            
                        <? } ?>
		 			</select> 
         
                    </div>
                    
                </dd>
            </dl>
           
           <dl>
                <dt><label for="color" class="NewsletterLabel">When To Send </label></dt>
                <dd>
                    <label class="check_label">Immediately After User Sign up</label>
                    <?php
					$imediate_check = "";
					if($values[0]['respond_send_immediately']=='Yes')
					{
						$imediate_check = " checked=\"checked\" ";
					}
					?>
                    <input type="radio" id="when_to_send1" name="when_to_send" value="immediate" <?=$imediate_check?> />
                    
                </dd>
            </dl>
            
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                   <div style=" margin-top:5px; float:left; display:inline;"> 
                   <?php
					$according_check = "";
					if($values[0]['respond_send_immediately']!='Yes')
					{
						$according_check = " checked=\"checked\" ";
					}
					?>
                   <input type="radio" id="when_to_send2" name="when_to_send" value="according" <?=$according_check?> /> 
                   </div>
				   <?
				   	if($values[0]['respond_send_key'] == 'Weeks')
					{
						$respond_send_value = $values[0]['respond_send_value']/7;
					}
					else if($values[0]['respond_send_key'] == 'Months')
					{
						$respond_send_value = $values[0]['respond_send_value']/30;
					}
					else if($values[0]['respond_send_key'] == 'Years')
					{
						$respond_send_value = $values[0]['respond_send_value']/365;
					}
					else
					{
						$respond_send_value = $values[0]['respond_send_value'];
					}
				   
				   ?>
                    <input type="text"  name="value_send" id="value_send" size="55" value="<?=$respond_send_value?>" />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel"></label></dt>
                <dd>
                    
                    <div style=" float:left; position:relative;">
                    <select size="1" id="send_key" name="send_key"  style="width:163px"> 
                        <option <? if($values[0]['respond_send_key'] == 'Days'){ echo 'selected';} ?> value="Days">Days</option>
                        <option <? if($values[0]['respond_send_key'] == 'Weeks'){ echo 'selected';} ?> value="Weeks">Weeks</option>
                        <option <? if($values[0]['respond_send_key'] == 'Months'){ echo 'selected';} ?> value="Months">Months</option>
                        <option <? if($values[0]['respond_send_key'] == 'Years'){ echo 'selected';} ?> value="Years">Years</option>
                    </select>
                    </div>
                    <div style=" float:left; position:relative; margin:5px 5px 0px 20px">
                    <label class="check_label">After: </label>
                    </div>
                    <div style=" float:left; position:relative;">
                    <select size="1" id="send_after" name="send_after" style="width:163px"> 
                        <option selected="selected" value="User Sign Up">User Sign Up</option>
                    </select>
                    </div>
                    
                </dd>
            </dl>
            <dl>
                <dt><label for="email" class="NewsletterLabel">From Address :</label></dt>
                <dd><input type="text" id="from_address" name="from_address" size="60" value="<?=$values[0]['respond_from_addrress']?>" /></dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Reply to Address :</label></dt>
                <dd><input type="text" id="to_address" name="to_address" size="60" value="<?=$values[0]['respond_to_address']?>" /></dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Subject :</label></dt>
                <dd><input type="text" id="subject" name="subject" size="60" value="<?=$values[0]['respond_subject']?>" /></dd>
            </dl>
           
            <dl>
                <dt><label for="comments" class="NewsletterLabel">Message Body :</label></dt>
                <dd><textarea name="body" id="ck_content" class="ckeditor" rows="10" cols="42"><?=$values[0]['respond_message_body']?></textarea></dd>
            </dl>
            
            
            <dl>
                <dt><label for="color" class="NewsletterLabel">Active ?: </label></dt>
                <dd>
				<?php
                if($values[0]['respond_active']=='1')
                {
                     $checked_yes = " checked=\"checked\" ";
                     $checked_no = "";
                }
                else
                {
                     $checked_yes = "";
                     $checked_no = " checked=\"checked\" ";
                } 
                ?>
                    <label class="check_label">Yes</label><input type="radio" id="active1" name="active" value="1" <?=$checked_yes?> />
                    <label class="check_label">No</label><input type="radio" id="active2" name="active" value="0" <?=$checked_no?> />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
               <div class="ButtonRow">
                   <a href="#" class="CancelButton">
                        <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
                   </a>
                     <input type="image" src="<?=base_url();?>images/webpowerup/SaveGreen.png">
               </div>
                </dd>
            </dl>

             
            
        </fieldset>
        
 </form>
 </div>
  <script>
	
	function check_group_selected(){

        var xyz = document.getElementById("user_group");
		if(xyz.value!=0)
		{
			//console.log(xyz.value);
			return true;
        }
		else
		{
			
			alert('Please select target group.');
			return false;
		}
    
}
	
</script>