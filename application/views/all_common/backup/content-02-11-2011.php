
<table width="100%" height="450" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="3" valign="top">
        <?php
        /*
        echo '<pre>';
        print_r($left_slideshows);
        exit;
        */
        if(!isset($top_slideshows))
        {
            $top_slideshows = new ArrayObject();
        }
        for($i=0; $i<sizeof($top_slideshows); $i++)
        {
            if($top_slideshows[$i]['slide_destination'] == 'page')
            {
                $strHref = base_url().index_page().'site_preview/page/'.$site_id.'/'.$top_slideshows[$i]['slide_destination_value'];    
            }
            else if($top_slideshows[$i]['slide_destination'] == 'url')
            {
                $strHref  = $top_slideshows[$i]['slide_destination_value']; 
            }
            else
            {
                //module url
                $strHref = 'javascript: void(0);';    
            }
        ?>
        <a href="<?=$strHref?>">
            <div class="slideshow">
        <?php
            for($j=0; $j<sizeof($top_slideshows[$i]['slide_images']); $j++)
            {
            ?>
                <img width="650" src="<?=base_url()?>slideshows/<?=$top_slideshows[$i]['slide_images'][$j]['slide_image']?>" />    
            <?php
            }
        ?>
            </div>
        <?php
        }
        ?>
        </a>
    </td>
</tr>
<!-- PAGE CONTENT AREA START -->
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
            if($left_slideshows[$i]['slide_destination'] == 'page')
            {
                $strHref = base_url().index_page().'site_preview/page/'.$site_id.'/'.$left_slideshows[$i]['slide_destination_value'];    
            }
            else if($left_slideshows[$i]['slide_destination'] == 'url')
            {
                $strHref  = $left_slideshows[$i]['slide_destination_value']; 
            }
            else
            {
                //module url
                $strHref = 'javascript: void(0);';    
            }
        ?>
        <a href="<?=$strHref?>">
            <div class="slideshow">
        <?php
            for($j=0; $j<sizeof($left_slideshows[$i]['slide_images']); $j++)
            {
            ?>
                <img width="100" src="<?=base_url()?>slideshows/<?=$left_slideshows[$i]['slide_images'][$j]['slide_image']?>" />    
            <?php
            }
        ?>
            </div>
        </a> 
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
        ?>
        <form id="frmEditPageContent" style="border: none; background: none;" method="post" action="<?=base_url().index_page()?>pagesController/updatePageContent/<?=$site_id?>/<?=$page_id?>">
            <input type="submit" value="Save Changes" />
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
            if($right_slideshows[$i]['slide_destination'] == 'page')
            {
                $strHref = base_url().index_page().'site_preview/page/'.$site_id.'/'.$right_slideshows[$i]['slide_destination_value'];    
            }
            else if($right_slideshows[$i]['slide_destination'] == 'url')
            {
                $strHref  = $right_slideshows[$i]['slide_destination_value']; 
            }
            else
            {
                //module url
                $strHref = 'javascript: void(0);';    
            }
        ?>
        <a href="<?=$strHref?>">
            <div class="slideshow">
        <?php
            for($j=0; $j<sizeof($right_slideshows[$i]['slide_images']); $j++)
            {
            ?>
                <img width="100" src="<?=base_url()?>slideshows/<?=$right_slideshows[$i]['slide_images'][$j]['slide_image']?>" />    
            <?php
            }
        ?>
            </div>
        </a>
        <?php
        }
        ?>    
    </td>
<?php
    }
?>
</tr>
<tr>
    <td colspan="3" valign="top">
        <?php
        /*
        echo '<pre>';
        print_r($bottom_slideshows);
        exit;
        */
        if(!isset($bottom_slideshows))
        {
            $bottom_slideshows = new ArrayObject();
        }
        for($i=0; $i<sizeof($bottom_slideshows); $i++)
        {
            if($bottom_slideshows[$i]['slide_destination'] == 'page')
            {
                $strHref = base_url().index_page().'site_preview/page/'.$site_id.'/'.$bottom_slideshows[$i]['slide_destination_value'];    
            }
            else if($bottom_slideshows[$i]['slide_destination'] == 'url')
            {
                $strHref  = $bottom_slideshows[$i]['slide_destination_value']; 
            }
            else
            {
                //module url
                $strHref = 'javascript: void(0);';    
            }
        ?>
        <a href="<?=$strHref?>">
            <div class="slideshow">
        <?php
            for($j=0; $j<sizeof($bottom_slideshows[$i]['slide_images']); $j++)
            {
            ?>
                <img width="650" src="<?=base_url()?>slideshows/<?=$bottom_slideshows[$i]['slide_images'][$j]['slide_image']?>" />    
            <?php
            }
        ?>
            </div>
        </a>
        <?php
        }
        ?>
    </td>
</tr>
<!-- PAGE CONTENT AREA END --> 

</table>