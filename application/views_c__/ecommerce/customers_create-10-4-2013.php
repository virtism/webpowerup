<script type="text/javascript" src="<?=base_url()?>js/validation/jquery.js" ></script>
<script type="text/javascript" src="<?=base_url()?>js/validation/jquery.validate.js" ></script>
<script type="text/javascript">


$(document).ready(function() {
	// validate the comment form when it is submitted
   // $("#registerform").validate();
	
	var radioChecked = 0;
	var block = 0;
	$("#registerform").submit(function(){
		
		
			clearAllError();
			block = 0;
			
			var radioName = new Array();
			var checkboxName = new Array();
			var i = 0;
			var j = 0;
			var id,firstLetter,splitID;
			$(".required_custom_field").each(function() {
				
				id = $(this).attr("id");
				splitID = id.split("-");
				//alert(splitID);
				firstLetter = splitID[0];
				if(firstLetter == "check") 
				{
					checkboxName[i] = $(this).attr("name");
					i++;
				}
				else if(firstLetter == "radio")
				{
					radioName[j] = $(this).attr("name");
					j++;
				}
				

			});
			//alert(radioName);alert(checkboxName);
			var unique = function(origArr) {  
				var newArr = [],  
					origLen = origArr.length,  
					found,  
					x, y;  
				for ( x = 0; x < origLen; x++ ) {  
					found = undefined;  
					for ( y = 0; y < newArr.length; y++ ) {  
						if ( origArr[x] === newArr[y] ) {  
						  found = true;  
						  break;  
						}  
					}  
					if ( !found) newArr.push( origArr[x] );  
				}  
			   return newArr;  
			};  
			
			radioName = unique(radioName);  
			checkboxName = unique(checkboxName);  
			
			chkboxName = checkboxName;
			radioName = radioName;
			// alert(chkboxName);
			//alert(radioName); 
			
			$.each(radioName, function(index, value) 
			{ 
				
				var name = "'"+value+"'";
				if( $("input[name="+name+"]").is(":checked") == false ) 
				{
					
					var radioChk = $("input[name="+value+"]").is(":checked");
					
					if(radioChk == false)
					{
						//radio.parent().css("border","solid 1px red");
						//radio.parent().css("border","green 1px red");
						$("input[name="+name+"]").parent().append("<span class='error2'> This is required</span>");
						block = 1;
						return false;
					}
					//break;
				}
				
				
			});
			$.each(chkboxName, function(index, value) 
			{ 
				
				var name = "'"+value+"'";
				if( $("input[name="+name+"]").is(":checked") == false ) 
				{
					
					var chkboxChk = $("input[name="+value+"]").is(":checked");
					
					if(chkboxChk == false)
					{
						//radio.parent().css("border","solid 1px red");
						//radio.parent().css("border","green 1px red");
						$("input[name="+name+"]").parent().append("<span class='error2'> This is required</span>");
						block = 1;
						return false;
					}
					//break;
				}
				
				
			});
			
			
			$(".required_custom_field").each(function(index) {
				// alert(index + ': ' + $(this).val());
				
				
				if ( $(this).is(":text") ) // if it is a text field
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error2'> This is required</span>");
						block = 1;
						return false;
					}
				}
				
				else if( $(this).is("textarea") )
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error2'> This is required</span>");
						block = 1;
						return false;
					}
				}
				
				
			});
			
			if(block == 1)
			{
				return false;
			}
			else
			{
				return true;
			}
			
	});
	
	
	function clearAllError()
	{
		$(".error2").html("");
	}
	
 
	$('#btnJoin').attr("disabled",true);
	$('#gp_drop_down').attr("disabled",true);
	
	
	$("#registerBtn").click(function(){
		
		
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var email = $("#email").val();
		var password = $("#password").val();
		
		if( !validate_register_form() )
		{
			return false;
		}
		
		dataString = "fname="+fname+"&lname="+lname+"&email="+email+"&password="+password;
		//alert(dataString);
		//alert(window.location.protocol);
		$.ajax({
		type: "POST",
		//url: "<?=base_url().index_page()?>MyAccount/register_process/",
		url: window.location.protocol+"/MyAccount/register_process/",
		data: dataString,
		success: function(rsp){
			  
			// alert(data);
			rsp = $.trim(rsp);
			
			// set customer id
			$("#customer_id").val(rsp);
			
			if (rsp != 0)
			{
				$("#regBtnDiv").html("");
				
				$("#rspMain").show();
				$("#rsp").hide();
				$("#closeRsp").hide();
				$("#rsp").removeClass();
				$("#rsp").addClass("success");
				$("#rsp").html("You have register successfully. Please select the group from below.");
				$("#rsp").fadeIn("slow");
				$("#closeRsp").fadeIn("slow");
				
				
				$('#btnJoin').attr("disabled",false);
				$('#gp_drop_down').attr("disabled",false);
				$("#regFormDiv").slideUp("slow");
				$('#btnJoin').addClass("myButton");
			}
			else
			{
				$("#rspMain").show();
				$("#rsp").hide();
				$("#closeRsp").hide();
				$("#rsp").removeClass();
				$("#rsp").addClass("error");
				$("#rsp").html("You did not register successfully. Please try again.");
				$("#rsp").fadeIn("slow");
				$("#closeRsp").fadeIn("slow");
				
				$('#btnJoin').attr("disabled",true);
				
			}
				
			}
		});
		
		
		return false;
		
	});
	
	$("#closeRsp").click(function(){
		
		$(this).parent().fadeOut("fast");
	});
	
	$("#gp_drop_down").change(function(e) {
        
		var group_id = $(this).val();
		
		payPal_bottom(group_id);
		check_group_payment_status(group_id);
		hide_group_code(group_id);
    });
	
});

