<?=doctype()?>
<html>
<head>
<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script> 
<title></title>

<link rel="stylesheet" href="<?=base_url();?>css/sidebuilder.css">
<!--<link rel="stylesheet" href="<?=base_url();?>/css/context-menu.css">-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/styles-dragable.css" />

<script type="text/javascript" src="<?=base_url();?>js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/ajaxupload/ajaxupload.js"></script>  
<script type="text/javascript" src="<?=base_url();?>js/jquery.contextmenu.r2.js"></script>  
<script type="text/javascript" src="<?=base_url();?>js/jwplayer.js"></script>  
<script type="text/javascript" src="<?=base_url();?>js/media.js"></script> 
<script type="text/javascript" src="<?=base_url();?>js/jquery.meiomask.js"></script>  
<?
	$this->load->view("all_common/drag_drop_script");
?>
</head>
<body>
<?php
if($action == 'edit')
{
	$strAction = base_url().'index.php/pagesController/edit_pagecontent_editorboard/';
}
else
{
	$strAction = base_url().'index.php/pagesController/save_pagecontent_editorboard/';
}
?>
<div class="RightColumnHeading">
    <h1>
        <span>Create a New Page : Editor Board (Step 3)</span>
    </h1>
</div>
<div class="clr"></div>

<div class="InnerMain">
<form id="frmEditor" name="frmEditor" method="post" action="<?=$strAction?>" style="background: none; border: none;" class="niceform">
	<fieldset>
		<input type="hidden" name="site_id" value="<?=$site_id?>" />
		<input type="hidden" name="page_id" id ="page_id" value="<?=$page_id?>" />
		<input type="hidden" name="item_id" value="<?=$item_id?>" />
		<input type="hidden" name="page_access" value="<?=$page_access?>" />

		
		  
		  
