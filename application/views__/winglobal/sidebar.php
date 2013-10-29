<!-- SEARCH BOX -->  



<div class="searchform" style="position: relative; margin-bottom:20px;">

<form id="formsearch" name="formsearch" method="post" action="#">

    <span>

        <input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" />

    </span>

    <input name="button_search" src="<?=base_url(); ?>css/winglobal/images/search_btn.gif" class="button_search" type="image" />

</form>

</div>





<?php

if(!isset($mode))

{

    $mode = '';

}

$addNewIcon = '';

if($mode=='edit')

{

    $addNewIcon = '<div style="position: relative; height: 20px;">

    <a class="edit_menu" href="'.base_url().index_page().'page_editor/createMenu/'.$site_id.'"><img align="right" src="'.base_url().'images/add_icon.png" style="border:none;background:none;" /></a>

    </div>';   

    echo $addNewIcon;     

}

    //echo "<pre>";

    //print_r($menus);



//load default/sample menus/menu items when no menus have been created

if(sizeof($menus)<1 && $mode=='edit')

{?>



    <div class="gadget" style="opacity: 0.3; filter:alpha(opacity=30);">

        <h2 class="star"><span>Sidebar</span> Menu</h2>

        <div class="clr"></div>

        

        <ul class="sb_menu">

                          

            <li><a href="javascript: void(0);">Home</a></li>

            <li><a href="javascript: void(0);">TemplateInfo</a></li>

            <li><a href="javascript: void(0);">Style Demo</a></li>

            <li><a href="javascript: void(0);">Blog</a></li>

            <li><a href="javascript: void(0);">Archives</a></li>

            <li><a href="javascript: void(0);">Web Templates</a></li>

        </ul>

    </div>

    

    <div class="gadget" style="opacity: 0.3; filter:alpha(opacity=30);">

          <h2 class="star"><span>Sponsors</span></h2>

          <div class="clr"></div>

          <ul class="ex_menu">

            <li><a href="javascript: void(0);">Dream</a><br />

              </li>

            <li><a href="javascript: void(0);">SOLD</a><br />

              Premium WordPress &amp; Joomla Themes</li>

            <li><a href="javascript: void(0);">ImHosted.com</a><br />

              Affordable Web Hosting Provider</li>

            <li><a href="javascript: void(0);">MyVectorStore</a><br />

              Royalty Free Stock Icons</li>

            <li><a href="javascript: void(0);">Evrsoft</a><br />

              Website Builder Software &amp; Tools</li>

            <li><a href="javascript: void(0);">CSS Hub</a><br />

              Premium CSS </li>

          </ul>

        </div>    



<?php 

}

//loads menus of the page

else

{

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

        

        $editIcon = '';

        if($boolDisplay == TRUE)

        {

            if($mode=='edit')

            {

                /*

                $editIcon = '<span title="Delete" style="cursor:pointer" onclick="$(document.getElementById('."'menu_area_".$i."'".')).fadeOut();"><b>&nbsp;x&nbsp;</b></span>

                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$menus[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>

                '; 

                */

                $editIcon = '<span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."menu_area_".$i."'".', '.$menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>

                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$menus[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>

                ';       

            }

?>

<div class="gadget" id="menu_area_<?=$i?>">

    <?=$editIcon?>

    <h2 class="star"><span><?=$menus[$i]['menu_name']?></span></h2>

    <div class="clr"></div>

            <?php

            if(sizeof($menus[$i])>0)

            {?>

        <ul class="sb_menu">

                <?php

                for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++){

                    if($mode=='edit')

                    {

                        $strLink = 'javascript: void(0);';    

                    }

                    else

                    {

                        $strLink = base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];

                    }

                ?>

            <li><a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>

            <?php

                }?>

        </ul>    

            <?php

            }

            ?>

            <span class="">

           

</div>      </span>

    <?php

        }

    }

}?>