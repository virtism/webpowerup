<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="<?=base_url(); ?>css/gymnastic/Stylesheet.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?=$_scripts?>
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
<meta name="Author" content="Mudassar Ali Sahil - sahil_bwp@yahoo.com - +92 334 6862971" />
<meta name="Robots" content="index,follow" />
<title><?=$title?></title>


<?php
if(!isset($page_header))
{
    $page_header = '';
}
if($page_header=='Slideshow')
{
?>
<script type="text/javascript">
$(document).ready(function() {
    $('.slideshow').cycle({
        fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    });
});
</script>
<?php
}
?>

</head>

<?php 
 $strBodyStyle = '';
if($page_header=='Slideshow' || $page_header=='Other')
{
    $strBodyStyle = 'style="background: none;"';
}
?>
<body <?=$strBodyStyle?>>




<div id="container">
<div id="backgroundshine">
    <div id="top">
    
<?php
$strStyle = '';
if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
{
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

 <?php
if($page_header=='Other')
{
?>     
        <div class="topinfonlogo" <?=$strStyle?>>
                <img src="<?=$header_image?>" style="width:960px; height:128px;" /> 
        </div>    
        
        
          
 <?php       }
else if($page_header=='Slideshow')
{
?> 

        <div class="slideshow"  >
           <?php 
                foreach($header_image->result_array() as $rowImage)
                {
           ?>
            <!--<img src="<?=base_url(); ?>css/gymnastic/Images/bigimage.png" /> -->
            <img style="width:960px; height:128px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
           <?php
                }
           ?>
        </div>
        
 <?php
}
?> 
 <?php
    if($page_header!='Slideshow' && $page_header!='Other')
    {
    ?>
  <div class="topinfonlogo" <?=$strStyle?>>
            <div id="logo">
                <?php // $this->load->view('gymnastic/logo');  ?>  
                <?=$logo?>  
            </div>
            <div class="smallinfotop">
                <div class="toplinea">
                    sit amet, consectetuer adipiscing elit, nonummy.
                </div>
                <div class="toplineb">
                    Lamet, consectetuer adipiscing elit, nonummy.
                </div>
                <div class="toplineb">
                    Lorem amet, sed diam nonummy.
                </div>
            </div>
        </div>
    
        <?php
    }
    ?>    

  

    
   
        <div id="nevigation">
           <?php // $this->load->view('all_common/menu',$menu);
            // print_r(); exit();
          ?>
          <?=$menu?> 
          <? //=$other_top_navigation?>
        
<!--        <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">Home</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">Anything</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">About</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">Events</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">Activities</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonleftround.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtn">
                        <a href="template.html">FAQs</a>
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/navigationnormalbuttonrightround.png" />
                </div>
            </div>
            <div class="empty">
            </div>
            <div class="nevibuttona">
                <div class="leftroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/fbbuttonnevileftroound.png" />
                </div>
                <div class="midnevibtn">
                    <div class="titlemidnevibtnfb">
                        <img src="<?=base_url(); ?>css/gymnastic/Images/fbbuttonnevimid.png" />
                    </div>
                </div>
                <div class="rightroundnevibtn">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/fbbuttonnevirightround.png" />
                </div>
            </div> -->
        </div>
    </div>
    <div id="mid">
   
    
                       
    
        <!--<div class="bigimage">
            
            <img src="<?=$header_image?>" style="width:960px; height:428px;" /> 
            <img src="<?=base_url(); ?>css/gymnastic/Images/bigimage.png" />
        </div> -->
        

        
        
        
        
        <?=$content?>
<!--  Content Area      -->
        <!--<div class="belowthebigimage">
            <div class="eventbox">
                <div class="eventboxtop">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/botleftbluecolumntop.png" />
                </div>
                <div class="eventboxmid">
                    <div class="headingevent">
                        Latest News
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    23
                                </div>
                                <div class="monthcale">
                                    OCT
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    30
                                </div>
                                <div class="monthcale">
                                    NOV
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    31
                                </div>
                                <div class="monthcale">
                                    DEC
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="morenews">
                        <a href="template.html">more news >></a>
                    </div>
                </div> 
                <div class="eventboxtop">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/botleftbluecolumnbot.png" />
                </div>
            </div>
            <div class="welcomebox">
                <div class="welcomeboxtop">
                    <img src="<?=base_url(); ?>css/gymnastic/Images/whiteboxnexttobluetopround.png" />
                </div>
                <div class="welcomeboxmid">
                        <div class="titlewelcome">
                        Welcome to Our Website!
                        </div>
                        <div class="leftwelcome">
                            <div class="smallimagewelcome">
                                <img src="<?=base_url(); ?>css/gymnastic/Images/lowersmall images.png" />
                            </div>
                            <div class="welcometxt">
                                <a href="template.html">Lorem ipsum dolor sit amet,</a> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </div>
                            <div class="buttonwelcome">
                                <form name="orange"><input type="button" class="welcomepress" /></form>
                            </div>
                        </div>
                        <div class="leftwelcome">
                            <div class="smallimagewelcome">
                                <img src="<?=base_url(); ?>css/gymnastic/Images/lowersmall images.png" />
                            </div>
                            <div class="welcometxt">
                                <a href="template.html">Lorem ipsum dolor sit amet,</a> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </div>
                            <div class="buttonwelcome">
                                <form name="orange"><input type="button" class="welcomepress" /></form>
                            </div>
                        </div>
                </div>
                <div class="welcomeboxbot">
                            <img src="<?=base_url(); ?>css/gymnastic/Images/whiteboxnexttobluebotround.png" />
                </div>
            </div>
        </div> -->                       
<!--  Content Area      --> 
    </div>
    <div class="clear">
    </div>
    <div id="footer">
        <?php  $this->load->view('gymnastic/footer');  ?> 
    </div>
</div>
</div>
</body>
</html>
