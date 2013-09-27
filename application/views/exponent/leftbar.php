<style>
.box-head
{
	border:#000000 solid 1px !important;
	background:url('http://10.1.1.50/gws/images/hback.png') repeat;
}
.box-head h2
{
	color:#000000;
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
if($left_menus_type == 'site'){
if(sizeof($left_menus)<1 && $mode=='edit')
{?>
 	<h2><?=$menus[$i]['menu_name']?></h2>
<div class="white" >
 <div style="opacity: 0.3; filter:alpha(opacity=30);"> 
   <div class="white">
		<label style=" width: 255px;"><h1>Leftbar Menu</h1></label>
		<ul class="sidemenu">
			<li><a href="javascript: void(0);">Home</a></li>
			<li><a href="javascript: void(0);">TemplateInfo</a></li>
			<li><a href="javascript: void(0);">Style Demo</a></li>
			<li><a href="javascript: void(0);">Blog</a></li>
			<li><a href="javascript: void(0);">Archives</a></li>
			<li><a href="javascript: void(0);">Web Templates</a></li>	
		</ul>
	
		<label style=" width: 255px;"><h1>Sponsors</h1></label>
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
	  </div><!--closing the div white here-->
	</div><!--Closing the style opacity div Here-->
 </div><!--Closing the div white here-->
<?php 
}

else
{
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
			if($mode=='edit')
			{
				
				$editIcon = '<div id="leftmenu_area_'.$i.'"><span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."leftmenu_area_".$i."'".', '.$left_menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$left_menus[$i]['menu_id'].'">
				<img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" />
				</a>';        
			}
?>

  		<?=$editIcon?>
		  <h2><?=$left_menus[$i]['menu_name']?></h2> 
		   <div class="sideNavWrapper">
		   	 <div class="sideNavBox-1">
			   <div class="sideNavBox-2">
			<?php
			if(sizeof($left_menus[$i])>0)
			{?>
				<ul class="sideNav">
				<?php
				
					for($j=0; $j<sizeof($left_menus[$i]['sub_menu']); $j++)
					{
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';  
							$link_url = $strLink;   
						}
						else
						{
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name'])){
							
							$strLink = base_url().index_page()."site_preview/page/".$site_id."/".$left_menus[$i]['sub_menu'][$j]['page_id'];
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
										<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
										<?
									}
								}
								else
								{
									?>
									<li>	
									<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
									<?
								}
							}
							else
							{
								//Show External Link Items
								?>
									<li>	
										<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
								<?
							}
						
						} 
					}
					else if(isset($_SESSION["customer_group_id"]) && $left_menus[$i]['sub_menu'][$j]["access_level"] == "Other")
					{
						//echo "mdsr";exit;
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
												<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
											
										<?
										}
									}
									else
									{
									?>
										<li>	
											<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
									}
								}
								else
								{
									//Show External Link Items
									?>
										<li>	
											<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
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
												<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
											</li>
										<?
										}
									}
									else
									{
									?>
										<li>	
											<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
										</li>
									<?
									}							
							}
							else
							{
								//Show External Link Items
								?>
									<li>	
										<a href="<?=$link_url?>"><?=$left_menus[$i]['sub_menu'][$j]['item_name']?></a>
									</li>
								<?
							}
						 }					
					}
					
				}?>
		    
			<?php
				if($mode == 'edit')
				{		
					echo '</div>';
				}	
			?>
	   	   	</ul>
		<?
			}//$left_menus get end here
		?>
			</div><!--Closing the div sideNavWrapper here-->
		  </div><!--Class div sideNavBox-1 here-->
		</div><!--Class div sideNavBox-2 here--> 	
	<?php
		}
	}	
  }//If statement gets End Here
}//Outer Main if Div gets End Here
if(isset($left_menus_type)){
	if ($left_menus_type == 'myshop')
	{
	 echo '<h2>Categories</h2>';
	  echo '<div class="sideNavWrapper">'; 
	   echo '<div class="sideNavBox-1">';
		echo '<div class="sideNavBox-2">';
		 echo '<ul class="sideNav">';
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
					
				}//end for loop here    
		}//End of a if loop Here
		echo  '</ul>'; 
	   echo '</div>';
	  echo '</div>';
	 echo '</div>'; 
	}
}
if(!empty($left_menus_Pbox))
{	
	?>
	<div align="center" style="border:#C3C3C3 solid 0px; vertical-align:middle;">
	<?
	for($i=0; $i<sizeof($left_menus_Pbox); $i++)
	{
		if($left_menus_Pbox[$i]['box_show_title']=='Yes')
		{
			echo "<div class='box-head'><h2>".$left_menus_Pbox[$i]['box_title']."</h2></div>";
		}
		if(isset($left_menus_Pbox[$i]['box_product']))
		{
		?>
		<a href="<?=base_url().index_page()?>MyShop/detail/<?=$left_menus_Pbox[$i]['product_id']?>" ><img src="<?php echo base_url();?>media/ecommerce/<?=$left_menus_Pbox[$i]['sit_name']?>/<?=$left_menus_Pbox[$i]['cat_name']?>/thumb/<?=$left_menus_Pbox[$i]['thumbnail']?>" border="0" alt="" width="164px" /> </a> 
		<?
		}
	}
	?>	
   </div>
<?
}//End of a last if Here
?>