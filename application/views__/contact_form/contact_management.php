<script type="text/javascript">

function trim() 
{ 
	var email_var;
	email_var = document.user.txtcap3.value.replace(/^\s+|\s+$/g,"");
	//alert(some.length);
	if(email_var.length == 0)
	{
		alert('Please! Enter Email Address.');
		document.user.txtcap3.focus();
		return false;
	}
}

$(document).ready(function(e) {
    
	$("#contactForm").submit(function(e) {
        trim();
    });
});

</script>  

<style>
.miniLbl{
	width:160px; 
	padding:20px 0 0 30px;
}
</style>


<div class="RightColumnHeading">
    <h1>
        <span>Contact Form Information</span>
    </h1>
</div>
<div class="clr"></div>

<div class="InnerMain">

<form class="niceform" action="<?=base_url().index_page()?>SiteController/contact_management/<?=$_SESSION["site_id"]?>" method="post" id="contactForm" name="user" >

	<fieldset>
		
		<?php
			if(isset($data_array['flag']) && $data_array['flag'] > 0)
				{	
			?>
			        <input type="hidden" name="action" value="update_contact_form" />
			<?php
				}	
				else
				{	
			?>
			        <input type="hidden" name="action" value="save_contact_form" />
            <?php
				}	
			?>	                    
		
            <dl>
                <dt>
                     <label class="NewsletterLabel">Add Caption </label><div class="miniLbl">i.e. Name</div>
                </dt>
                <dd>
                     <input type="text" size="55" name="txtcap1" value="<? if(isset($data_array['caption_Name'])){echo $data_array['caption_Name'];}?>" id="txtcap1"  />
                    
                </dd>
            </dl>
            
            <dl>
                <dt>
                     <label class="NewsletterLabel">Add Caption </label><div class="miniLbl">i.e. Subject</div>
                </dt>
                <dd>
                     <input type="text" size="55" name="txtcap2" value="<? if(isset($data_array['caption_Subject'])){echo $data_array['caption_Subject'];}?>" id="txtcap2"  />
                    
                </dd>
            </dl>
            
            <dl>
                <dt>
                    <div>
                         <label class="NewsletterLabel">Email to </label><div class="miniLbl">i.e. Where you want to receive email</div>
	                </div>
                </dt>
                <dd>
                     <input type="text" size="55" name="txtcap3" value="<? if(isset($data_array['caption_EmailTo'])){echo $data_array['caption_EmailTo'];}?>" id="txtcap3" />
                    
                </dd>
            </dl>
            
            
            <dl>
                <dt>
                     <label class="NewsletterLabel">Add Caption </label><div class="miniLbl">i.e. Message</div>
                     
                </dt>
                <dd>
                     <input type="text" size="55" name="txtcap4" value="<? if(isset($data_array['caption_Message'])){echo $data_array['caption_Message'];}?>" id="txtcap4" />
                    
                </dd>
            </dl>
            
            <dl>
                <dt>
                     <label class="NewsletterLabel">View on Contact Us Page ? </label>
                </dt>
                <dd>
                     <?php
						if(isset($data_array['publish']) && $data_array['publish'] == "Yes")
						{	?>
							<td><input type="checkbox" name="cf_publish" value="Yes" style="opacity:1 !important;" checked="checked" /> <label class="check_label">Yes</label></td>
						<?php
						}
						else
						{	?>
							<td><input type="checkbox" name="cf_publish" value="Yes" style="opacity:1 !important;" /> Yes</td>
						<?php
						}
						
						?>   
                </dd>
            </dl>
          
		<dl>
           <dt>
                 &nbsp;
           </dt>
           <dd>
               <div style="padding:5px 0 0 0;">
				<?php 	if(isset($data_array['flag']) && $data_array['flag'] > 0)
                        {	?>
                    
                        <input type="submit" value="Update Form" />
        
                    <?	}	
                        else
                        {	?>
                    
                        <input type="submit" value="Save Form" />
        
                    <?	}	?>           
                </div>
           </dd>
        </dl>
		
		
	</fieldset>
</form>
</div>