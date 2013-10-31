
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

<div class="RightColumnHeading">
        	<h1>
            	<img src="<?=base_url();?>images/webpowerup/CreateGallery.png" alt="CreateGallery"/>
                <span>Create a Video Gallery</span>
            </h1>
            
        </div>       
        
    <div class="form">

<form class="niceform" id="slideshowEditForm" action="<?=base_url().index_page()?>site_slides/edit_slide/<?=$site_id?>/<?=$slide_id?>" onsubmit="return validate();" enctype="multipart/form-data" method="post" >

    <input type="hidden" id="count" name="numImages" value="<?=count($slide_images)?>" />
    <input type="hidden" id="numUploadedImages" name="numUploadedImages" value="<?=sizeof($slide_images)?>" />

    <dl>
           <dt>
                 <label  class="NewsletterLabel">Slider (Width*Height)<span class="star">*</span></label>
           </dt>
           <dd>
           		<div>
           		<input type="text" name="slide_width" id="slide_width" size="4" value="<?=$slide_width?>" />
                </div>
                <span style="width:25px; float:left; padding:0 5px 0 5px; line-height:35px;">PX &nbsp;</span>
                
                <div>
                <input type="text" name="slide_height" id="slide_height" size="4" value="<?=$slide_height?>" />
                </div>
                <span style="width:25px; float:left; padding:0 5px 0 5px; line-height:35px;">PX &nbsp;</span>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Captions Position<span class="star">*</span></label>
           </dt>
           <dd>
				<?php
                $strChecked = '';    
                if($caption_position == 'Bottom')
                {
                    $strChecked = 'checked="checked"';    
                }
                ?>
           		<label class="check_label">Bottom of Slider</label>
           		<input type="radio" value="Bottom" name="slide_dec_position" id="slide_dec_position1" <?=$strChecked?> />
                <?php
				$strChecked = '';    
				if($caption_position == 'Top')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Top of Slider</label>
           		<input type="radio" value="Top" name="slide_dec_position" id="slide_dec_position2" <?=$strChecked?> />
           </dd>
    </dl>
    
    <div class="DoubleColumn" style="padding-left:5px; margin:5px 0 5px 0;">
        <ul>
            <li> <label class="NewsletterLabel">Images <span class="star">*</span></label> </li>
            <li>  <label class="check_label"><a href="javascript: void(0)" id="addRow">Add more images</a> </label> </li>
        </ul>
     </div>
     
     
     <!--	SLIDESHOW IMAGES	 -->
    <span id="rowDiv"> 
     <?php
	
	$counter = 0;
	foreach($slide_images as $row_image_info)
	{
	   $fetch_id ='change_link'.$row_image_info['slide_image_id'];
	   $fetch_title ='slide_title'.$row_image_info['slide_image_id'];
	   $fetch_desc ='slide_description'.$row_image_info['slide_image_id'];
	   $fetch_url ='slide_url'.$row_image_info['slide_image_id'];
	   $target = '';
	   if(isset($row_image_info['target']) && !empty($row_image_info['target']))
		{
			$target ='target'.$row_image_info['target'];
		
		}
	    $counter++;
		?>
     	<div class="DoubleColumn">
        
        
        <div class="ColumnA">
            <ul>
            <li>
             <input type="text" name="slide_title<?=$row_image_info['slide_image_id']?>" id="slide_main" size="45" value="<?=$row_image_info['slide_title']?>" onkeypress="fade_link('<?=$fetch_id?>');" />
             </li>
             <li>
             <textarea id="slide_desc" rows="10" cols="40" onkeypress="fade_link('<?=$fetch_id?>');" name="slide_description<?=$row_image_info['slide_image_id']?>"><?=$row_image_info['slide_description']?></textarea>
             </li>
            <li> <div style=" float:left; width:100%; position:relative;">
                <select size="1" name="slide_target<?=$counter?>" id="slide_target<?=$counter?>" style="width:340px"> 
                    <option value="0">Same Window</option>
                    <option value="1">New Window</option> 
                </select>
                </div>
             </li>
              
            </ul>
        </div>
        
        <div class="ColumnB">
            <ul>
            <li>
             <input type="text" id="slide_image_url" size="45" value="<?=$row_image_info['slide_image_url']?>" name="slide_image_url<?=$counter?>" onkeypress="fade_link('<?=$fetch_id?>');" />
             </li>
              <li>
                <table border="1">
                    <tr>
                        <td colspan="2">
                        <?php

						// calculate preview image 200*150 path 
						$prewImg = explode("/",$row_image_info['slide_image']);
						$imgName = explode(".",$prewImg[5]);
						$thumbImg =  substr($imgName[0],0,-1);
						$thumbImg = $thumbImg."1";
						$imgName[0] = $thumbImg;
						$newName = implode(".",$imgName);
						$prewImg[5] = $newName;
						$thumbPath = implode("/",$prewImg);
						
						
						// calculate small thumnail 25*25 image path 
						$prewImg = explode("/",$row_image_info['slide_image']);
						$imgName = explode(".",$prewImg[5]);
						$smallThumbImg =  substr($imgName[0],0,-1);
						$smallThumbImg = $smallThumbImg."0";
						$imgName[0] = $smallThumbImg;
						$newName = implode(".",$imgName);
						$prewImg[5] = $newName;
						$smallThumbPath = implode("/",$prewImg);

						
						?>
                        <a href="<?php echo base_url(); ?>/<?=$thumbPath;?>" class="preview"><img src="<?php echo base_url(); ?>/<?=$smallThumbPath?>" alt="Slide Show Image" /></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <!-- edit link here -->
                        </td>
                        <td><a onclick="delete_slider_image($(this).parent().parent(), <?=$row_image_info['slide_image_id']?>)" style="font-size: 10px" href="javascript: void(0);">Delete</a></td>
                    </tr>
                    <tr>
	                    <td colspan="2"><!--<input type="file" name="slide_image1" id="slide_image1" size="35" />--></td>
                    </tr>
                </table>

             
             </li>
            </ul>
        </div>
        
    </div>
    <?php } ?>
	    
    </span>
    <!--	SLIDESHOW IMAGES	 -->
        
    <fieldset>
        
         <dl>
            <dt><label for="email" class="NewsletterLabel">Title:<span class="star"> *</span> </label></dt>
            <dd><input type="text" id="slide_title" name="slider_title" size="53" value="<?=$slide_title?>"  />
            </dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel">Description:<span class="star"> *</span> </label></dt>
            <dd>
            <textarea id="slide_description" name="slider_description" rows="10" cols="42"><?=$slide_description?></textarea>
            </dd>
        </dl>
        
        
        
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Position:<span class="star"> *</span> </label></dt>
            <dd>
            	<?php
				$strChecked = '';    
				if($slide_position == 'Main')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Main Slider (Above menu & content) </label>
                <input type="radio" value="Main" name="slide_position" id="slide_position1" <?=$strChecked?> />
                
                <?php
				$strChecked = '';    
				if($slide_position == 'Top')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Top (Content)</label>
                <input type="radio" value="Top" name="slide_position" id="slide_position2" <?=$strChecked?> />
                
                <?php
				$strChecked = '';    
				if($slide_position == 'Right')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Right (Content)</label>
                <input type="radio" value="Right" name="slide_position" id="slide_position3" <?=$strChecked?> />
                <br />
                <br />
                
                <?php
				$strChecked = '';    
				if($slide_position == 'Left')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Left (Content)</label>
                <input type="radio" value="Left" name="slide_position" id="slide_position4" <?=$strChecked?> />
                
                <?php
				$strChecked = '';    
				if($slide_position == 'Bottom')
				{
					$strChecked = 'checked="checked"';    
				}
				?>
                <label class="check_label">Bottom (Content)</label>
                <input type="radio" value="Bottom" name="slide_position" id="slide_position5" <?=$strChecked?> />

            </dd>
        </dl>
        
         <!--<dl>
            <dt><label for="email" class="NewsletterLabel">Open Gallery:<span class="star"> *</span> </label></dt>
            <dd>
            <label class="check_label">Light Box</label>
             <input type="radio" name="Light" id="" value=""  checked="checked"/>
             <label class="check_label">New Window </label>
             <input type="radio" name="Light" id="" value="" />
            </dd>
        </dl>-->
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Published:<span class="star"> *</span> </label></dt>
            <dd>
            <?php
			$strChecked = '';
			if($slide_published == 'Yes')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
            <label class="check_label">Yes</label>
             <input type="radio" name="slide_published" id="slide_published2" value="Yes"  <?=$strChecked?> />
             
			<?php
			$strChecked = '';
			if($slide_published == 'No')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
             <label class="check_label">No</label>
             <input type="radio" name="slide_published" id="slide_published2" value="No" <?=$strChecked?> />
            </dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Display on Pages:<span class="star"> *</span> </label></dt>
            <dd>
            <?php
			$strChecked = '';
			if($slide_pages == 'All')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
            <label class="check_label">All Pages</label>
             <input type="radio" value="All" name="slide_pages" id="slide_pages1"  <?=$strChecked?> />
             
             <?php
                    $strChecked = '';
                    $strStyle = 'display: none;';
                    if($slide_pages == 'Other')
                    {
                        $strChecked = 'checked="checked"';
                        $strStyle = '';    
                    }
                    ?>
             <label class="check_label">Some Pages</label>
             <input type="radio" value="Other" name="slide_pages" id="slide_pages2" <?=$strChecked?> />
             
                <div style=" <?=$strStyle?> clear:both; " id="slide_pages">
                    <div  style=" position:relative;">
                    <select name="slide_pages_list[]" multiple="multiple" size="5" >
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
                
            </dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Who can see this slide?:<span class="star"> *</span> </label></dt>
            <dd>
            <?php
			$strChecked = '';
			if($slide_access == 'Everyone')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
            <label class="check_label">Every one</label>
             <input type="radio" value="Everyone" name="slide_access" id="slide_access1" <?=$strChecked?> />
            <? if($template_name!='gymnastic')
            {
            ?>
            <?php
			$strChecked = '';
			if($slide_access == 'Registered')
			{
 				$strChecked = 'checked="checked"';    
			}
			?>
             <label class="check_label">Registered</label>
             <input type="radio" value="Registered" name="slide_access" id="slide_access2" <?=$strChecked?> />

			<?php
            $strChecked = '';
            $strStyle = 'display: none;';
            if($slide_access == 'Other')
            {
                $strChecked = 'checked="checked"'; 
                $strStyle = '';   
            }
            ?>


              <label class="check_label">Other</label>
             <input type="radio" value="Other" name="slide_access" id="slide_access3" <?=$strChecked?> />
                
                <div id="slide_roles" style="display:none; clear:both;">
                     <?php 
					 if ( count($groups) > 0 ) 
					 { 
					 ?>
                     <div style=" position:relative;">
                     <select name="slide_roles_list[]" multiple="multiple" size="5" >
                     <?php
                
						   foreach($groups as $group)
							{
								$strSelected = '';
								$slide_groups = explode(",",$current_slide_groups);
								if(in_array($group['id'], $slide_groups))
								{
									$strSelected = 'selected="selected"';     
								}
						?>
							<option value="<?=$group['id']?>" <?=$strSelected?>><?=$group['group_name']?></option>    
						<?php
							}
						?>
                     </select>
                    </div>
                    <?php 
					 } // end if conut $groups
					 else
					 {
						 echo "No group found";
					 }
					?>
                </div>
            <? } ?>
            </dd>
    	</dl>
        
     </fieldset>
    
    <div class="ButtonRow">

        <a href="<?=base_url().index_page();?>site_slides/index/<?=$_SESSION['site_id'];?>/0"><img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="CancelButton"/></a>
        
        <button type="submit" >
            <img src="<?=base_url();?>images/webpowerup/Create.png" alt="Create"/>
        </button>
       
    </div>
                    
