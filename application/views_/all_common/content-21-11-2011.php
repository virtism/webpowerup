<?php
$isset_slider = FALSE;   
if(!isset($top_slideshows))
{
    $top_slideshows = new ArrayObject();
}  
if(sizeof($top_slideshows)>0)
{ 

/* echo '<pre>';
 print_r($top_slideshows);
 echo '</pre>';  exit();*/   
?>       
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
<tr>
    <td valign="top" height="100">
        <?php
        for($i=0; $i<sizeof($top_slideshows); $i++)
        {
            $isset_slider = TRUE;
            
            if($mode=='edit')
            {
        ?>
            <span style="font-size: 10px;">
            <a class="edit_slider" href="<?=base_url().index_page()?>page_editor/editSliderInfo/<?=$site_id?>/<?=$top_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$top_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>   
            <div class="slider" id="babu">
             
        <?php
            /*
            echo '<pre>';
            print_r($top_slideshows);
            exit;
            */
            for($j=0; $j<sizeof($top_slideshows[$i]['slide_images']); $j++)
            {
                
                $strSrc = base_url().'slideshows/'.$top_slideshows[$i]['slide_images'][$j]['slide_image'];
                
                $strTitle = $top_slideshows[$i]['slide_title'].' : '.$top_slideshows[$i]['slide_description'];
                
                $strImage = '<img id="saif" src="'.$strSrc.'" title="'.$strTitle.'" />';
                
                $strHref = $top_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                
                if( $strHref != '')
                {
                    $strImage = '<a target="_blank"  href="'.$strHref.'">'.$strImage.'</a>';    
                }
                
                echo $strImage;
               // exit();
                
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
<!-- PAGE CONTENT AREA START --> 
<table width="100%" height="450" border="0" cellpadding="0" cellspacing="0">
<tr>
<?php
    if(!isset($left_slideshows))
    {
        $left_slideshows = new ArrayObject();
    }
    if(sizeof($left_slideshows)>0)
    {
?>    
    <td width="100" valign="top">
            <?php
       
        for($i=0; $i<sizeof($left_slideshows); $i++)
        {
            $isset_slider = TRUE;  
            if($mode=='edit')
            {
        ?>
            <span style="font-size: 10px;">
            <a class="edit_slider" href="<?=base_url().index_page()?>page_editor/editSliderInfo/<?=$site_id?>/<?=$left_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$left_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>
            <div class="slider" id="babu"> 
        <?php
            for($j=0; $j<sizeof($left_slideshows[$i]['slide_images']); $j++)
            {  
                $strSrc = base_url().'slideshows/'.$left_slideshows[$i]['slide_images'][$j]['slide_image'];
                
                $strTitle = $left_slideshows[$i]['slide_title'].' : '.$left_slideshows[$i]['slide_description'];
                
                $strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                
                $strHref = $left_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                
                if( $strHref != '')
                {
                    $strImage = '<a target="_blank"  href="'.$strHref.'">'.$strImage.'</a>';    
                }
                
                echo $strImage;
            
            }
        ?>
            </div>
        <?php
        }
        ?> 
    </td>
<?php
    }
?>
    <td valign="top">
        <?php
        if($mode=='edit')
        {
            $this->load->view('all_common/toolbox.php');
        ?>
        <form id="frmEditPageContent" style="border: none; background: none;" method="post" action="<?=base_url().index_page()?>pagesController/updatePageContent/<?=$site_id?>/<?=$page_id?>">
            <input type="submit" value="Save Changes" />
        <div id="cart_container" style="border: 1px #CCCCCC dotted; margin:0px; width: auto;">
              <div id="cart_title" style="width: auto;">
                    
              </div>
              <!--<div id="cart_toolbar" style="width: auto; background: none;">-->
              <div id="cart_toolbar" style="min-height: 1000px; width: auto; background: none;">
                  <div id="cart_items" class="back" style="width: auto; background: none;"> 
                  <?=$content?>
                  </div>
              </div>
              
        </div>
            <input type="submit" value="Save Changes" />
        </form> 
        <?php
        }
        else
        {
        ?>
            <div>
                <?=$content?>
            </div>
        <?php
        }
        ?>
    </td>
<?php
    if(!isset($right_slideshows))
    {
        $right_slideshows = new ArrayObject();
    }
    if(sizeof($right_slideshows)>0)
    {
?>
    <td width="100" valign="top">
        <?php
        for($i=0; $i<sizeof($right_slideshows); $i++)
        {
            $isset_slider = TRUE;  
            
            if($mode=='edit')
            {
            ?>
            <span style="font-size: 10px;">
            <a class="edit_slider" href="<?=base_url().index_page()?>page_editor/editSliderInfo/<?=$site_id?>/<?=$right_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$right_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>
            <div class="slider" id="babu"> 
        <?php
            for($j=0; $j<sizeof($right_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().'slideshows/'.$right_slideshows[$i]['slide_images'][$j]['slide_image'];
                
                $strTitle = $right_slideshows[$i]['slide_title'].' : '.$right_slideshows[$i]['slide_description'];
                
                $strImage = '<img align="middle" src="'.$strSrc.'" title="'.$strTitle.'" />';
                
                $strHref = $right_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                
                if( $strHref != '')
                {
                    $strImage = '<a target="_blank"  href="'.$strHref.'">'.$strImage.'</a>';    
                }
                
                echo $strImage;
            
            }
        ?>
            </div>
        <?php
        }
        ?>    
    </td>  
<?php
    }
?>
</tr>  
</table>  
<?php
if(!isset($bottom_slideshows))
{
    $bottom_slideshows = new ArrayObject();
}    
if(sizeof($bottom_slideshows)>0)
{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td colspan="3" valign="top" height="100">
        <?php
        for($i=0; $i<sizeof($bottom_slideshows); $i++)
        {
            $isset_slider = TRUE;  
            
            if($mode=='edit')
            {
        ?>
        <span style="font-size: 10px;">
        <a class="edit_slider" href="<?=base_url().index_page()?>page_editor/editSliderInfo/<?=$site_id?>/<?=$bottom_slideshows[$i]['slide_id']?>">Edit Slider</a>
        |
        <a onclick="delete_slider($(this), <?=$bottom_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
        </span>
        <?php
            }
        ?>
        <div class="slider" id="babu"> 
        <?php
            for($j=0; $j<sizeof($bottom_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().'slideshows/'.$bottom_slideshows[$i]['slide_images'][$j]['slide_image'];
                
                $strTitle = $bottom_slideshows[$i]['slide_title'].' : '.$bottom_slideshows[$i]['slide_description'];
                
                $strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                
                $strHref = $bottom_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                
                if( $strHref != '')
                {
                    $strImage = '<a target="_blank"  href="'.$strHref.'">'.$strImage.'</a>';    
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
if($isset_slider == TRUE)
{
?>
<script type="text/javascript">
    $(window).load(function() {
        $('.slider').nivoSlider({
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
            beforeChange: function(){ 
               // $( "#babu" ).css( "background-position","center" ); 
              //$( "#babu" ).css( "background-color","#FFFFFF" );
            }, // Triggers before a slide transition
            afterChange: function(){
              // $( "#babu" ).css( "background-position","center" ); 
              //$( "#babu" ).css( "background-color","#FFFFFF" ); 
            }, // Triggers after a slide transition
            slideshowEnd: function(){
               // $( "#babu" ).css( "background-position","center" ); 
              //$( "#babu" ).css( "background-color","#FFFFFF" );
            }, // Triggers after all slides have been shown
            lastSlide: function(){
               // $( "#babu" ).css( "background-color","#FFFFFF" ); 
            }, // Triggers when last slide is shown
            afterLoad: function(){
              //  $( "#babu" ).css( "background-position","center" ); 
             // $( "#babu" ).css( "background-color","#FFFFFF" );
            } // Triggers when slider has loaded
        });
    });
/*  sahil babu coding  */
    $(window).load(function() {
        var total = $( "#babu img" ).length;
        $( "#babu" ).css( "width","628px" );
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