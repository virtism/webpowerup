<?=doctype()?>

<html>

<head>
<script src="<?=base_url()?>js/jquery-1.5.1.min.js" type="text/javascript" language="javascript"></script>

<script type="text/javascript" language="javascript">
    
    
    var numImages = 1;
    var numUploadedImages = <?=sizeof($slide_images)?>;
    $(document).ready(function() {
        
        $('a#add_more_images').click(function(){
            numImages++;
            $('#numImages').val(numImages);
            var html = '<tr><td width="30%"><input type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" /></td><td style="padding-bottom: 5px"><span style="font-size:10px">URL:</span><input class="slider_image_url" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" type="text" /></td></tr>';
            $('table#images_uploader').append(html); 
        });
        
            //jquery for hide/show panels
        $('#slide_destination1').click(function() {
            if($('#slide_url').css('display') != 'none')
            { 
               $('#slide_url').fadeOut('fast', function(){
                    $('#select-page').fadeIn('fast');         
               });
            }
            if($('#select-module').css('display') != 'none')
            { 
               $('#select-module').fadeOut('fast', function(){
                    $('#select-page').fadeIn('fast');     
               });
            } 
        });
        
        $('#slide_destination2').click(function() {
            if($('#slide_url').css('display') != 'none')
            { 
               $('#slide_url').fadeOut('fast', function(){
                   $('#select-module').fadeIn('fast');
               }); 
            } 
            if($('#select-page').css('display') != 'none')
            { 
               $('#select-page').fadeOut('fast', function(){
                    $('#select-module').fadeIn('fast');      
               });
            }
        });
        
        
        $('#slide_destination3').click(function() {
            if($('#select-module').css('display') != 'none')
            { 
               $('#select-module').fadeOut('fast', function(){
                   $('#slide_url').fadeIn('fast');
               });
            } 
            if($('#select-page').css('display') != 'none')
            { 
               $('#select-page').fadeOut('fast', function(){
                    $('#slide_url').fadeIn('fast');    
               });
            }
        });
        
        
        $('#slide_pages1').click(function() {
            if($('#slide_pages').css('display') != 'none')
            { 
               $('#slide_pages').fadeOut('fast'); 
            } 
        });  
        $('#slide_pages2').click(function() {
            if($('#slide_pages').css('display') == 'none')
            { 
               $('#slide_pages').fadeIn('fast'); 
            } 
        });
        
        $('#slide_access1').click(function() {
            if($('#slide_roles').css('display') != 'none')
            { 
               $('#slide_roles').fadeOut('fast'); 
            } 
        });
        $('#slide_access2').click(function() {
            if($('#slide_roles').css('display') != 'none')
            { 
               $('#slide_roles').fadeOut('fast'); 
            } 
        });
        $('#slide_access3').click(function() {
            if($('#slide_roles').css('display') == 'none')
            { 
               $('#slide_roles').fadeIn('fast'); 
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
            $('#slide_images_message').html('<code style="color: red; font-size: 11px">Please select slide image(s)</code>');
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
                    $('#slide_images_message').html('<code style="color: red; font-size: 11px">Invalid slide image(jpg, gif or png): '+i+'</code>');
                    flagSubmit = false;    
                }    
            }             
        } 
        
        if($('#slide_title').val() == '')
        {
            $('#slide_title_message').html('<code style="color: red; font-size: 11px">Please enter title for this slideshow.</code>');
            flagSubmit = false;
        }
        
        if($('#slide_description').val() == '')
        {
            $('#slide_desc_message').html('<code style="color: red; font-size: 11px">Please enter description of slideshow.</code>');
            flagSubmit = false;
        }
        
        if($('#slide_pages2').is(':checked') && $('#slide_pages option:selected').val() == null)
        {
            $('#slide_pages_message').html('<code style="color: red; font-size: 11px">Please select page(s) to display slideshow.</code>');
            flagSubmit = false;
        }
        
        if($('#slide_access3').is(':checked') && $('#slide_roles option:selected').val() == null)
        {
            $('#slide_roles_message').html('<code style="color: red; font-size: 11px">Please select role(s) to slideshow access.</code>');
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
            $(slider_area).fadeOut('slow', function(){
                $.ajax({
                url: '<?=base_url().index_page()?>site_slides/delete_slide_image_info/'+slider_image_id,
                success: function(data)
                        {
                        }
                });  
            });
        }
        else
        {
            return;
        }
    }
    function save_slider_image_url(slider_parent_tag, slider_image_id)
    {
        $(slider_parent_tag).find('a').fadeOut('slow', function(){
            
            var slider_image_url = $(slider_parent_tag).find('input').val();
            var dataString = 'slider_image_url='+slider_image_url; 
            
            $.ajax({
            type: "POST",
            data: dataString,
            url: '<?=base_url().index_page()?>site_slides/save_slide_image_url/'+slider_image_id,
            success: function(data)
                    {
                    }
            }); 
        });  
    }
    

     
</script>

</head>

<body>

<h1>Edit Slideshow Banner</h1>

<form id="frmEditSlider" action="<?=base_url().index_page()?>site_slides/edit_slide_fancybox/<?=$site_id?>/<?=$slide_id?>" onsubmit="return validate()" enctype="multipart/form-data" method="post">                                 

    <input type="hidden" id="numImages" name="numImages" value="1" />
    <input type="hidden" id="numUploadedImages" name="numUploadedImages" value="<?=sizeof($slide_images)?>" />  
        
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top" width="25%"><b>Images <span style="color: red;">*</span></b>
        <br />
        <span style="font-size: 10px"><a id="add_more_images" href="javascript: void(0);">Add more images</a></span>
        </td>
        <td valign="top">
            <table id="images_uploader" width="100%" border="0" cellpadding="2" cellspacing="0">
                <?php
                foreach($slide_images as $row_image_info)
                {
                ?>
                <tr>
                    <td align="center">
                        <?=$row_image_info['slide_image']?>
                        <a onclick="delete_slider_image($(this).parent().parent(), <?=$row_image_info['slide_image_id']?>)" style="font-size: 10px" href="javascript: void(0);">Delete</a>
                    </td>
                    <td style="padding-bottom: 5px;">
                        <span style="font-size:10px">URL:</span> 
                        <input class="slider_image_url" type="text" value="<?=$row_image_info['slide_image_url']?>" onkeypress="$(this).parent().find('a').fadeIn('slow');" />
                        <a onclick="save_slider_image_url($(this).parent(), <?=$row_image_info['slide_image_id']?>)" style="display: none; font-size: 10px" href="javascript: void(0);">Save</a>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td width="30%">
                        <input type="file" name="slide_image1" id="slide_image1" size="19" />
                    </td>
                    <td style="padding-bottom: 5px">
                        <span style="font-size:10px">URL:</span> 
                        <input class="slider_image_url" id="slide_image_url1" name="slide_image_url1" type="text" />
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
            <input id="slide_title" class="text" type="text" name="slide_title" maxlength="30" value="<?=$slide_title?>" />
            <label class="messages" id="slide_title_message" style="padding: 0;"></label>
            <br /> 
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Description <span style="color: red;">*</span></b></td>
        <td valign="top">
            <textarea id="slide_description" name="slide_description" rows="5" cols="30"><?=$slide_description?></textarea>
            <label class="messages" id="slide_desc_message" style="padding: 0;"></label>
            <br />  
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Position <span style="color: red;">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';    
            if($slide_position == 'Top')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Top" name="slide_position" id="slide_position1" <?=$strChecked?> />
            <label for="slide_position1">Top</label> 
            
            <?php
            $strChecked = '';
            if($slide_position == 'Right')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Right" name="slide_position" id="slide_position2" <?=$strChecked?> />
            <label for="slide_position2">Right</label>
            
            <?php
            $strChecked = '';
            if($slide_position == 'Left')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Left" name="slide_position" id="slide_position3" <?=$strChecked?> />
            <label for="slide_position3">Left</label>
            
            <?php
            $strChecked = '';
            if($slide_position == 'Bottom')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Bottom" name="slide_position" id="slide_position4" <?=$strChecked?> />
            <label for="slide_position4">Bottom</label>
            
            <br /><br />  
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Published <span style="color: red;">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';
            if($slide_published == 'Yes')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Yes" name="slide_published" id="slide_published1" <?=$strChecked?> />
            <label for="slide_published1">Yes</label>
        
            <?php
            $strChecked = '';
            if($slide_published == 'No')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="No" name="slide_published" id="slide_published2" <?=$strChecked?> />
            <label for="slide_published2">No</label>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Display on Pages <span style="color: red;">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';
            if($slide_pages == 'All')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="All" name="slide_pages" id="slide_pages1" <?=$strChecked?> />
            <label for="slide_pages1">All Pages</label>
            
            <?php
            $strChecked = '';
            $strStyle = 'display: none;';
            if($slide_pages == 'Other')
            {
                $strChecked = 'checked="checked"';
                $strStyle = '';    
            }
            ?>
            <input type="radio" value="Other" name="slide_pages" id="slide_pages2" <?=$strChecked?> />
            <label for="slide_pages2">Some Pages</label>
            <div>
            <select id="slide_pages" name="slide_pages_list[]" multiple="multiple" style="width: 130px; margin: 15px 0 5px 5px; <?=$strStyle?>">
            <?php 
            if($slide_pages != 'Other')
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
                    if(in_array($rowPages['page_id'], $slide_display_pages))
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
            <div style="padding-top:0"><label class="messages" id="slide_pages_message" style="padding: 0;"></label> </div>
            <br />
        </td>
    </tr>
    <tr>
        <td valign="top"><b>Who can see this Slide? <span style="color: red;">*</span></b></td>
        <td valign="top">
            <?php
            $strChecked = '';
            if($slide_access == 'Everyone')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Everyone" name="slide_access" id="slide_access1" <?=$strChecked?> />
            <label for="slide_access1">Everyone</label>
            
            <?php
            $strChecked = '';
            if($slide_access == 'Registered')
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <input type="radio" value="Registered" name="slide_access" id="slide_access2" <?=$strChecked?> />
            <label for="slide_access2">Registered</label>
            
            <?php
            $strChecked = '';
            $strStyle = 'display: none;';
            if($slide_access == 'Other')
            {
                $strChecked = 'checked="checked"'; 
                $strStyle = '';   
            }
            ?>
            <input type="radio" value="Other" name="slide_access" id="slide_access3" <?=$strChecked?> />
            <label for="slide_access3">Other</label>
            
            <br /><br /> 
            
            <select id="slide_roles" name="slide_roles_list[]" multiple="multiple" style="width: 130px; margin: 0 0 20px 15px; <?=$strStyle?>">
            <?php
            if($slide_access != 'Other')
            { 
                foreach($roles->result_array() as $rowRoles)
                {
            ?>
                <option value="<?=$rowRoles['role_id']?>"><?=$rowRoles['role_name']?></option>
            <?php 
                }
            }
            else
            {
                foreach($roles->result_array() as $rowRoles)
                {
                    $strSelected = '';
                    if(in_array($rowRoles['role_id'], $slide_access_roles))
                    {
                        $strSelected = 'selected="selected"';     
                    }
            ?>
                <option value="<?=$rowRoles['role_id']?>" <?=$strSelected?>><?=$rowRoles['role_name']?></option>    
            <?php
                }
            }
            ?>
        </select>
        <div style="padding-top:0"><label class="messages" id="slide_roles_message" style="padding: 0;"></label></div>    
        <br />    
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="Cancel" onclick="parent.$.fancybox.close();"> &nbsp; <input type="submit" value="Update" /></td>
    </tr>
    
</table>

</form>

</body>

</html>
<!--
<form action="<?=base_url().index_page()?>site_slides/edit_slide/<?=$site_id?>/<?=$slide_id?>" onsubmit="return validate()" enctype="multipart/form-data" method="post">
    <fieldset>
        <input type="hidden" id="numImages" name="numImages" value="1" />
        <input type="hidden" id="numUploadedImages" name="numUploadedImages" value="<?=sizeof($slide_images)?>" />  
        <label>Edit Slide Show Banner</label>
        
        <div class="section">
            <label>Images <span class="required">&nbsp;</span>
            <br />
            <span><a id="add_more_images" href="javascript: void(0);">Add more images</a></span></label>
            
            <div>
                <table id="images_uploader" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php
                    foreach($slide_images as $row_image_info)
                    {
                    ?>
                    <tr>
                        <td align="center">
                            <?=$row_image_info['slide_image']?>
                            <a onclick="delete_slider_image($(this).parent().parent(), <?=$row_image_info['slide_image_id']?>)" style="font-size: 10px" href="javascript: void(0);">Delete</a>
                        </td>
                        <td style="padding-bottom: 5px;">
                            <span style="font-size:10px">URL:</span> 
                            <input class="slider_image_url" type="text" value="<?=$row_image_info['slide_image_url']?>" onkeypress="$(this).parent().find('a').fadeIn('slow');" />
                            <a onclick="save_slider_image_url($(this).parent(), <?=$row_image_info['slide_image_id']?>)" style="display: none; font-size: 10px" href="javascript: void(0);">Save</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td width="30%">
                            <div class="uploader" style="width: 181px;">
                                <input type="file" name="slide_image1" id="slide_image1" size="19" style="opacity: 0;filter: alpha(opacity=0);">
                                <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                <span class="action" style="-moz-user-select: none;">Choose File</span>
                            </div>
                        </td>
                        <td style="padding-bottom: 5px">
                            <span style="font-size:10px">URL:</span> <input class="slider_image_url" id="slide_image_url1" name="slide_image_url1" type="text" />
                        </td>
                    </tr>
                </table>
            </div>
            <div style="padding-top: 0"><label class="messages" id="slide_images_message" style="padding: 0;"></label></div>
        </div>
        
        <div class="section">
            <label>Title <span class="required">&nbsp;</span></label>
            <div>
                <input id="slide_title" class="text" type="text" name="slide_title" maxlength="30" value="<?=$slide_title?>" />
                <label class="messages" id="slide_title_message" style="padding: 0;"></label>
            </div>
        </div>
        
        <div class="section">
            <label>Description <span class="required">&nbsp;</span></label>
            <div>
                <textarea id="slide_description" name="slide_description" rows="5" cols="30"><?=$slide_description?></textarea>
                <label class="messages" id="slide_desc_message" style="padding: 0;"></label>  
            </div>    
        </div>  
        
        <div class="section">
            <label>Position <span class="required">&nbsp;</span></label>
             <div>
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';    
                    if($slide_position == 'Top')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Top" name="slide_position" id="slide_position1" <?=$strChecked?> /></span>
                </div>
                <label for="slide_position1">Top</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($slide_position == 'Right')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Right" name="slide_position" id="slide_position2" <?=$strChecked?> /></span>
                </div>
                <label for="slide_position2">Right</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($slide_position == 'Left')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Left" name="slide_position" id="slide_position3"<?=$strChecked?> /></span>
                </div>
                <label for="slide_position3">Left</label>
                
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($slide_position == 'Bottom')
                    {
                        $strClass = 'class="checked"';
                        $strChecked = 'checked="checked"';    
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" value="Bottom" name="slide_position" id="slide_position4" <?=$strChecked?> /></span>
                </div>
                <label for="slide_position4">Bottom</label>
             </div>
        </div>
        
        <div class="section">
            <label>Published <span class="required">&nbsp;</span></label>
             <div>
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($slide_published == 'Yes')
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
                    if($slide_published == 'No')
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
            <label>Display on Pages <span class="required">&nbsp;</span></label>
             <div>
                <div class="radio">
                    <?php
                    $strClass = '';
                    $strChecked = '';
                    if($slide_pages == 'All')
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
                    if($slide_pages == 'Other')
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
                if($slide_pages != 'Other')
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
                        if(in_array($rowPages['page_id'], $slide_display_pages))
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
                    if($slide_access == 'Everyone')
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
                    if($slide_access == 'Registered')
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
                    if($slide_access == 'Other')
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
                if($slide_access != 'Other')
                { 
                    foreach($roles->result_array() as $rowRoles)
                    {
                ?>
                    <option value="<?=$rowRoles['role_id']?>"><?=$rowRoles['role_name']?></option>
                <?php 
                    }
                }
                else
                {
                    foreach($roles->result_array() as $rowRoles)
                    {
                        $strSelected = '';
                        if(in_array($rowRoles['role_id'], $slide_access_roles))
                        {
                            $strSelected = 'selected="selected"';     
                        }
                ?>
                    <option value="<?=$rowRoles['role_id']?>" <?=$strSelected?>><?=$rowRoles['role_name']?></option>    
                <?php
                    }
                }
                ?>
            </select>
            <div style="padding-top:0"><label class="messages" id="slide_roles_message" style="padding: 0;"></label></div>
        </div>
        
        <div class="section">
            <div>
                <input type="button" value="CANCEL" onclick="javascript: history.go(-1);" />  <input type="submit" value="UPDATE" />
            </div>
        </div>
         
    </fieldset>
</form>
-->

