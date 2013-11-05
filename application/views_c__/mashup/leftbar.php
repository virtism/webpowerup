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
        /*float: right;*/
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

</style>

<?php   
//echo "<pre>";print_r($left_menus) ;exit;
if(!isset($mode))
{
	$mode = '';
}
$addNewIcon = '';
if($mode=='edit')
{
	$addNewIcon = '<div style="height:20px; position: relative;"><a class="edit_menu" href="'.base_url().index_page().'/page_editor/createMenu/'.$site_id.'"><img align="right" src="'.base_url().'images/add_icon.png" style="border:none;background:none;" /></a>
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
else if($this->config->item('seo_url') == 'On')
{
	
	include_once('seo_left_menu.php');
	
}
else
{
	
	//DebugBreak();
	/*echo "<pre>";
	print_r($_SESSION['login_info']);
	print_r($left_menus);
	exit;*/
	//echo sizeof($private_page_users)."---------------".sizeof($left_menus);
	//$private_page_users;
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
	$link_target = '';
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
			<label style="background: #<?=$left_menus[$i]['menu_primary_color']?>;"><p style="color: #<?=$left_menus[$i]['menu_txt_color']?>;"><?=$left_menus[$i]['menu_name']?></p></label>
				<div class="links_area" >
			<?php
			if(sizeof($left_menus[$i])>0)
			{?>
		<ul>
				<?php
					  
					if(isset($left_menus[$i]['is_default']) &&  $left_menus[$i]['is_default']==1)
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
								$link_target = 'target="'.$left_menus[$i]['sub_menu'][$j]['item_target'].'"';
							}
							else
							{
								$link_url = $strLink;
								
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
							$private_page_user_id = $this->Menus_Model->check_private_page($site_id, $left_menus[$i]['sub_menu'][$j]["page_id"]);
							if($private_page_user_id == $_SESSION['login_info']['customer_id'])
							{
								$group_check = true;
							}
							
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
									if(isset($page_acc) && !empty($page_acc) && $page_acc='private')
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
					/*else if()
						{
							$private_page_user_id = $this->Menus_Model->check_private_page($site_id, $left_menus[$i]['sub_menu'][$j]["page_id"]);
							if($private_page_user_id == $_SESSION['login_info']['customer_id'])
							{
							
								
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name']))
							{
								if(isset($left_menus[$i]['sub_menu'][$j]['page_id']) && $left_menus[$i]['sub_menu'][$j]['page_id'] != "")
								{
									$page_acc = $this->Pages_Model->get_page_privacy($left_menus[$i]['sub_menu'][$j]['page_id']);
									if(isset($page_acc) && !empty($page_acc) && $page_acc='private')
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
						
					}*/
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
					else if($left_menus[$i]['sub_menu'][$j]["access_level"] == "Other")
					{	
												
						
						$private_page_user_id = $this->Menus_Model->check_private_page($site_id, $left_menus[$i]['sub_menu'][$j]["page_id"]);
						//echo '---------'.$private_page_user_id;
						if($private_page_user_id == $_SESSION['login_info']['customer_id'])
						{
						
							if(isset($left_menus[$i]['sub_menu'][$j]['item_name']) && $private_page_user_id)
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
					}
					//echo $left_menus[$i]['sub_menu'][$j]["access_level"];					
				} 
              //  echo '<pre>';print_r($registartion_menue);
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
                       
                       if($this->config->item('seo_url') == 'On')
                        {
                            echo  '<li ><a href="http://'.$_SERVER['SERVER_NAME'].'/MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>'; 
                        }
                        else
                        {
                            echo  '<li ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';   
                        }				   
						    //echo  '<li ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
					}
					else
					{
                        if($this->config->item('seo_url') == 'On')
                        {
                            echo  '<li style="margin-left:8px;" ><a href="http://'.$_SERVER['SERVER_NAME'].'/MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>'; 
                        }
                        else
                        {
                            echo  '<li style="margin-left:8px;" ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>'; 
                        }
						//echo  '<li style="margin-left:8px;" ><a href="'.base_url().index_page().'MyShop/index/'.$left_menus[$i]['site_id'].'/'.$left_menus[$i]['cat_id'].'">'.$left_menus[$i]['cat_name'].'</a></li>';
					}
					
				 }   
		}
		 echo  '</ul>';
	   echo '</div>';
	}
}
if(!empty($left_menus_Pbox) && $left_menus_type=='site')
{
	/*echo "</div>";
	echo "<pre>";
	print_r($left_menus_Pbox);
	exit;*/
	
	?>
	<div  align="center" style=" border:#C3C3C3 solid 0px; padding-top:3px; vertical-align:middle;">
	<?

	for($i=0; $i<sizeof($left_menus_Pbox); $i++)
	{
		
		if($left_menus_Pbox[$i]['box_position']=='Left')
		{
		
			if($left_menus_Pbox[$i]['box_show_title']=='Yes')
			{
				echo "<div class='box-head' style='background: #".($left_menus_Pbox[$i]['box_primary_color'] == 'FFFFFF' ? '58bef1' : $left_menus_Pbox[$i]['box_primary_color'])."'><h2 style='color:#".$left_menus_Pbox[$i]['box_txt_color']."'>".$left_menus_Pbox[$i]['box_title']."</h2></div>";
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
}
?>
</div> 
 
<?php 
	if(sizeof($left_menus) > 0 )
	{
?> 

<?php
	}
	
?>
<?php
    if($newsletter_groups_a!='')
    {
        foreach($newsletter_groups_a as $newsletter_groups_all)                               
        {
            if($newsletter_groups_all->newsgroup_position == 'Left')
            {
                 
            
                if($this->config->item('seo_url') == 'On')
				{ ?>
 						<form action="<?='http://'.$_SERVER['SERVER_NAME']?>/Create_Newsletter/save_newsletter_user/" method="post">				
				<? }
				else
				{?>
						<form action="<?=base_url().index_page()?>Create_Newsletter/save_newsletter_user/" method="post">
				<? }			
				?>	
                <input type="hidden" value="<?php echo $newsletter_groups_all->newsgroup_id;?>" name="NL_group_id">
                <input type="hidden" name="url" value="<?php echo $this->uri->uri_string();?>">
                <div> <?php echo $this->session->flashdata('success_msg');?></div>
                <div id="content">
                    <ul id="newsletter-freebie">
                        <li>
                            <!-- Start Freebie -->
                            <div class="newsletter">
                            <div id="smalltext"> <h3>Subscribe to Our Newsletter</h3></div>
                            <div id="smalltext"> </div> 
                                <div class="email-wrapper">
                                    <label style="float: left; background: none; color: black;"> Name</label>
                                    <input align="middle" placeholder="User Name"  style="float: left; width: 124px;" type="text" id="name" name="user_name" value=""/>
                                    <div> <?php echo $this->session->flashdata('error_name');?></div> 
                                    <label style="float: left; background: none; color: black;"> Email</label>
                                    <input align="middle" style="float: left; width: 124px;" placeholder="email@email.com" type="text" id="email" name="user_email" value=""/>
                                    <div> <?php echo $this->session->flashdata('error_email');?></div> 
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
</br>
<?php
    if($newsletter_groups_p!='')
    {
        foreach($newsletter_groups_p as $newsletter_groups_show)
        {
            if($newsletter_groups_show->newsgroup_position == 'Left')
            {
                 
			
				if($this->config->item('seo_url') == 'On')
				{?>
 						<form action="<?='http://'.$_SERVER['SERVER_NAME']?>/Create_Newsletter/save_newsletter_user/" method="post">				
				<? }
				else
				{?>
						<form action="<?=base_url().index_page()?>Create_Newsletter/save_newsletter_user/" method="post">
				<? }			
				?>	
                
                <input type="hidden" value="<?php echo $newsletter_groups_show->newsgroup_id;?>" name="NL_group_id">
                <input type="hidden" name="url" value="<?php echo $this->uri->uri_string();?>">
                <div> <?php echo $this->session->flashdata('success_msg');?></div>
                <div id="content">
                    <ul id="newsletter-freebie">
                        <li>
                            <!-- Start Freebie -->
                            <div class="newsletter">
                            <div id="smalltext"> <h3>Subscribe to Our Newsletter</h3></div>
                            <div id="smalltext"> </div> 
                                <div class="email-wrapper">
                                    <label style="float: left; background: none; color: black;"> Name</label>
                                    <input align="middle" placeholder="User Name"  style="float: left; width: 124px;" type="text" id="name" name="user_name" value=""/>
                                    <div> <?php echo $this->session->flashdata('error_name');?></div> 
                                    <label style="float: left; background: none; color: black;"> Email</label>
                                    <input align="middle" style="float: left; width: 124px;" placeholder="email@email.com" type="text" id="email" name="user_email" value=""/>
                                    <div> <?php echo $this->session->flashdata('error_email');?></div> 
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
