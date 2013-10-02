<form  action="<?=base_url().index_page()?>gallery_management/save_gallery_info/<?=$site_id?>" onsubmit="return validate()" enctype="multipart/form-data" method="post" id="slider_upload" name="slider_upload">
	<fieldset>
		<label>Create a Gallery</label>
		<div class="section clearfix" >
			<label>Images <span class="required">&nbsp;</span>
			<br />
			<span><a id="add_more_images" href="javascript: void(0);"> Add more images </a></span></label>
			
			<div>
				<table id="images_uploader" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%">
						<div class="section">
							<div>
								<input id="slide_main" class="text" type="text" name="slide_title1" maxlength="30" title="Title" />
								<label class="messages" id="slide_title_message" style="padding: 0;"></label>
							</div>
						</div>
					</td>
					<td>					
						<input class="slider_image_url" id="slide_image_url" name="slide_image_url1" type="text" title="URL" />
					</td>
				</tr>
				<tr>
					<td>							
						<div class="section">
							<div>
								<textarea id="slide_desc" name="slide_description1" rows="5" cols="20" title="Description"></textarea>
								<label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
							</div>
						</div>
					</td>
					<td style="padding-bottom: 5px">
						<div class="uploader" style="width: 181px;">
							<input type="file" name="slide_image1" id="slide_image1" size="19" style="opacity: 0;filter: alpha(opacity=0);">
							<span class="filename" style="-moz-user-select: none;">No file selected</span>
							<span class="action" style="-moz-user-select: none;">Choose File</span>
						</div>  
					</td>
				</tr>
				<tr>					
					<td style="padding-bottom: 5px" colspan="2">
						<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target1" id="slide_target1">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>
						</div>
					</td>
				</tr>
				<tr><td colspan="2"><hr/></td></tr>   
				<tr>
					<td width="50%">
						<div class="section">
							<div>
								<input id="slide_main" class="text" type="text" name="slide_title2" maxlength="30" title="Title" />
								<label class="messages" id="slide_title_message" style="padding: 0;"></label>
							</div>
						</div>
					</td>
					<td>
					 <input class="slider_image_url" id="slide_image_url" name="slide_image_url2" type="text" title="URL" />
					</td>
				</tr>
				<tr>
					<td >
						<div class="section">
							<div>
								<textarea id="slide_desc" name="slide_description2" rows="5" cols="20" title="Description"></textarea>
								<label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
							</div>
						</div>
					</td>
					<td style="padding-bottom: 5px">
						<div class="uploader" style="width: 181px;">
							<input type="file" name="slide_image2" id="slide_image2" size="19" style="opacity: 0;filter: alpha(opacity=0);">
							<span class="filename" style="-moz-user-select: none;">No file selected</span>
							<span class="action" style="-moz-user-select: none;">Choose File</span>
						</div>  
					</td>
				</tr>
				<tr>					
					<td style="padding-bottom: 5px" colspan="2">
						<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target2" id="slide_target2">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>												
						</div>
					</td>
				</tr>
				<tr><td colspan="2"><hr/></td></tr>
				<tr>
					<td width="50%">
						<div class="section">
							<div>
								<input id="slide_main" class="text" type="text" name="slide_title3" maxlength="30" title="Title" />
								<label class="messages" id="slide_title_message" style="padding: 0;"></label>
							</div>
						</div>
					</td>
					<td>
						<input class="slider_image_url" id="slide_image_url" name="slide_image_url3" type="text" title="URL" />
					</td>
				</tr>
				<tr>
					<td>						
						<div class="section">
							<div>
								<textarea id="slide_desc" name="slide_description3" rows="5" cols="20" title="Description"></textarea>
								<label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
							</div>
						</div>
					</td>
					<td style="padding-bottom: 5px">
						<div class="uploader" style="width: 181px;">
							<input type="file" name="slide_image3" id="slide_image3" size="19" style="opacity: 0;filter: alpha(opacity=0);">
							<span class="filename" style="-moz-user-select: none;">No file selected</span>
							<span class="action" style="-moz-user-select: none;">Choose File</span>
						</div>  
					</td>
				</tr>
				<tr>					
					<td style="padding-bottom: 5px" colspan="2">
						<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target3" id="slide_target3">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>			
																
						</div>
					</td>
				</tr>
				
		</table>
		
			</div>
			<div style="padding-top: 0"><label class="messages" id="slide_images_message" style="padding: 0;"></label></div>
		</div>
		<script src="<?=base_url()?>js/mootool/jquery.searchField.js" type="text/javascript"></script>
		<script src="<?=base_url()?>js/mootool/execute-scripts.js" type="text/javascript"></script>
		<div class="section">
			<label>Title <span class="required">&nbsp;</span></label>
			<div>
				<input id="slide_title" class="text" type="text" name="slider_title" maxlength="30" />
				<label class="messages" id="slide_title_message" style="padding: 0;"></label>
			</div>
		</div>
		
		<div class="section">
			<label>Description <span class="required">&nbsp;</span></label>
			<div>
				<textarea id="slide_description" name="slider_description" rows="5" cols="30"></textarea>
				<label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
			</div>    
		</div>  
		
		<!--
		<div class="section">
			<label>Destination <span class="required">&nbsp;</span></label>
			 <div>
				<div class="radio">
					<span class="checked"><input type="radio" value="page" name="slide_destination" id="slide_destination1" checked="checked" /></span>
				</div>
				<label for="slide_destination1">One of my Pages</label>
				
				<div class="radio">
					<span><input type="radio" value="module" name="slide_destination" id="slide_destination2" /></span>
				</div>
				<label for="slide_destination2">One of my Modules</label>
				
				<div class="radio">
					<span><input type="radio" value="url" name="slide_destination" id="slide_destination3" /></span>
				</div>                        
				<label for="slide_destination3">Custom URL (Website)</label>
				<input type="text" id="slide_url" name="slide_url" style="display: none; margin-top: 17px;" />
			</div>
			<div id="select-module" style="margin: 0px; padding-top:0px; display: none;">
				 <div class="selector">
					<span style="-moz-user-select: none;">Select Module</span>
					<select id="slide_module" name="slide_module" style="opacity: 0; filter: alpha(opacity = 0);">
						<option value="0">Select Module</option>
						<?php 
						foreach($modules->result_array() as $rowModule)
						{
						?>
						<option value="<?=$rowModule['module_id']?>"><?=$rowModule['module_name']?></option>
						<?php 
						}
						?>
					</select>
				</div> 
			</div>
			<div id="select-page" style="margin: 0px; padding-top:0px;">
				 <div class="selector">
					<span style="-moz-user-select: none;">Select Page</span>
					<select id="slide_page" name="slide_page" style="opacity: 0; filter: alpha(opacity = 0);">
						<option value="0">Select Module</option>
						<?php 
						foreach($pages->result_array() as $rowPages)
						{
						?>
						<option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option>
						<?php 
						}
						?>
					</select>
				</div> 
			</div> 
			<div style="padding-top: 0"><label class="messages" id="slide_destination_message" style="padding: 0;"></label></div>
			 
		</div>
		-->
		
		
		
		<?php /*?><div class="section">
			<label>Position <span class="required">&nbsp;</span></label>
			 <div>
			 
				<div class="radio">
					<span class="checked"><input type="radio" value="Main" name="slide_position" id="slide_position1" checked="checked" /></span>
				</div>
				<label for="slide_position1">Main Slider (Below Menue)</label>
				
				<div class="radio">
					<span ><input type="radio" value="Top" name="slide_position" id="slide_position2" /></span>
				</div>
				<label for="slide_position1">Top (Content)</label>
				
				<div class="radio">
					<span><input type="radio" value="Right" name="slide_position" id="slide_position3" /></span>
				</div>
				<label for="slide_position2">Right (Content)</label>
				
				<div class="radio">
					<span><input type="radio" value="Left" name="slide_position" id="slide_position4" /></span>
				</div>
				<label for="slide_position3">Left (Content)</label>
				
				<div class="radio">
					<span><input type="radio" value="Bottom" name="slide_position" id="slide_position5" /></span>
				</div>
				<label for="slide_position4">Bottom (Content)</label>
			 </div>
		</div><?php */?>
		<div class="section">
			<label>Select Gallery Layout<span class="required">&nbsp;</span></label>
			 <div>
			 	<select  name="template_options" id="template_options" style="opacity:1;">
					<option value="0">Select Template</option>
					<option value="1">Square Green Boxes</option>
					
				</select>												
			 	<select  name="gallery_styles" id="gallery_styles" style="opacity:1;">
					<option value="0">Select Style</option>
					<option value="1">Two Column</option>
					<option value="2">Three Column</option>
				</select>												
			 </div>
		</div>
		<div class="section">
			<label>Open Gallery<span class="required">&nbsp;</span></label>
			 <div>
				<div class="radio">
					<span class="checked"><input type="radio" value="light_box" name="open_gallery" id="open_gallery1" checked="checked" /></span>
				</div>
				<label for="light_box">Light Box</label>
				<div class="radio">
					<span><input type="radio" value="new_page" name="open_gallery" id="open_gallery2" /></span>
				</div>
				<label for="slide_published2">New Window</label>
			 </div>
		</div>
		<div class="section">
			<label>Published <span class="required">&nbsp;</span></label>
			 <div>
				<div class="radio">
					<span class="checked"><input type="radio" value="Yes" name="slide_published" id="slide_published1" checked="checked" /></span>
				</div>
				<label for="slide_published1">Yes</label>
				
				<div class="radio">
					<span><input type="radio" value="No" name="slide_published" id="slide_published2" /></span>
				</div>
				<label for="slide_published2">No</label>
			 </div>
		</div>
		
		<div class="section">
			<label>Display on Pages <span class="required">&nbsp;</span></label>
			 <div>
				<div class="radio">
					<span class="checked"><input type="radio" value="All" name="slide_pages" id="slide_pages1" checked="checked" /></span>
				</div>
				<label for="slide_pages1">All Pages</label>
				
				<div class="radio">
					<span><input type="radio" value="Other" name="slide_pages" id="slide_pages2" /></span>
				</div>
				<label for="slide_pages2">Some Pages</label>
				<div>
				<select id="slide_pages" name="slide_pages_list[]" multiple="multiple" style="opacity: 1.0; filter: alpha(opacity = 100); width: 130px; margin: 15px 0 5px 5px; display: none;">
				<?php 
				foreach($pages->result_array() as $rowPages)
				{
				?>
					<option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option>
				<?php 
				}
				?>
				</select>
				</div>
			 </div>
			 <div style="padding-top:0"><label class="messages" id="slide_pages_message" style="padding: 0;"></label> </div>
		</div>
		
		<div class="section">
			<label>Who can see this Slide? <span class="required">&nbsp;</span></label>
			 <div>
				<div class="radio">
					<span class="checked"><input type="radio" value="Everyone" name="slide_access" id="slide_access1" checked="checked" /></span>
				</div>
				<label for="slide_access1">Everyone</label>
				 <? if($template_name!='gymnastic')
				{
				?>
					<div class="radio">
						<span><input type="radio" value="Registered" name="slide_access" id="slide_access2" /></span>
					</div>				
					<label for="slide_access2">Registered</label>
					
					<div class="radio">
						<span><input type="radio" value="Other" name="slide_access" id="slide_access3" /></span>
					</div>
					<label for="slide_access3">Other</label>
			   <? } ?>
			 </div>
				<? if($template_name!='gymnastic')
				{
				?>
				 <select id="slide_roles" name="slide_roles_list[]" multiple="multiple" style="opacity: 1.0; filter: alpha(opacity = 100); width: 130px; margin: 0 0 20px 15px; display: none;">
					<?php 
					foreach($groups as $group)
					{
					?>
						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>
					<?php 
					}
					?>
				</select>
			<? } ?>
			<div style="padding-top:0"><label class="messages" id="slide_roles_message" style="padding: 0;"></label></div>
		</div>
		
		<div class="section">
			<div>
				<input type="button" value="CANCEL" onclick="javascript: history.go(-1);" />  <input type="submit" value="CREATE" />
			</div>
		</div>
		 
	</fieldset>
	<input type="hidden" id="count" name="numImages" value="3" />
