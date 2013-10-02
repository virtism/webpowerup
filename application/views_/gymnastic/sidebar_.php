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
?>
<?php    
		
if(sizeof($menus) >1 && $mode=='edit')
{  

?>      

<div class="sidebox">   
                <div class="sideboxTop">&nbsp; </div>
                <div class="sideboxMid">
                
                     <div id="colTwo">
                        <ul>

                            <li>
                                <h2>Archives</h2>
                                <ul>
                                    <li><a href="#">Make New Menu</a></li>
                                    <li><a href="#">Click on + icon</a></li>
                                </ul>
                            </li>


                        </ul>
                    </div>
                    
                    <div class="morenews"> &nbsp; </div>
                </div> 
                <div class="sideboxBtm"> &nbsp;</div>
 </div>
<?php
  } 
 
else
{
    ?>
<div class="sidebox">   
                <div class="sideboxTop">&nbsp; </div>
                <div class="sideboxMid">   
 <?php                
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




                     <div id="colTwo" >
                      <?=$editIcon?>
                        <ul>

                            <li id="menu_area_<?=$i?>">
                                <h2><?=$menus[$i]['menu_name']?></h2>
                                <ul>
<?php
if(sizeof($menus[$i])>0)
{
    for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++)
        {
            if($mode=='edit')
            {
                $strLink = 'javascript: void(0);';    
            }
            else
            {
                $strLink = base_url().index_page()"site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];
            }
    ?>
                                    <li><a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>
 <?php
        }?>
                                </ul>
                            </li>
   <?php
}
?>                         


                        </ul>
                    </div>
      <?php
    }
    }
?>


                    
                    <div class="morenews"> &nbsp; </div>
                </div> 
                <div class="sideboxBtm"> &nbsp;</div>
 </div>
<?php
    }

?>
