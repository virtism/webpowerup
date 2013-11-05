<?php

	for($i=0; $i<count($menu); $i++)
	{
		 if(isset($menu[$i]))
			   {
					//$menu_id = $menu[$i]['menu_id'];
					
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
						if($i==0)
						{?>
								<?php /*?><li ><a class="link_style active" href="<?=base_url().index_page()?>site_preview/page/<?=$menu[$i]["site_id"]?>/<?=$menu[$i]["page_id"]?>"><?=$menu[$i]["page_title"]?></a></li><?php */?>
							<li ><a class="link_style active"  href="<?=$strLink?>"><?=$link_caption?></a></li>   
						<? }
						else{
						?>
								<?php /*?><li ><a class="link_style" href="<?=base_url().index_page()?>site_preview/page/<?=$menu[$i]["site_id"]?>/<?=$menu[$i]["page_id"]?>"><?=$menu[$i]["page_title"]?></a></li><?php */?>
							<li ><a class="link_style"  href="<?=$strLink?>"><?=$link_caption?></a></li>   
						<? 
						}
	}

}
?>