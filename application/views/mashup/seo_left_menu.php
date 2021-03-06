<?php
	$this->load->model('Pages_Model');
	

	function check_page_exist($page_id, $private_page_users)
	{
		if(!empty($private_page_users))
		{	
			foreach($private_page_users as $pages)
			{
				$users = explode(",",$pages['page_users']);						
				if(isset($users) && !empty($users))
				{
					if(isset($_SESSION['login_info']['customer_id']))
					{
						if(in_array($_SESSION['login_info']['customer_id'], $users))
						{
							return true;	
						}							
					}
				}			
			}
		}
	}
	
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
				
				$editIcon = '<div id="leftmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."leftmenu_area_".$i."'".', '.$left_menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'/page_editor/editMenuInfo/'.$site_id.'/'.$left_menus[$i]['menu_id'].'">
				<img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />
				</a>';        
			}
?>      <?=$editIcon?>
		<div class="sidebox">  
			<label><?=$left_menus[$i]['menu_name']?></label>
				<div class="links_area" >
			<?php
			if(sizeof($left_menus[$i])>0)
			{?>
		<ul>
				<?php
					  
					if(isset($left_menus[$i]['is_default']) &&  $left_menus[$i]['is_default']==1)
					{
					?><li>
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/myaccount/account.html">Profile</a>
						</li>
						<li>	
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/orders/order_site_list">Orders</a>
						</li>                        
						<li>	
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/myaccount/invoices.html">Invoices</a>
						</li>
						<li>	
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/manage_ticket/my_ticket.html">Support Tickets</a>
						</li>
						<li>	
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/meeting_rooms/user_rooms.html">Online Meetings</a>
						</li>
						<li>	
						<a href="<?='http://'.$_SERVER['SERVER_NAME']?>/webinars/user_webinar.html">Webinar</a>
						</li>
					<?					
					}
								
					for($j=0; $j<sizeof($left_menus[$i]['sub_menu']); $j++)
					{
						$seo_page_title = $this->Pages_Model->page_seo_link($left_menus[$i]['sub_menu'][$j]['page_id']);
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';  
							$link_url = $strLink;   
						}
						else
						{
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name'])){
							
							//$strLink = base_url().index_page().'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
							$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/'.'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
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
								$link_target = 'target="'.$left_menus[$i]['sub_menu'][$j]['item_target'].'"';
							}
							else
							{
								$link_url = $strLink;
								$link_target = '';
								$link_target = 'target="'.$left_menus[$i]['sub_menu'][$j]['item_target'].'"';
							}
						}
					?>
				
					<? 
					//For Registered Users					
					
					if(isset($_SESSION["customer_group_id"]) && $left_menus[$i]['sub_menu'][$j]["access_level"] == "Registered")
					{
						if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
						{
							if(isset($left_menus[$i]['sub_menu'][$j]['page_id']) && $left_menus[$i]['sub_menu'][$j]['page_id'] != "")
							{
								
								$page_acc = $this->Pages_Model->get_page_privacy($left_menus[$i]['sub_menu'][$j]['page_id']);
								if(isset($page_acc) && !empty($page_acc) && $page_acc='Private')
								{
									
									if(isset($private_page_users)){
									$check_private = check_page_exist($left_menus[$i]['sub_menu'][$j]["page_id"], $private_page_users);								
									}
									if(isset($check_private) && !empty($check_private))
									{
										?>
										<li>	
										<a <?=$link_target?>  href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
										<?
									}
								}
								else
								{
									?>
									<li>	
									<a  <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
									<?
								}
							}
							else
							{
								//Show External Link Items
								?>
									<li>	
										<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
								<?
							}
						
						} 
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
							{
								if(isset($left_menus[$i]['sub_menu'][$j]['page_id']) && $left_menus[$i]['sub_menu'][$j]['page_id'] != "")
								{
									$page_acc = $this->Pages_Model->get_page_privacy($left_menus[$i]['sub_menu'][$j]['page_id']);
									if(isset($page_acc) && !empty($page_acc) && $page_acc='Private')
									{
										$check_private = check_page_exist($left_menus[$i]['sub_menu'][$j]["page_id"], $private_page_users);								
										if(isset($check_private) && !empty($check_private))
										{
										?>
											<li>	
												<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
									}
									else
									{
									?>
										<li>	
											<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
									}
								}
								else
								{
									//Show External Link Items
									?>
										<li>	
											<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
								}
							}
						}	 
						
					}
					else if($left_menus[$i]['sub_menu'][$j]["access_level"] == "" || $left_menus[$i]['sub_menu'][$j]["access_level"] == "Everyone")
					{	
						if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
						{
							  
							if(isset($left_menus[$i]['sub_menu'][$j]['page_id']) && $left_menus[$i]['sub_menu'][$j]['page_id'] != "" && isset($private_page_users))
							{
										
									$page_acc = $this->Pages_Model->get_page_privacy($left_menus[$i]['sub_menu'][$j]['page_id']);
									if(isset($page_acc) && !empty($page_acc) && $page_acc='Private')
									{
										
										$check_private = check_page_exist($left_menus[$i]['sub_menu'][$j]["page_id"], $private_page_users);								
										if(isset($check_private) && !empty($check_private))
										{
										?>
											<li>	
												<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
										else
										{  
										?>
											<li>	
												<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
									}
									else
									{  
									?>
										<li>	
											<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
									}							
							}
							else
							{
								//Show External Link Items
								?>
									<li>	
										<a <?=$link_target?> href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
								<?
							}
						 }	
						 //exit;				
					}
					
				}//  echo '<pre>';print_r($registartion_menue);
                if($registartion_menue[0]['menu_id'] == $left_menus[$i]['menu_id'])
               {
                ?>
                <li>    
                <a  href="<?=base_url().'Froms/index/'.$site_id.'/'.$registartion_menue[0]['form_id']?>"><?=$registartion_menue[0]['form_title']?></a>
                </li>
                
                <?
                }
					//Start 1
					if(isset($left_menus[$i]["webinar_list"]) && count($left_menus[$i]["webinar_list"]) > 0)
					{
						for($k = 0; $k<count($left_menus[$i]["webinar_list"]);$k++)
						{
							//webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id']
							$webinar_link_url = base_url().index_page()."webinar_site/index/".$left_menus[$i]["webinar_list"][$k]["site_id"]."/".$left_menus[$i]["webinar_list"][$k]["id"];
							?>
								<li> <a href="<?=$webinar_link_url?>"><?=$left_menus[$i]["webinar_list"][$k]["title"]?></a> </li>
							<?
						}
					}
					//End
				?>				
		</ul> 
	</div>	
</div>	 
			<?php
				if($mode == 'edit')
				{
					echo '</div>';
				}
			}
			?>
			<br clear="all" />
	<?php
			}
		}
	
