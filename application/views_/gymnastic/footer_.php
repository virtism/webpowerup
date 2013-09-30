<script type="text/javascript" language="javascript">
  function check_value(obj, text, valCheck)
	{
		var objValue = obj.value;
		if(valCheck != objValue)
		{
			if(objValue.length == 0)
			{
			 //$(obj).css("border","solid 1px #e1e1e1");
			  obj.value = text;
			}
		}
		else
		{
			if(valCheck == "")
			{
			//$(obj).css("border","solid 1px #FF0000");
			}
			else
			{
			  //$(obj).css("border","solid 1px #e1e1e1");
			}
			obj.value = text;
		}
  }
  
 function submit_message()
 {
		var error = 0;
		var errMsg = "";
		var name = document.getElementById("Name").value;
		var email = document.getElementById("Email").value;
		var msg = document.getElementById("textarea").value;
		if(name=="Name")
		{
			//errMsg +="* Name is required.<br>";
		   // $("#Name").css("border","solid 1px #FF0000");
			error = 1;
		}
		else
		{
		   // $("#Name").css("border","solid 1px #e1e1e1");
		}
		if(email=="Email")
		{
			//errMsg +="* Email is required.<br>";
			//$("#Email").css("border","solid 1px #FF0000");
			error = 1;
		}
		else
		{
			//$("#Email").css("border","solid 1px #e1e1e1");
		}
		if(msg=="What you would like to know?")
		{
			//errMsg +="* Message is required.<br>";
			//$("#textarea").css("border","solid 1px #FF0000");
			error = 1;
		}
		else
		{
		   // $("#textarea").css("border","solid 1px #e1e1e1");
		}
		if(error==0)
		{
			$.ajax({
				type: "POST",
				url: "http://www.cu-bd.com/pages/email_message.php",
				data: "name="+name+"&email="+email+"&msg="+msg+"&security_code="+security_code+"&language="+language,
				success: function(msg)
				{
					if(msg!='')
					{
						$("#email_form1").hide();
						$("#email_form2").show();
						$("#error_msg").html(msg);
					}
					else
					{
						$("#sorry").hide();
						$("#email_form1").hide();
						$("#email_form").show();
					}
				}
			});
		}
  }
</script> 
		<div class="footercontent">
				 <?php
					if(isset($footer_content)&&!empty($footer_content))
					{
											
						echo stripslashes($footer_content);
						
					}else{
				?>        
			   <div class="linksfooter">
				<div class="footertitle">
					Links
				</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
				</div>
				<div class="linksfooter">
					<div class="footertitle">
					Popular
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
					<div class="footerdivider">
					...................................................................................................
					</div>
					<div class="alinkfooter">
						<a href="template.html">consectetuer adipiscing elit, sed diam nonummy nibh euismod</a>
					</div>
				</div>
				<? } ?>
				<div class="fieldsareafooter">
				<div class="footertitle">
					Get Intouch
				</div>
				<form name="orange">
					<div class="usernamefooter">
						<input type="text" value="Name"  name="name" class="userfooter" onblur="check_value(this,'Name','');" onfocus="check_value(this,'','Name');">
					</div>
					<div class="usernamefooter">
						<input type="text" value="Email" name="name" class="userfooter" onblur="check_value(this,'Email','');" onfocus="check_value(this,'','Email');">
					</div>
					<div class="txtareafooter">
						<textarea class="textarea" onblur="check_value(this,'Message','');" onfocus="check_value(this,'','Message');" >Message</textarea> 
					</div>
					<div class="bluebuttonfooter">
						<input type="button" class="footerpress" onclick="submit_message();" value="Submit"  />
					</div>
					</form>
				</div>
				
			   
		</div> 
		<div class="footerbotbg">
				<div class="footerendcontent">
					<a href="template.html">consectetuer </a> &nbsp;&nbsp; <a href="template.html">conuer </a>
				</div>
				
		</div>    
	   
	   
	   
