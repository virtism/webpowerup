<p>
&copy; copyright 2006 <strong>GWS</strong>&nbsp;&nbsp;  

Powered by: <a href="http://www.styleshout.com/">Virtism</a> | 
Valid: <a href="http://validator.w3.org/check/referer">XHTML</a> | 
<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        
<?php
for($i=0; $i<count($footer_navigation); $i++)
{
    if($mode == 'edit')
    {
        $link = 'javascript: void(0);';
    }
    else
    {
        $link = base_url().'index.php/site_preview/page/'.$footer_navigation[$i]['site_id'].'/'.$footer_navigation[$i]['page_id'];     
    }
    if($i>0)
    {
        echo stripslashes($footer_content); 
    }
?>
    <a href="<?=$link?>"><?=$footer_navigation[$i]['page_title']?></a> 
<?php   
}
?> 
</p>        