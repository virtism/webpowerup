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
@import "<?=base_url()?>css/gws_new/css/styles.css";
@import "<?=base_url()?>css/gws_new/css/styleOld.css";
@import "<?=base_url()?>css/gws_new/css/forms.css";


</style>

<script type="text/javascript" src="<?=base_url()?>css/gws_new/js/jquery.js" ></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('.what_we_do_button').click(function(){
	$('.what_we_do_div_container').slideToggle('slow');
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

<body <? if($this->uri->uri_string() == ''){?> onload="MM_preloadImages('<?=base_url()?>css/gws_new/images/pricing_hover.png')" <? }?> >
<div id="header">

	<?
	echo $this->load->view('gws/logo');
	echo $this->load->view('gws/header');

?>	
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
		
	<? if($this->uri->uri_string() == '')
	    {
		  echo $content;
		}
	else
	   {
	?>
	<table height="450" border="0" cellpadding="0" cellspacing="0" id="wrapper" id="container_content">
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
	
	<table style="width:100%;" id="container_content" align="center" id="contents" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
			<td><div style="height:auto;" id="dashboard"><?=$content?></div></td>
		</tr>
	</table>
		</td>
	</tr>
	</table>

	<? }?>
	<!--Foooter-->
	<div id="footer">
		<?
	echo $this->load->view('gws/footer');
	

?>
	
	</div>
	<!--/Foooter--> 
</body>
	

</html>