function show_busy(divId)
{
	
	busyImg = "<td>&nbsp;</td><td colspan='3'><img width='25px' height='25px' id='busy' src='<?=base_url();?>images/webpowerup/busy1.gif'><td>";
	$("#"+divId).html(busyImg);
}
function payPal_bottom(group_id)
{
		show_busy("group_custom_field");
		
		var cid = $("#customer_id").val();
		var site_id = $("#site_id").val();
		var dataString = 'group_id='+group_id+"&cid="+cid+"&sid="+site_id;	
		
		if( group_id == "" ) 
		{
			$('#group_custom_field').html("");
		}
		else
		{
			$.ajax({
			type: "POST",
			url: "<?=base_url().index_page()?>sitegroups/group_fields_paypal_button/register",
			data: dataString,
			success: function(data){
				   // alert(data);
				   $('#group_custom_field').html("<td>&nbsp;</td><td colspan='3'>"+data+"<td>");
				   $('#group_custom_field').show();
				   
				}	
			});
		}
		
		
}
function check_group_payment_status(group_id)
{
	  var dataString = 'group_id='+group_id;	
	    //alert("");
		$.ajax({
		type: "POST",
		url: "<?=base_url().index_page()?>group_managment/check_group_payment_status/",
		data: dataString,
		success: function(data){
			  //alert("asd");
			  data = $.trim(data);
			  if(data == "Free" || data == "Trial")
			  {
				  submitBtn("enable");
			  }
			  else
			  {
				  submitBtn("disable");
			  }
			}	
		});
		
		$("#response").html("");
}

