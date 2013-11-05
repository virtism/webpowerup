<!-- SEARCH BOX -->  

<div class="searchform">
<form id="formsearch" name="formsearch" method="post" action="#">
    <span>
        <input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" />
    </span>
    <input name="button_search" src="<?=base_url(); ?>css/winglobal/images/search_btn.gif" class="button_search" type="image" />
</form>
</div>

<?php
    //echo "<pre>";
    //print_r($menus);
for($i=0; $i<sizeof($menus); $i++)
{
    $boolDisplay = FALSE;
    if($menus[$i]['menu_published']=='Yes')
    {
        $boolDisplay = TRUE;
    }
    else{          
        $dateStart = strtotime($menus[$i]['menu_start']);
        $dateEnd = strtotime($menus[$i]['menu_end']);
        $dateToday = strtotime(date("Y-m-d h:i:s"));          
        if($dateStart<$dateToday && $dateEnd>$dateToday)
        {
            $boolDisplay = TRUE;
        }
    }
    
    if($boolDisplay == TRUE)
    {
?>
<div class="gadget">
    <h2 class="star"><span><?=$menus[$i]['menu_name']?></span></h2>
    <div class="clr"></div>
        <?php
        if(sizeof($menus[$i])>0)
        {?>
        <ul class="sb_menu">
            <?php
            for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++){
            ?>
            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id']?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>
        <?php
            }?>
        </ul>    
        <?php
        }
        ?>
</div>
<?php
    }
}?>