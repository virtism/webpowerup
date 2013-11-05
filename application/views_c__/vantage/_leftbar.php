
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
    /*echo "<pre>";
    print_r($left_menus);
    exit;*/
//load default/sample menus/menu items when no menus have been created
if($left_menus_type == 'site'){
if(sizeof($left_menus)<1 && $mode=='edit')
{?>
<div style="opacity: 0.3; filter:alpha(opacity=30);"> 
        <h1>Leftbar Menu</h1>
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

    /*echo "<pre>";
    print_r($left_menus);
    exit;*/
    
    for($i=0; $i<sizeof($left_menus); $i++)
    {
        $boolDisplay = FALSE;
        if($left_menus[$i]['menu_published']=='Yes')
        {
            $boolDisplay = TRUE;
        }
        else{          
            $dateStart = strtotime($left_menus[$i]['menu_start']);
            $dateEnd = strtotime($left_menus[$i]['menu_end']);
            $dateToday = strtotime(date("Y-m-d h:i:s"));          
            if($dateStart<$dateToday && $dateEnd>$dateToday)
            {
                $boolDisplay = TRUE;
            }
        }
        
        $editIcon = '';
        if($boolDisplay == TRUE)
        {
      //     echo "asasas";exit;
		    if($mode=='edit')
            {
                /*
                $editIcon = '<div id="leftmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="$(document.getElementById('."'leftmenu_area_".$i."'".')).fadeOut();"><b>&nbsp;x&nbsp;</b></span>
                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$left_menus[$i]['menu_id'].'">
                <img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />
                </a>';
                */
                $editIcon = '<div id="leftmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."leftmenu_area_".$i."'".', '.$left_menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
                <a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$left_menus[$i]['menu_id'].'">
                <img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />
                </a>';        
            }
?>      <?=$editIcon?>
        <h1><?=$left_menus[$i]['menu_name']?></h1>
            <?php
        	if(sizeof($left_menus[$i])>0)
            {?>
        <ul class="sidemenu">
                <?php
					for($j=0; $j<sizeof($left_menus[$i]['sub_menu']); $j++)
					{
					//	echo "<pre>";
					//	print_r($left_menus[$i]['sub_menu']);
					//	exit;
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';    
						}
						else
						{
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name'])){
							
							$strLink = base_url().index_page()"site_preview/page/".$site_id."/".$left_menus[$i]['sub_menu'][$j]['page_id'];
							}
							
							if(empty($left_menus[$i]['sub_menu'][$j]["page_id"]) && !empty($left_menus[$i]['sub_menu'][$j]["item_link"]))
							{
								//Checking The Full URL 
								if(strstr($left_menus[$i]['sub_menu'][$j]["item_link"],"http://"))
								{
									$link_url =  $left_menus[$i]['sub_menu'][$j]["item_link"];	
								}
								else
								{
									//Making Full Url Starting from HTTP
									$link_url =  "http://".$left_menus[$i]['sub_menu'][$j]["item_link"];	
								}
								//exit;
							}
							else
							{
								$link_url = $strLink;
							}
						}
					?>
				
					<? 
					//For Registered Users
					
					if(isset($_SESSION["customer_group_id"]) && $left_menus[$i]['sub_menu'][$j]["access_level"] == "Registered")
					{
						if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
						{?>
							<li>	
								<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
							</li>
					<? } 
					}
					else if(isset($_SESSION["customer_group_id"]) && $left_menus[$i]['sub_menu'][$j]["access_level"] == "Other")
					{
						//echo "usman";exit;
						if(isset($left_menus[$i]['sub_menu'][$j]['page_id']))
						{
							$group_check = $this->Menus_Model->is_page_allowed_for_group($left_menus[$i]['sub_menu'][$j]['page_id'],$_SESSION["customer_group_id"]);
						}
						else
						{
							//Destination is Link NEEEEEED CODE HERE
							$group_check = true;
						}	
						
						if($group_check)
						{
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
							{?>
								<li>	
									<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
								</li>
						<?  
							}
						}	 
						
					}
					else if($left_menus[$i]['sub_menu'][$j]["access_level"] == "" || $left_menus[$i]['sub_menu'][$j]["access_level"] == "Everyone")
					{
						if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
						{?>
							<li>	
								<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
							</li>
					<?  }					
					}
					
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
}
}
?>
<?php 
if(isset($left_menus_type)){
    if ($left_menus_type == 'myshop')
    {
     echo '<h1>Categories</h1>
             <ul class="sidemenu">';
         if (count($left_menus) > 0)
         {  
                 for ($i=0; $i < count($left_menus); $i++)
                 {
                 
                   if($left_menus[$i]['parentid']==0){				   
				   		echo  '<li ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
                    }
					else
					{
						echo  '<li style="margin-left:8px;" ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
					}
                    
                 }   

       echo  '</ul>'; 
        }
        
    }
}
?>