function validate_register_form()
{
	$(".errorMsg").remove();
	var fname = $("#fname").val();
	var lname = $("#lname").val();
	var email = $("#email").val();
	var password = $("#password").val();
	var passwordf = $("#passwordConf").val();
	var code = $("#code").val(); 
	var captcha = $("#captcha").val();
	var flag = 1;
	
	if(fname == "")
	{
		flag = 0;
		$("#fname").parent().append("<p class='errorMsg' style='color:red; '>First Name is required.</p>");
	}
	if(lname == "")
	{
		flag = 0;
		$("#lname").parent().append("<p class='errorMsg' style='color:red; '>Last Name is required.</p>");
	}
	
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
	var m = email.match(emailPattern);
	if(m == null)
	{
		flag = 0;
		$("#email").parent().append("<p class='errorMsg' style='color:red; '>Enter a valid email.</p>");
	}
	
	if(password.length < 4 )
	{
		flag = 0;
		$("#password").parent().append("<p class='errorMsg' style='color:red; '>Password should be at least 4 character.</p>");
	}
	if( passwordf != password)
	{
		flag = 0;
		$("#passwordConf").parent().append("<p class='errorMsg' style='color:red; '>Password dont match.</p>");
	}
	if( code != captcha)
	{
		flag = 0;
		$("#code").parent().append("<p class='errorMsg' style='color:red; '>Please enter the valid image code	.</p>");
	}
	
	if(flag == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
	
}
function gp_code_load(val)
{
	if(val=="gpCode")
	{
		$('#gp_drop_down').hide();
		$('#gp_custom_code').show();	
	}
	else if(val=="gpCode")
	{
		
	}
	
}
function show_group_code()
{
	$('#group_code_field').show();
}
function hide_group_code(val)
{
	//group_custom_field
	
	var option_id = $("#gp_drop_down option:selected").attr("id");
	//alert(option_id);
	if(val == 0 && val != "")
	{
		$('#group_code_field').show();
	}
	else if(option_id!= "" && typeof option_id!= "undefined")
	{
		
		$("#group_code_field").show();
	}
	else
	{
		$('#group_code_field').hide();
		$('#btnJoin').attr("disabled",false);
	}
}
function checkGroupCode(group_code)
{
	var msg = document.getElementById('code_id');
	var dataString = 'group_code='+group_code;
   // alert(group_code);
	if(group_code != ""){
	   // alert(group_code);
		$.ajax({
		type: "POST",
		url: "<?=base_url().index_page()?>customers/code_exist/"+group_code,
		data: dataString,
		success: function(data){
			   //alert(data);
				if(data==1)
				{
					submitFlag = true;     
					//msg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
					$('#btnJoin').attr("disabled",false);	
					msg.innerHTML = '<code style="color: green;">Valid Code.</code>';
				  //  alert('Valid Code'); 	  
				}
				else{
				
				  
				  	submitFlag = false;
					//msg.innerHTML = '<label class="error">This user login already exist.</font>';
					msg.innerHTML = '<code style="color: red;" >Invalid Code! Please put valid Group Code</code>';
					$('#btnJoin').attr("disabled",true);
					//alert('Invalid Code');
				  
				}
			}
		});
	}        
}
function checkEmail(user_mail)
{
	var msg_email = document.getElementById('email_id');
	var dataString = 'user_login='+user_mail;
	if(user_mail != ""){
	   // alert(user_mail);
		$.ajax({
		type: "POST",
		url: "<?=base_url().index_page()?>customers/email_exist/<?=time();?>",
		data: dataString,
		success: function(data){
			  // alert(data);
				if(data  == 'TRUE')
				{
					submitFlag = false;
					//msg_email.innerHTML = '<label class="error">This user login already exist.</font>';
					msg_email.innerHTML = '<code style="color: red;">This user Email is already in use.</code>';
				   // alert('Email is already in use');    
						
				}
				else{
					submitFlag = true;     
					//msg_email.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
					msg_email.innerHTML = '<code style="color: green;">This user login is available.</code>';
				   // alert('login is available');
				}
			}
		});
	}        
}
function submitBtn(option)
{
	if(option == "enable")
	{
		$('#btnJoin').attr("disabled",false);
	}
	else if(option == "disable")
	{
		$('#btnJoin').attr("disabled",true);
	}
	else
	{
		return false;
	}
	
}
</script>
<style type="text/css">
#commentForm { width: 500px; }
#commentForm label { width: 250px; }
#registerform label.error, #commentForm input.submit { margin-left: 0px; color:red; }
#signupForm { width: 670px; }
#signupForm label.error {
	margin-left: 10px;
	width: auto;
	display: inline;
}
#newsletter_topics label.error {
	display: none;
	margin-left: 103px;
}
/***********/
/*	RESPONSE CSS	*/
#rspMain{
	position:relative;
	clear:both;
	display:none;
	height:45px;
	margin:5px 0 5px 0;
}
#rsp{
	position:absolute;
	top:0;
	width:100%;
	padding:15px 15px 15px 15px;
}
#rspMain #closeRsp{
	position:absolute;
	top:5px;
	right:5px;
	margin:10px 10px 0 0;
	background:url(../../../images/common/icon_nok.png) no-repeat;
	width:15px;
	height:15px; 
	display:none;
}
.info 
{
color: #00529B;
background-color: #BDE5F8;
}
.success 
{
color: #4F8A10;
background-color: #DFF2BF;
}
.warning 
{
color: #9F6000;
background-color: #FEEFB3;
}
.error, .error2 
{
color: #D8000C;
background-color: #FFBABA;
}
.error2 
{
background:none;
}
/***********/
</style>
<h2><?php echo $title;?></h2>
<div id="rspMain">
    <div id="rsp"></div>
	<div id="closeRsp"></div>
