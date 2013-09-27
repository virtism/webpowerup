<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gws<?=$title?></title>
<?=$_scripts?>
<link rel="stylesheet" href="<?=base_url()?>css/gws/style.css" />

   
<link rel="stylesheet" href="<?=base_url()?>css/gws/forms.css" />  


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

<script type="text/javascript" src="<?=base_url(); ?>css/winglobal/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/arial.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/cuf_run.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/radius.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script src="<?=base_url()?>js/jqEasySlidePanel/js/jquery.slidePanel.js" type="text/javascript" language="javascript"></script>
<script src="<?=base_url()?>js/jqEasySlidePanel/js/jquery.slidePanel.min.js" type="text/javascript" language="javascript"></script>
<script src="<?=base_url()?>js/jquery.tablednd_0_5.js" type="text/javascript" language="javascript"></script>

<!-- Home Page Slider Start -->



<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws/gws/style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws/gws/advanced-slider-base.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws/gws/curved-square/curved-square.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws/gws/scrollbar-7-light/scrollbar-7-light.css" media="screen"/>


<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.advancedSlider.min.js"></script>



<!--
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
-->
<script type="text/javascript" src="<?=base_url()?>js/jquery.cycle.all.js"></script>
<script type="text/javascript">
/*
$(document).ready(function() {    
	$('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
*/ 
</script>

<script type="text/javascript">
 
flagShow = true;
function slidePanel()
{
	var mainmenu = document.getElementById('mainmenu');
	var menu_nav = document.getElementById('menu_nav');
	if(flagShow == true)
	{
		$("#mainmenu").animate({marginLeft:'-200px', opacity:'toggle'}, '2000', 'linear');
		setTimeout("showImage()",500);
		flagShow = false;    
	}
	else
	{
		$("#mainmenu").animate({marginLeft:'0px', opacity:'toggle'}, '2000', 'linear');
		setTimeout("hideImage()",500);
		flagShow = true;     
	}
	
} 
function showImage()
{
	var menu_nav = document.getElementById('menu_nav');
	menu_nav.style.backgroundImage="url('<?=base_url()?>css/gws/images/right.png')";
	return;    
}  
function hideImage()
{
	var menu_nav = document.getElementById('menu_nav');
	menu_nav.style.backgroundImage="url('<?=base_url()?>css/gws/images/left.png')";
	return;            
}


</script>

</head>
<?php
$bg = '';
$display = '';
	//echo "<pre>";
	//print_r($_SERVER);
	//	echo $_SERVER['REQUEST_URI'];
	//$url = str_replace('/','',$_SERVER["REQUEST_URI"]);
//	$this->uri->segment(2)
	$URL = $_SERVER['REQUEST_URI'];
	$flag = false;
	if(trim($URL)=='/index.php/UsersController/login/sitelogin' || trim($URL)=='/' || trim($URL)=='/index.php/SiteController/sitebuilder/')
	{
		//echo "if";
		$bg = 'style = "background:url('.base_url().'css/gws/images/bg3.png) no-repeat center top #EDEDED ; "';
		$display = '';
		$flag = true;
	}
	else
	{
		$bg = 'style = "background:url('.base_url().'css/gws/images/bg.jpg)"';
		$display = 'style = "display : none;"';
		
	}
?>

<body <?=$bg?>  >

<? 
	if($flag)
	{
		echo "<div>";
	}else
	{
		echo "<div id='top-bar'>";
		?>
		<a href="<?=base_url()?>"><img height="30" style="border: none;" src="<?=base_url()?>css/gws/images/logo.png" /></a>
		<?
	}
	echo $this->load->view('gws/header');
	echo "</div>";

