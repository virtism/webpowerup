<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<?=$_scripts?>
<?=$_styles?>
<style type="text/css">
div.menu_nav ul 
{
    list-style: none;
    padding: 0;
    margin: 0;
}
div.menu_nav li 
{
    float: left;
    position: relative;
}
div.menu_nav ul ul li 
{
    width: 150px;
}
div.menu_nav ul#nav li a 
{
    display: block;
    
}
div.menu_nav li ul 
{
    display: none;
    position: absolute;
    width:150px;
    top: 0;
    left: 0;
    margin-left:-1px;
}
div.menu_nav li>ul 
{
    top: auto;
    left: auto;
    
}
div.menu_nav li:hover ul, div.menu_nav li.over ul 
{
    display: block;
}

</style>
<title><?= $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if(!isset($description))
{
	$description = "";    
}
?>
<meta name="description" content="<?=$description?>" />
<?php
if(!isset($keywords))
{
	$keywords = "";    
}
?>
<meta name="keywords" content="<?=$keywords?>" />
<link href="<?php echo base_url(); ?>css/winglobal/style.css" rel="stylesheet" type="text/css" />
<!-- problem area commented   
<script type="text/javascript" src="<?=base_url(); ?>css/winglobal/js/cufon-yui.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/arial.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/cuf_run.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>css/winglobal/js/radius.js"></script>
 -->  
<?php
if(!isset($page_header))
{
    $page_header = '';
}
//if($page_header=='Slideshow')
//{
?>
<script type="text/javascript" src="<?=base_url()?>js/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
<?php
//}
?>

</head>   
<body>
<?php
$strStyle = '';    
if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
{
    //$strBackgroundColor = 'style="background-color: #'.$header_background.'"';
    //$strBackgroundColor = '#'.$header_background;
    if($header_background == 'Image')
    {
        $strStyle = 'style="background-image:url('."'".$header_background_image."'".'); background-repeat: repeat;"';
    }   
    else
    {
        $strStyle = 'style="background-color:#'.$header_background.'"';        
    }    
}
?>   

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr <?=$strStyle?>>
                <td>&nbsp;</td>
                <td width="970">
                    <?php
                    if($page_header=='Other')
                    {
                    ?>
                        <img src="<?=$header_image?>" style="width:100%" />        
                    <?php
                    }
                    else if($page_header=='Slideshow')
                    {?>
                        <div class="slideshow">
                            <?php 
                            foreach($header_image->result_array() as $rowImage)
                            {
                            ?>
                            <img style="width: 100%;" src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />    
                            <?php
                            }
                            ?>
                        </div>        
                    <?php
                    }
                    ?>
                    
                    <div class="menu_nav" style="position: absolute;top:0px;margin-left:450px; z-index: 999;">
                    <ul>
                        <?=$menu?>
                    </ul>
                    </div>
                    
                    <?php
                    if($page_header=='Default')
                    {
                    ?>
                        <div class="logo"> 
                        <?php $this->load->view('winglobal/logo'); ?>
                        </div>    
                    <?php
                    }
                    ?>
                    
                    <div class="clr"></div>
                    
                </td>
                <td>&nbsp;</td>
            </tr>  
        </table>

<div class="main">
  <div class="header" style="height: 120px;">
    <!--
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
	-->
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
        <?php
        if(!isset($mode))
        {
            $mode = '';
        }
        if($mode=='edit')
        {
            /*
            $strHeader = '<div style="border:dotted 1px #CECECE;"><h2>'.$title.'
            <a class="edit_title" href="'.base_url().'index.php/page_editor/editPageTitle/'.$site_id.'/'.$page_id.'"><img style="border:none; cursor: pointer" src="'.base_url().'images/edit_icon.jpg" /></a></h2></div>';
            */
            $strHeader = '<div style="border:dotted 1px #CECECE;"><h2>'.$title.'
            <a style="font-size:10px;" class="edit_title" href="'.base_url().'index.php/page_editor/editPageTitle/'.$site_id.'/'.$page_id.'">Edit Title</a></h2></div>';
        }
        else
        {
            $strHeader = '<h2>'.$title.'</h2>';    
        }
        ?>
        <?=$strHeader?>
		<?=$content?>
	</div>
<!-- End manin Content   -->      
	  
<!-- Sidebar  -->
	  <div class="sidebar">
	  <?=$sidebar?>
	  <?php //$this->load->view('winglobal/sidebar'); ?>
	  </div>
<!-- End Sidebar  -->      
	  
	  <div class="clr"></div>
	</div>
  </div>
  <div class="fbg">
  
<!-- Footer 1 -->
	<div class="fbg_resize">
    <?php //$this->load->view('winglobal/footer'); ?>
    <?=$footer?>
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
