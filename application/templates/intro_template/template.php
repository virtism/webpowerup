<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style type="text/css">
    @import "<?=base_url()?>css/intro_template/css/reset.css";    
    @import "<?=base_url()?>css/intro_template/css/style.css";	
	@import "<?=base_url()?>css/fancyalert/style.css";	
</style>



<script src="<?=base_url()?>css/intro_template/png/png-fix.js" type="text/javascript"></script>
<script src="<?=base_url()?>css/intro_template/png/png_c.js" type="text/javascript"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=$_scripts?>

<script type="text/javascript" src="<?=base_url()?>js/fancyalert/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancyalert/alertbox.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<?=$_styles?>
<?php
    if(!isset($description))
    {
        $description = "";    
    }	
?>
<meta name="Description" content="<?=$description?>" />
<?php
    if(!isset($keywords))
    {
        $keywords = "";    
    }	
?>
<meta name="Keywords" content="<?=$keywords?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Robots" content="index,follow" />

<title><?=$title?></title>
<script type="text/javascript">
	function add_customer()
	{
			
			var path =  "<?=base_url().index_page()?>MyAccount/register/";
			var site_id = document.getElementById('get_site_id').value;
			var action = document.getElementById('action').value;
			var f_name = document.getElementById('f_name').value;
			var last_name = document.getElementById('last_name').value;
			var email = document.getElementById('email').value;
			if($.trim(f_name)=='')
			{
				csscody.error('<p style="color:#FF0000">Please enter first name.</p>');
			}
			else if($.trim(last_name)=='')
			{
				csscody.error('<p style="color:#FF0000">Please enter last name.</p>');
			}
			else if($.trim(email)=='')
			{
				csscody.error('<p style="color:#FF0000">Please enter email.</p>');
			}
			else
			{
			
			
				var dataString ="get_site_id="+site_id+"&action="+action+"&f_name="+f_name+"&last_name="+last_name+"&email="+email;
				
				//alert( path);
				$.ajax({
					url: path, 
					data: dataString,
					type:'POST', 
					success: function(data){
						//$("#groups_customres").html(data);
						//$("#groups_customres").show();
						//alert(data);
						if(data==0)
						{
							csscody.error('<p style="color:#FF0000">The same email id is already exists.</p>');
						}
						else
						{
							csscody.alert('<p style="color:#006600">You have successfully registered.</p>');
						}
					}
				});
			}
			
			return false;
	}
	$(document).ready(function() {
		//$("#inline1").fancybox();  
			$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
	
			$('#submit-form').click(function(){
 	 		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var names 				 = $('#contact-form [name="contact-names"]').val();	 
			var email_address = $('#contact-form [name="contact-email"]').val();
			var comment			 = $.trim($('#contact-form .contact-commnent').val());
			var data_html ='' ;
 				if(names == ""){
 					 $('.name-required').html('Your name is required.');
 				}else{
 					 $('.name-required').html('');
 				}
 				if(email_address == ""){
 					 $('.email-required').html('Your email is required.');
 				}else if(reg.test(email_address) == false){
 					 $('.email-required').html('Invalid Email Address.');
 				}else{
 					 $('.email-required').html('');
 				}
 				
 				if(comment == ""){
 					 $('.comment-required').html('Comment is required.');
 				}else{
 					 $('.comment-required').html('');
 				}
				if(comment != "" && names != "" && reg.test(email_address) != false){
				
					data_html = "names="+ names + "&comment=" + comment + "&email_address="+ email_address;
					
					//alert(data_html);
					
				  $.ajax({
						  type: 'POST',
						  url: '<?=base_url().index_page()?>MyAccount/sendcontact_mail',
						  data: data_html,
						  success: function(msg){
							if ( $.trim(msg) == 'sent'){
									$('#success').html('Thank you, your message has been sent!') 	;
									$('#contact-form [name="contact-names"]').val('');	 
								  $('#contact-form [name="contact-email"]').val('');
								$('#contact-form .contact-commnent').val('');
									
								}else{
									$('#success').html('Mail Error. Please Try Again.!') 	;	
								}
						  }
					});
 		
 	  			}
 	  		
	 		return false;
 		})
	});


</script>
 <style>
  .form-wrapper{
  	 margin: auto;
    width: 444px;
  }
  .contact-email,.contact-names{
     border: 1px solid #CCCCCC;
    height: 25px;
    width: 290px;	
  }
  .contact-commnent{
     border: 1px solid #CCCCCC;
    height: 125px;
    width: 290px;	
  }
  .comment-required, .name-required, .email-required{
  color:red;
  }
</style>
</head>
<body>  
    <?=str_replace('hidden_site_id',$_SESSION['site_id'],$content)?>
	<div style="display: none;">
		<div id="inline1" style="overflow:auto;">
			<div id="wrapper">	
                    <div class="form-wrapper">
                    	<p id="success"></p>
                    	  <h1>Contact Form</h1>
                        	<form id="contact-form" name="contact-form" method="POST">
                       	    	<label class="label">Name:</label>
                            	<p><input type="text" value="" name="contact-names" class="contact-names"/><span class="name-required"></span></p>
                            	<label class="label"class="label">Email:</label>
                             	<p><input type="text" value="" name="contact-email" class="contact-email"/><span class="email-required"></span></p>
                             	<label class="label">Message:</label>
                             	<p><textarea class="contact-commnent" name="comments"></textarea><span class="comment-required"></span></p>
                            	<label class="label"></label>
                             	<p id="p-submit"><input id="submit-form" class="submit-button" name="submit"type="submit" value="Submit"></p>                   	      	
                         	</form>
                   </div>	
			</div>
		</div>
	</div>
 </body>
</html>