</div>

<form name="registerform" id="registerform" class="contact" method="post" action="http://<?=$_SERVER['SERVER_NAME']?>/MyAccount/join_group">
<input type="hidden" id="customer_id" name="customer_id" value="0" />
<input type="hidden" name="site_id" value="<?=$site_id?>" id="site_id" />
<? //	echo "<pre>";"-----------------".print_r($membership);exit;	  ?>
<div id="regFormDiv">
<p class="register-note">
		   The form below allows you to create a profile which is necessary to place orders. 
		   Do not forget that this information is essential to use our services correctly.
			<br>
			<br>
		The fields marked with <span class="data-required">*</span> are mandatory.
</p>
 
	<table cellspacing="1" summary="Register" class="data-table register-table" style="margin-left: 20px;">
<tbody>
 
			<tr>
				<td class="register-section-title" colspan="3">
					<div>
						<label>Personal information</label>
					</div>
				</td>
			</tr>
				<td class="data-name"><label for="firstname">First name</label></td>
				<td class="data-required">*</td>
				<td>
					<input type="text" name="fname" id="fname" size="32" maxlength="32" class="required" value="" />
				</td>
			</tr>
			<tr>
				<td class="data-name"><label for="lastname">Last name</label></td>
				<td class="data-required">*</td>
				<td>
					<input type="text" name="lname" id="lname" size="32" maxlength="32" class="required" value="" />
				</td>
			</tr>
			
			
	<tr>
		<td class="data-name"><label for="email">Email</label></td>
		<td class="data-required">*</td>
		   <td>
			<input type="text" name="email" id="email" size="32" maxlength="128" class="required email" onblur="checkEmail(this.value)" value="" />
			<div  id="email_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Make sure you enter a valid email address</div> 
		</td>
	</tr>
   <tr style="display:none;"><td><input type="hidden" value="N" id="password_is_modified" name="password_is_modified"></td></tr>
   <tr>
	  <td class="data-name"><label for="passwd1">Password</label></td>
	  <td class="data-required">*</td>
	  <td>
		  
		  <input type="password" value="" maxlength="64" size="32" class="required" name="password" id="password">  
	  </td>
   </tr>
   <tr>
	  <td class="data-name"><label for="passwd2">Confirm password</label></td>
	  <td class="data-required">*</td>
	  <td>
 		<input type="password" value="" maxlength="64" size="32" class="required" name="passwordConf" id="passwordConf">
		  <span class="validate-mark"><!--<img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif">--></span>
	  </td>
   </tr>                  
   <tr>
	  <td class="register-newbie-note" colspan="3" style="padding-left: 162px;;">
		  I accept the <a href="<?=base_url()."about-us.html"?>">"Terms &amp; Conditions"</a>
		  <!-- I accept the <a target="_blank" onclick="javascript:popupOpen(this.href, '', {width:800,height:600}); return false;" href="#">"Terms &amp; Conditions"</a>-->
	  </td>
   </tr> 
   
   <tr>
   		
        <td ><label >Please Enter the image below</label><br /></td>
        <td class="data-required">*</td>
        <td style="padding-top:8px;" >
        	<div><input class="required"  style="margin: 0px 5px 0 6px; display: inline-block; float: left; height: 18px; width: 120px;" id="code" name="code" id="code" type="text" value=""  /><?=$captcha_data['image'];?></div>
            <input type="hidden" name="captcha" id="captcha" value="<?=$captcha_data['word'];?>"/>
        </td>
   </tr>    
                       
   <tr>                      
	  <td class="button-row center" align="center" style="padding: 20px 0px 20px 0px;">&nbsp;</td>
	  <td class="button-row center" align="center" style="padding: 20px 0px 20px 0px;">&nbsp;</td>
	  <td class="button-row center" align="center" style="padding: 20px 0px 20px 0px;">
      
      <div id="regBtnDiv" style="text-align:left;">
	    <input id="registerBtn" type="button"  value="Register" class="myButton"/>
      </div>
      
      </td>                      
   </tr>
