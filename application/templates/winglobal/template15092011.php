<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if(!isset($page_desc))
{
	$page_desc = "";    
}
?>
<meta name="description" content="<?=$page_desc?>" />
<?php
if(!isset($page_keywords))
{
	$page_keywords = "";    
}
?>
<meta name="keywords" content="<?=$page_keywords?>" />
<link href="<?php echo base_url(); ?>css/winglobal/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=base_url(); ?>css/winglobal/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/arial.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/cuf_run.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/radius.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!--
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
-->
<script type="text/javascript" src="<?=base_url()?>js/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
</head>
<body>
<div class="main">
  <div class="header">
	<div class="header_resize">
	
	  <div class="menu_nav">
		<ul>
			<?php $this->load->view('all_common/menu'); ?>  
		</ul>
	  </div>
	  
	  <div class="logo">
	   <?php $this->load->view('winglobal/logo'); ?> 
	  </div>
	  <div class="clr"></div>
	
	</div> 
  </div>
  <div class="content">
    
    <?php
    if(!isset($background_image))
    {
        $background_image = '';    
    }
    $strStyle = "";
    if($background_image!="" && $background_area=='page' && $background_style=='stretch')
    {
        $strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
    }
    else if($background_image!="" && $background_area=='page' && $background_style=='tile')
    {
        $strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
    }
    ?>
	<div class="content_resize" style="<?=$strStyle?>">
	
      <?=$header;?>
 
<!-- main Content   -->
	
    <?php
    $strStyle = "";
    if($background_image!="" && $background_area=='content' && $background_style=='stretch')
    {
        $strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
    }
    else if($background_image!="" && $background_area=='content' && $background_style=='tile')
    {
        $strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
    }
    ?>
	  <div class="mainbar" style="<?=$strStyle?>">
        <h2><?=$title?></h2>
		<?=$content?>
		<!--<div class="article">
		  <h2><span>Future</span> technology</h2>
		  <div class="clr"></div>
		  <p class="infopost"><span class="date">On 29 aug 2010</span> Posted by <a href="#">Owner</a> &nbsp;|&nbsp; Filed under <a href="#">templates</a>, <a href="#">internet</a> &nbsp;|&nbsp; with <a href="#" class="com">Comments (<span>7</span>)</a></p>
		  <img src="images/img2.jpg" width="201" height="141" alt="" class="fl" />
		  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</a> Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam.</p>
		  <p>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla. Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
		  <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
		</div>-->
	  </div>
<!-- End manin Content   -->      
	  
<!-- Sidebar  -->
	  <div class="sidebar">
	  <?=$sidebar?>
	  <?php //$this->load->view('winglobal/sidebar'); ?>
		  
<!--        <div class="searchform">
		  <form id="formsearch" name="formsearch" method="post" action="#">
			<span>
			<input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" />
			</span>
			<input name="button_search" src="images/search_btn.gif" class="button_search" type="image" />
		  </form>
		</div>
		<div class="gadget">
		  <h2 class="star"><span>Sidebar</span> Menu</h2>
		  <div class="clr"></div>
		  <ul class="sb_menu">
			<li><a href="#">Home</a></li>
			<li><a href="#">TemplateInfo</a></li>
			<li><a href="#">Style Demo</a></li>
			<li><a href="#">Blog</a></li>
			<li><a href="#">Archives</a></li>
			<li><a href="#">Web Templates</a></li>
		  </ul>
		</div>
		<div class="gadget">
		  <h2 class="star"><span>Sponsors</span></h2>
		  <div class="clr"></div>
		  <ul class="ex_menu">
			<li><a href="http://www.dreamtemplate.com">DreamTemplate</a><br />
			  Over 6,000+ Premium Web Templates</li>
			<li><a href="http://www.templatesold.com/">TemplateSOLD</a><br />
			  Premium WordPress &amp; Joomla Themes</li>
			<li><a href="http://www.imhosted.com">ImHosted.com</a><br />
			  Affordable Web Hosting Provider</li>
			<li><a href="http://www.myvectorstore.com">MyVectorStore</a><br />
			  Royalty Free Stock Icons</li>
			<li><a href="http://www.evrsoft.com">Evrsoft</a><br />
			  Website Builder Software &amp; Tools</li>
			<li><a href="http://www.csshub.com/">CSS Hub</a><br />
			  Premium CSS Templates</li>
		  </ul>
		</div>-->
	  </div>
<!-- End Sidebar  -->      
	  
	  <div class="clr"></div>
	</div>
  </div>
  <div class="fbg">
  
<!-- Footer 1 -->
	<div class="fbg_resize">
	<?php $this->load->view('winglobal/footer'); ?>
<!--      <div class="col c1">
		<h2><span>Image Gallery</span></h2>
		<a href="#"><img src="images/pix1.jpg" width="58" height="58" alt="" /></a> <a href="#"><img src="images/pix2.jpg" width="58" height="58" alt="" /></a> <a href="#"><img src="images/pix3.jpg" width="58" height="58" alt="" /></a> <a href="#"><img src="images/pix4.jpg" width="58" height="58" alt="" /></a> <a href="#"><img src="images/pix5.jpg" width="58" height="58" alt="" /></a> <a href="#"><img src="images/pix6.jpg" width="58" height="58" alt="" /></a> </div>
	  <div class="col c2">
		<h2><span>Lorem Ipsum</span></h2>
		<p>Lorem ipsum dolor<br />
		  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi tincidunt, orci ac convallis aliquam</a>, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam.</p>
	  </div>
	  <div class="col c3">
		<h2><span>Contact</span></h2>
		<p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue.</p>
		<p><a href="#">support@yoursite.com</a></p>
		<p>+1 (123) 444-5677<br />
		  +1 (123) 444-5678</p>
		<p>Address: 123 TemplateAccess Rd1</p>
	  </div>-->
	  <div class="clr"></div>
	</div>
  </div>
  <div class="footer">
  <!-- Footer 2 -->
	<div class="footer_resize">
	  <?php $this->load->view('winglobal/footer2'); ?> 
	</div>
  </div>
</div>
</body>
</html>
