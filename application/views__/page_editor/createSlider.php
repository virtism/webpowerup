<?=doctype()?>
<head>
<script src="<?=base_url()?>js/jquery-1.5.1.min.js" type="text/javascript" language="javascript"></script> 
<script type="text/javascript" language="javascript">
    
var numImages = 3;
$(document).ready(function() {
    $('a#add_more_images').click(function(){
        numImages++;
        $('#numImages').val(numImages);
        var html = '<tr><td width="30%"><input type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" /></td><td style="padding-bottom: 5px"><span style="font-size:10px">URL: </span><input class="slider_image_url" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" type="text" /><br><span style="font-size:10px">Title:</span><input id="slide_title'+numImages+'" class="text" type="text" name="slide_title'+numImages+'" maxlength="30" title="Title" /><br><textarea id="slide_description'+numImages+'" name="slide_description'+numImages+'" rows="5" cols="20" title="Description"></textarea><div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span><select  name="slide_target'+numImages+'" id="slide_target'+numImages+'"><option value="0">Same Window</option><option value="1">New Window</option></select></div></td></tr>';	
		
		/*<div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
			<select  name="slide_target1" id="slide_target1">
				<option value="0">Same Window</option>
				<option value="1">New Window</option>							
			</select>
		</div>*/
		
		
        $('table#images_uploader').append(html); 
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
    
    flagSubmit = true;
    
    flagSelected = false;
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
        $('#slide_images_message').html('<code style="font-size:11px; color: red;">Please select slide image(s)</code>');
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
                $('#slide_images_message').html('<code style="font-size:11px; color: red;">Invalid slide image(jpg, gif or png): '+i+'</code>');
                flagSubmit = false;    
            }    
        }             
    } 
    
    if($('#slide_title').val() == '')
    {
        $('#slide_title_message').html('<code style="font-size:11px; color: red;">Please enter title for this slideshow.</code>');
        flagSubmit = false;
    }
    
    if($('#slide_description').val() == '')
    {
        $('#slide_desc_message').html('<code style="font-size:11px; color: red;">Please enter description of slideshow.</code>');
        flagSubmit = false;
    }
    
    if($('#slide_pages2').is(':checked') && $('#slide_pages option:selected').val() == null)
    {         
        $('#slide_pages_message').html('<code style="font-size:11px; color: red;">Please select page(s) to display slideshow.</code>');
        flagSubmit = false;
    }
    
    if($('#slide_access3').is(':checked') && $('#slide_roles option:selected').val() == null)
    {
        $('#slide_roles_message').html('<code style="font-size:11px; color: red;">Please select role(s) to slideshow access.</code>');
        flagSubmit = false;
    }
       
    return flagSubmit;   
    
}
</script>
</head>
<body>
<h1>Create Slideshow Banner</h1>
     
