<?php
$set_slider_Main = FALSE; 
$proportions = '';  
if(!isset($main_slideshows))
{
    $main_slideshows = new ArrayObject();
}  

   /* if(array_key_exists(0,$slideshows)){
    $slideshows=  $slideshows[0];
    }*/
    

if(sizeof($main_slideshows)>0)
{ 
/*    echo '<pre> i am in main';
 print_r($main_slideshows);
 echo '</pre>'*/;

?>       
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
<tr>
    <td valign="top" height="100">
        <?php
        
        for($i=0; $i<sizeof($main_slideshows); $i++)
        {
            $str = '<script type="text/javascript">$("#786").val('.$main_slideshows[$i]['slide_id'].');$("#slider_999").css("bottom","0");  $("#slider_999").addClass("posotionBottom"); apply_slider('.$main_slideshows[$i]['slide_id'].');</script>';
            echo $str;
   ?>
   
            
   <?       
            $set_slider_Main = TRUE;
            
            $width = trim($main_slideshows[0]['slide_width']).'px';      
            $height = trim ($main_slideshows[0]['slide_height']).'px'; 
            $proportions .= '
                $( "#main-babu_'.$main_slideshows[$i]['slide_id'].'" ).css( "width","'.$width.'" );
                $( "#main-babu_'.$main_slideshows[$i]['slide_id'].'" ).css( "height","'.$height.'" );
            ';
            
            if($mode=='edit')
            {
        ?>
            <span style="font-size: 10px;">
           <?php /*?> <a class="edit_slider" href="<?=base_url()?>index.php/page_editor/editSliderInfo/<?=$site_id?>/<?=$main_slideshows[$i]['slide_id']?>">Edit Slider</a><?php */?>
		   <a target="_blank" href="<?=base_url().index_page()?>site_slides/edit/<?=$site_id?>/<?=$main_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$main_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>   
            <?php 
			
			$style = "";
			$style .= " margin:0 !important; ";
			$style .= " border-top:2px solid #330000; ";
			
			?>
            <div class="slider2" id="main-babu_<?=$main_slideshows[$i]['slide_id']?>" style=" <?=$style?> " >
             
        <?php
            
           /* echo '<pre>';
            print_r($main_slideshows);
            exit;*/
            
            for($j=0; $j<sizeof($main_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().str_replace(' ','_',$main_slideshows[$i]['slide_images'][$j]['slide_image']);
				
                $target = '';
                if(isset($main_slideshows[$i]['slide_images'][$j]['target']) && !empty($main_slideshows[$i]['slide_images'][$j]['target']))
				{
					$target = $main_slideshows[$i]['slide_images'][$j]['target'];
				
				}
				$title = trim($main_slideshows[$i]['slide_images'][$j]['slide_title']);
				$description = trim($main_slideshows[$i]['slide_images'][$j]['slide_description']);
				$title_flag = false;
				$des_flag = false;
//				echo $title;exit;
				if(isset($title) && !empty($title))
				{
					$title_flag = true;
				}
				if(isset($description) && !empty($description))
				{
					$des_flag = true;
				}
				if($title_flag && $des_flag)
				{
                	$strTitle = $main_slideshows[$i]['slide_images'][$j]['slide_title'].' : '.$main_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                }
				else if($title_flag && !$des_flag)
				{
					$strTitle = $main_slideshows[$i]['slide_images'][$j]['slide_title'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else if(!$title_flag && $des_flag)
				{
					$strTitle = $main_slideshows[$i]['slide_images'][$j]['slide_description'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else
				{
					$strImage = '<img src="'.$strSrc.'" />';
				}								
                
                $strHref = $main_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                if( $strHref != '' && $strHref != 'URL' )
				{
					if(!isset($target) || $target=='0' || $target=='')
					{
						
						$strImage = '<a   href="'.$strHref.'">'.$strImage.'</a>';    
					}
					else
					{
						
						$strImage = '<a target="_blank"  href="'.$strHref.'">'.$strImage.'</a>';
						
					}
				}
                echo $strImage;       
                
            }
        ?>   
            </div> 
        <?php
        }
        ?>
    </td>
</tr> 
</table>   
<?php
}
 
  
?>                               

<!-- PAGE CONTENT AREA END --> 
<?php
 if($set_slider_Main == TRUE)
//$isset_slider=TRUE;
//if(isset($isset_slider))

{
?>
<script type="text/javascript">
    $(window).load(function() {
        $('.slider2').nivoSlider({
            effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
          //  effect: 'boxRandom', // Specify sets like: 'fold,fade,sliceDown'
            slices: 15, // For slice animations
            boxCols: 8, // For box animations
            boxRows: 4, // For box animations
            animSpeed: 500, // Slide transition speed
            pauseTime: 3000, // How long each slide will show
            startSlide: 0, // Set starting Slide (0 index)
            directionNav: true, // Next & Prev navigation
            directionNavHide: true, // Only show on hover
            controlNav: true, // 1,2,3... navigation
            controlNavThumbs: false, // Use thumbnails for Control Nav
            controlNavThumbsFromRel: false, // Use image rel for thumbs
            controlNavThumbsSearch: '.jpg', // Replace this with...
            controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
            keyboardNav: true, // Use left & right arrows
            pauseOnHover: true, // Stop animation while hovering
            manualAdvance: false, // Force manual transitions
            captionOpacity: 0.8, // Universal caption opacity
            prevText: '<img src="<?=base_url()?>images/arrow_left.png" title="Prev" alt="Prev" />', // Prev directionNav text
            nextText: '<img src="<?=base_url()?>images/arrow_right.png" title="Next" alt="Next" />', // Next directionNav text
            beforeChange: function(){}, // Triggers before a slide transition
            afterChange: function(){}, // Triggers after a slide transition
            slideshowEnd: function(){}, // Triggers after all slides have been shown
            lastSlide: function(){}, // Triggers when last slide is shown
            afterLoad: function(){} // Triggers when slider has loaded
        });
    });
/*  sahil babu coding  */
    $(window).load(function() {
        var total = $( "#babu img" ).length;
      //  $( "#babu" ).css( "width","628px" );
      // $( "#babu-content" ).css( "width","<?=$width?>" );
       // $( "#babu-content" ).css( "height","<?=$height?>" );
       <?=$proportions?>
       // $( "#babu" ).css( "background-position","center" );

      //  var pic = $('#saif');
      //  pic.removeAttr("width");
      //  pic.removeAttr("height");
    });
    /*  sahil babu coding  */ 
</script>    
<?php
}
?>