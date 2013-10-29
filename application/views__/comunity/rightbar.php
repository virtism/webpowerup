<style>
h1{
	margin:15px 5px 0 5px; 
	background:#702D09 ;
	width:230px;
	padding:10px 10px 10px 10px;
	color: #F1EBD6;
    display: block;
    font-family: Myriad Pro;
    font-size: 18px;
   
}
ul.sidemenu{
	margin:0 5px 10px 5px; 
	width:250px;
}
ul.sidemenu li{
	background:#FFFFFF;
	padding:5px 5px 5px 5px;
	width:240px;
	color: #635E41;
    font-family: Georgia,'Times New Roman',Times,serif;
    font-style: italic;
}
ul.sidemenu li a{
	color: #635E41;
}
ul.sidemenu li a:hover{
	text-decoration:underline;
}
</style>

<?php

if(!isset($mode))

{

    $mode = '';

}

$addNewIcon = '';

if($mode=='edit')

{

    $addNewIcon = '<div style="height:20px; position: relative;"><a class="edit_menu" href="'.base_url().index_page().'page_editor/createMenu/'.$site_id.'"><img align="right" src="'.base_url().'images/add_icon.png" style="border:none;background:none;" /></a>

    </div>';   

    echo $addNewIcon;     

}

    //echo "<pre>";

    //print_r($right_menus);



//load default/sample menus/menu items when no menus have been created

if(sizeof($right_menus)<1 && $mode=='edit')

{

    ?>

<div style="opacity: 0.3; filter:alpha(opacity=30);">  

        <h1>Rightbar Menu</h1>

        <ul class="sidemenu">

            <li><a href="javascript: void(0);">Home</a></li>

            <li><a href="javascript: void(0);">TemplateInfo</a></li>

            <li><a href="javascript: void(0);">Style Demo</a></li>

            <li><a href="javascript: void(0);">Blog</a></li>

            <li><a href="javascript: void(0);">Archives</a></li>

            <li><a href="javascript: void(0);">Web Templates</a></li>

        </ul>

    

        <h1>Sponsors</h1>

            <ul class="sidemenu">

            <li><a href="javascript: void(0);">Dream</a></li>

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

    for($i=0; $i<sizeof($right_menus); $i++)

    {

        $boolDisplay = FALSE;

        if($right_menus[$i]['menu_published']=='Yes')

        {

            $boolDisplay = TRUE;

        }

        else{          

            $dateStart = strtotime($right_menus[$i]['menu_start']);

            $dateEnd = strtotime($right_menus[$i]['menu_end']);

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

                $editIcon = '<div id="rightmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="$(document.getElementById('."'rightmenu_area_".$i."'".')).fadeOut();"><b>&nbsp;x&nbsp;</b></span>

                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$right_menus[$i]['menu_id'].'">

                <img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>'; 

                */

                $editIcon = '<div id="rightmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."rightmenu_area_".$i."'".', '.$right_menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>

                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$right_menus[$i]['menu_id'].'">

                <img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />

                </a>';

            }

?>      <?=$editIcon?>

        <h1><?=$right_menus[$i]['menu_name']?></h1>

            <?php

            if(sizeof($right_menus[$i])>0)

            {?>

        <ul class="sidemenu">

                <?php

                for($j=0; $j<sizeof($right_menus[$i]['sub_menu']); $j++)

                {

                    if($mode=='edit')

                    {

                        $strLink = 'javascript: void(0);';    

                    }
					else if ($right_menus[$i]['sub_menu'][$j]['item_link'] != "")
					{
						$strLink = $right_menus[$i]['sub_menu'][$j]['item_link'];
					}

                    else

                    {

                        $strLink = base_url().index_page()."site_preview/page/".$site_id."/".$right_menus[$i]['sub_menu'][$j]['page_id'];

                    }

                ?>

            <li>

                <a href="<?=$strLink?>"><?=$right_menus[$i]['sub_menu'][$j]['item_name']?></a>

            </li>

            <?php

                }?>

        </ul>    

            <?php

                if($mode == 'edit')

                {

                    echo '</div>';

                }

            }

            ?>

    <?php

        }

    }

}?>