<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<tr>
		<td>
			<div id="cart_items1">
				  </div>
			<div id="item_container">
				  <!--
				  <div class="item" id="i1">
					  
					  <label class="title">Text Area</label>
					  <label class="price"></label>
				  </div>
				  -->
				  <div class="item" id="para">
					  <label class="title">Content</label>
					  <label class="price"></label>
				  </div>
				  
				  <div class="item" id="image">
					  <label class="title">Image</label>
					  <label class="price"></label>
				  </div>
				  
				  <div class="item" id="image_content">
					  <label class="title">Image and Content</label>
					  <label class="price"></label>
				  </div>
				   <div class="item" id="video">
					  <label class="title">Add Video</label>
					  <label class="price"></label>
				  </div>
				  <!--  Start Document Upload 3-6-2012 -->
				  <div class="item" id="menu_doc">
						 <!--<a  class="edit_slider" href="<?=base_url()?>index.php/menusController/upload_doc/<?=$site_id?>" target="_blank">Upload Document</a>-->
						 <label class="title">Upload Document</label>
					  <label class="price"></label>
					</label>
				 </div>
				 <!--  End Document Upload 3-6-2012 -->
				<!--  <div class="item" id="content_image">
					  <label class="title">Content and Image</label>
					  <label class="price"></label>
				  </div>-->
				   <div class="clear"></div> 
			  </div>
			  
			<div id="cart_container" style="margin-left: -4px;">
				  <div id="cart_title">
					  <div class="clear"></div>
				  </div>
				  <div id="cart_toolbar">
					<div id="cart_items" class="back">
					<?php
					$count = 0;
					$my_scripts = '';
					if($action=='edit')
					{
						//back button load
						
						foreach($content->result_array() as $rowContentControl)
						{
							$count++;
							if($rowContentControl['type']=='textarea')
							{
							?> 
							<div id="item_cart_<?=$count?>">
								<div>
									<a onClick="remove_item('item_cart_<?=$count?>');" id="remove<?=$count?>" name="textarea_<?=$count?>" class="remove <?=$count?>">&times;</a>
								</div>
							<textarea cols="86" rows="1" id="textarea_<?=$count?>" name="content[]" onKeyUp="sizeBox(this.id)"  onfocus="apply_style(this, 'focus');" onClick="apply_style(this,'click')" onMouseOver="this.style.border='dashed 1px black';" onMouseOut="borderCheck(this)"><?=$rowContentControl['data']?></textarea>
							<input type="hidden" name="control_type[]" value="textarea"/>
							</div>  
							<?php
							}
							
							if($rowContentControl['type']=='image')
							{
							?>
							<div id="item_cart_<?=$count?>">
								<div>
									<input type="hidden" id="input_para_<?=$count?>" name="content[]" value="<?=$rowContentControl['data']?>" />
									<a onClick="remove_item('item_cart_<?=$count?>');" id="remove<?=$count?>" class="remove <?=$count?>" name="image_<?=$count?>">&times;</a>
								</div>
								<a id="image_<?=$count?>" href="<?=base_url()?>index.php/media/index/<?=$count?>" ><img src="<?=base_url()?>media/uploads/<?=$rowContentControl['data']?>" id="para_<?=$count?>" name="para_<?=$count?>" onClick="box_load('image_<?=$count?>')" title = "" alt = ""  /></a>
								<input type="hidden" name="control_type[]" value="image" /> 
							</div>  
							<?php
							}
								// Junaid 7 March 2012
							if($rowContentControl['type']=='doc_menu')
							{
							?>
							<div id="item_cart_<?=$count?>">
								<div>
									<input type="hidden" id="input_para_<?=$count?>" name="content[]" value="<?=$rowContentControl['data']?>" />
									<a onClick="remove_item('item_cart_<?=$count?>');" id="remove<?=$count?>" class="remove <?=$count?>" name="doc_<?=$count?>">&times;</a>
								</div>
								
								<input type="hidden" name="control_type[]" value="doc_menu" /> 
                                
                                
							</div>  
							<?php
							}
								// Junaid 7 March 2012
							if($rowContentControl['type']=='para')
							{
							?>
							<div id="item_cart_<?=$count?>">
								<div>
								<a onClick="remove_item('item_cart_<?=$count?>')" id="remove<?=$count?>" class="remove<?=$count?>">&times;</a>
								</div>
								<textarea cols="86" class="editor_ta" rows="1" id="para_<?=$count?>" name="content[]" onKeyUp="sizeBox(this.id)" onBlur="save_to_db(this.id);" onMouseOver="this.style.border='dashed 1px black';" onMouseOut="borderCheck(this)" onFocus="this.style.border='dashed 1px black';"><?=$rowContentControl['data']?></textarea>
								<input type="hidden" name="control_type[]" value="para" />
							</div>
							<?php
							$my_scripts = '<script type="text/javascript" language="javascript">
								'."CKEDITOR.replace( 'para_".$count."', {resize_enabled : 'false', width: '725', height: '100'} );      
							</script>";
							}
						}
					}
					?>
					</div>
				  </div>
				  <div class="clear"></div>
			</div>
			  
			  <!--
			  </div>
			  </div>
			  -->
		</td>
	</tr>
	<tr>
		<td>
			<input type="button" value="Back" onClick="document.getElementById('frmEditPageMenus').submit();" />
			<input type="submit" value="Continue" />
			<input type="hidden" name="popup_id" id="popup_id" value="">
			<input type="hidden" id="numControls" name="numControls" value="<?=$count?>" /> 
			<input type="hidden" id="img_property" name="img_property" value="" disabled="disabled" /> 
			
			<input type="hidden" id="temp_editor_data" name="temp_editor_data" value="" disabled="disabled" /> 
		</td>
	</tr>
			
</table>
</fieldset>
</form>    
<form id="frmEditPageMenus" method="post" action="<?=base_url()?>index.php/pagesController/page_menu/<?=$site_id?>/<?=$page_id?>/<?=$item_id?>" style="visibility: hidden;">
	<input type="hidden" name="site_id" value="<?=$site_id?>" />
	<input type="hidden" name="page_id" value="<?=$page_id?>" />
	<input type="hidden" name="item_id" value="<?=$item_id?>" />
	<input type="hidden" name="page_access" value="<?=$page_access?>" />
</form>
</div>
<?
//$baseDir = getcwd().'/media/ckeditor_uploads/'.$_SESSION["user_info"]["user_login"]."_".$_SESSION["user_info"]["user_id"]."/administrative";
//$baseDir = getcwd().'/media/ckeditor_uploads';
//if(!is_dir($baseDir)) 
//{
	//mkdir($baseDir , 0777); 
//  echo  'Here ='.$category_path.'<br>';   
//}
?>
<script type="text/javascript" language="javascript">
 
	var controls_count = <?=$count?>;
	var count = <?=$count?>;
	
</script>
<?=$my_scripts?>
</body>
</html>   