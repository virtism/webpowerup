<html>
<head>
<title>Edit Page Background Info</title>

<script language="javascript" type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>js/jscolor/jscolor.js"></script>   
<script type="text/javascript" language="javascript">

$(document).ready(function(){
	$('#page_background_2').click(function(){
		$('#background_area').slideDown('slow');
		$('#background_image').slideDown('slow');
	}); 
	
	$('#page_background_1').click(function(){
		$('#background_area').slideUp('slow');
		$('#background_image').slideUp('slow');        
	}); 
	
	$('#page_background_other').click(function(){
		$('#background_area').slideDown('slow');
		$('#background_image').slideDown('slow');
	});       
});


function validateFileUpload(fup)
{    
	var fileName = fup.value;
	
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
	{
		return true;
	} 
	else
	{        
		return false;
	}
}

function validate()
{
	var page_background_2 = document.getElementById("page_background_2");
	var background_image = document.getElementById("background_image");
	var background_image_message = document.getElementById("background_image_message");
	
	if(page_background_2.checked == true)
	{
		if(background_image.value == "")
		{
			background_image_message.innerHTML = '<code style="font-size: 11px; color: red">Please select background image.</code>';
			return false;    
		}
		else
		{
			if(validateFileUpload(background_image)==false)
			{
			background_image_message.innerHTML = '<code style="font-size: 11px; color: red">Invalid background image(jpg, gif or png)</code>';
			return false;
			}    
		}
   }
}
</script>
</head>
<body>

<h1>Page Background</h1>

<form id="frmEditPageBackground" method="post" action="<?=base_url().index_page()?>page_editor/updateBackgroundInfo/<?=$site_id?>/<?=$page_id?>" onSubmit="return validate()" enctype="multipart/form-data">

<input type="hidden" name="background_id" value="<?=$background_id?>" />

<input type="hidden" name="background_image" value="<?=$background_image?>" />  

<input type="hidden" id="DateTime" name="DateTime" value="<?=date("his")?>" />

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" width="25%">
			<b>Background Pattern <span style="color: red">*</span></b>
		</td>
		<td valign="top">
			<?php
				$strChecked = "";
				if($page_background == "Default")
				{
					$strChecked = 'checked="checked"';
				}
				?>
				<label>
					<input id="page_background_1" name="page_background" type="radio" value="Default" <?=$strChecked;?> />
					Use An Existing Background
				</label>
				<br />
				<?php
				if($page_background == "Other")
				{
				?>
					<label>
						<input type="radio" id="page_background_other" name="page_background" value="<?=$background_image?>" checked="checked"><?=$background_image?></option>
					</label>
					<br />
				<?php
				}
				?>
				<label>
					<input id="page_background_2" name="page_background" value="Other" type="radio" />
					Upload Your Own Image (Advance Feature)
				</label>        
				
				<br />
				&nbsp; &nbsp; &nbsp; &nbsp;<input type="file" id="background_image" name="background_image" style="display: none; margin-top: 5px;" />
				
				<br />
				&nbsp; &nbsp; &nbsp; &nbsp;<label class="message" id="background_image_message"></label>
				<br />     
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php
			$strDisplay = 'display: block;';
			if($page_background == 'Default')
			{
				$strDisplay = 'display: none;';      
			}
			?> 
			<div id="background_area" style="<?=$strDisplay?>">
			<table  width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" valign="top"><strong>Background Area</strong> </td>
					<td valign="top">
						<?php
						if(($page_background == 'Other' && $background_area == 'page') || $page_background == 'Default')
						{
							$strChecked = 'checked="checked"';    
						}
						else
						{
							$strChecked = '';    
						}
						//echo $color_after_image;exit;
						
						?>
						<label for="background_area_1">
							<input type="radio" id="background_area_1" name="background_area" value="page" <?=$strChecked?> />
							Whole Page                         <br>
								<span style="padding-left: 25px;"> Color To Fill Space for after Image Ends </span> 
								<input type="text" name="image_bg_color" id="prim_color" value="<?=($color_after_image) ?  $color_after_image : 'FFFFFF';?>"  onmousemove="document.getElementById('prim_color').color.showPicker()" onmouseover=document.getElementById('prim_color').color.hidePicker()" style="width: 60px; height: 35px; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" class="color {pickerClosable:true}" autocomplete="off" />
						</label>
						<br />
						<?php
						if($page_background == 'Other' && $background_area == 'content')
						{
							$strChecked = 'checked="checked"';    
						}
						else
						{
							$strChecked = '';    
						}
						?>

						<label for="background_area_2">
							<input type="radio" id="background_area_2" name="background_area" value="content" <?=$strChecked?> />
							Only Page Content  
						</label> <br /> 
						<?php
						if($page_background == 'Other' && $background_area == 'menu with content')
						{
							$strChecked = 'checked="checked"';    
						}
						else
						{
							$strChecked = '';    
						}
						?>
						<label for="background_area_3">
							<input type="radio" id="background_area_3" name="background_area" value="menu with content" <?=$strChecked?> />
							 Content and menu 
						</label>
						<br />
						<br />
					</td>
				</tr>
				<tr>
					<td valign="top"><strong>Background Style</strong> </td>
					<td valign="top">
						<?php
							if(($page_background == 'Other' && $background_style == 'stretch') || $page_background == 'Default')
							{
								$strChecked = 'checked="checked"';    
							}
							else
							{
								$strChecked = '';    
							}
							?>
							<label for="background_style_1">
								<input type="radio" id="background_style_1" name="background_style" value="stretch" <?=$strChecked?> />
								Stretch(to fit the area)
							</label>
							<br />
							<?php
							if($page_background == 'Other' && $background_style == 'tile')
							{
								$strChecked = 'checked="checked"';    
							}
							else
							{
								$strChecked = '';    
							}
							?>
							<label for="background_style_2">
								<input type="radio" id="background_style_2" name="background_style" value="tile" <?=$strChecked?> />
								Tile(the area)
							</label>
					</td>
				</tr>
			</table>
			</div>
			<br />
			
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" value="Cancel" onClick="parent.$.fancybox.close();" />
			<input type="submit" value="Update" />
		</td>    
	</tr>
</table>

</form>

</body>
</html>