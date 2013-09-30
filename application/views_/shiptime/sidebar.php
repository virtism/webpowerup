
				<div id="left_top">
					<img src="<?=base_url(); ?>css/shiptime/images/lefttop.png" alt="dfdf" border="0"  />
				</div>
				<div class="shipnow">
					<?php

						$attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript:void(0);' );
						echo form_open('MyAccount/login',$attributes);
						echo form_hidden('action','do_login');
						echo form_hidden('log_in','shiptime');
						
					?>
					<div class="ship_box">
							<div class="ship_form_row">
								<label class="ship_label">Username:</label><br />
								<input type="email"  name="email" class="ship_input">
							</div>
							<div class="ship_form_row">
								<label class="ship_label">Password:</label><br />
								<input type="password"  name="password" size="18" class="ship_input">
							</div>
							<div class="ship_form_row">                                     
								 <!--<input type="image" class="login" src="<?=base_url(); ?>css/shiptime/images/btn_shipnow.jpg"> -->
								 <input name="submit" type="submit" value=" " class="button-login"/>
								 
							</div>
							<div class="ship_form_row">                                     
								 <strong>Forgot your password?</strong> <a href="#" class="blue_link">Click here</a>
							</div>                               
						
					  </div>
					  <?php  echo form_close();  ?> 
				</div>
				<div class="shipnow">
					 <div class="hr_row" > &nbsp;</div>
					<div class="share"> 
						<input type="image" class="login" src="<?=base_url(); ?>css/shiptime/images/btn_share.jpg"><br />
						<span>Tell your Colleagues about ship time</span>
						<span>and pay no sign-up free!</span>
					</div>
						
					<div class="hr_row"> &nbsp; </div>
				</div>
				<div class="shipnow">
					<div style=" height:144px;">
						<div align="center" style=" padding-top:32px;">Ready to start shipping?</div>
						<div align="center" style=" padding-top:12px;">
                           <a href="<?=base_url().index_page()?>MyAccount/register"> <input type="image" class="login" src="<?=base_url(); ?>css/shiptime/images/btn_signup_Big.jpg">  </a>
                            </div>
						<div align="center" style=" padding-top:12px;"><img src="<?=base_url(); ?>css/shiptime/images/left-box.png" alt="dfdf" border="0"  /></div>
					</div>
				</div>
				<div class="brd-bottom"> &nbsp; </div>


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
	echo $addNewIcon;     
}
	//echo "<pre>";
	//print_r($menus);
?>
  <br>
<?
//load default/sample menus/menu items when no menus have been created
if(sizeof($menus)<1 && $mode=='edit')
{?>

	<div class="" style="opacity: 0.3; filter:alpha(opacity=30);">
		<h2 class="star"><span>Sidebar</span> Menu</h2>
		<ul class="">
			<li><a href="javascript: void(0);">Home</a></li>
			<li><a href="javascript: void(0);">TemplateInfo</a></li>
			<li><a href="javascript: void(0);">Style Demo</a></li>
			<li><a href="javascript: void(0);">Blog</a></li>
			<li><a href="javascript: void(0);">Archives</a></li>
			<li><a href="javascript: void(0);">Web Templates</a></li>
		</ul>
	</div>
	
	<div class="" style="opacity: 0.3; filter:alpha(opacity=30);">
		  <h2 class=""><span>Sponsors</span></h2>
		  <ul class="">
			<li><a href="javascript: void(0);">Dream</a><br />
			  </li>
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
//loads menus of the page
else
{
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
				$editIcon = '<span title="Delete" style="cursor:pointer" onclick="deleteMenu('."'"."menu_area_".$i."'".', '.$menus[$i]['menu_id'].')"><b>&nbsp;x&nbsp;</b></span>
				<a class="edit_menu" href="'.base_url().index_page().'page_editor/editMenuInfo/'.$site_id.'/'.$menus[$i]['menu_id'].'"><img src="'.base_url().'images/edit_icon.jpg" style="border:none;background:none;" /></a>
				';       
			}
?>

<div class="menu-dialog" id="menu_area_<?=$i?>">
	<div class="title-bar">
		<?=$editIcon?>
		<img alt="" src="<?=base_url()?>css/shiptime/images/spacer.gif" class="icon ajax-minicart-icon">
		<h2><?=$menus[$i]['menu_name']?></h2>
	</div>
	
	<div class="content">
			<?php
			if(sizeof($menus[$i])>0)
			{?>
		<ul >
				<?php
				for($j=0; $j<sizeof($menus[$i]['sub_menu']); $j++){
					if($mode=='edit')
					{
						$strLink = 'javascript: void(0);';    
					}
					else
					{
						$strLink = base_url().index_page()"site_preview/page/".$site_id."/".$menus[$i]['sub_menu'][$j]['page_id'];
					}
				?>
			<li>
				<a href="<?=$strLink?>"><?=$menus[$i]['sub_menu'][$j]['item_name']?>
				</a>
			</li>
			<?php
				}?>
		</ul>    
			<?php
			}
			?>
			</div>
</div>
	<?php
		}
	}
}?>