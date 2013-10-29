<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
        $("#reg_form").submit(function(){
			
			var subject = $("#subject").val();
			if ( subject == "")
			{
				alert("Please Enter the subject");
				$("#subject").focus();
				return false;
			}
			var value = $("#drop_down").val();
			if(value == 0 || value == null)
			{ 
				alert("Please select a Recipients Group");
				return false;
			}
			return true;
			
		})
    });
	
</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreatNewsletter.png" alt="Creat a Newsletter"/>
        <span>Create A Newsletter</span>
    </h1>
</div>

<div class="form">
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
    <form action="<?=base_url().index_page()?>Create_Newsletter/create_newsletter" method="post" id="reg_form" class="niceform">
        <dl>
            <dt><label for="email" class="NewsletterLabel">Newsletter Subject :</label></dt>
            <dd><input type="text" name="subject" id="subject" size="55" /></dd>
        </dl>
         <dl>
            <dt><label for="email" class="NewsletterLabel">Newsletter From :</label></dt>
            <dd><input type="text" name="from" id="from" size="55" /></dd>
        </dl>
        <dl>
            <dt><label for="comments" class="NewsletterLabel">Newsletter Body :</label></dt>
            <dd><textarea name="body" id="ck_content" class="ckeditor" rows="10" cols="42"></textarea></dd>
        </dl>
        
        <dl>
            <dt><label for="comments2" class="NewsletterLabel">Newsletter Recipients Group :</label></dt>
            <dd>
            <?php
			
            if($groups)
            { ?>
            <div  style=" position:relative; margin-top:10px; float:left">
           
            <select size="5" style="width:360px;" multiple="multiple" name="user_group[]" id="drop_down">
                <?php
                foreach($groups as $group)
                { ?>
                
                    <option value="<?=$group['id']?>"><?=$group['group_name'];?></option>
                <?php
                } ?>
            </select>
            </div>
            <?php }
            else
            {
                echo "No group found";
            }
            ?>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel">Send Now ?: </label></dt>
        <dd>
            <label class="check_label">Yes</label>
            <input type="radio"  id="send_now" name="send_now" value="1" />
            
            <label class="check_label">No</label>
            <input type="radio"  id="send_now" name="send_now" value="0" checked="checked" />
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
    </form>
</div>


