<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gws<?=$title?></title>
<?=$_scripts?>
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

</head>

<body>

<div id="container">
                
    <div id="top">
        <div id="logo">
               <? $this->load->view('gws_admin/logo');  ?>
        </div> 
    </div>
    <table width="100%" height="250" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top" width="20%">
                 &nbsp;
                 <!--Sidebar area-->
                 <?=$sidebar?>
            </td>
            
            <td valign="top">
                &nbsp;<!--Sidebar opener-->
            </td>
            
            <td valign="top" width="100%">
                 <!--diskspace & search area-->
        
                <table align="center" class="content" width="750" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td>
                            <?=$content?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>                
     
</body>
</html>
