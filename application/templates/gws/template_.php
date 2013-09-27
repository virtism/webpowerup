<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gws<?=$title?></title>

<link rel="stylesheet" href="<?=base_url()?>css/gws/style.css" />
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

<script type="text/javascript">
$(document).ready(function(){
    
    $('#mainmenu').slidePanel({
        triggerName: '#trigger1',
        position: 'relative',
        speed: 'slow',
        ajax: false,
        ajaxSource: null,
        clickOutsideToClose: false
    });
    
});      
</script>

</head>

<body>

<div id="container">
    			
    <div id="top">
        <div id="logo">
               <!-- <img src="<?=base_url()?>css/gws/images/logo.png" /> -->
               <? $this->load->view('gws/logo');  ?>
        </div>
        <div id="welcomeandlogin">
             <?php $this->load->view('gws/menu'); ?>
             <!--
             <div id="welcome">
                Hello Danial
             </div>
             
             <div id="login">
                <a href="<?=base_url()?>index.php/UsersController/logout">logout</a> 
             </div>
             
             <div id="homesmall">
                <form name="homesmallbtn">
                <input type="button" id="bluelogin" />
                </form>
             </div>
             -->
             
        </div>
        
        <div id="nevigation">
            <?php $this->load->view('gws/header');?>
            <!--
            <div id="homebg">
                <div id="homebtn">
                        <form name="hombtn">
                        <input type="button" id="silverbtn" style="cursor:pointer;" onclick="document.location='<?=base_url()?>index.php/SiteController/sitebuilder/';" />
                        </form>
                </div>
            </div>
            
            <div id="nevibg">
                <div id="nevistuff">
                     <div id="notify">
                          <img src="<?=base_url()?>css/gws/images/notifications.png" />
                     </div>
                     
                     <div id="newmail">
                         <div id="newmailtxt">
                               New Mail
                         </div>
                          
                          <div id="newmailicon">
                                <form name="neviemailbtn">
                                <input type="button" id="emailicon" />
                                </form>
                          </div>
                     </div>
                     
                     <div id="confrcall">
                            <div id="confrcalltxt">
                                   Conference Call
                            </div>
                            
                            <div id="confrcallicon">
                                    <form name="ccallbtn">
                                    <input type="button" id="ccallicon" />
                                    </form>
                            </div>
                     </div>
                     
                     <div id="supporttkt">
                            <div id="supporttkttxt">
                                   Support Ticket
                            </div>
                            
                            <div id="supporttkticon">
                                <form name="suprttktbtn">
                                <input type="button" id="suprttkticon" />
                                </form>
                            </div>
                     </div>
                     
                     <div id="neworder">
                         <div id="newordertxt">
                                New Order
                         </div>
                         <div id="newordericon">
                                <form name="newordrbtn">
                                <input type="button" id="newordricon" />
                                </form>
                         </div>
                     </div>
                     
                     <div id="dividernevi">
                           <img src="<?=base_url()?>css/gws/images/nevidivider.png" />
                     </div>
                     
                     <div id="refresh">
                            <form name="refreshbtn">
                            <input type="button" id="refreshicon" />
                            </form>
                     </div>
                     
                     <div id="helpbtn">
                            <form name="helpbutton">
                            <input type="button" id="helpbtnn" />
                            </form>
                     </div>
                </div>
            </div>
            -->
       </div>
    </div>
        
    
    <!--
    <div id="mainmenu" style="visibility: hidden;position: absolute;">
    -->
    <table  height="950" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
    <div id="mainmenu" class="panel" style="width:198px">
        <div id="topmm">
           <div id="datentime">
                <div id="date">
                        <?php echo date('M d, Y');?>
                </div>
                
                <div id="time">
                        <?php echo date('h:i');?>
                </div>
          </div>
        </div>
                    
    <div id="mmbg">
        <?php $this->load->view('gws/sidebar');?>
            
        <!--
        <div id="buttons">
            <div id="profnset">
                <form name="pnsbutton">
                <input type="button" id="mmprof" />
                </form>
            </div>
            
            <div id="emails">
                <form name="emailsbutton">
                <input type="button" id="mmemail" />
                </form>
            </div>
            
            <div id="mywebpage">
                <form name="mwpbutton">
                <input type="button" id="mmmwp" />
                </form>
            </div>
            
            <div id="designandconfig">
                <form name="dandcbutton">
                <input type="button" id="mmdnc" />
                </form>
            </div>
            
            <div id="membersandgroups">
                <form name="mandgbutton">
                <input type="button" id="mmmg" />
                </form>
            </div>
            
            <div id="newsletters">
                <form name="nlbutton">
                <input type="button" id="mmnl" />
                </form>
            </div>
            
            <div id="invoices">
                <form name="invibutton">
                <input type="button" id="mminv" />
                </form>
            </div>
            
            <div id="appointments">
                <form name="appointbutton">
                <input type="button" id="mmapoint" />
                </form>
            </div>
            
            <div id="clients">
                <form name="clintsbutton">
                <input type="button" id="mmclint" />
                </form>
            </div>
            
            <div id="supportticket">
                <form name="stbutton">
                <input type="button" id="mmstk" />
                </form>
            </div>
            
            <div id="reviews">
                <form name="reviewbutton">
                <input type="button" id="mmreview" />
                </form>
            </div>
            
            <div id="ecommerce">
                <form name="ecombutton">
                <input type="button" id="mmecom" />
                </form>
            </div>
            
            <div id="registrationform">
                <form name="registbutton">
                <input type="button" id="mmregf" />
                </form>
            </div>
            
            <div id="promotionalboxes">
                <form name="prombbutton">
                <input type="button" id="mmpromb" />
                </form>
            </div>
            
            <div id="contactmanage">
                <form name="conmbutton">
                <input type="button" id="mmcm" />
                </form>
            </div>
            
            <div id="quickconference">
                <form name="qcbutton">
                <input type="button" id="mmqc" />
                </form>
            </div>
            
            <div id="eventcalander">
                <form name="eventcbutton">
                <input type="button" id="mmevc" />
                </form>
            </div>
            
            <div id="rdpartyconfig">
                <form name="3rdconfigbutton">
                <input type="button" id="mmrdpc" />
                </form>
            </div>
        </div>
        -->
        
    </div>
        </td>
        <td valign="top">
            <div style="cursor:pointer;background-image:url('<?=base_url()?>images/menu_icon.jpg');background-repeat:no-repeat;width:20px;height:40px;position:relative;margin-bottom:20px;" id="trigger1">
    </div>
        
    
               
    		
            
    </div>
        </td>
        <td valign="top" width="100%">
    <div style="border:0px solid black; float:right;">                       
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
                <form name="searchform" action="">
                <input type="text" value="search" id="searcher" />
                </form>
            </div> 
        </div>
    </div>
    
    <table align="center" class="content" width="730" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td><?=$content?></td>
        </tr>
    </table>
        </td>
    </tr>
    </table>
</div>				
     
</body>
</html>
