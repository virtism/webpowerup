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
 <form action="<?=base_url().index_page()?>Create_Autoresponder/create_autoresponder" method="post" class="niceform" onsubmit="return check_group_selected()">
 
        <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Autoresponder Name</label></dt>
                <dd><input type="text" name="name" id="name" size="60" /></dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel">Autoresponder Group </label></dt>
                <dd>
                    
                    <div style=" float:left; width:100%; position:relative; margin-top:10px">
                    <? // echo "<pre>";print_r($all_groups); ?>
                    <select size="1" name="user_group" id="user_group" style="width:163px" >
						<option value="0">Select Group</option>
						<?  for($i = 0; $i<count($all_groups); $i++){ ?>
            
                            <option value="<?=$all_groups[$i]['id']?>"><?=$all_groups[$i]['group_name']?></option>
            
                        <? } ?>
		 			</select> 
         
                    </div>
                    
                </dd>
            </dl>
           
           <dl>
                <dt><label for="color" class="NewsletterLabel">When To Send </label></dt>
                <dd>
                    <label class="check_label">Immediately After User Sign up</label>
                    <input type="radio" id="when_to_send1" name="when_to_send" value="immediate" />
                    
                </dd>
            </dl>
            
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                   <div style=" margin-top:5px; float:left; display:inline;"> 
                   <input type="radio" id="when_to_send2" name="when_to_send" value="according" checked="checked" /> 
                   </div>
                    <input type="text"  name="value_send" id="value_send" size="55" value="1" />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel"></label></dt>
                <dd>
                    
                    <div style=" float:left; position:relative;">
                    <select size="1" id="send_key" name="send_key"  style="width:163px"> 
                        <option selected="selected" value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                        <option value="Months">Months</option>
                        <option value="Years">Years</option>
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
                <dd><input type="text" id="from_address" name="from_address" size="60" /></dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Reply to Address :</label></dt>
                <dd><input type="text" id="to_address" name="to_address" size="60" /></dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Subject :</label></dt>
                <dd><input type="text" id="subject" name="subject" size="60" /></dd>
            </dl>
           
            <dl>
                <dt><label for="comments" class="NewsletterLabel">Message Body :</label></dt>
                <dd><textarea name="body" id="ck_content" class="ckeditor" rows="10" cols="42"></textarea></dd>
            </dl>
            
            
            <dl>
                <dt><label for="color" class="NewsletterLabel">Active ?: </label></dt>
                <dd>
                    <label class="check_label">Yes</label><input type="radio" id="active1" name="active" value="1" />
                    <label class="check_label">No</label><input type="radio" id="active2" name="active" value="0" />
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