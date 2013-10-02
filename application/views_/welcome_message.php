<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>


<script type="text/javascript">

	$(document).ready(function(){
		$('.slider').advancedSlider({width: 840, height: 400, skin: 'light-round-extended', slideshow: false, slideshowControls: false, fadeNavigationArrows: false, thumbnailsType: 'none', 
									 horizontalSlices: 1, verticalSlices: 1,
									 slideProperties:{
										 0: {effectType: 'fade'}, 
										 1: {htmlDuringTransition:false}, 
										 2: {effectType: 'fade'}, 
										 3: {htmlDuringTransition:false},
										 4: {effectType: 'fade', slicePattern: 'spiralMarginToCenterCW'}
									 }
									});
	});
	
</script>
<script type="text/javascript">
	
	function checkLogin()
	{
		
		
		if(document.getElementById('mail').value=='' || document.getElementById('mail').value=='E-mail')
		{
			alert('Please Enter Email Address');
			return false;
		}
		else if(document.getElementById('password').value=='' || document.getElementById('password').value=='Password')
		{
			alert('Please Enter Password');
			return false;
		}
		
		return true;
	}	
</script>

<script src="<?=base_url()?>js/purr/jquery.purr.js" type="text/javascript"></script>

<script type="text/javascript">
   		<?php  if(isset($_SESSION['user_exist']) && $_SESSION['user_exist']==1){ echo  $_SESSION['user_exist'] = 0; ?>
		
		$(document).ready(function(){
			
				$("#createSiteForm").submit(function(){
						
						var email = $("#mail").val();
						var pass = $("#password").val();
						
						if(email == "")
						{
							alert("Email is empty");
							return false;
						}
						else if (pass == "")
						{
							alert("Password is empty");
							return false;
						}
						return false;
						
					
				});
				
				/*
					var notice = '<div class="notice">'
							  + '<div class="notice-body">' 
								  + '<img src="<?=base_url()?>js/purr/info.png" alt="" />'
								  + '<h3>User Login</h3>'
								  + '<p>You Are Already Login Member Please SignIn.</p>'
							  + '</div>'
							  + '<div class="notice-bottom">'
							  + '</div>'
						  + '</div>';
						  
						$( notice ).purr(
							{
								usingTransparentPNG: true
							}
						);
						*/
		});
		<? } ?>
   	</script>
	
<div class="clear"></div>	
<div id="banner">
<div class="youtube">
<div class="slider">

		<!--<div class="slider-item">
        	
			<div class="html">
				<img src="<?=base_url()?>css/gws_new/images/video.jpg" alt="" /><br clear="all" />
				<label class="slider_label">WebPowerUp! Overview Video Tours</label>
				<p>See how to Power Up your website! Click the circles below to scroll through other videos</p>
			</div>
		</div>
		
		<div class="slider-item">
        	
			<div class="html">
				<iframe src="http://www.youtube.com/embed/JVuUwvUUPro?wmode=transparent" width="600" height="310" frameborder="0"></iframe>
				<label class="slider_label">WebPowerUp! Video Tours</label>
				<p>See how to Power Up your website!</p>
			</div>
		</div>     -->
        
     <!--  <div class="slider-item">        	
			<div class="html">
            <object type="application/x-shockwave-flash" id="player7259161_1809094071" name="player7259161_1809094071" class="" data="http://a.vimeocdn.com/p/flash/moogaloop/5.2.44/moogaloop.swf?v=1.0.0" width="600" height="310" style="visibility: visible; "><param name="allowscriptaccess" value="always"><param name="allowfullscreen" value="true"><param name="scalemode" value="noscale"><param name="quality" value="high"><param name="wmode" value="opaque"><param name="bgcolor" value="#000000"><param name="flashvars" value="server=vimeo.com&amp;player_server=player.vimeo.com&amp;cdn_server=a.vimeocdn.com&amp;embed_location=http%3A%2F%2Fwww.google.com.pk%2Furl%3Fsa%3Dt%26rct%3Dj%26q%3D%26esrc%3Ds%26source%3Dweb%26cd%3D6%26ved%3D0CE4QtwIwBQ%26url%3Dhttp%253A%252F%252Fvimeo.com%252F7259161%26ei%3DQqiYUPnuKI7EtAaZiIC4BQ%26usg%3DAFQjCNGNzXiVWeNuD77HS55ZCyDB06huiA%26sig2%3Dz_sqw3w9bpk5t8D8xz5Luw&amp;force_embed=0&amp;force_info=0&amp;moogaloop_type=moogaloop_local&amp;js_api=1&amp;js_getConfig=player7259161_1809094071.getConfig&amp;js_setConfig=player7259161_1809094071.setConfig&amp;clip_id=7259161&amp;fullscreen=1&amp;js_onLoad=player7259161_1809094071.player.moogaloopLoaded&amp;js_onThumbLoaded=player7259161_1809094071.player.moogaloopThumbLoaded"></object><label class="slider_label">WebPowerUp! Video Tours</label>
				<p>See how to Power Up your website!</p>
			</div>
		</div>-->
        
        
        
        <div class="slider-item">        	
			<div class="html">
				<iframe src="http://www.youtube.com/embed/r0ZOSDQ6noY?rel=0&wmode=transparent" width="600" height="310" frameborder="0" allowfullscreen></iframe>
				<label class="slider_label">WebPowerUp! Overview</label>
				<p>Click the circles below to scroll through other videos</p>
			</div>
		</div>
        
        <div class="slider-item">        	
			<div class="html">
				<iframe src="http://www.youtube.com/embed/05OMmo508EU?rel=0&wmode=transparent" width="600" height="310" frameborder="0" allowfullscreen></iframe>
				<label class="slider_label"> Memberships</label>
				<p>Click the circles below to scroll through other videos</p>
			</div>
		</div>        
        
        <div class="slider-item">        	
			<div class="html">
				<iframe src="http://www.youtube.com/embed/5jPz1PuFbfI?rel=0&wmode=transparent" width="600" height="310" frameborder="0" allowfullscreen></iframe>
				<label class="slider_label">Video Conferencing</label>
				<p>Click the circles below to scroll through other videos</p>
			</div>
		</div>
        
        <div class="slider-item">        	
			<div class="html">
				<iframe src="http://www.youtube.com/embed/lOgKiIQ3hBs?rel=0&wmode=transparent" width="600" height="310" frameborder="0" allowfullscreen></iframe>
			<label class="slider_label">Invoicing and Support Tickets</label>
				<p>Click the circles below to scroll through other videos</p>
			</div>
		</div>
		
	</div>
  
