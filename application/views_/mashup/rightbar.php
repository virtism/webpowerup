<style>
.box-head
{
	font-weight:bold;
	display:block;
	background:#58bef1;
	color:#FFFFFF;
	padding:10px 10px;
	margin: 0 0 4px;
	/*background:url('http://webpowerup.com/images/hback.png') repeat;*/	
}
.box-head h2
{
	color:#ffffff;
}
.testimonial {
    margin: 0;
    background: #B7EDFF;
    padding: 5px 10px;
    position: relative;
    font-family: Georgia, serif;
    color: #666;
    border-radius: 2px;
    font-style: italic;
    text-shadow: 0 1px 0 #ECFBFF;
    background-image: linear-gradient(#b0d0cf, #B7EDFF);
	margin-bottom:5px;
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
if(isset($right_menus) && sizeof($right_menus)<1 && $mode=='edit')
{
    
}
//loads menus of the page
else
{ ?>
    
    <div class="sidebox">
    
    <?php 
	if(isset($right_menus))
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
			<label><?=$right_menus[$i]['menu_name']?></label>
				<?php
				if(sizeof($right_menus[$i])>0)
				{?>
                
			<div class="links_area">
			<ul>
					<?php
					for($j=0; $j<sizeof($right_menus[$i]['sub_menu']); $j++)
					{
						//echo "<pre>";print_r($right_menus[$i]['sub_menu']);
						
						$seo_page_title = $this->Pages_Model->page_seo_link($right_menus[$i]['sub_menu'][$j]['page_id']);
						$link_target = '';
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';    
						}
						else if ($right_menus[$i]['sub_menu'][$j]['item_link'] != "")
						{
							$strLink = 'http://'.$right_menus[$i]['sub_menu'][$j]['item_link'];
							$link_target = 'target="'.$right_menus[$i]['sub_menu'][$j]['item_target'].'"';
						}
						else
						{
							//$strLink = base_url().index_page()."site_preview/page/".$site_id."/".$right_menus[$i]['sub_menu'][$j]['page_id'];
							if(!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost')
							{
								//$strLink = base_url().'pages/'.$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');
								$strLink = base_url().'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
							}
							else
							{
								$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/'.'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
							}
							
							
							
							$link_target = 'target="'.$right_menus[$i]['sub_menu'][$j]['item_target'].'"';
						}
						
					?>
				<li>
					<a <?=$link_target?> href="<?=$strLink?>"><?=$right_menus[$i]['sub_menu'][$j]['item_name']?></a>
				</li>
				<?php
					}?>
			</ul>    
			</div>
            <br />
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
	
	?>

    </div>
 <?php 
 /*echo "<pre>";
	print_r($right_menus_Pbox);
	exit;*/
if(!empty($right_menus_Pbox) && $left_menus_type=='site')
{
	// echo "<pre>";	print_r($right_menus_Pbox); echo "</pre>";
	?>
	<div align="center" style="border:#C3C3C3 solid 0px; padding-top:3px; vertical-align:middle;">
	<?
	for($i=0; $i<sizeof($right_menus_Pbox); $i++)
	{
		if($right_menus_Pbox[$i]['box_position']=='Right')
		{
			//echo "<pre>";	print_r($right_menus_Pbox); echo "</pre>";
			if($right_menus_Pbox[$i]['box_show_title']=='Yes')
			{
				echo "<div class='box-head'><h2>".$right_menus_Pbox[$i]['box_title']."</h2></div>";
			}
			
			if(isset($right_menus_Pbox[$i]['box_product']) && $right_menus_Pbox[$i]['box_product']!=0)
			{
			?>
            	<?php
				if($right_menus_Pbox[$i]['thumbnail'] != "")
				{
				?>
				 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$right_menus_Pbox[$i]['product_id']?>" ><img src="<?php echo base_url();?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$right_menus_Pbox[$i]['site_id']?>/<?=$right_menus_Pbox[$i]['cat_name']?>/thumb/<?=$right_menus_Pbox[$i]['thumbnail']?>" border="0" alt="" /> </a> 
                 <?php
				}
				else
				{ ?>
                <a href="<?=base_url().index_page()?>MyShop/detail/<?=$right_menus_Pbox[$i]['product_id']?>" >
                <img src="<?php echo base_url(); ?>media/ecommerce/no-image.png" border="0" alt="" width="116px" height="125px" />
                </a> 
				<?php
                }
				?>
			<?
			}
			else if(isset($right_menus_Pbox[$i]['box_content']) && !empty($right_menus_Pbox[$i]['box_content']))
			{?>
				<div class="testimonial"><p><?=$right_menus_Pbox[$i]['box_content']?></p></div>
			
			<? }
		}
	}
	echo "</div>";	
}
}
?>