?>




<div class="sidebox"> 
<?php 
if(isset($left_menus_type)){
	if ($left_menus_type == 'myshop')
	{
	 echo '<label>Categories</label>';
	 echo '<div class="links_area" >';
	 echo '<ul>';
		 if (count($left_menus) > 0)
		 {  
				 for ($i=0; $i < count($left_menus); $i++)
				 {
				 
				   if($left_menus[$i]['parentid']==0){				   
						echo  '<li ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
					}
					else
					{
						echo  '<li style="margin-left:8px;" ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
					}
					
				 }   
		}
		 echo  '</ul>';
	   echo '</div>';
	}
}
 /*?>if(!empty($left_menus_Pbox) && $left_menus_type=='site')
{
	
	
	?>
	<div align="center" style="border:#C3C3C3 solid 0px; padding-top:3px; vertical-align:middle;">
	<?

	for($i=0; $i<sizeof($left_menus_Pbox); $i++)
	{
		
		if($left_menus_Pbox[$i]['box_position']=='Left')
		{
		
			if($left_menus_Pbox[$i]['box_show_title']=='Yes')
			{
				echo "<div class='box-head'><h2>".$left_menus_Pbox[$i]['box_title']."</h2></div>";
			}
			if(isset($left_menus_Pbox[$i]['box_product']) && $left_menus_Pbox[$i]['box_product']!=0)
			{
				
			?>
				 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$left_menus_Pbox[$i]['product_id']?>" ><img src="<?php echo base_url();?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$left_menus_Pbox[$i]['site_id']?>/<?=$left_menus_Pbox[$i]['cat_name']?>/thumb/<?=$left_menus_Pbox[$i]['thumbnail']?>" border="0" alt="" /> </a> 
			<?
			}
			else if(isset($left_menus_Pbox[$i]['box_content']) && !empty($left_menus_Pbox[$i]['box_content']))
			{?>
				<div class="testimonial"><p><?=$left_menus_Pbox[$i]['box_content']?></p></div>
			
			<? }
		}
	}
	?>
	</div>
	<?php
}<?php */?>

</div> 
 
<?php 
	if(sizeof($left_menus) > 0 )
	{
?> 

<?php
	}
	
?>