</tbody>
</table> 
</div>

<p class="register-note">
		  Please select a group you want to subscribe ( For group selection Please register first )
</p>
<br>
    <table class="data-table register-table" cellspacing="1" style="margin-left: 20px; width:630px;" >
    
    <tr>
    <td width="99%">
    	<table style="width:100%">
        <tr>
    
          <td width="148" class="data-name">Sign up for membership</td>
    
          <td width="7"></td>
    
          <td width="203">     
           <?
		   		if($this->session->userdata('group_id'))
				{
					$group_id = $this->session->userdata('group_id');
				}
				//echo "<pre>";print_r($membership);
		   ?>
                 <select   name="pending_membershipid" id="gp_drop_down" >
                    <option value=""> None</option>
                    <option value="0">Group Code</option>
            		
                    <? 
						if(empty($group_id)){ 
						for($i = 0; $i<count($membership); $i++){
							
					?>
                        		<option id="<? if(isset($membership[$i]['group_code']) && $membership[$i]['group_code'] != 'None'){ echo 'code_exist'.$i; } ?>"  value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
                    <? 
							}
							
						}	
					else 
						{
							for($i = 0; $i<count($membership); $i++){
								
								if($group_id == $membership[$i]['id']){
							
					?>
								 <option id="<? if(isset($membership[$i]['group_code']) && $membership[$i]['group_code'] != 'None'){ echo 'code_exist'.$i; } ?>"  value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
					
					<?		
								}
							} 
							
						}					
					?>
                 </select>
          </td>
       </tr>     
       <tr id="group_code_field" style="display: none;">
          <td class="data-name"> Group Code </td>
          <td> </td>
             <td> 
               <?php 
			   $group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'onblur'=>"checkGroupCode(this.value)");
			   echo form_input($group_code); ?>
               <!--<span style="color: #B3B6BF; font-size: 8px; font-weight: bold;">Use your Code</span>-->
                <div  id="code_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Use your Code </div>
            </td>
       </tr>
       
       <tr id="group_custom_field" style="display: none;">
    
          <td class="data-name"> Group Code </td>
    
          <td> </td>
    
             <td> 
    
               <?php 
			   $group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'onblur'=>"checkGroupCode(this.value)");
			   echo form_input($group_code) ?>
    
               <!--<span style="color: #B3B6BF; font-size: 8px; font-weight: bold;">Use your Code</span>-->
    
                <div  id="code_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Use your Code </div>
    
            </td>
    
       </tr>
       <tr>
         <td class="data-name">&nbsp;</td>
         <td></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td class="data-name" align="right">
         
        
         </td>
         <td>
         </td>
         <td class="data-name" align="left">
            <input id="btnJoin" type="submit" name="subscribe" value="Continue" />
         </td>
       </tr>
       
       <tr>
         <td class="data-name">&nbsp;</td>
         <td></td>
         <td>&nbsp;</td>
       </tr>
       </table>
    </td>
    <td width="1%">
		<?php 
		/*
		if ($button_groups)
		{ ?>   
			<h2>
				Currently Available Groups
			</h2>
			<ul>
				<?php 
				foreach($button_groups as $button_group)
				{ ?>
					<li>
						<a title="Click to see group detail" href="<?=base_url().index_page()?>site_preview/page/<?php echo $button_group['site_id']."/".$button_group['page_id']; ?>"><?php echo $button_group['name']; ?></a>
					</li>
				<?php 
				} ?>
			</ul>
		<?php 
		} 
		*/ 
		?>    
    </td>
    </tr>   
       
    </table>

</form>