</form>

<script type="text/javascript" language="javascript">


	 //jquery for select list control
	$('div.selector select').change(function() {
		$(this).parent().find('span').text($(this).find('option:selected').html()) ;   
	});
	
	//jquery for radio button control
	$('div.radio span input:radio').click(function() {
		$(this).parent().parent().parent().find('div.radio span').removeClass('checked');
		$(this).parent().parent().parent().find('div.radio span input').attr('checked', false);
		
		var className = $(this).parent().attr('class');
		if(className == "")
		{
			$(this).parent().addClass("checked");
			$(this).attr('checked', true);
		}
		else
		{
			$(this).parent().removeClass('checked'); 
			$(this).attr('checked', false);
		}
	});
	
	//jquery for file upload control
	$('div.uploader input').change(function() {
		$(this).parent().find('span.filename').text(this.value) ; 
	});
	
	$('div.uploader2 input').change(function() {
	 alert(this.value);
		$(this).parent().find('span.filename').text(this.value) ; 
	});
	
	/*
	//jquery for hide/show panels
	$('#slide_destination1').click(function() {
		if($('#slide_url').css('display') != 'none')
		{ 
		   $('#slide_url').slideUp('slow', function(){
				$('#select-page').slideDown('slow');         
		   });
		}
		if($('#select-module').css('display') != 'none')
		{ 
		   $('#select-module').slideUp('slow', function(){
				$('#select-page').slideDown('slow');     
		   });
		} 
	});
	
	$('#slide_destination2').click(function() {
		if($('#slide_url').css('display') != 'none')
		{ 
		   $('#slide_url').slideUp('slow', function(){
			   $('#select-module').slideDown('slow');
		   }); 
		} 
		if($('#select-page').css('display') != 'none')
		{ 
		   $('#select-page').slideUp('slow', function(){
				$('#select-module').slideDown('slow');      
		   });
		}
	});
	
	
	$('#slide_destination3').click(function() {
		if($('#select-module').css('display') != 'none')
		{ 
		   $('#select-module').slideUp('slow', function(){
			   $('#slide_url').slideDown('slow');
		   });
		} 
		if($('#select-page').css('display') != 'none')
		{ 
		   $('#select-page').slideUp('slow', function(){
				$('#slide_url').slideDown('slow');    
		   });
		}
	});
	
	*/
	
	$('#slide_pages1').click(function() {
		if($('#slide_pages').css('display') != 'none')

		{ 
		   $('#slide_pages').slideUp('slow'); 
		} 
	});  
	$('#slide_pages2').click(function() {
		if($('#slide_pages').css('display') == 'none')
		{ 
		   $('#slide_pages').slideDown('slow'); 
		} 
	});
	
	$('#slide_access1').click(function() {
		if($('#slide_roles').css('display') != 'none')
		{ 
		   $('#slide_roles').slideUp('slow'); 
		} 
	});
	$('#slide_access2').click(function() {
		if($('#slide_roles').css('display') != 'none')
		{ 
		   $('#slide_roles').slideUp('slow'); 
		} 
	});
	$('#slide_access3').click(function() {
		if($('#slide_roles').css('display') == 'none')
		{ 
		   $('#slide_roles').slideDown('slow'); 
		} 
	});
	
	var numImages = 3;
	$(document).ready(function() {
		$('a#add_more_images').click(function(){
			numImages++;

		  var html ='<tr><td colspan="2"><hr/></td></tr><tr><td width="50%"><div class="section"><div><input id="slide_main" class="text" type="text" name="slide_title'+numImages+'" maxlength="30" title="Title"  /><label class="messages" id="slide_title_message" style="padding: 0;"></label></div></div></td><td><input class="slider_image_url" id="slide_image_url" name="slide_image_url'+numImages+'" type="text" title="URL" value="URL"/></td></tr><tr><td ><div class="section"><div><textarea id="slide_desc" name="slide_description'+numImages+'" class="watermark" rows="5" cols="20" title="Description">Description</textarea><label class="messages" id="slide_desc_message" style="padding: 0;"></label></div></div></td><td style="padding-bottom: 5px"><div class="uploader" style="width: 181px;"><input onchange="setFileName($(this))" type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" style="opacity: 0;filter: alpha(opacity=0);"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div></td></tr><tr><td style="padding-bottom: 5px" colspan="2"><div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span><select  name="slide_target'+numImages+'" id="slide_target'+numImages+'"><option value="0">Same Window</option><option value="1">New Window</option></select></div></td></tr>';
		   
			$('table#images_uploader').append(html); 
			 document.getElementById('count').value = numImages;
		});
	});
	
	function setFileName(uploader)
	{
		//jquery for file upload control
		$(uploader).parent().find('span.filename').text($(uploader).val()) ;
		return; 
	}
	
	function validateFileUpload(fup)
	{   
		var handle = document.getElementById(fup); 
		var fileName = handle.value;
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

		$('label.messages').empty();
		var flagSubmit = true;
		var flagSelected = false;		        
		for(i=1; i<=numImages; i++)
		{
			var slide_image = '#slide_image'+i;
			if($(slide_image).val() != "")
			{
				flagSelected = true;   
			}    
		}
		if(flagSelected == false)
		{
			$('#slide_images_message').html('<code>Please select slide image(s)</code>');
			flagSubmit = false;   
		}
		
		for(i=1; i<=numImages; i++)
		{
			var slide_image = '#slide_image'+i;
			if($(slide_image).val() != "")
			{
				flagFile = validateFileUpload('slide_image'+i);
				if(flagFile == false)
				{
					$('#slide_images_message').html('<code>Invalid slide image(jpg, gif or png): '+i+'</code>');
					flagSubmit = false;    
				}    
			}             
		} 
		
		if($('#slide_title').val() == '')
		{
			$('#slide_title_message').html('<code>Please enter title for this gallery.</code>');
			flagSubmit = false;
		}

		if($('#slide_description').val() == '')
		{
			$('#slide_desc_message').html('<code>Please enter description of gallery.</code>');
			flagSubmit = false;
		}

		

		/*
		if($('#slide_destination1').is(':checked') && $('#slide_page').val() == '0')
		{
			$('#slide_destination_message').html('<code>Please select page for slideshow.</code>');
			flagSubmit = false;
		}
		
		if($('#slide_destination2').is(':checked') && $('#slide_module').val() == '0')
		{
			$('#slide_destination_message').html('<code>Please select module for slideshow.</code>');
			flagSubmit = false;
		}
		
		if($('#slide_destination3').is(':checked') && $('#slide_url').val() == '')
		{
			$('#slide_destination_message').html('<code>Please enter url for slideshow.</code>');
			flagSubmit = false;
		}
		*/
		if($('#slide_pages2').is(':checked') && $('#slide_pages option:selected').val() == null)
		{         
			$('#slide_pages_message').html('<code>Please select page(s) to display gallery.</code>');
			flagSubmit = false;
		}       
		if($('#slide_access3').is(':checked') && $('#slide_roles option:selected').val() == null)
		{
			$('#slide_roles_message').html('<code>Please select role(s) to gallery access.</code>');
			flagSubmit = false;
		}
		var other = document.getElementById('slide_access3').checked;
		var len = document.slider_upload.group_access.length;
		var i = 0;
		var chosen = '';
		if(other)
		{
			for (i = 0; i < len; i++)
			{
				if (document.frmMenuInfo.group_access[i].selected)
				{
					 chosen = document.frmMenuInfo.group_access[i].value;
				}
			}
			if(chosen =="")
			{
				alert("Please select Group(s) allowed to access this page");
				flagSubmit = false;
			}
		}
		//flagSubmit = true; 
		return flagSubmit;
		
	}     
</script>