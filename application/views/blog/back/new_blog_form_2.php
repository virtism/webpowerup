<script src="http://connect.facebook.net/en_US/all.js"></script>  
<script type="text/javascript">
function onFacebookLoginStatus(response)
{
	
	   
	if (response.authResponse)
	  { 
	 	 var query = FB.Data.query('SELECT uid, first_name, last_name, email, sex, pic_square, timezone, birthday_date, current_location FROM user WHERE uid = me()', response.authResponse.id);
		query.wait(function(rows) { 
		
		 console.log('fName : '+ rows[0].first_name);
		 console.log('Email : ' +rows[0].email);
		 console.log('User Id:' +rows[0].uid);
		 console.log('LasName:' +rows[0].last_name);
		 console.log('sex:' +rows[0].sex);
		 console.log('Birthday:' +rows[0].birthday_date);
		
			var userId = rows[0].uid;     //user id which is unique to every user
			var fname = rows[0].first_name  //split it to make username
			//var userName = fname+ userId.substring(0,8);  //unique username for every incoming user
			var email = rows[0].email;
			var password = "1234";
			var surname = rows[0].last_name;
			var sex = rows[0].sex;
			if($("#fb_status").val() != "What is in your mind?")
			{
				str_text = $("#fb_status").val();		
			}
			else
			{
				str_text = "Webpowerup is sharing a Link With You.";	
			}
			
			site_id = $('#fb_site_id').val();
			page_id = $('#fb_page_id').val();
			blog_id = $('#fb_blog_id').val();
			
			str_link = "<?=base_url().index_page()?>blog/index/"+site_id+"/"+page_id+"/"+blog_id;
			
				
			var body = str_text+"\n"+str_link; 
		  
				// logged in and connected user, someone you know
			  	FB.getLoginStatus(function(response) {
			  if (response.authResponse) {
				// logged in and connected user, someone you know
			  FB.api('/'+userId+'/feed', 'post', { message: body }, function(response) {       
								if (!response || response.error) {
									alert('There is some Techinal Error Occured Please Try Some Later!'); 
								} else {
									alert('Request is Successfully Processed.');
								}
							});  
			  } else {
				// no user session available, someone you dont know
				 alert("yor are not with facebook connected");
			  }
			});        
			  
			 
				
			
		//  var dataString = 'facebook_userId='+userId+'&email='+ email+'&userName='+userName+'&fName='+fname+'&lName='+surname+'&sex='+sex+'&password='+password;
			 //  var path='<?=base_url().index_page()?>html5/login';
			   //alert(dataString)
			  //alert(path)
			/* $.ajax({
			type: "POST",
			url: path,
			data: dataString, 
			async : false,
			success: function(data) {
			 
					alert("data is saved via ajax");
					 var body = "you can get free 1GB online storage, Please click on this link: http://www.cloudify.in"  ;
			FB.getLoginStatus(function(response) {
			  if (response.authResponse) {
				// logged in and connected user, someone you know
			  FB.api('/'+f_id+'/feed', 'post', { message: body }, function(response) {       
								if (!response || response.error) {
									alert('Error occured');
								} else {
									alert('Successfully added 10MB in your storage quato');
								}
							});  
			  } else {
				// no user session available, someone you dont know
				 alert("yor are not with facebook connected");
			  }
			});        
			
			
				},
			error:function(){
				alert('Problem in your connection');
				}
			});*/
		  
		 });                      
	  }
	  else
	  {
		console.log('User cancelled login or did not fully authorize.');
	  }
}
function fblogin()
{
	
	 // document.getElementById('loading').style.display='block';
	  FB.init({ 
			appId:'293519274018980', 
			cookie:true, 
			status:true,
			xfbml:true 
			});   
	 
	  FB.api('/me', function(response) {
			   
			   FB.login(onFacebookLoginStatus, {scope: 'email,publish_stream,user_birthday,user_location' });
		  });    
}
function fb_authentication(id)
{
	
	//alert(element);
	if ($('#'+id).attr('checked'))
	{
		//alert("ok");	
		fblogin();
	}
	else
	{
		//alert("not required");
	}
}

$("img.NFCheck").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	if(id == "fb_save")
	{
		fb_authentication(id);
	}
});

</script>
<body>

<div>
	<?php echo $this->session->flashdata('rspBlogAdd'); ?>
</div>

<div class="RightColumnHeading">
    <h1>
        <span>Share Your New Blog</span>
    </h1>
</div>
<div class="clr"></div>

<!--Normal -->
<div class="InnerMain2">
<form class="niceform" method="post" action="<?=base_url().index_page();?>blog_managment/blog/<?=$blog_id?>">
<input type="hidden" id="fb_site_id" name="fb_site_id" value="<?=$site_id?>" />
<input type="hidden" id="fb_page_id" name="fb_page_id" value="<?=$page_id?>" />
<input type="hidden" id="fb_blog_id" name="fb_blog_id" value="<?=$blog_id?>" />

    <dl>
           <dt>
                 <label  class="NewsletterLabel">
                     Add this to facebook	<br>
                     <img src="<?=base_url()?>images/fb_logo.png" alt="FB" border="0" />
                 </label>
           </dt>
           <dd style="height:70px; padding-left:30px; width:500px;">
                <input style="opacity:1;" type="checkbox" name="fb_save" id="fb_save" value="1" onClick="fb_authentication(this);" />
              Share it 
                        <br><br>
                        <input type="text" name="fb_status" id="fb_status" size="55"  > 
           </dd>
    </dl>
    
    
    <dl>
           <dt>&nbsp;
                 
           </dt>
           <dd style="height:70px; padding-left:30px; width:500px;">
                &nbsp;
            	<input type="submit" value="Continue">
           </dd>
    </dl>
    
    
</form>    
</div>