?>	
<div  <?=$display?>>
		<p class="curent_site"><!--Current Site : Show Site title ( http://siteurl.com)--></p>
		<div class="top-nav-bar">
		  <?php
		 
                if(isset($_SESSION['current_site_info'])){
                    if(!empty($_SESSION['current_site_info'])){
                ?>
          <?php /*?>  <div class="tab_site">
               <table  border="0" cellpadding="0" cellspacing="0">
                  <tr>        
                    <td width="189" ><div class="link_div"><a class="red_link" href="<?=base_url().index_page()?>SiteController/sitebuilder/">Manage A Different Site</a></div></td>
                    <td width="172"><div class="link_div"><?=$_SESSION['current_site_info']["site_name"]?></div></td>
                    <td width="273"><div class="link_div"><?=$_SESSION['current_site_info']["site_url"]?></div></td>
                    <td width="112"><div class="link_div"><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$_SESSION['current_site_info']["site_id"]?>">Preview</a>&nbsp;|&nbsp;<a href="<?=base_url().index_page()?>SiteController/sitehome/<?=$_SESSION['current_site_info']["site_id"]?>">Manage</a></div></td>
                    </tr>
                </table> 
            </div><?php */?>
            <?php  } } ?>
			<?php /*?><ul>
				<li style="margin-left: 600px;"><a href="#">Home</a></li>
				<li><a href="#">Dashboard</a></li>
				<li><a href="#">Site Preview</a></li>
				<?php if($_SESSION)
				{
					echo '<li><a href="http://stage.globalonlinewebsitesolutions.com/UsersController/logout">logout</a></li>';
					
				}
				else
				{
					echo '<li><a href="#">Login</a></li>';
				}
				?>
			</ul><?php */?>
		</div>
	</div>
	<div id="container">
				
	<div id="top">
		<? if($flag)
		{ ?>
			<div id="logo">
				   <? $this->load->view('gws/logo');  ?>
			</div>
		<? } ?>
        <div class="clear"> </div>

        <div class="current_site">
                <?php
                if(isset($_SESSION['current_site_info'])){
                    if(!empty($_SESSION['current_site_info'])){
                ?>
            <!--<div class="tab_site">
               <table  border="0" cellpadding="0" cellspacing="0">
                  <tr>        
                    <td width="189" ><div class="link_div"><a class="red_link" href="<?=base_url().index_page()?>SiteController/sitebuilder/">Manage A Different Site</a></div></td>
                    <td width="172"><div class="link_div"><?=$_SESSION['current_site_info']["site_name"]?></div></td>
                    <td width="273"><div class="link_div"><?=$_SESSION['current_site_info']["site_url"]?></div></td>
                    <td width="112"><div class="link_div"><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$_SESSION['current_site_info']["site_id"]?>">Preview</a>&nbsp;|&nbsp;<a href="<?=base_url().index_page()?>SiteController/sitehome/<?=$_SESSION['current_site_info']["site_id"]?>">Manage</a></div></td>
                    </tr>
                </table> 
            </div>-->
            <?php  } } ?>
        </div>
	</div>
		
	
	<table  height="950" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
	<!--<div id="mainmenu" class="panel" style="width:198px">
		<div id="topmm">
		   <div id="datentime">
				<div id="date">
						<?php echo date('M d, Y');?>
				</div>
				
				<div id="time">
						<?php echo date('h:i a');?>
				</div>
		  </div>
		</div>-->
					
	<!--<div id="mmbg">
		<?php //$this->load->view('gws/sidebar');?>
	</div>-->
	
		</td>
		<td valign="top">
			<!--<div onclick="slidePanel()" style="z-index: 999;cursor:pointer;background-image:url('<?=base_url()?>css/gws/images/left.png');background-repeat:no-repeat;width:25px;height:100px;position:relative;margin-top:400px;" id="menu_nav">
			</div>-->
		</td>
		
		<td valign="top" width="100%">
	<!--<div style="border:0px solid black; float:right;padding-right:13px;">                       
		<div id="dsandbw"> 
			<div id="diskspace">
				<img src="<?=base_url()?>css/gws/images/diskspace.png" /> 
			</div>
			<div id="bandwidth">
				<img src="<?=base_url()?>css/gws/images/bandwidth.png" />
			</div>    
		</div>
				
		<div id="searchbg">
			<div id="searchbar">
				<form name="searchform" action="" class="gws_form">
				<input type="text" value="search" id="searcher" />
				</form>
			</div> 
		</div>
	</div>-->
	
	<table id="container_content" align="center" class="content" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
			<td><?=$content?></td>
		</tr>
	</table>
		</td>
	</tr>
	</table>

	</div>
	</div>
	<!--Foooter-->
	<div id="footer">
		<div class="footer">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Features</a></li>
				<li><a href="#">Privacy</a></li>
				<li><a href="#">About-us</a></li>
				<li><a href="#">Contact-us</a></li>
			</ul>
		</div>
	</div>
	<!--/Foooter--> 
</body>
	

</html>