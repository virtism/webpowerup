<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<meta name="Robots" content="index,follow" />
<link href="css/style.css" rel="stylesheet" title="" /> 
<style type="text/css">
img, div,h1,a,span,table 
{ 
}
</style>
<style type="text/css">
	@import "<?=base_url()?>css/salima-pirani/home.css";
		
	@import "<?=base_url()?>css/salima-pirani/reset.css";
	@import "<?=base_url()?>css/salima-pirani/style.css";
	

</style>
<script src="<?=base_url()?>css/salima-pirani/png-fix.js" type="text/javascript"></script>

<script src="<?=base_url()?>css/salima-pirani/png.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/salima-pirani/engine1/style.css" />
	<style type="text/css">a#vlb{display:none}</style>
	

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
	
		if(!isset($background_image))

	{

		$background_image = '';    

	}

	

	$strStyle = "";
	
		if($background_image!="" && $background_area=='page' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

  if($background_image!="" && $background_area=='page' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

	}
	 if ($background_image!="" && $background_area=='both' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

  if($background_image!="" && $background_area=='both' && $background_style=='tile')

	{
		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

	}

?>
<body <? if($ishome == 'yes') {?> style="background:#330000;" <? } else ?>style=" <?=$strStyle?>">

<? if($ishome == 'yes')
{  ?>
<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/wowslider.js"></script>
<div id="wrapper"  style="background: url(<?=base_url()?>css/salima-pirani/images/tree.png) no-repeat scroll -14px bottom transparent; padding: 0 0 21px;width: 960px;">
<? } ?>
<div id="wrapper" >
<div id="header">
<?php

	if($page_header!='Slideshow' && $page_header !='Other')

	{

?>

<a href="index.html" class="logo"><?=$logo?></a>
<?php

	}
	else
	{
	?>
	<a href="index.html" class="logo"><?=$logo?></a>
	<?
}
?>  

<div class="top_div"><div class="member_login">
<?	  

				//echo "<pre>"; 	print_r($other_top_navigation); 	die();

			

				//This is For Top Navigation Reg Form/Shop/Help Center/Login/logout

				if(!empty($other_top_navigation) || count ($other_top_navigation) > 0 )

				{

					for($a=0; $a<count($other_top_navigation); $a++)

					{

						if($mode=='edit')

						{

							$strLink = 'javascript: void(0);';    

						}

						else

						{

							$strLink = base_url().index_page().$other_top_navigation[$a]['link'];

						}

						?>
							
						<li style="display:inline; margin-left:20px;" >

						<a href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a>

						</li>   

					<?php   

					}

				}

				else

				{

					$other_top_navigation = '';

				}	

		?>
		</div><br clear="all" />


<div class="menu">
<ul>
<?=$menu;?>

</ul>
</div>
</div></div>

  

  <style>

.ft {

    border-bottom: 2px solid #587379;

    color: #E6F3FB;

    display: block;

    font-size: 24px;

    height: 20px;

    padding: 0 0 18px;

    text-align: left;

    width: 387px;

}

	.p1{

		line-height:25px;

		font-size:12px;

		color:#FFF !important;

		text-align:left;

		padding:0 10px 0 0;

		}

  </style>
<?

 		/*****Code to Prefill BG color after image end*****/

	if(isset($color_after_image) && $background_area == "page" )

	{

		$background_color = 'style="background-color : #'.$color_after_image.';"';

	}

	else

	{

		$background_color = 'style="background-color : white;"';

	}

?>



<?php

		$strStyle = '';

if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')

{

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

	if(!isset($background_image))

	{

		$background_image = '';    

	}

	

	$strStyle = "";

   if($background_image!="" && $background_area=='menu with content' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

   if($background_image!="" && $background_area=='menu with content' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

	}


   if($background_image!="" && $background_area=='content' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

   if($background_image!="" && $background_area=='content' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat; ";

	}
  
    	$style =" style= "; 

/*    if(isset($left_menus) && sizeof($left_menus) == 0 )

    {

        $strStyle .= ' width:824px;';           

        $style .= ' width:auto;';

    }*/
 
   
	if(isset($left_menus) && sizeof($left_menus) > 0)
	{
		$strStyle .= ' width:300px;';
		$strStyle .= ' float:left;';

	}

	if(isset($right_menus) && sizeof($right_menus) > 0 && isset($left_menus) && sizeof($left_menus) > 0)

    {

		$strStyle .= ' width:200px;';

		$strStyle .= ' float:right;';          

        $style .= '';

    }		

?>
      <input type="hidden" disabled="disabled" id="786" value="temp">      

<?php

    if(isset($main_slideshows) )

	{

    

?>      

        <div class="clear"> </div><!--Main slider starts at top of content--> 

        	<div class="top_slider_div">

            	 <?=$top_slider?><!--Main slider starts at top of content-->

        	</div>

        <div class="clear"> </div>

 <?

	}

?>       



  <!--content div starts here-->

  <div id="contents" <? if(!isset($background_image)) {?>style=" <?=$strStyle?><? }?>">

 <?php

	if($page_header=='Other')

	{

?>       
		<img src="<?=$header_image?>" style="width:961px; height:153px; margin:auto" /> 	
<?php       

	}

	else if($page_header=='Slideshow')

	{

?> 

		<div class="slideshow" ><!--Header slider Begins Here-->

<?php 

	foreach($header_image->result_array() as $rowImage)

	{

?>

	  <img style="width:960px; height:125px; margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" /> <?php

	}

?>

		</div><!--Header slider Ends Here-->

		

<?php

	}

  	if(isset($left_menus) && sizeof($left_menus) > 0 )
	{
?>		

   
 <div class="left_bar">
<ul class="side_bar">

		<?=$leftbar?> 

  	</ul>
</ul>
<br clear="all" />
<div class="buttons_side_bar">
<a href="#" class="get_conect"></a>
<a href="#" class="course"></a><br clear="all" />
<a href="#" class="buk_session"></a>

</div><br clear="all" />
<ul class="social_icon">
<li><a href="#" class="f"></a></li>
<li><a href="#" class="n"></a></li>
<li><a href="#" class="b"></a></li>
<li><a href="#" class="t"></a></li>
</ul>
   </div>

<? 

	}else{
	if($ishome == 'no' or $ishome == 'ok')
	 {
	
  ?> 
  <div class="left_bar"> 
  <br clear="all" />
<div class="buttons_side_bar">
<a href="#" class="get_conect"></a>
<a href="#" class="course"></a><br clear="all" />
<a href="#" class="buk_session"></a>

</div><br clear="all" />
<ul class="social_icon">
<li><a href="#" class="f"></a></li>
<li><a href="#" class="n"></a></li>
<li><a href="#" class="b"></a></li>
<li><a href="#" class="t"></a></li>
</ul>
   </div>
   <? }} ?>

   <div class="right_bar" ><!--Main contents of the body will come here-->

  	<? 
	  if($ishome == 'ok' or $ishome == 'no')
	  {
	  if(isset($contact_form))
	    {  
	      echo $contact_form;
	    }
	  else
		{
          echo $content;
		} 
	  }
	  ?> 	  





</div>  


  <div class="clear"></div>


</div> 


<? if($ishome == 'yes')
{ ?>
  <div class="clear"></div>
<div class="side_content"><br clear="all" />
<div id="wowslider-container1">
	<div class="ws_images">
<span><img src="<?=base_url()?>css/salima-pirani/data1/images/home_qout_1.jpg" alt="Home_Qout_1" id="wows0"/>learn more</span>
<span><img src="<?=base_url()?>css/salima-pirani/data1/images/home_qout_2.jpg" alt="Home_Qout_2" id="wows1"/>for your body</span>
<span><img src="<?=base_url()?>css/salima-pirani/data1/images/home_qout_3.jpg" alt="Home_Qout_3" id="wows2"/>for your mind</span>
<span><img src="<?=base_url()?>css/salima-pirani/data1/images/home_qout_4.jpg" alt="Home_Qout_4" id="wows3"/>for your spirit</span>
</div>
<div class="ws_bullets"><div>
<a href="#wows0" title="Home_Qout_1">1</a>
<a href="#wows1" title="Home_Qout_2">2</a>
<a href="#wows2" title="Home_Qout_3">3</a>
<a href="#wows3" title="Home_Qout_4">4</a>
</div></div>
<a style="display:none" href="http://wowslider.com">Web Gallery Javascript by cdgraphic.ca v2.0</a>
	</div>
<br clear="all" />

<div class="buttons">
<a href="#" class="get_conect"></a>
<a href="#" class="course"></a>
<a href="#" class="buk_session"></a>

</div>

</div>

</div>


<? }
  if( $ishome == 'no')
	  {
 ?>

<br clear="all" />
<br clear="all" />
<div id="footer">
     <? 
	
        echo $footer;
	  ?>  
 </div></div><!--Inner footer Ends Here-->

<br clear="all" />	  
<? } else {?>
<br clear="all" />
<div id="footer_home">
<div class="side_content2">
<ul class="social_icon"><li><p class="copy_rigt">Copyright &copy; 2011 Salima Pirani. All Rights Reserved.</p></li>
<li><a href="#" class="f"></a></li>
<li><a href="#" class="n"></a></li>
<li><a href="#" class="b"></a></li>
<li><a href="#" class="t"></a></li>
</ul>

</div></div>
<br clear="all" />

</div>


	  
<? } ?>
<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/script.js"></script>
 </div>
</body>
</html>
<style type="text/css">
#editor_content {
width: 650px !important;
float: right !important;
}
</style>