               
     <?php
      if(!isset($mode))
        {
            $mode = '';
        }
       //echo $mode; exit;
       //print_r($menu); exit();
         if(count($menu)>0 || ! empty($menu)){
           for($i=0; $i<count($menu); $i++)
           {
               if($mode=='edit')
                {
                    $strLink = 'javascript: void(0);';    
                }
                else
                {
                    $strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
                }
            ?>
            <li>
                <a href="<?=$strLink?>"><?=$menu[$i]['page_title']?></a>
            </li>   
            <?php   
           }
                echo '<li><a href="'.base_url().index_page().'Help_Center_Home/index"> Help Center </a>   </li>';

         }
       
       //top menu area
       if(!isset($adv_menu))
       {
            $adv_menu = array();    
       }
       for($i=0; $i<sizeof($adv_menu); $i++)
        {
            $boolDisplay = FALSE;
            if($adv_menu[$i]['menu_published']=='Yes')
            {
                $boolDisplay = TRUE;
            }
            else{          
                $dateStart = strtotime($adv_menu[$i]['menu_start']);
                $dateEnd = strtotime($adv_menu[$i]['menu_end']);
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
                    $editIcon = '<span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."menu_area_".$i."'".', '.$adv_menu[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
                    <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$adv_menu[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>
                    ';       
                }
        ?>
            <li>
                <a href="javascript: void(0);"><?=$adv_menu[$i]['menu_name']?></a><?=$editIcon?>
                <?php
                if(sizeof($adv_menu[$i])>0)
                {?>
                <ul>
                    <?php
                    for($j=0; $j<sizeof($adv_menu[$i]['sub_menu']); $j++)
                    {
                        if($mode=='edit')
                        {
                            $strLink = 'javascript: void(0);';    
                        }
                        else
                        {
                            $strLink = base_url().index_page()."site_preview/page/".$site_id."/".$adv_menu[$i]['sub_menu'][$j]['page_id'];
                        }
                    ?>
                    <li>
                        <a href="<?=$strLink?>"><?=$adv_menu[$i]['sub_menu'][$j]['item_name']?></a>
                    </li>
                    <?php
                    }?>
                </ul>    
                <?php
                }
                ?>    
            </li>
    <?php
        }
    }
    ?>
    <?php
    if($mode=='edit' && isset($menu_id))
    {
        echo '<a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$menu_id.'" style="font-size:10px;">Edit</a>';
    }
    ?>
