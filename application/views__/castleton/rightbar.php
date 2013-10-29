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
h1{
	margin:0px 5px 0 5px; 
	background:#000000 ;
	width:230px;
	padding:10px 10px 10px 10px;
	color: #FFFFFF;
    display: block;
    font-family: Myriad Pro;
    font-size: 18px;
   
}
ul.sidemenu{
	margin:0 5px 10px 5px; 
	width:250px;
}
ul.sidemenu li{
	background:#FFFFFF;
	padding:5px 5px 5px 5px;
	width:240px;
	color: #000000;
    font-family: Georgia,'Times New Roman',Times,serif;
    font-style: italic;
}
ul.sidemenu li a{
	color: #000000;
}
ul.sidemenu li a:hover{
	text-decoration:underline;
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

?>
<?php  
  
$_SESSION["is_menu"] = 0;	
	
  	
	
if(sizeof($right_menus) > 0 && $mode=='edit')
{
	
	                
	$_SESSION["is_menu"] = 1;
	?>      
	
	
	 <?php                
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
	
	
						 <div id="colTwo" >
						  <?//$editIcon?>
							<ul>
	
								<li id="menu_area_<?=$i?>">
									<h2><?=$menus[$i]['menu_name']?></h2>
									<ul>
	<?php
	if(sizeof($menus[$i])>0)
	{
		
		for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++)
			{
				if($mode=='edit')
				{
					$strLink = 'javascript: void(0);';    
				}
				else if ($right_menus[$i]['sub_menu'][$j]['item_link'] != "")
				{
					$strLink = $right_menus[$i]['sub_menu'][$j]['item_link'];
				}
				else
				{
				   $strLink = base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];
				}
		?>
										<li><a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>
	 <?php
			} ?>
									</ul>
								</li>
	   <?php
	}
	?>                         
	
	
							</ul>
						</div>
		  <?php
		}
	?>
	<div class="morenews"> &nbsp; </div>
					</div> 
					<div class="sideboxBtm"> &nbsp;</div>
	 </div>
	<?    
		}
	?>
	
	
						
						
	<?php
	  
} 
 
else if(sizeof($right_menus) > 0 ) 
{
	
	/*echo "<pre>";
	print_r($right_menus);
	echo "</pre>";*/
	
	
    $_SESSION["is_menu"] = 1;
    // echo "<pre>"; print_r($right_menus);  echo "</pre>";  
	?>
  
 <?php
                 
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
				$editIcon = '<span title="Delete" style="cursor:pointer" onclick="$(document.getElementById('."'menu_area_".$i."'".')).fadeOut();"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$menus[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>
				'; 
				*/
				$editIcon = '<span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."menu_area_".$i."'".', '.$right_menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$right_menus[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>
				';       
			}
?>




					 <?=$editIcon?>
					 
								<h1><?=$right_menus[$i]['menu_name']?></h1>
								<ul class="sidemenu">
										<?php
										if(sizeof($right_menus[$i])>0)
										{
										
										//echo "here";exit;
											for($j=0; $j<sizeof($right_menus[$i]['sub_menu']); $j++)
												{
													//echo "<pre>";
													//print_r($right_menus[$i]['sub_menu']);
													
												
													//exit;
										
													if($mode=='edit')
													{
														$strLink = 'javascript: void(0);';    
													}
													else
													{
														$strLink = base_url().index_page()."site_preview/page/".$site_id."/".$right_menus[$i]['sub_menu'][$j]['page_id'];
													}
													
													if(empty($right_menus[$i]['sub_menu'][$j]["page_id"]) && !empty($right_menus[$i]['sub_menu'][$j]["item_link"]))
													{
														//Checking The Full URL 
														if(strstr($right_menus[$i]['sub_menu'][$j]["item_link"],"http://"))
														{
															$link_url =  $right_menus[$i]['sub_menu'][$j]["item_link"];	
														}
														else
														{
															//Making Full Url Starting from HTTP
															$link_url =  "http://".$right_menus[$i]['sub_menu'][$j]["item_link"];	
														}
														//exit;
													}
													else
													{
														$link_url = $strLink;
													}
											?>
													<li><a href="<?=$link_url?>"><?=$right_menus[$i]['sub_menu'][$j]['item_name']?></a></li>
											<?php } ?>
									
					
										  <?php
										}
										?>                         
									</ul>

	  <?php
	}
    
 ?>
 <?php   
	
	}

}

?>
