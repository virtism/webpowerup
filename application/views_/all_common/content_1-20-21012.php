<script type="text/javascript">
function publich_unpublish(getlink,action)
{
	var status;
	var allowed = confirm("Are you sure you want to "+action+" your page?")

	if(allowed)
	{
		var path =  "<?=base_url().index_page()?>pagesController/updatePageStatus/<?=$site_id?>/<?=$page_id?>";
		var dataString = 'status='+action+'&site_id='+<?=$site_id?>+'&page_id='+<?=$page_id?>;                         
		$.ajax
		({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data)
			{
				//alert("sasas");
				$('#row_start').html('');
				if(action == "publish")
				{
					var a_html = '<a id="unpublish" onclick="publich_unpublish(this,\'unpublish\')" href="javascript: void(0);" >Unpublich</a> Your Page !';
					$('#row_start').html(a_html);
				}
				else
				{
					var a_html = '<a id="publish" onclick="publich_unpublish(this,\'publish\')" href="javascript: void(0);" >Publich</a> Your Page !';
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

function publich_unpublish_title(getlink,action)
{
	
	var status;
	var allowed = confirm("Are you sure you want to "+action+" your page?")

	if(allowed)
	{
		var path =  "<?=base_url().index_page()?>pagesController/publich_unpublish_title/<?=$site_id?>/<?=$page_id?>";
		var dataString = 'status='+action+'&site_id='+<?=$site_id?>+'&page_id='+<?=$page_id?>;
		//alert(path);
		$.ajax
		({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data)
			{
				//alert("sasas");
				$('#row_start_title').html('');
				if(action == "Published")
				{
					var a_html = '<a id="unpublish" onclick="publich_unpublish_title(this,\'No Published\')" href="javascript: void(0);" >Unpublich</a> Your Page Title !';
					$('#row_start_title').html(a_html);
				}
				else
				{
					var a_html = '<a id="publish" onclick="publich_unpublish_title(this,\'Published\')" href="javascript: void(0);" >Publich</a> Your Page Title !';
					$('#row_start_title').html(a_html);
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
$proportions = '';
if(!isset($top_slideshows))
{
    $top_slideshows = new ArrayObject();
}

if(sizeof($top_slideshows)>0)
{ 
/*
echo '<pre> i am in top';
print_r($top_slideshows);
echo '</pre>'; 
 exit();*/

?>       
<table width="100%" border="0" cellspacing="0" cellpadding="0">  
<tr>
    <td valign="top" height="100">
        <?php
        for($i=0; $i<sizeof($top_slideshows); $i++)
        {
            
			$isset_slider = TRUE;
            $width = trim($top_slideshows[$i]['slide_width']).'px';      
            $height = trim ($top_slideshows[$i]['slide_height']).'px';
            
            $proportions .= '
                $( "#babu-content_'.$top_slideshows[$i]['slide_id'].'" ).css( "width","'.$width.'" );
                $( "#babu-content_'.$top_slideshows[$i]['slide_id'].'" ).css( "height","'.$height.'" );
            ';
            
            
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
            <div class="slider1" id="babu-content_<?=$top_slideshows[$i]['slide_id']?>">
             
        <?php
            /*
            echo '<pre>';
            print_r($top_slideshows);
            exit; 
            */
            for($j=0; $j<sizeof($top_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().'slideshows/'.$top_slideshows[$i]['slide_images'][$j]['slide_image'];
				$target = '';
                if(isset($top_slideshows[$i]['slide_images'][$j]['target']) && !empty($top_slideshows[$i]['slide_images'][$j]['target']))
				{
					$target = $top_slideshows[$i]['slide_images'][$j]['target'];
				
				}
				$title = trim($top_slideshows[$i]['slide_images'][$j]['slide_title']);
				$description = trim($top_slideshows[$i]['slide_images'][$j]['slide_description']);
				$title_flag = false;
				$des_flag = false;
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
                	$strTitle = $top_slideshows[$i]['slide_images'][$j]['slide_title'].' : '.$top_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                }
				else if($title_flag && !$des_flag)
				{
					$strTitle = $top_slideshows[$i]['slide_images'][$j]['slide_title'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else if(!$title_flag && $des_flag)
				{
					$strTitle = $top_slideshows[$i]['slide_images'][$j]['slide_description'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else
				{
					$strImage = '<img src="'.$strSrc.'" />';
				}								
				$strHref = $top_slideshows[$i]['slide_images'][$j]['slide_image_url'];
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
<!-- PAGE CONTENT AREA START --> 
<table width="100%" height="450" border="0" cellpadding="0" cellspacing="0">
<tr>
<?php

if(!isset($left_slideshows))
{
    $left_slideshows = new ArrayObject();
}
    if(sizeof($left_slideshows)>0 )
    {
        /*echo '<pre> i am in Left';
print_r($left_slideshows);
echo '</pre>';*/ 
?>    
    <td width="100" valign="top">
        <?php       
        for($i=0; $i<sizeof($left_slideshows); $i++)
        {            
                                
                                                
                                                $isset_slider = TRUE;
            $width = trim($left_slideshows[$i]['slide_width']).'px';      
            $height = trim ($left_slideshows[$i]['slide_height']).'px'; 
            $proportions .= '
                $( "#babu-content_'.$left_slideshows[$i]['slide_id'].'" ).css( "width","'.$width.'" );
                $( "#babu-content_'.$left_slideshows[$i]['slide_id'].'" ).css( "height","'.$height.'" );
            '; 
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
            <div class="slider1" id="babu-content_<?=$left_slideshows[$i]['slide_id']?>"> 
        <?php
            for($j=0; $j<sizeof($left_slideshows[$i]['slide_images']); $j++)
            {  
                $strSrc = base_url().'slideshows/'.$left_slideshows[$i]['slide_images'][$j]['slide_image'];
				$target = '';
                if(isset($left_slideshows[$i]['slide_images'][$j]['target']) && !empty($left_slideshows[$i]['slide_images'][$j]['target']))
				{
					$target = $left_slideshows[$i]['slide_images'][$j]['target'];
				
				}
                $title = trim($left_slideshows[$i]['slide_images'][$j]['slide_title']);
				$description = trim($left_slideshows[$i]['slide_images'][$j]['slide_description']);
				$title_flag = false;
				$des_flag = false;
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
                	$strTitle = $left_slideshows[$i]['slide_images'][$j]['slide_title'].' : '.$left_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                }
				else if($title_flag && !$des_flag)
				{
					$strTitle = $left_slideshows[$i]['slide_images'][$j]['slide_title'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else if(!$title_flag && $des_flag)
				{
					$strTitle = $left_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else
				{
					$strImage = '<img src="'.$strSrc.'" />';
				}
                $strHref = $left_slideshows[$i]['slide_images'][$j]['slide_image_url'];
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
             <span id="row_start">
             <?
                  if(isset($page_status)&&!empty($page_status))
				  {
                    if(trim($page_status) == "Published")
                     {
                     ?>
                      	<a id="unpublish" onclick="publich_unpublish(this,'unpublish')"    href="javascript: void(0);" >Unpublich</a> Your Page !
					 <? 
					 } 
					 else
					 { 
					 ?>
                        <a id="publish" onclick="publich_unpublish(this,'publish')"   href="javascript: void(0);" >Publich</a> Your Page !
                     <? 
					 } 
                  } 
             ?>
             </span>
			 <br />
			 <span id="row_start_title">
			 
             <?
                  if(isset($page_title_status)&&!empty($page_title_status))
				  {
						if(trim($page_title_status) == "Published")
						 {
						 ?>
							Page Title Is <a id="unpublish" onclick="publich_unpublish_title(this,'Not Published')"    href="javascript: void(0);" >Unpublich</a>
						 <? 
						 } 
						 else
						 { 
						 ?>
							Page Title Is <a id="publish" onclick="publich_unpublish_title(this,'Published')"   href="javascript: void(0);" >Publich</a>
						 <? 
						 } 
					}
					/*?>else
					{
						?>
                        <a id="publish" onclick="publich_unpublish_title(this,'publish')"   href="javascript: void(0);" >Publich</a> Your Page Title !
                     <? 
					} <?php */
             ?>
             </span>
        <div id="cart_container" style="border: 1px #CCCCCC dotted; margin:0px; width: auto;">
              <div id="cart_title" style="width: auto;">
                    
              </div>
              <!--<div id="cart_toolbar" style="width: auto; background: none;">-->
              <div id="cart_toolbar" style="min-height: 1000px; width: auto; ">
                  <div id="cart_items" class="back" style="width: auto; "> 
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
    if(sizeof($right_slideshows)>0 )
    {

?>


    <td width="100" valign="top">
        <?php
/*echo '<pre> i am in Right';
print_r($right_slideshows);
echo '</pre>';
exit(); */       
		for($i=0; $i<sizeof($right_slideshows); $i++)
        {
            $isset_slider = TRUE;
            $width = trim($right_slideshows[$i]['slide_width']).'px';      
            $height = trim ($right_slideshows[$i]['slide_height']).'px'; 
            $proportions .= '
                $( "#babu-content_'.$right_slideshows[$i]['slide_id'].'" ).css( "width","'.$width.'" );
                $( "#babu-content_'.$right_slideshows[$i]['slide_id'].'" ).css( "height","'.$height.'" );
            '; 
            
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
         <div class="slider1" id="babu-content_<?=$right_slideshows[$i]['slide_id']?>"> 
        <?php
            for($j=0; $j<sizeof($right_slideshows[$i]['slide_images']); $j++)
            {
                $strSrc = base_url().'slideshows/'.$right_slideshows[$i]['slide_images'][$j]['slide_image'];
                $target = '';
                if(isset($right_slideshows[$i]['slide_images'][$j]['target']) && !empty($right_slideshows[$i]['slide_images'][$j]['target']))
				{
					$target = $right_slideshows[$i]['slide_images'][$j]['target'];
				
				}
				$title = trim($right_slideshows[$i]['slide_images'][$j]['slide_title']);
				$description = trim($right_slideshows[$i]['slide_images'][$j]['slide_description']);
				$title_flag = false;
				$des_flag = false;
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
                	$strTitle = $right_slideshows[$i]['slide_images'][$j]['slide_title'].' : '.$right_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                }
				else if($title_flag && !$des_flag)
				{
					$strTitle = $right_slideshows[$i]['slide_images'][$j]['slide_title'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else if(!$title_flag && $des_flag)
				{
					$strTitle = $right_slideshows[$i]['slide_images'][$j]['slide_description'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else
				{
					$strImage = '<img src="'.$strSrc.'" />';
				}								
                
                $strHref = $right_slideshows[$i]['slide_images'][$j]['slide_image_url'];
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
if(sizeof($bottom_slideshows)>0 )
{
 
 /*   
 echo '<pre> i am in Bootom';
print_r($bottom_slideshows);
echo '</pre>';
exit();*/

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td colspan="3" valign="top" height="100">
        <?php
        for($i=0; $i<sizeof($bottom_slideshows); $i++)
        {
            ?>
          <script type="text/javascript">
            $("#786").val('<?=$bottom_slideshows[$i]['slide_id']?>');
            
            apply_slider('<?=$bottom_slideshows[$i]['slide_id']?>');
        //   alert($("#slider_123"));
            $("#slider_123").css("bottom","1");
           // $('#slider_123').addClass('replace');
             $("#slider_123").addClass("posotionTop");
          //  alert($("#slider_<?=$bottom_slideshows[$i]['slide_id']?>"));
          </script>
            <input type="hidden" disabled="disabled" value="<?=$bottom_slideshows[$i]['slide_id']?>" id="temp_slider_id">
            <?
            
            $width = trim($bottom_slideshows[$i]['slide_width']).'px';      
            $height = trim ($bottom_slideshows[$i]['slide_height']).'px';
            $proportions .= '
                $( "#babu-content_'.$bottom_slideshows[$i]['slide_id'].'" ).css( "width","'.$width.'" );
                $( "#babu-content_'.$bottom_slideshows[$i]['slide_id'].'" ).css( "height","'.$height.'" );
            ';
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
        <div class="slider1" id="babu-content_<?=$bottom_slideshows[$i]['slide_id']?>"> 
        <?php
			
            for($j=0; $j<sizeof($bottom_slideshows[$i]['slide_images']); $j++)
            {
                
				$strSrc = base_url().'slideshows/'.$bottom_slideshows[$i]['slide_images'][$j]['slide_image'];
				$target = '';
				/*echo "<pre>";
                print_r($bottom_slideshows);
				exit;*/
				if(isset($bottom_slideshows[$i]['slide_images'][$j]['target']) && !empty($bottom_slideshows[$i]['slide_images'][$j]['target']))
				{
					$target = $bottom_slideshows[$i]['slide_images'][$j]['target'];
				
				}
				$title = trim($bottom_slideshows[$i]['slide_images'][$j]['slide_title']);
				$description = trim($bottom_slideshows[$i]['slide_images'][$j]['slide_description']);
				$title_flag = false;
				$des_flag = false;
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
                	$strTitle = $bottom_slideshows[$i]['slide_images'][$j]['slide_title'].' : '.$bottom_slideshows[$i]['slide_images'][$j]['slide_description'];                
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
                }
				else if($title_flag && !$des_flag)
				{
					$strTitle = $bottom_slideshows[$i]['slide_images'][$j]['slide_title'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else if(!$title_flag && $des_flag)
				{
					$strTitle = $bottom_slideshows[$i]['slide_images'][$j]['slide_description'];
                	$strImage = '<img src="'.$strSrc.'" title="'.$strTitle.'" />';
				}
				else
				{
					$strImage = '<img src="'.$strSrc.'" />';
				}						
                
                $strHref = $bottom_slideshows[$i]['slide_images'][$j]['slide_image_url'];
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
if($isset_slider == TRUE )
//$isset_slider=TRUE;
//if(isset($isset_slider))

{
?>
<script type="text/javascript">
    $(window).load(function() {
        $('.slider1').nivoSlider({
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
            tempVar: '123',
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