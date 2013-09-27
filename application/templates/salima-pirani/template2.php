<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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
	<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/wowslider.js"></script>
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

<body style="background:#330000;">

	
<div id="header_home">
<a href="index.html" class="logo">
<?=$logo?> 

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

					

					<div class="top_div"><div class="member_login">	<a  class="li_style"  href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a>  </div><br clear="all" />

  

					<?php   

					}

				}

				else

				{

					$other_top_navigation = '';

				}	

		?>

	 <div class="menu-salima"><!--Munu div Starts Here-->

   	 <ul>

	 	<li><?=$menu?></li>

     </ul>

	
</div>
</div></div>
	
<div style="position:absolute;top:50"><img src="<?=base_url()?>css/salima-pirani/images/tree.png" hspace="50" /></div>
		<!--Munu div Ends Here-->      
<? exit();?>
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

<div id="container" <?=$background_color?>><!--Main Outer container div of body starts Here-->

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

		//Color Control For Header Area and menu BG	

		$css_header_id = "header_area";

		$menu_bg_style = "";

	

	if($strStyle  != "")

	{

		$css_header_id = "header_area_bg";

		$menu_bg_style = 'style="background-color:#307D99;"';

	}	

?>

 <div id="backgroundshine" style="<?=$strStyle?>" ><!--Inner Backgroundshine div starts Here-->

<!--Use this outer wrapper for integarte-->

  <div id="wrapper2"><!--Inner wrapper name wrapper2 starts here scope beyond footer-->

   <div id="header <?=$css_header_id?>"><!--Main header area starts here-->

    <div id="top"><!--Top div required to use for the header backgrougd color, image, slider, Logo, menu bg color-->

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

	if($page_header=='Other')

	{

?> 

		<div class="topinfonlogo" <?=$strStyle?>><!--Header Image div starts here-->

			<img src="<?=$header_image?>" style="width:960px;margin: auto;" /> 

		</div><!--Header Image div Ends here-->

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

?> 

<?php

	if($page_header!='Slideshow' && $page_header!='Other')

	{

?>

  

<?php

	}

?>    

  

    </div><!--Top Header working div Ends Here-->

  </div><!--Header area Ends Here-->

  <div id="mid" style="<?=$strStyle?>"><!--Mid div starts Here-->

  

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

<?php

		$strStyle = "";

	if($background_image!="" && $background_area=='menu with content' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

	else if($background_image!="" && $background_area=='menu with content' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

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

  <div id="contents" style="<?=$strStyle?>">

<?php

		$strStyle = "";

	if($background_image!="" && $background_area=='content' && $background_style=='stretch')

	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}

	else if($background_image!="" && $background_area=='content' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat; ";

	}

    	$style =" style= "; 

/*    if(isset($left_menus) && sizeof($left_menus) == 0 )

    {

        $strStyle .= ' width:824px;';           

        $style .= ' width:auto;';

    }*/

	

	if(isset($left_menus) && sizeof($left_menus) == 0 && isset($right_menus) && sizeof($right_menus) == 0 )

    {

        $strStyle .= ' width:824px;';           

        $style .= ' width:auto;';

    }

	

  	if(isset($right_menus) && sizeof($right_menus) > 0 )

	{

		$strStyle .= ' width:500px;';

		$strStyle .= ' float:left;';

		?>		

		   

		  <div class="col_right" style="float:right; width:315px;"><!--Side Bar wil come here-->

				<div class="side_bar">

					<?=$rightbar?>

				</div>

		   </div><!--/content-->

		<? 

	}

	if(isset($left_menus) && sizeof($left_menus) > 0)
	{
		$strStyle .= ' width:500px;';
		$strStyle .= ' float:right;';

	}

	if(isset($right_menus) && sizeof($right_menus) > 0 && isset($left_menus) && sizeof($left_menus) > 0)

    {

		$strStyle .= ' width:200px;';

		$strStyle .= ' float:right;';          

        $style .= '';

    }		

	

	

?>

    

   <div class="col_right" style="<?=$strStyle?>"><!--Main contents of the body will come here-->

  	  <?=$content;?> 

      <? if(isset($contact_form))

	  { echo $contact_form; }?> 	  

   </div><!--Main content Div Get Ends Here-->

<? 

  	if(isset($left_menus) && sizeof($left_menus) > 0 )

	{

?>		

   

  <div class="col_left"><!--Side Bar wil come here-->

   	<div class="side_bar">

		<?=$leftbar?> 

  	</div>

   </div><!--/content-->

<? 

	}

?>		

   

	<div class="clear"></div>

</div>  

</div><!--Mid Div Ends Here-->

  <div class="clear"></div>



</div><!--Wrapper2 Ends Here-->

	<div class="footer"><!--Footer Starts Here-->

   		<div class="inner_footer">

		   <?=$footer?>

		 <!--

		 <p> Footer &copy; 2020 All Rights Reserved</p>

		 -->

		 </div><!--Inner footer Ends Here-->

	  	</div><!--Footer Ends Here-->
		</div>
<script type="text/javascript" src="<?=base_url()?>css/salima-pirani/engine1/script.js"></script>
	   </div><!--Outer Wrappe Ends Here-->

      </div><!--Inner Backgroundshine div Ends Here-->

     </div><!--Main Outer container div of body Ends Here-->

    </body>

   </html>