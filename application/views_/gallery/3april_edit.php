<script src="<?=base_url()?>js/tool-tip.js" type="text/javascript"></script>
<style>
	#preview
	{
		position:absolute;
		border:1px solid #fff;
		background:#fff;
		padding:0px;
		display:none;
		color:#fff;
	}
</style>
<form action="<?=base_url().index_page()?>gallery_management/edit_gallery/<?=$gallery_id?>/<?=$site_id?>" onsubmit="return validate()" enctype="multipart/form-data" method="post">
    <fieldset>
        <input type="hidden" id="numImages" name="numImages" value="<?=count($gallery_images)?>" />
        <input type="hidden" id="numUploadedImages" name="numUploadedImages" value="<?=sizeof($gallery_images)?>" />  
        <label>Edit Gallery View</label>
      	<div class="section">
            <label>Images <span class="required">&nbsp;</span>
            <br />
            <span><a id="add_more_images" href="javascript: void(0);">Add more images</a></span></label>
            
            <div>
                <table id="images_uploader" width="100%" border="0" cellpadding="0" cellspacing="0">
                 
                    <?php
					$counter = 0;
					foreach($gallery_images as $row_image_info)
                    {
                       $fetch_id ='change_link'.$row_image_info['gallery_id'];
                       $fetch_title ='slide_title'.$row_image_info['gallery_title'];
                       $fetch_desc ='slide_description'.$row_image_info['gallery_description'];
                       $fetch_url ='slide_url'.$row_image_info['gallery_image_url'];
					   $target = '';
					   if(isset($row_image_info['target']) && !empty($row_image_info['target']))
						{
							$target ='target'.$row_image_info['target'];
						
						}						
					   $counter++;
                    ?>                    
                    
<tr>
                    <td width="50%">
					<div class="section">
                        <div>
                        <input id="slide_main" class="text <?=$fetch_title?>" type="text" name="slide_title<?=$counter?>" maxlength="30" value="<?=$row_image_info['gallery_title']?>" onkeypress="fade_link('<?=$fetch_id?>');" />
                        <label class="messages" id="slide_title_message" style="padding: 0;"></label>
                        </div>
                    </div>
                    </td>
                    <td>
                    
                     <input class="slider_image_url <?=$fetch_url?>" type="text" value="<?=$row_image_info['gallery_image_url']?>" name="slide_image_url<?=$counter?>" onkeypress="fade_link('<?=$fetch_id?>');" />
                            
                    </td>
                </tr>
                    <tr>
                        <td >
                            
                            
                        <div class="section">
                            <div>
                                <textarea id="slide_desc" class="<?=$fetch_desc?>" onkeypress="fade_link('<?=$fetch_id?>');" name="slide_description<?=$counter?>" rows="5" cols="20" title="Description"><?=$row_image_info['gallery_description']?></textarea>
                                <label class="messages" id="slide_desc_message" style="padding: 0;" ></label>
                            </div>
                        </div>
                        </td>
                        <td style="padding-bottom: 5px;">
                          <table>
						  	<tr>
						  		<td>
									<div >
                                <?=$row_image_info['gallery_image']?>
								<?
								$image_name = explode(".", $row_image_info['gallery_image']);
								$g_image = $image_name[0]."_thumb_200.".$image_name[1];			
								
								?>
                            <a onclick="delete_slider_image($(this).parent().parent(), <?=$row_image_info['gallery_image_id']?>)" style="font-size: 10px" href="javascript: void(0);">Delete</a></div>
								</td>
								<td>
								
								<a href="<?=base_url().'galleries/'.$g_image?>" class="preview"><img src="<?=base_url().'galleries/'.$row_image_info['gallery_image']?>"/></a>
								</td>
							</tr>
							</table>
                        </td>
                    </tr>
                    
                 <tr><td colspan="2" align="center" >
                 <a id="change_link<?=$row_image_info['gallery_image_id']?>" onclick="save_slider_image_url('<?=$fetch_id?>', '<?=$fetch_title?>', '<?=$fetch_desc?>', '<?=$fetch_url?>', <?=$row_image_info['gallery_image_id']?>)" style="display: none; font-size: 14px" href="javascript: void(0);">Save Changes </a>
                 </td></tr>
				 <tr>					
					<td style="padding-bottom: 5px" colspan="2">
						<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target<?=$counter?>" id="slide_target<?=$counter?>">
								<option value="0" >Same Window</option>
								<option value="1" >New Window</option>							
							</select>	
						</div>											
					</td>
				</tr>
                 <tr><td colspan="2"><hr/></td></tr>
                 
                                    
                 <?php
                    }
                    ?>
                    <!--<tr>
                    <td width="50%">
                    <div class="section">
                        <div>
                        <input id="slide_main" class="text" type="text" name="slide_title1" maxlength="30" title="Title" />
                        <label class="messages" id="slide_title_message" style="padding: 0;"></label>
                        </div>
                    </div>
                    </td>
                    <td>
                    
                     <input class="slider_image_url" id="slide_image_url" name="slide_image_url" type="text" title="URL" />
                    </td>
                </tr>-->
                    <!--<tr>
                        <td >
                            
                            
                        <div class="section">
                            <div>
                                <textarea id="slide_desc" name="slide_description1" rows="5" cols="20" title="Description"></textarea>
                                <label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
                            </div>
                        </div>
                        </td>
                        <td style="padding-bottom: 5px">
                          <div class="uploader" style="width: 181px;">
                                <input type="file" name="slide_image1" id="slide_image" size="19" style="opacity: 0;filter: alpha(opacity=0);">
                                <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                <span class="action" style="-moz-user-select: none;">Choose File</span>
                            </div>  
                        </td>
                    </tr>-->
					<!--<tr>					
						<td style="padding-bottom: 5px" colspan="2">
							<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
								<select  name="slide_target1" id="slide_target">
									<option value="0">Same Window</option>
									<option value="1">New Window</option>							
								</select>	
							</div>											
						</td>
					</tr>-->
                </table>
            </div>
            <div style="padding-top: 0"><label class="messages" id="slide_images_message" style="padding: 0;"></label></div>
        </div>
        
        <div class="section">
            <label>Title <span class="required">&nbsp;</span></label>
            <div>
                <input id="slide_title" class="text" type="text" name="slider_title" maxlength="30" value="<?=$gallery_title?>" />
                <label class="messages" id="slide_title_message" style="padding: 0;"></label>
            </div>
        </div>
        
        <div class="section">
            <label>Description <span class="required">&nbsp;</span></label>
            <div>
                <textarea id="slide_description" name="slider_description" rows="5" cols="30"><?=$gallery_description?></textarea>
                <label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
            </div>    
        </div>  
        <script src="<?=base_url()?>js/mootool/jquery.searchField.js" type="text/javascript"></script>
        <script src="<?=base_url()?>js/mootool/execute-scripts.js" type="text/javascript"></script>
        <div class="section">
            <label>Published <span class="required">&nbsp;</span></label>
             <div>
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($gallery_published == 'Yes')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Yes" name="slide_published" id="slide_published1" <?=$strChecked?> /></span>
                </div>
                <label for="slide_published1">Yes</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($gallery_published == 'No')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="No" name="slide_published" id="slide_published2" <?=$strChecked?> /></span>
                </div>
                <label for="slide_published2">No</label>
             </div>
        </div>
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
            <label>Display on Pages <span class="required">&nbsp;</span></label>
             <div>
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($gallery_pages == 'All')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="All" name="slide_pages" id="slide_pages1" <?=$strChecked?> /></span>
                </div>
                <label for="slide_pages1">All Pages</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    $strStyle = 'display: none;';
                    if($gallery_pages == 'Other')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';
                        $strStyle = '';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Other" name="slide_pages" id="slide_pages2" <?=$strChecked?> /></span>
                </div>
				<label for="slide_pages2">Some Pages</label>
                <div>
				
                <select id="slide_pages" name="slide_pages_list[]" multiple="multiple" style="opacity: 1.0; filter: alpha(opacity = 100); width: 130px; margin: 15px 0 5px 5px; <?=$strStyle?>">
                <?php 
                if($gallery_pages != 'Other')
                {
                    
					
					foreach($pages->result_array() as $rowPages)
                    {
                ?>
                    <option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option>
                <?php 
                    }
                }
                else
                {
                    foreach($pages->result_array() as $rowPages)
                    {
                        $strSelected = '';
                        if(in_array($rowPages['page_id'], $gallery_display_pages))
                        {
                            $strSelected = 'selected="selected"';     
                        }
                ?>
                    <option value="<?=$rowPages['page_id']?>" <?=$strSelected?>><?=$rowPages['page_title']?></option>
                <?php 
                    }
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
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($gallery_access == 'Everyone')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Everyone" name="slide_access" id="slide_access1" <?=$strChecked?> /></span>
                </div>
                <label for="slide_access1">Everyone</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($gallery_access == 'Registered')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Registered" name="slide_access" id="slide_access2" <?=$strChecked?> /></span>
                </div>
                <label for="slide_access2">Registered</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    $strStyle = 'display: none;';
                    if($gallery_access == 'Other')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"'; 
                        $strStyle = '';   
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Other" name="slide_access" id="slide_access3" <?=$strChecked?> /></span>
                </div>
                <label for="slide_access3">Other</label>
             </div>
             <select id="slide_roles" name="slide_roles_list[]" multiple="multiple" style="opacity: 1.0; filter: alpha(opacity = 100); width: 130px; margin: 0 0 20px 15px; <?=$strStyle?>">
                <?php
                if($gallery_access != 'Other')
                { 
                    foreach($groups as $rowRoles)
                    {
                ?>
                    <option value="<?=$rowRoles['id']?>"><?=$rowRoles['group_name']?></option>
                <?php 
                    }
                }
                else
                {
                    foreach($groups as $rowRoles)
                    {
                        $strSelected = '';
                        if(in_array($rowRoles['id'], $gallery_access_roles))
                        {
                            $strSelected = 'selected="selected"';     
                        }
                ?>
                    <option value="<?=$rowRoles['id']?>" <?=$strSelected?>><?=$rowRoles['group_name']?></option>    
                <?php
                    }
                }
                ?>
            </select>
			<?php /*?> <select id="slide_roles" name="slide_roles_list[]" multiple="multiple" style="opacity: 1.0; filter: alpha(opacity = 100); width: 130px; margin: 0 0 20px 15px; display: none;">
					<?php 
					foreach($groups as $group)
					{
					?>
						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>
					<?php 
					}
					?>
				</select><?php */?>
            <div style="padding-top:0"><label class="messages" id="slide_roles_message" style="padding: 0;"></label></div>
        </div>
        
        <div class="section">
            <div>
                <input type="button" value="CANCEL" onclick="javascript: history.go(-1);" />  <input type="submit" value="UPDATE" />
            </div>
        </div>
         
    </fieldset>
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
    
    var numImages = <?=$counter?>;
    var numUploadedImages = <?=sizeof($gallery_images)?>;
    $(document).ready(function() {
        $('a#add_more_images').click(function(){
            numImages++;
            $('#numImages').val(numImages);
            /*var html = '<tr><td colspan="2"><hr/></td></tr><tr><td ><div class="section"><label>Title </label><div><input id="slide_main" class="text" type="text"  name="slide_title'+numImages+'"  maxlength="30" /><label class="messages" id="slide_title_message"  style="padding: 0;"></label></div></div></td><td><div class="section"><label>Description </label><div> <input id="slide_main" class="text" type="text" name="slide_description'+numImages+'" maxlength="30" /><label class="messages" id="slide_title_message" style="padding: 0;"></label></div></div></td></tr><tr><td width="30%"><div class="uploader" style="width: 181px;"><input onchange="setFileName($(this))" type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" style="opacity: 0;filter: alpha(opacity=0);"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div></td><td style="padding-bottom: 5px"><span style="font-size:10px">URL:</span> <input class="slider_image_url" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" type="text" /></td></tr>';*/
            
             var html ='<tr><td colspan="2"><hr/></td></tr><tr><td width="50%"><div class="section"><div><input id="slide_main" class="text" type="text" name="slide_title'+numImages+'" maxlength="30" title="Title" value="Title" /><label class="messages" id="slide_title_message" style="padding: 0;"></label></div></div></td><td><input class="slider_image_url" id="slide_image_url" name="slide_image_url'+numImages+'" type="text" title="URL" value="URL"/></td></tr><tr><td ><div class="section"><div><textarea id="slide_desc" name="slide_description'+numImages+'" rows="5" cols="20" title="Description">Description</textarea><label class="messages" id="slide_desc_message" style="padding: 0;"></label></div></div></td><td style="padding-bottom: 5px"><div class="uploader" style="width: 181px;"><input type="file" onchange="setFileName($(this))" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" style="opacity: 0;filter: alpha(opacity=0);"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div></td></tr><tr><td style="padding-bottom: 5px" colspan="2"><div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span><select  name="slide_target'+numImages+'" id="slide_target'+numImages+'"><option value="0" >Same Window</option><option value="1" >New Window</option></select></div></td></tr>';
			 
			 
            
            $('table#images_uploader').append(html); 
			 document.getElementById('numImages').value = numImages;
        });
    });
    
    function fade_link(objlnk){
        // alert("I am called"+objlnk);
        // $(this).parent().find('a').fadeIn('slow');
        $("#"+objlnk).fadeIn('slow');
    }
    
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
        
        flagSubmit = true;
        
        if(numUploadedImages>0)
        {
            flagSelected = true;
        }
        else
        {
            flagSelected = false;    
        }
        
        
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
            $('#slide_title_message').html('<code>Please enter title for this slideshow.</code>');
            flagSubmit = false;
        }
        
        if($('#slide_description').val() == '')
        {
            $('#slide_desc_message').html('<code>Please enter description of slideshow.</code>');
            flagSubmit = false;
        }
        if($('#slide_width').val() == '' || $('#slide_height').val() == '' )
        {
            $('#slide_width_height').html('<code>Please Enter Width and Height for this slideshow.</code>');
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
            $('#slide_pages_message').html('<code>Please select page(s) to display slideshow.</code>');
            flagSubmit = false;
        }
        
        if($('#slide_access3').is(':checked') && $('#slide_roles option:selected').val() == null)
        {
            $('#slide_roles_message').html('<code>Please select role(s) to slideshow access.</code>');
            flagSubmit = false;
        }
           
        return flagSubmit;   
        
    }
    
    function delete_slider_image(slider_area, slider_image_id)
    {
        bool = confirm('Are you sure to delete this slider image?');
        if(bool == true)
        {
            numUploadedImages--;
            $('#numUploadedImages').val(numUploadedImages);
           // $( "tr_"+slider_image_id ).css( "display","none" );
            $(slider_area).fadeOut('slow', function(){
                $.ajax({
                url: '<?=base_url().index_page()?>site_slides/delete_slide_image_info/'+slider_image_id,
                success: function(data)
                        {
                           // alert("tr_"+slider_image_id);
                           // $( "tr_"+slider_image_id ).css( "display","none" );
                           location.reload();

                        }
                });  
            });
        }
        else
        {
            return;
        }
    }
    function save_slider_image_url(fetch_link, title , desc , url , slider_image_id)
    {
        $('#'+fetch_link).fadeOut('slow'); 
                   
            var title = $("."+title).val();
            var desc = $("."+desc).val();
            var url = $("."+url).val();

            var slider_image_url = $('#'+fetch_link).val();
            var dataString = 'slider_image_url='+url+'&&slider_image_title='+title+'&&slider_image_desc='+desc; 
            var url_link = '<?=base_url().index_page()?>site_slides/save_slide_image_url/'+slider_image_id;
           // alert(dataString);
           // alert(url_link);
            
            $.ajax({
            type: "POST",
            data: dataString,
            url: url_link,
            success: function(data)
                    {
                       // alert(data);
                        // success messege 
                    }
            });  
    }
     
</script>