<form id="frmCreateSlider" action="<?=base_url().index_page()?>site_slides/create_slide_fancy/<?=$site_id?>" onSubmit="return validate()" enctype="multipart/form-data" method="post">    
    <input type="hidden" name="numImages" value="3" />
        
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
        <td colspan="2" valign="top">
            <div class="section">
            <label>Slider (Width*Height)</label>
            <div>
                <input type="text" maxlength="30"  name="slide_width" class="text" id="slide_width" title=""> PX            
                <input type="text" maxlength="30"  name="slide_height" class="text" id="slide_height" title=""> PX
                <label style="padding: 0;" id="slide_width_height" class="messages"></label>
                
            </div>
        </div>
        </td>
    </tr>
    <tr>
        <td valign="top" width="25%"><b>Images <span style="color: red;">*</span></b>
        <br />
        <span style="font-size: 10px"><a id="add_more_images" href="javascript: void(0);">Add more images</a></span>
        </td>
        <td valign="top">
            <table id="images_uploader" width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="30%">
                        <input type="file" name="slide_image1" id="slide_image1" size="19" />						
                    </td>
                    <td style="padding-bottom: 5px">
                        <span style="font-size:10px">URL:</span> 
                        <input class="slider_image_url" id="slide_image_url1" name="slide_image_url1" type="text" /><br>
						<span style="font-size:10px">Title:</span> 
						<input id="slide_title1" class="text" type="text" name="slide_title1" maxlength="30" title="Title" /><br>						
						<textarea id="slide_description1" name="slide_description1" rows="5" cols="20" title="Description"></textarea>
                        <div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target1" id="slide_target1">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>
						</div>
                        </td>
                </tr>
                <tr>
                    <td width="30%">
                        <input type="file" name="slide_image2" id="slide_image2" size="19" />
                    </td>
                    <td style="padding-bottom: 5px">
                        <span style="font-size:10px">URL:</span> 
                        <input class="slider_image_url" id="slide_image_url2" name="slide_image_url2" type="text" /><br>
						<span style="font-size:10px">Title:</span> 
						<input id="slide_title2" class="text" type="text" name="slide_title2" maxlength="30" title="Title" /><br>						
						<textarea id="slide_description2" name="slide_description2" rows="5" cols="20" title="Description"></textarea>
                        <div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target2" id="slide_target2">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>
						</div>
                    </td>
                </tr>
                <tr>
                    <td width="30%">
                        <input type="file" name="slide_image3" id="slide_image3" size="19" />
                    </td>
                    <td style="padding-bottom: 5px">
                        <span style="font-size:10px">URL:</span> 
                        <input class="slider_image_url" id="slide_image_url3" name="slide_image_url3" type="text" /><br>
						<span style="font-size:10px">Title:</span> 
						<input id="slide_title3" class="text" type="text" name="slide_title3" maxlength="30" title="Title" /><br>						
						<textarea id="slide_description3" name="slide_description3" rows="5" cols="20" title="Description"></textarea>
                        <div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span>
							<select  name="slide_target3" id="slide_target3">
								<option value="0">Same Window</option>
								<option value="1">New Window</option>							
							</select>
						</div>
                    </td>
                </tr>
            </table> 
            <div style="padding-top: 0"><label class="messages" id="slide_images_message" style="padding: 0;"></label></div> 
            <br />   
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Title <span style="color: red;">*</span></b></td>
        <td valign="top">
            <input id="slide_title" class="text" type="text" name="slider_title" maxlength="30" value="" />
            <label class="messages" id="slide_title_message" style="padding: 0;"></label>
            <br /> 
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Description <span style="color: red;">*</span></b></td>
        <td valign="top">
            <textarea id="slide_description" name="slider_description" rows="5" cols="30"></textarea>
            <label class="messages" id="slide_desc_message" style="padding: 0;"></label>
            <br />  
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Position <span style="color: red;">*</span></b></td>
        <td valign="top">
            <input type="radio" value="Top" name="slide_position" id="slide_position1" checked="checked" />
            <label for="slide_position1">Top</label> 
            
            <input type="radio" value="Right" name="slide_position" id="slide_position2" />
            <label for="slide_position2">Right</label>
            
            <input type="radio" value="Left" name="slide_position" id="slide_position3" />
            <label for="slide_position3">Left</label>
            
            <input type="radio" value="Bottom" name="slide_position" id="slide_position4" />
            <label for="slide_position4">Bottom</label>
            
            <br /><br />  
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Published <span style="color: red;">*</span></b></td>
        <td valign="top">
            <input type="radio" value="Yes" name="slide_published" id="slide_published1" checked="checked" />
            <label for="slide_published1">Yes</label>
        
            <input type="radio" value="No" name="slide_published" id="slide_published2" />
            <label for="slide_published2">No</label>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Display on Pages <span style="color: red;">*</span></b></td>
        <td valign="top">
            <input type="radio" value="All" name="slide_pages" id="slide_pages1" checked="checked" />
            <label for="slide_pages1">All Pages</label>
            
            <input type="radio" value="Other" name="slide_pages" id="slide_pages2" />
            <label for="slide_pages2">Some Pages</label>
            <div>
            <select id="slide_pages" name="slide_pages_list[]" multiple="multiple" style="width: 130px; margin: 15px 0 5px 5px; display: none;">
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
            <div style="padding-top:0"><label class="messages" id="slide_pages_message" style="padding: 0;"></label> </div>
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Who can see this Slide? <span style="color: red;">*</span></b></td>
        <td valign="top">
            <input type="radio" value="Everyone" name="slide_access" id="slide_access1" checked="checked" />
            <label for="slide_access1">Everyone</label>
            
            <input type="radio" value="Registered" name="slide_access" id="slide_access2" />
            <label for="slide_access2">Registered</label>
            
            <input type="radio" value="Other" name="slide_access" id="slide_access3" />
            <label for="slide_access3">Other</label>
            
            <br /><br /> 
            
            <select id="slide_roles" name="slide_groups[]" multiple="multiple" style="width: 130px; margin: 0 0 20px 15px; display: none;">
            <?php
            foreach($groups as $group)
            {
            ?>
                <option value="<?=$group['id']?>"><?=$group['group_name']?></option>
            <?php 
            }
            ?>
        </select>
        <div style="padding-top:0"><label class="messages" id="slide_roles_message" style="padding: 0;"></label></div>    
        <br />    
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="Cancel" onClick="parent.$.fancybox.close();"> &nbsp; <input type="submit" value="Create" /></td>
    </tr>
    
</table>

</form>
</body>

