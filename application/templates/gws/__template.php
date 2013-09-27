<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>WebpowerUp!<?=$title?></title>
<?=$_scripts?>


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
<style type="text/css">
@import "<?=base_url()?>css/gws_new/css/reset.css";
@import "<?=base_url()?>css/gws_new/css/style.css";
</style>
<script type="text/javascript" src="<?=base_url()?>css/gws_new/js/jquery.js" ></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('.what_we_do_button').click(function(){
	$('.what_we_do_div_container').slideToggle('slow');
	});
	
	
	
	

});





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
									 horizontalSlices: 8, verticalSlices: 4,
									 slideProperties:{
										 0: {effectType: 'scale'}, 
										 1: {htmlDuringTransition:false}, 
										 2: {effectType: 'fade'}, 
										 3: {htmlDuringTransition:false}, 
										 4: {effectType: 'scale', slicePattern: 'spiralMarginToCenterCW'}
									 }
									});
	});
	
</script>


<script type="text/javascript" src="<?=base_url()?>css/gws_new/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>css/gws_new/js/jquery.advancedSlider.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws_new/css/advanced-slider-base.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gws_new/css/light-round-extended/light-round-extended.css" media="screen"/>


</head>


<?php
$bg = '';
$display = '';
	//echo "<pre>";
	//print_r($_SERVER);
	//	echo $_SERVER['REQUEST_URI'];
	//$url = str_replace('/','',$_SERVER["REQUEST_URI"]);
	
	
	
	
	$URL = $_SERVER['REQUEST_URI'];
	$flag = false;
	if(trim($URL)=='/index.php/UsersController/login/sitelogin' || trim($URL)=='/' || trim($URL)=='/index.php/SiteController/sitebuilder/')
	{
		//echo "if";
		$bg = 'style = "background:url('.base_url().'css/gws_new/images/bg3.png) no-repeat center top #EDEDED ; "';
		$display = '';
		$flag = true;
	}
	else
	{
		//$bg = 'style = "background:url('.base_url().'css/gws/images/bg.jpg)"';
		$bg = 'style = "background:#f0eff0;"';
		$display = 'style = "display : none;"';		
	}
?>

<body onload="MM_preloadImages('images/pricing_hover.png')" >
<div id="header">

		
  <div class="top_launch_bar"><a href=""><img height="30" style="border: none;" src="<?=base_url()?>css/gws_new/images/logo.png" /></a>
	<?
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