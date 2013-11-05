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




    div.newsletter
    {
        display: table;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;

        background: rgba(255,255,255,0.4);
        border: 1px solid #b8b8b8;
        padding: 5px;
    }

    div.email-wrapper
    {
        float: left;
    }

    div.email-wrapper input[type=text]
    {
        border: 1px solid #cacaca;
        background: white;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        padding: 10px 15px;

        color: #9f9e9e;

        -moz-box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.5);
        -webkit-box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.5);
        box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.5);
    }
    div.email-wrapper input[type=text]:hover
    {
        -moz-box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.8);
        -webkit-box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.8);
        box-shadow: inset 0 2px 11px -5px rgba(0,0,0,0.8);
    }

    div.submit-wrapper
    {
        float: right;
        margin-left: 10px;
    }

    div.submit-wrapper input[type=submit]
    {
        border: 1px solid #59a751;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        padding: 10px 25px;
        text-shadow: 0px 1px 0px rgba(0,0,0,.3);

        color: white;

        background: #58bef1; /* Old browsers */
        background: -moz-linear-gradient(top, #58bef1 0%, #58bef1 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#66c975), color-stop(100%,#52bd5f)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* IE10+ */
        background: linear-gradient(to bottom, #58bef1 0%,#58bef1 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#66c975', endColorstr='#52bd5f',GradientType=0 ); /* IE6-9 */

        -moz-box-shadow: inset 0 3px -2px -2px rgba(255,255,255,0.4);
        -webkit-box-shadow: inset 0 3px -2px -2px rgba(255,255,255,0.4);
        box-shadow: inset 0 3px -2px -2px rgba(255,255,255,0.4);

        cursor: pointer;
    }

    div.submit-wrapper input[type=submit]:hover
    {
        background: #66c975; /* Old browsers */
        background: -moz-linear-gradient(top, #58bef1 0%, #58bef1 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#66c975), color-stop(100%,#48a057)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* IE10+ */
        background: linear-gradient(to bottom, #58bef1 0%,#58bef1 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#66c975', endColorstr='#48a057',GradientType=0 ); /* IE6-9 */
    }
    div.submit-wrapper input[type=submit]:active
    {
        background: #66c975; /* Old browsers */
        background: -moz-linear-gradient(top, #58bef1 0%, #58bef1 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#66c975), color-stop(100%,#89b780)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #58bef1 0%,#58bef1 100%); /* IE10+ */
        background: linear-gradient(to bottom, #58bef1 0%,#58bef1 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#66c975', endColorstr='#89b780',GradientType=0 ); /* IE6-9 */
    }

    
/**
 *  END FREEBIE STYLES
 */
    

/**
 *    Not important styles
 */


   
</style>
<?php
    if($newsletter_groups_p!='')
    {
        foreach($newsletter_groups_p as $newsletter_groups_show)
        {
            if($newsletter_groups_show->newsgroup_position == 'Right')
            {
                 
            ?>
                <form action="<?=base_url().index_page()?>Create_Newsletter/save_newsletter_user/" method="post">
                <input type="hidden" value="<?php echo $newsletter_groups_show->newsgroup_id;?>" name="NL_group_id">
                <input type="hidden" name="url" value="<?php echo $this->uri->uri_string();?>">
                <div> <?php echo $this->session->flashdata('success_msg');?></div>
                <div id="content">
                    <ul id="newsletter-freebie">
                        <li>
                            <!-- Start Freebie -->
                            <div class="newsletter">
                            <div id="smalltext"> <h3>Subscribe to Our Newsletter</h3></div>
                            <div id="smalltext"><?=$newsletter_groups_show->newsgroup_intro_text?></div> 
                                <div class="email-wrapper">
                                    <label style="float: left; background: none; color: black;"> Name</label>
                                    <input style="float: left;" type="text" id="name" name="user_name" value=""/>
                                    <label style="float: left; background: none; color: black;"> Email</label>
                                    <input style="float: left;" type="text" id="email" name="user_email" value="email@email.com"/>
                                </div>
                                <div class="submit-wrapper">
                                    <input type="submit" id="sub-news" name="sub-news" value="Subscribe"/>
                                </div>
                            </div>
                            <!-- End Freebie -->
                        </li>
                    </ul>
                </div>
                </form>
            <?php                
            }  
        }
        
    }

?>
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
					  $private_page_user_id = $this->Menus_Model->check_private_page($site_id, $right_menus[$i]['sub_menu'][$j]["page_id"]);
                   $page_acc = $this->Pages_Model->get_page_privacy($right_menus[$i]['sub_menu'][$j]['page_id']);
                   if($private_page_user_id == $_SESSION['login_info']['customer_id'] && $page_acc == 'Private')
                   { 
                    ?>
                <li>
                    <a <?=$link_target?> href="<?=$strLink?>"><?=$right_menus[$i]['sub_menu'][$j]['item_name']?></a>
                </li>
                <?php
                   }else if($page_acc != 'Private'){?>
                      <li>
                    <a <?=$link_target?> href="<?=$strLink?>"><?=$right_menus[$i]['sub_menu'][$j]['item_name']?></a>
                    </li>   
                  <? }
                    }  
                    if($registartion_menue[0]['menu_id'] == $right_menus[$i]['menu_id'])
               {
                ?>
                <li>    
                <a  href="<?=base_url().'Froms/index/'.$site_id.'/'.$registartion_menue[0]['form_id']?>"><?=$registartion_menue[0]['form_title']?></a>
                </li>
                
                <?
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
				echo "<div class='box-head' style='background: #".$right_menus_Pbox[$i]['box_primary_color']."'><h2 style='color:#".$right_menus_Pbox[$i]['box_txt_color']."'>".$right_menus_Pbox[$i]['box_title']."</h2></div>";
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
