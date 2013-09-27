<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?=$_scripts?>
<?=$_styles?>
<?php
if(!isset($description))
{
    $description = "";    
}
?>

<?php
if(!isset($keywords))
{
    $keywords = "";    
}
?>
<title><?=$title?></title>
<meta name="Keywords" content="<?=$keywords?>" /> 
<meta name="Description" content="<?=$description?>" />

<link rel="stylesheet" media="screen" href="<?=base_url(); ?>css/shiptime/style.css" />

<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /><!-- custom favicon -->
<meta name="Author" content="Mudassar Ali - virtism.com" />
<meta name="Robots" content="index,Take a tour , help center" />
<meta http-equiv="imagetoolbar" content="no" /><!-- disable IE's image toolbar -->

</head>

<body>
<div id="daddy">
   <div id="logoandnevigation">
    <div id="logo">
        <!--<a href="./"><img src="<?=base_url(); ?>css/shiptime/images/logo.png" alt="Your Company Logo" /></a>
        <span id="logo-text"><a href="./">&nbsp;</a></span>  -->
        
        <?php  $this->load->view('shiptime/logo');  ?> 
    </div>
        <!-- logo -->
    <div id="header">
        <div id="topsmallbuttons">    
            <div id="tweeterbutton">
                <form name="homesmallbtn"><input type="button" id="smallsatweet" /></form>
            </div>
            <div id="facebookbutton">
                <form name="homesmallbtn"><input type="button" id="smallsafb" /></form>
            </div>
            <div id="insmallbutton">
                <form name="homesmallbtn"><input type="button" id="insmallsabutton" /></form>
            </div>
        </div>
        <div id="nevigation">
            <div id="leftroundside">
                    <img src="<?=base_url(); ?>css/shiptime/images/leftnevinormbtnside.png" />
            </div>
            <div class="menu">
             
                <ul>
                <?=$menu?>
                   <!-- <li><a href="./" id="active">Home</a></li>
                    <li><a href="./">Take A tour</a></li>
                    <li><a href="./">Stories</a></li>
                    <li><a href="./">Sign up</a></li>
                    <li><a href="./">Learning Center</a></li>
                    <li><a href="./">Help Center</a></li>
                    <li><a href="./">Contact Support</a></li>  -->
                </ul>
                <!--<img src="images/menu2.png" alt="Your " border="0"  />-->
    </div>
            <div id="rightroundside">
                    <img src="<?=base_url(); ?>css/shiptime/images/rightnevinormbtnside.png" />
            </div>
        </div>
        
        
    </div>
   </div><!-- menu -->
        <!-- headerimage -->
    <!-- header -->
    <div id="clear"> </div>
    
    <div id="content">
           <div id="cA"> 
           <?php //  $this->load->view('shiptime/sidebar');  ?> 
             <?=$sidebar?>
            </div>
            <div id="cB">
                <?php
                if(!isset($mode))
                {
                    $mode = '';
                }
                if($mode=='edit')
                {
                    $strHeader = '<div id="page_title">'.$title.'
                    <a class="edit_title" href="'.base_url().'index.php/page_editor/editPageTitle/'.$site_id.'/'.$page_id.'"><img style="border:none; cursor: pointer" src="'.base_url().'images/edit_icon.jpg" /></a></div>';
                }
                else
                {
                    $strHeader = '<div id="page_title">'.$title.'</div>';    
                }
                ?>
                <?=$strHeader?>
                <?=$content?>  
           <?php // $this->load->view('shiptime/content');  ?> 
           </div>
    </div><!-- content -->

</div><!-- daddy -->
<!-- footer starts here --> 
<div id="footer">    
    <?php  $this->load->view('shiptime/footer');  ?> 
       <?=$footer?> 
     
</div>
    <!-- footer ends here --> 
</div><!-- footer -->
</body>
</html>
