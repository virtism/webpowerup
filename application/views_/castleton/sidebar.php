<?php

if(!isset($mode))

{

	$mode = '';					



}

$addNewIcon = '';

if($mode=='edit')

{

	$addNewIcon = '<div style="position: relative; height: 20px;">

	<a class="edit_menu" href="'.base_url().index_page().'page_editor/createMenu/'.$site_id.'"><img align="right" src="'.base_url().'images/add_icon.png" style="border:none;background:none;" /></a>

	</div>';   

//	echo $addNewIcon;     

}

?>

<?php    

$_SESSION["is_menu"] = 0;		

if(sizeof($menus) >0 && $mode=='edit')

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

			

	<div class="sidebar"><!--Closing the above side bar div here-->

		<label><?=$menus[$i]['menu_name']?></label>

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

            else

            {

                $strLink = base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];

            }

    ?>

              <li><a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>

<?php

        }

?>

            </ul>

		  </div><!--Closing the above side bar div here--> 

                    

<?php

	}

?>                         

                        

<?php

    }

  

	    }

?>





                    

                    

<?php

  } 

 

else if(sizeof($menus) >0) 

{

    $_SESSION["is_menu"] = 1;

    /*echo "<pre>";

        print_r($menus);

echo "</pre>"; */ 

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

							<!--

				<div class="sidebar">

 				    <label>Lorem ipsum sikd</label>

				   <ul>

				   		<li>Vestibulum vitae <a class="active"  href="#"></a>

					    <a href="#"><span class="the_form_below" style="color:#000;">l to us</span></a>

					    </li>

						<li><a href="#"><span class="the_form_below" style="color:#000;">essential to us</span></a></li>

						<li><a href="#">Vestibulum vitae </a></li>

						<li><a href="#"><span class="the_form_below">fields marked</span></a></li>

						<li><a href="#"><span class="the_form_below" style="color:#000;">essential to us</span></a></li>

						<li><a href="#">Vestibulum vitae </a></li>

						<li><a href="#"><span class="the_form_below">fields marked</span></a></li>

			     </ul>

 				</div>

					-->





				 <div id="colTwo" >

					 <?=$editIcon?>

					 <ul>

							<li id="menu_area_<?=$i?>">

							    <div class="sidebar">

								<label><?=$menus[$i]['menu_name']?></label>

									<ul>

										<?php

										if(sizeof($menus[$i])>0)

										{

										

										//echo "here";exit;

											for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++)

												{

													//echo "<pre>";

													//print_r($menus[$i]['sub_menu']);

													

												

													//exit;

										

													if($mode=='edit')

													{

														$strLink = 'javascript: void(0);';    

													}

													else

													{

														$strLink = base_url().index_page()."site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];

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

													}

													else

													{

														$link_url = $strLink;

													}

											?>

													<li><a href="<?=$link_url?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?></a></li>

											<?php 

													}

											 ?>

									    </ul>

									  </div>

									</li>

										  <?php

												}

										?>                         

						</ul>

					</div>

<?php

		}    

                 

	}



}



?>

