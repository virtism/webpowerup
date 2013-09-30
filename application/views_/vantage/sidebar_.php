
<?php
    //echo "<pre>";
    //print_r($menus);

//load default/sample menus/menu items when no menus have been created
if(sizeof($menus)<1)
{?>
        <h1>Sidebar Menu</h1>
        <ul class="sidemenu">
            <li><a href="#">Home</a></li>
            <li><a href="#">TemplateInfo</a></li>
            <li><a href="#">Style Demo</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Archives</a></li>
            <li><a href="#">Web Templates</a></li>
        </ul>
    
        <h1>Sponsors</h1>
            <ul class="sidemenu">
            <li><a href="#">Dream</a></li>
            <li><a href="#">SOLD</a><br />
              Premium WordPress &amp; Joomla Themes</li>
            <li><a href="#">ImHosted.com</a><br />
              Affordable Web Hosting Provider</li>
            <li><a href="#">MyVectorStore</a><br />
              Royalty Free Stock Icons</li>
            <li><a href="#">Evrsoft</a><br />
              Website Builder Software &amp; Tools</li>
            <li><a href="#">CSS Hub</a><br />
              Premium CSS </li>
        </ul>
    
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
        else
        {          
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
        <h1><?=$menus[$i]['menu_name']?></h1>
            <?php
            if(sizeof($menus[$i])>0)
            {?>
        <ul class="sidemenu">
                <?php
                for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++)
                {
                ?>
            <li>
                <a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id']?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a>
            </li>
            <?php
                }?>
        </ul>    
            <?php
            }
            ?>
    <?php
        }
    }
}?>