<script type="text/javascript" language="javascript">
  function validateEmail(email) 
  {
	
	var objRegExp  = /^[a-z0-9]([a-z0-9_\-\.]*)@([a-z0-9_\-\.]*)(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/i;
	  //check for valid email
		if(objRegExp.test(email))
			return true;
		else	
		{
			//alert(strMsg);
			//formfield.focus();
			return false;		
		}
	}	
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
		
		//alert(email);
		 
		if(name=="Name")
		{
			errMsg +="* Name is required.<br>";
		   $("#Name").css("background","#F68CB8");
			error = 1;
		}
		else
		{
		   $("#Name").css("border","solid 1px #ffffff");
		}
		if(email=="Email")
		{
			errMsg +="* Email is required.<br>";
			$("#Email").css("background","#F68CB8");
			error = 1;
		}
		else
		{
			$("#Email").css("border","solid 1px #ffffff");
		}
		if(email != "Email")
		{
			if(validateEmail(email))
			{
				$("#Email").css("border","solid 1px #ffffff");
			}
			else
			{
				errMsg +="* Email is Not Valid.<br>";
				$("#Email").css("background","#F68CB8");
				error = 1;
			}
			
		}
		
		if(msg=="Message")
		{
			errMsg +="* Message is required.<br>";
			$("#textarea").css("background","#F68CB8");
			error = 1;
		}
		else
		{
		   $("#textarea").css("border","solid 1px #ffffff");
		}
		
		if(error==1)
		{
			 $("#error_msg").css("color","#FF0000");
			$("#error_msg").html(errMsg);
		}
		
		if(error==0)
		{
			//alert('<?=base_url()?>');
			$.ajax({
				type: "POST",
				url: "<?=base_url().index_page()?>FooterController/send_conatct_email",
				data: "name="+name+"&email="+email+"&msg="+msg,
				success: function(msg)
				{
					if(msg!='')
					{
						//alert('This is msg not set');
						$("#email_form1").hide();
					  //  $("#email_form2").show();
					  	$("#error_msg").css("color","#009900");
						$("#error_msg").html(msg);
					}
					else
					{
						alert('Msg set');
						/*$("#error_msg")..html('Sory for Inconvenience.Please try again later.');
						$("#email_form1").show();*/
						
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
						
					}
					else
					{
										//    echo "i m out test mode";
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
				<? } 
				//exit;
				
				?>
				<div class="fieldsareafooter">
				<div class="footertitle">
					Get Intouch
				</div>
				<span id="error_msg" style="color:#009900; font-size:12px">&nbsp;</span>
				<form name="contact_us" method="post" action="" id="email_form1" >
					<div class="usernamefooter">
						<input type="text" value="Name" id="Name"  name="name" class="userfooter" onblur="check_value(this,'Name','');" onfocus="check_value(this,'','Name');">
					</div>
					<div class="usernamefooter">
						<input type="text" value="Email" id="Email" name="name" class="userfooter" onblur="check_value(this,'Email','');" onfocus="check_value(this,'','Email');">
					</div>
					<div class="txtareafooter">
						<textarea class="textarea" id="textarea" onblur="check_value(this,'Message','');" onfocus="check_value(this,'','Message');" >Message</textarea> 
					</div>
					<div class="bluebuttonfooter">
						<input type="button" class="footerpress" onclick="submit_message();" value="Submit"  />
					</div>
					</form>
					
				</div>
				
			   
		</div>