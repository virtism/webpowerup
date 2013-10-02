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

</script>  

<form action="<?=base_url().index_page()?>SiteController/contact_management/<?=$_SESSION["site_id"]?>" method="post" id="user" name="user" onsubmit="return trim()">

	<fieldset>
		
        <?php 	if(isset($data_array['flag']) && $data_array['flag'] > 0)
				{	?>
			        <input type="hidden" name="action" value="update_contact_form" />
			<?	}	
				else
				{	?>
			        <input type="hidden" name="action" value="save_contact_form" />
            <?	}	?>	                    
		
		<label>Conact Form Information</label>
		 <?
		//echo $current_template_id; exit;
		 ?>
		<div class="section">
			
			<div>
				
            <table width="80%" border="0" cellpadding="8" cellspacing="0">
            <tr>
            <td>Add Caption <label>i.e. Name</label></td>
            <td><input type="text" name="txtcap1" value="<? if(isset($data_array['caption_Name'])){echo $data_array['caption_Name'];}?>" /></td>
            </tr>
            <tr>
            <td>Add Caption <label>i.e. Subject</label></td>
            <td><input type="text" name="txtcap2" value="<? if(isset($data_array['caption_Subject'])){echo $data_array['caption_Subject'];}?>" /></td>
            </tr>
            <tr>
            <td>Add Caption <label>i.e. Email To</label></td>
            <td><input type="text" name="txtcap3" value="<? if(isset($data_array['caption_EmailTo'])){echo $data_array['caption_EmailTo'];}?>" /></td>
            </tr>
            <tr>
            <td>Add Caption <label>i.e. Message</label></td>
            <td><input type="text" name="txtcap4" value="<? if(isset($data_array['caption_Message'])){echo $data_array['caption_Message'];}?>" /></td>
            </tr>
            </table>
						
			</div>
		
        </div>
		
		<div class="section">
        <?php 	if(isset($data_array['flag']) && $data_array['flag'] > 0)
				{	?>
			<div>
				<input type="submit" value="Update Form" />
			</div>
			<?	}	
				else
				{	?>
 			<div>
				<input type="submit" value="Save Form" />
			</div>
			<?	}	?>           
		</div>
		
	</fieldset>
</form>

<!--<script type="text/javascript">
	//jquery for radio button control
	$('div.radio span input:radio').click(function() {
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span').removeClass('checked');
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span input').attr('checked', false);    
		var className = $(this).parent().attr('class');
		if(className == "")
		{
			$(this).parent().addClass("checked"); 
			$(this).attr('checked', true);  
		}
		else
		{
			$(this).parent().removeClass('checked');   
			$(this).attr('checked', false);   
		}
	});
	
</script>-->

 </div>