</form>
</div>
<script type="text/javascript" language="javascript">

        // 02 April - To disappear the default values of textboxes generated on runtime.
    function empty(value_fields)
    {
        //alert(value_fields);
        document.getElementById(value_fields).value = '';
        //$('#'.value_fields).val() ;
        //if(value_fields == 'Title') { this.value = ''; }
    }
    function fill(value_fields)
    {
        if(document.getElementById(value_fields).value == '')
         { document.getElementById(value_fields).value = 'Title'; }
    }

    function empty_url(value_fields)
    {
        document.getElementById(value_fields).value = '';
    }
    function fill_url(value_fields)
    {
        if(document.getElementById(value_fields).value == '')
         { document.getElementById(value_fields).value = 'URL'; }
    }
    function empty_desc(value_fields)
    {
        document.getElementById(value_fields).value = '';
    }
    function fill_desc(value_fields)
    {
        if(document.getElementById(value_fields).value == '')
         { document.getElementById(value_fields).value = 'Description'; }
    }
        
        // 02 April - To disappear the default values of textboxes generated on runtime.

    
    //jquery for file upload control
    $('div.uploader input').change(function() {
        $(this).parent().find('span.filename').text(this.value) ; 
    });
    
    
    
    
    var numImages = <?=$counter?>;
    var numUploadedImages = <?=sizeof($slide_images)?>;
    $(document).ready(function() {
        $('a#add_more_images').click(function(){
            numImages++;
            $('#numImages').val(numImages);
            /*var html = '<tr><td colspan="2"><hr/></td></tr><tr><td ><div class="section"><label>Title </label><div><input id="slide_main" class="text" type="text"  name="slide_title'+numImages+'"  maxlength="30" /><label class="messages" id="slide_title_message"  style="padding: 0;"></label></div></div></td><td><div class="section"><label>Description </label><div> <input id="slide_main" class="text" type="text" name="slide_description'+numImages+'" maxlength="30" /><label class="messages" id="slide_title_message" style="padding: 0;"></label></div></div></td></tr><tr><td width="30%"><div class="uploader" style="width: 181px;"><input onchange="setFileName($(this))" type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" style="opacity: 0;filter: alpha(opacity=0);"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div></td><td style="padding-bottom: 5px"><span style="font-size:10px">URL:</span> <input class="slider_image_url" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" type="text" /></td></tr>';*/
            
             var html ='<tr><td colspan="2"><hr/></td></tr><tr><td width="50%"><div class="section"><div><input style="width:80%;" id="slide_main'+numImages+'" onblur="fill(this.id)" onclick="empty(this.id)" class="text" type="text" name="slide_title'+numImages+'" maxlength="30" width="50%" title="Title" value="Title" /><label class="messages" id="slide_title_message" style="padding: 0;"></label></div></div></td><td><input class="slider_image_url" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" type="text" title="URL" value="URL" onblur="fill_url(this.id)" onclick="empty_url(this.id)"/></td></tr><tr><td ><div class="section"><div><textarea style="width:80%;" id="slide_desc'+numImages+'" name="slide_description'+numImages+'" class="watermark" rows="5" cols="20" title="Description" onblur="fill_desc(this.id)" onclick="empty_desc(this.id)">Description</textarea><label class="messages" id="slide_desc_message" style="padding: 0;"></label></div></div></td><td style="padding-bottom: 5px"><div class="uploader" style="width: 181px;"><input onchange="setFileName($(this))" type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="19" style="opacity: 0;filter: alpha(opacity=0);"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div></td></tr><tr><td style="padding-bottom: 5px" colspan="2"><div class="selector" id="uniform-dropdown_vegetables"><span style="-moz-user-select: none;">Select Target</span><select  name="slide_target'+numImages+'" id="slide_target'+numImages+'"><option value="0">Same Window</option><option value="1">New Window</option></select></div></td></tr>';
             
             
            
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
        var flagSubmit = true;
        var flagSelected = false;
        
        
        
        
        if($('#slide_title').val() == '')
        {
            $('#slidetitle_message').html('<code>Please enter title for this slideshow.</code>');
            flagSubmit = false;
        }
        /*
        if($('#slide_description').val() == '')
        {
            $('#slide_desc_message').html('<code>Please enter description of slideshow.</code>');
            flagSubmit = false;
        }
        */
        
        if( $('#slide_width').val() == "" || $('#slide_height').val() == "" )
        {
            
            $('#slide_width_height').html('<code>Please Enter Width and Height for this slideshow.</code>');
            flagSubmit = false;
        }
        
        /*       
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
        */
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
        /*
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
        */
        //alert(flagSubmit);
        //flagSubmit = true; 
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


<script type="text/javascript">

$("div.NFRadio").live("click",function(){
    var id = $(this).next("input").attr("id");
    //alert(id);
    if(id == "slide_pages1")
    {
        $('#slide_pages').fadeOut();
    }
    if(id == "slide_pages2")
    {
        
        $('#slide_pages').fadeIn();
        NFFix();
    }
    
    if(id == "slide_access1" || id == "slide_access2" )
    {
        $('#slide_roles').fadeOut();
    }
    if(id == "slide_access3")
    {
        
        
        $('#slide_roles').fadeIn();
        NFFix();
    }
    
});

$(document).ready(function(e) {
    
    
    // ADD ROW DYNAMICALLY
    
    $("#addRow").click(function(){
        
        i = $("#count").val();
        i++;
    
        var html = '<div class="DoubleColumn"><div class="ColumnA"><ul><li><input type="text" id="slide_main" name="slide_title'+i+'" size="45" /></li><li><textarea id="slide_desc" name="slide_description'+i+'" rows="10" cols="40"></textarea></li><li><div style=" float:left; width:100%; position:relative;"><select size="1" name="slide_target'+i+'" id="slide_target'+i+'"  style="width:340px"><option value="0">Same Window</option><option value="1">New Window</option></select></div></li></ul></div><div class="ColumnB"><ul><li><input type="text" id="slide_image_url'+i+'" name="slide_image_url'+i+'" size="45" value="URL" /></li><li><input type="file" name="slide_image'+i+'" id="slide_image'+i+'" size="35" /></li></ul></div></div>';        
        
        $("#rowDiv").append(html);
        $("#count").val(i);
        NFFix();
        
        return false;
    });
});
    
</script>