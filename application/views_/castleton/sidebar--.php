<?php
  if(isset($ishome) && $ishome=='yes'){     
?>

<!--<div class="eventbox">
                <div class="eventboxtop">
                    <img src="<?=base_url()?>/css/gymnastic/Images/botleftbluecolumntop.png" />
                </div>
                <div class="eventboxmid">
                    <div class="headingevent">
                        Latest News
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    23
                                </div>
                                <div class="monthcale">
                                    OCT
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    30
                                </div>
                                <div class="monthcale">
                                    NOV
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="calendernnewsinfo">
                        <div class="calender">
                                <div class="datecale">
                                    31
                                </div>
                                <div class="monthcale">
                                    DEC
                                </div>
                        </div>
                        <div class="detailnews">
                            <a href="template.html">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy volutpat.</a>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="morenews">
                        <a href="template.html">more news >></a>
                    </div>
                </div> 
                <div class="eventboxtop">
                    <img src="<?=base_url()?>/css/gymnastic/Images/botleftbluecolumnbot.png" />
                </div>
            </div>  -->
<?php
  }  
?>

<!--sidebar menu-->
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

<div class="sidebox">
        <div class="sideboxTop">&nbsp; </div>
        <div class="sideboxMid">
            <div class="heading">
                Menus
            </div>
            

            
            <div id="menu_area_<?=$i?>" class="menu-dialog">
            <?=$editIcon?> 
                <div class="title-bar"> <img class="icon ajax-minicart-icon" src="spacer.gif" alt=""> <h2><?=$menus[$i]['menu_name']?></h2></div>
                <div class="content">
                  <?php
            if(sizeof($menus[$i])>0)
            {?>
                    <ul>
               <?php
                for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++){
                    if($mode=='edit')
                    {
                        $strLink = 'javascript: void(0);';    
                    }
                    else
                    {
                        $strLink = base_url().index_page()"site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];
                    }
                ?>
                        <li><a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a> </li>
                 <?php
                }?>
                    </ul> 
                 <?php
            }
            ?>   
                       
                </div>
                    <?php
        }
    }
}?>
            </div>
            
            
            
            
            
            
            <div class="morenews"> &nbsp; </div>
        </div> 
        <div class="sideboxBtm"> &nbsp;</div>
</div>
 <!--sidebar menu--> 
 
<?php 
if( sizeof($menus)< 1 && $ishome=='no') {
 
?>

 <div class="sidebox">
                <div class="sideboxTop">&nbsp; </div>
                <div class="sideboxMid">
                    <div class="heading">
                        Menus
                    </div>
                    
                    <div id="menu_area" class="menu-dialog">
                        <div class="title-bar"> <img class="icon ajax-minicart-icon" src="spacer.gif" alt=""> <h2>tech menu</h2></div>
                        <div class="content">
                            <ul>
                                <li><a href="#">Usman Salim </a> </li>
                                <li> <a href="#">Usman Salim</a> </li>
                                <li><a href="#">Usman Salim </a> </li>
                                <li> <a href="#"> Usman Salim </a> </li>
                                <li><a href="#">Usman Salim </a> </li>
                                <li> <a href="#"> Usman Salim </a> </li>
                            </ul>    
                        </div>
                    </div>
                    
                    <div id="menu_area" class="menu-dialog">
                        <div class="title-bar"> <img class="icon ajax-minicart-icon" src="spacer.gif" alt=""> <h2>tech menu</h2></div>
                        <div class="content">
                            <ul>
                                <li><a href="#">Usman Salim </a> </li>
                                <li> <a href="#"> Usman Salim </a> </li>
                                <li><a href="#">Usman Salim </a> </li>
                                <li> <a href="#"> Usman Salim </a> </li>
                            </ul>    
                        </div>
                    </div>
                    <div class="morenews"> &nbsp; </div>
                </div> 
                <div class="sideboxBtm"> &nbsp;</div>
            </div>



<?php
    }
?>