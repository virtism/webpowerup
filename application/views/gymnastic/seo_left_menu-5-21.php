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
	  //     echo "asasas";exit;
			if($mode=='edit')
			{
				
				$editIcon = '<div id="leftmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."leftmenu_area_".$i."'".', '.$menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'/page_editor/editMenuInfo/'.$site_id.'/'.$menus[$i]['menu_id'].'">
				<img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />
				</a>';        
			}
?>      
		<div class="sidebox">
		  <div class="sideboxTop">&nbsp; </div>
		  <div class="sideboxMid">
			<div id="colTwo" >
			<?=$editIcon?>
			<ul>
        <li id="menu_area_<?=$i?>">
          <h2>
            <?=$menus[$i]['menu_name']?>
          </h2>
		   <ul>
		  <?
			if(sizeof($menus[$i])>0)
			{?>
	
				<?php
					  
					if(isset($menus[$i]['is_default']) &&  $menus[$i]['is_default']==1)
					{
					?><li>
						<a href="<?=base_url().index_page()?>MyAccount/account/<?=$site_id?>">Profile</a>
						</li>
						<li>	
						<a href="<?=base_url().index_page()?>orders/order_site_list/<?=$site_id?>">Orders</a>
						</li>                        
						<li>	
						<a href="<?=base_url().index_page()?>MyAccount/invoices/<?=$site_id?>">Invoices</a>
						</li>
						<li>	
						<a href="<?=base_url().index_page()?>ticket/my_ticket/<?=$site_id?>">Support Tickets</a>
						</li>
						<li>	
						<a href="<?=base_url().index_page()?>room_management/user_rooms/<?=$site_id?>">Online Meetings</a>
						</li>
						<li>	
						<a href="<?=base_url().index_page()?>webinar_site/user_webinar/<?=$site_id?>">Webinar</a>
						</li>
					<?					
					}
								
					for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++)
					{
						$seo_page_title = $this->Pages_Model->page_seo_link($menus[$i]['sub_menu'][$j]['page_id']);
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';  
							$link_url = $strLink;   
						}
						else
						{
							if(isset($menus[$i]['sub_menu'][$j]['item_name'])){
							
							//$strLink = base_url().index_page().'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
							$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/'.'pages/'.$seo_page_title.$this->config->item('custom_url_suffix');
							}
							
							if(empty($menus[$i]['sub_menu'][$j]["page_id"]) && !empty($menus[$i]['sub_menu'][$j]["item_link"]))
							{
								//Checking The Full URL 
								if(strstr($menus[$i]['sub_menu'][$j]["item_link"],"http://"))
								{
									$link_url =  $menus[$i]['sub_menu'][$j]["item_link"];	
								}
								else
								{
									//Making Full Url Starting from HTTP
									$link_url =  "http://".$menus[$i]['sub_menu'][$j]["item_link"];	
								}
								//exit;
								$link_target = 'target="'.$menus[$i]['sub_menu'][$j]['item_target'].'"';
							}
							else
							{
								$link_url = $strLink;
								$link_target = '';
								$link_target = 'target="'.$menus[$i]['sub_menu'][$j]['item_target'].'"';
							}
						}
					?>
				
					<? 
					//For Registered Users					
					
					if($menus[$i]['sub_menu'][$j]["access_level"] == "" || $menus[$i]['sub_menu'][$j]["access_level"] == "Everyone")
					{	
						if(isset($menus[$i]['sub_menu'][$j]['item_name']))
						{
							  
							if(isset($menus[$i]['sub_menu'][$j]['page_id']) && $menus[$i]['sub_menu'][$j]['page_id'] != "" && isset($private_page_users))
							{
										
									$page_acc = $this->Pages_Model->get_page_privacy($menus[$i]['sub_menu'][$j]['page_id']);
									if(isset($page_acc) && !empty($page_acc) && $page_acc='Private')
									{
										
										$check_private = check_page_exist($menus[$i]['sub_menu'][$j]["page_id"], $private_page_users);								
										if(isset($check_private) && !empty($check_private))
										{
										?>
											<li>	
												<a <?=$link_target?> href="<?=$link_url?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
										else
										{  
										?>
											<li>	
												<a <?=$link_target?> href="<?=$link_url?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
									}
									else
									{  
									?>
										<li>	
											<a <?=$link_target?> href="<?=$link_url?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
									}							
							}
							else
							{
								//Show External Link Items
								?>
									<li>	
										<a <?=$link_target?> href="<?=$link_url?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
								<?
							}
						 }	
						 //exit;				
					}
					
				}?>
			
			</ul>	
			</li>		
		</ul> 
	</div>
	 <div class="morenews"> &nbsp; </div>	
	</div>
	 <div class="sideboxBtm"> &nbsp;</div>
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
if(isset($menus_type)){
	if ($menus_type == 'myshop')
	{
	 echo '<label>Categories</label>';
	 echo '<div class="links_area" >';
	 echo '<ul>';
		 if (count($menus) > 0)
		 {  
				 for ($i=0; $i < count($menus); $i++)
				 {
				 
				   if($menus[$i]['parentid']==0){				   
						echo  '<li ><a href="'.base_url().index_page().'MyShop/index/'.$menus[$i]['site_id'].'/'.$menus[$i]['cat_id'].'">'.$menus[$i]['cat_name'].'</a></li>';
					}
					else
					{
						echo  '<li style="margin-left:8px;" ><a href="'.base_url().index_page().'MyShop/index/'.$menus[$i]['site_id'].'/'.$menus[$i]['cat_id'].'">'.$menus[$i]['cat_name'].'</a></li>';
					}
					
				 }   
		}
		 echo  '</ul>';
	   echo '</div>';
	}
}

?>
</div>