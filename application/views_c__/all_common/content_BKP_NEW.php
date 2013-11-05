<script type="text/javascript">
	function publich_unpublish(getlink,action)
	{
		var status;
		var allowed = confirm("Are you sure you want to "+action+" your page?")
		
		if(allowed)
		{
			var path =  "<?=base_url()?>index.php/pagesController/updatePageStatus/<?=$site_id?>/<?=$page_id?>";
			var dataString = 'status='+action+'&site_id='+<?=$site_id?>+'&page_id='+<?=$page_id?>;		
			$.ajax({
				url: path, 
				data: dataString,
				type:'POST', 
				success: function(data){
				//alert("sasas");
				$('#row_start').html('');
					if(action == "publish")
					{
						var a_html = '<a id="unpublish" onclick="publich_unpublish(this,\'unpublish\')" href="javascript: void(0);" >Unpublish</a> Your Page !';
						$('#row_start').html(a_html);
					}
					else
					{
						var a_html = '<a id="publish" onclick="publich_unpublish(this,\'publish\')" href="javascript: void(0);" >Publish</a> Your Page !';
						$('#row_start').html(a_html);
					}
				}
			});
		}
		else
		{
			return false;
		}
	}
</script>
<?php
$isset_slider = FALSE;   
if(!isset($top_slideshows))
{
    $top_slideshows = new ArrayObject();
}  
if(sizeof($top_slideshows)>0)
{    
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
            <a class="edit_slider" href="<?=base_url()?>index.php/page_editor/editSliderInfo/<?=$site_id?>/<?=$top_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$top_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>   
            <div class="slider">
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
                
                $strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                
                $strHref = $top_slideshows[$i]['slide_images'][$j]['slide_image_url'];
                
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
            <a class="edit_slider" href="<?=base_url()?>index.php/page_editor/editSliderInfo/<?=$site_id?>/<?=$left_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$left_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>
            <div class="slider">
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
        <form id="frmEditPageContent" style="border: none; background: none;" method="post" action="<?=base_url()?>index.php/pagesController/updatePageContent/<?=$site_id?>/<?=$page_id?>">
            
			
			<input type="submit" value="Save Changes" />
			
			<span id="row_start">
				<?
					
                  if(isset($page_status)&&!empty($page_status)){
                    if(trim($page_status) == "Published")
					{
				?>
						<a id="unpublish" onclick="publich_unpublish(this,'unpublish')"    href="javascript: void(0);" >Unpublish</a> Your Page !				
				<? } else { ?>
					
	
						<a id="publish" onclick="publich_unpublish(this,'publish')"   href="javascript: void(0);" >Publish</a> Your Page !
				
				<? } 
                } 
                ?>
			</span>
			
	    <div id="cart_container" style="border: 1px #CCCCCC dotted; margin:0px; width: auto;">
              <div id="cart_title" style="width: auto;">
                    
              </div>
              <div id="cart_toolbar" style="width: auto; background: none;">
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
            <a class="edit_slider" href="<?=base_url()?>index.php/page_editor/editSliderInfo/<?=$site_id?>/<?=$right_slideshows[$i]['slide_id']?>">Edit Slider</a>
            |
            <a onclick="delete_slider($(this), <?=$right_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
            </span>
            <?php
            }
            ?>
            <div class="slider">
        <?php
            for($j=0; $j<sizeof($right_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().'slideshows/'.$right_slideshows[$i]['slide_images'][$j]['slide_image'];
                
                $strTitle = $right_slideshows[$i]['slide_title'].' : '.$right_slideshows[$i]['slide_description'];
                
                $strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                
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
        <a class="edit_slider" href="<?=base_url()?>index.php/page_editor/editSliderInfo/<?=$site_id?>/<?=$bottom_slideshows[$i]['slide_id']?>">Edit Slider</a>
        |
        <a onclick="delete_slider($(this), <?=$bottom_slideshows[$i]['slide_id']?>)" href="javascript: void(0);">Delete</a>
        </span>
        <?php
            }
        ?>
        <div class="slider">
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
            prevText: 'Prev', // Prev directionNav text
            nextText: 'Next', // Next directionNav text
            beforeChange: function(){}, // Triggers before a slide transition
            afterChange: function(){}, // Triggers after a slide transition
            slideshowEnd: function(){}, // Triggers after all slides have been shown
            lastSlide: function(){}, // Triggers when last slide is shown
            afterLoad: function(){} // Triggers when slider has loaded
        });
    });
</script>    
<?php
}
?>