</div></div>
    <?php 
	$action = base_url().index_page();
	if ( isset($_SESSION["user_info"]["user_id"]))
	{
		$action .=  "SiteController/creatnewsite/";
	}
	
		
	
	
	?>
	<div id="content_container">
  <div id="contents">
    <label class="ready">Ready to get started?</label>
    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam neque lorem, cursus</p>
    <p> vitae malesuada non, pretium sit amet arcu.</p>-->
    <br clear="all" />
    <a href="<?=base_url().index_page()?>UsersController/signup_step1" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image22','','<?=base_url()?>css/gws_new/images/pricing_hover.png',1)"><img src="<?=base_url()?>css/gws_new/images/plans_pricing.png" name="Image22" width="302" height="78" border="0" id="Image22" /></a>
    <div class="content_details">
      <div class="details">
        <h1>Services</h1>
    <!--    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<a href="#"  style="color:#000000;">Read More </a></p>-->
      </div>
      <table width="100%" border="0" cellspacing="2" cellpadding="0" align="left">
        <tr>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Webinar</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img1.png" alt="" /><br />
              <p class="description">Launch webinar from your website without relying on third party tools. Scheduling your webinar will automatically notify the viewers. You have the option to keep the webinar free for viewers or charge them.</p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">E-Commerce</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img2.png" alt="" /><br />
              <p class="description">Sell digital products. It's easy and it's instant, create your store, select products, set prices and taxes and start selling in minutes. </p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Drag-n-Drop</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img3.png" alt="" /><br />
              <p class="description">No complex programming or technical expertise required. Simply drag and drop your components and get started. Rich "What You See Is What You Get" (WYSIWYG) editors make web development as easy as a breeze.</p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Video Conferencing </label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img4.png" alt="" /><br />
              <p class="description">Forget expensive web conferencing systems. Add video conferencing to your own website, invite users to your own site url. Video chat, whiteboard, text chat, file sharing, presentation sharing. It's All Included.</p>
            </div></td>
        </tr>
        <tr height="10">
          <td></td>
        </tr>
        <tr>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Membership</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img5.png" alt="" /><br />
              <p class="description">Create a membership based site. Users can join your site and become members of your site. You can set privileges and control access level of users. You get complete control managing your user base.</p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Help Desk </label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img6.png" alt="" /><br />
              <p class="description">Get your own helpdesk. Create support (trouble) tickets and assign to your support team. Complete management of support tickets keeps your customers happy and simplifies your business needs.</p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Registration Forms</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img7.png" alt="" /><br />
              <p class="description">Create complex programming: No technical expertise required. Simply drag and drop your components and get started. Rich WYSIWYG editors make web development as easy as breeze.</p>
            </div></td>
          <td width="25%"><div class="webinar_content">
              <label class="outline">Newsletter</label>
              <br />
              <img src="<?=base_url()?>css/gws_new/images/display_img8.png" alt="" /><br />
              <p class="description">Create and manage your newsletter from a user friendly interface. Create autoresponders and automate your communication with clients!</p>
            </div></td>
        </tr>
      </table>
    </div>
  </div>
  <br clear="all" />
  <br clear="all" />
  <br clear="all" />
</div>