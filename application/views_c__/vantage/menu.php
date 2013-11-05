<?php

	  if(!isset($mode))

		{

			$mode = '';

		}

	  // echo $mode; exit;

	  // echo '<pre>';

	  // print_r($menu);

	  // exit();

		 if(count($menu)>0 || ! empty($menu))

		   for($i=0; $i<count($menu); $i++)

		   {

			   if(isset($menu[$i]))

			   {

				  //Start 1
					$menu_id = 0;
					if(!isset($menu[$i]["is_webinar"]))
					{
						$menu_id = $menu[$i]['menu_id'];
					}	
					//End

				   if($mode=='edit')

					{

						$strLink = 'javascript: void(0);';  
						//Start 2
						if(isset($menu[$i]["is_webinar"]))
						{
							$link_caption = $menu[$i]['title'];
						}
						else
						{
							$link_caption = $menu[$i]['page_title'];
						}
						//End	  

					}

					else

					{

						//Start 3
						//A Webinar Component's Link
						if(isset($menu[$i]["is_webinar"]))
						{
						//echo 
//							index($site_id,$webinar_id)
							$strLink = base_url().index_page().'webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id'];
							$link_caption = $menu[$i]['title'];
						}
						else
						{
							$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
							$link_caption = $menu[$i]['page_title'];
						}	
						
						//End

					}

				?>

				<li >

					<a class="li_style"  href="<?=$strLink?>"><?=$link_caption?></a>

				</li>   

			<?php   

				}

		   }

		   else

		   $menu='';

		   

			//if(isset($_SESSION['user_info']['user_id']))

			//{

				if(isset($other_top_navigation) && !empty($other_top_navigation) || count ($other_top_navigation) > 0 )
				{
					for($a=0; $a<count($other_top_navigation); $a++)
					{
						if($mode=='edit')
						{
							$strLink = 'javascript: void(0);';    
						}
						else
						{
							$strLink = base_url().index_page().''.$other_top_navigation[$a]['link'].'/';
						}
						?>

						<li>

						<a  class="li_style"  href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a>

						</li>   

					<?php   

					}

				}

				else

				{

					$other_top_navigation = '';

				}	

		//	}

	 

	   if(!isset($adv_menu))

	   {

			$adv_menu = array();    

	   }

	 //top menu area

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
					<li >
						<a  class="li_style" href="<?=$strLink?>"><?=$adv_menu[$i]['sub_menu'][$j]['item_name']?></a>
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