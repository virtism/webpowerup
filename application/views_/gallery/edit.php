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
    
    
    
    
    var numImages 		  = <?=$counter?>;
    var numUploadedImages = <?=count($gallery_images)?>;
    $(document).ready(function() {
        $('#add_more_images').click(function(){
		//alert(numImages);
            numImages++;
            $('#numImages').val(numImages);           
            var html = '<div class="DoubleColumn"><div class="ColumnA"><ul><li><input type="text" id="slide_main" name="slide_title'+numImages+'" size="45" /></li><li><textarea id="slide_desc" name="slide_description'+numImages+'" rows="10" cols="40"></textarea></li><li><div style=" float:left; width:100%; position:relative;"><select size="1" name="slide_target'+numImages+'" id="slide_target'+numImages+'"  style="width:340px"><option value="0">Same Window</option><option value="1">New Window</option></select></div></li></ul></div><div class="ColumnB"><ul><li><input type="text" id="slide_image_url'+numImages+'" name="slide_image_url'+numImages+'" size="45" value="URL" /></li><li><input type="file" name="slide_image'+numImages+'" id="slide_image'+numImages+'" size="35" /></li></ul></div></div>';		
			 	            
            $('#rowDiv').append(html); 
			 document.getElementById('numImages').value = numImages;
			 NFFix();
			 return false;
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
          	var dataString = 'slider_image_id='+slider_image_id; 
            $(slider_area).fadeOut('slow', function(){
                $.ajax({
				type: "POST",
            	data: dataString,
                url: '<?=base_url().index_page()?>gallery_management/delete_slide_image_info/',
                success: function(data)
                        {
                           // alert("tr_"+slider_image_id);
                           // $( "tr_"+slider_image_id ).css( "display","none" );
                           location.reload();
						  //alert(data);

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
		var commonWidth = 205;
		var commonHeight = "90px";
		$("#slide_pages").children().children("div:nth-child(2n+1)").css({
		   width : 205,
		   height:"10px"
		   
		});
		 
		 $("#slide_pages").children().children("div:nth-child(2)").css({
		   width : commonWidth+5,
		   height:commonHeight
		   
		}); 
		$("#slide_pages").children().children("div:nth-child(2)").children("div").css({
		   width : "5px",
		   height:"82px"
		});
		$("#slide_pages").children().children("div:nth-child(2)").children("select").css({
		   width : commonWidth-5,
		   height:commonHeight,
		   position: 'static'
		  
		});
		
		$('#slide_pages').fadeIn();
	}
	
	if(id == "slide_access1" || id == "slide_access2" )
	{
		$('#slide_roles').fadeOut();
	}
	if(id == "slide_access3")
	{
		var commonWidth = 205;
		var commonHeight = "90px";
		$("#slide_roles").children().children("div:nth-child(2n+1)").css({
		   width : 205,
		   height:"10px"
		   
		});
		 
		 $("#slide_roles").children().children("div:nth-child(2)").css({
		   width : commonWidth+5,
		   height:commonHeight
		   
		}); 
		$("#slide_roles").children().children("div:nth-child(2)").children("div").css({
		   width : "5px",
		   height:"82px"
		});
		$("#slide_roles").children().children("div:nth-child(2)").children("select").css({
		   width : commonWidth-5,
		   height:commonHeight,
		   position: 'static'
		  
		});
		$('#slide_roles').fadeIn();
	}
	
});
    
</script>
<div class="RightColumnHeading">
  <h1> <img src="<?=base_url();?>images/webpowerup/CreateGallery.png" alt="CreateGallery"/> <span>Edit a Photo Gallery</span> </h1>
</div>
<div class="form">
  <form class="niceform" action="<?=base_url().index_page()?>gallery_management/edit_gallery/<?=$site_id?>/<?=$gallery_id?>" onsubmit="return validate()" enctype="multipart/form-data" method="post" >
    <input type="hidden" id="count" name="numImages" value="3" />
    <input type="hidden" id="numImages" name="numImages" value="<?=count($gallery_images)?>" />
    <input type="hidden" id="numUploadedImages" name="numUploadedImages" value="<?=sizeof($gallery_images)?>" />
	<span id="rowDiv">
   <!-- <div class="DoubleColumn" style="padding-left:5px; margin:5px 0 5px 0;">
      <ul>
        <li>
          <label class="NewsletterLabel">Images <span class="star">*</span></label>
        </li>
        <li>
          <label class="check_label"><a href="javascript: void(0)" id="add_more_images">Add more images</a> </label>
        </li>
      </ul>
    </div>-->
    <!--	SLIDESHOW IMAGES	 -->
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
			/*echo $target;
			exit();	*/					
		   $counter++;
		?>
		
    <div class="DoubleColumn">
      <div class="ColumnA">
        <ul>
          <li>
            <input type="text" id="slide_main" size="45" name="slide_title<?=$counter?>" maxlength="30" value="<?=$row_image_info['gallery_title']?>" onkeypress="fade_link('<?=$fetch_id?>');" />
			
          </li>
          <li>
            <textarea id="slide_desc" rows="10" cols="40" onkeypress="fade_link('<?=$fetch_id?>');" name="slide_description<?=$counter?>" ><?=$row_image_info['gallery_description']?>
</textarea>
          </li>
          <li>
            <div style=" float:left; width:100%; position:relative;">
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
            <input type="text" id="slide_image_url" size="45" value="<?=$row_image_info['gallery_image_url']?>" name="slide_image_url<?=$counter?>" onkeypress="fade_link('<?=$fetch_id?>');" />
			<input type="hidden" name="slide_id<?=$counter?>" value="<?=$row_image_info['gallery_image_id']?>" />
          </li>
          <li>
            <table border="1">
              <tr>
                <td colspan="2">
				<?php
				
					$path 		= 'media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/';
					$image_name = $row_image_info['gallery_image'];
				?>
                  <a onclick="return false;" href="<?=base_url().$path.'middle/'.$image_name?>" class="preview"> <img src="<?=base_url().$path.'thumb/'.$image_name?>"/> </a> </td>
              </tr>
              <tr>
                <td><!-- edit link here -->
                </td>
                <td><a  onclick="delete_slider_image($(this).parent().parent(), <?=$row_image_info['gallery_image_id']?>)" style="font-size: 10px" href="javascript: void(0);">Delete</a></td>
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
	<fieldset>
		<dl>                    	
			<dd><input type="button" value="Add more images"  id="add_more_images" ></dd>
		</dl>
	</fieldset>
    <!--	SLIDESHOW IMAGES	 -->
    <fieldset>
    <dl>
      <dt>
        <label for="email" class="NewsletterLabel">Title:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <input type="text" id="slide_title" name="slider_title" size="53" value="<?=$gallery_title?>"  />
      </dd>
    </dl>
    <dl>
      <dt>
        <label for="email" class="NewsletterLabel">Description:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <textarea id="slide_description" name="slider_description" rows="10" cols="42"><?=$gallery_description?>
</textarea>
      </dd>
    </dl>
    <dl>
      <dt>
        <label for="email" class="NewsletterLabel">Select Gallery Layout:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <div style=" float:left; width:200px; position:relative;">
          <select size="1" name="template_options" id="template_options" style="width:200px">
            <option value="0">Select Template</option>
            <? for($i = 0; $i<count($gallery_templates); $i++) 
			{ ?>
				<option <? if(isset($template_options) && $template_options==$gallery_templates[$i]['id']){ echo "selected";} ?> value="<?=$gallery_templates[$i]['id']?>"><?=$gallery_templates[$i]['template_name']?></option>
            <? }  ?>
          </select>
        </div>
        <!--<div style=" float:left; width:200px; position:relative; margin-left:20px;">
                <select size="1" name="selectdrop" id=""  style="width:200px"> 
                    <option value="">Select Style</option>
                    <option value="">Select option 2</option> 
                    <option value="">Select option 3</option>
                    <option value="">Select option 4</option> 
                    <option value="">Select option 5</option> 
                </select>
                </div>-->
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
      <dt>
        <label for="email" class="NewsletterLabel">Published:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <?php
			$strChecked = '';
			if($gallery_published == 'Yes')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
        <label class="check_label">Yes</label>
        <input type="radio" name="slide_published" id="slide_published2" value="Yes"  <?=$strChecked?> />
        <?php
			$strChecked = '';
			if($gallery_published == 'No')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
        <label class="check_label">No</label>
        <input type="radio" name="slide_published" id="slide_published2" value="No" <?=$strChecked?> />
      </dd>
    </dl>
    <dl>
      <dt>
        <label for="email" class="NewsletterLabel">Display on Pages:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <?php
			$strChecked = '';
			if($gallery_pages == 'All')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
        <label class="check_label">All Pages</label>
        <input type="radio" value="All" name="slide_pages" id="slide_pages1"  <?=$strChecked?> />
        <?php
				$strChecked = '';
				$strStyle = 'display: none;';
				if($gallery_pages == 'Other')
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
						if($gallery_pages != 'Other')
						{
							foreach($pages->result_array() as $rowPages)
							{
						?>
              <option value="<?=$rowPages['page_id']?>">
              <?=$rowPages['page_title']?>
              </option>
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
								  <option value="<?=$rowPages['page_id']?>" <?=$strSelected?>>
								  <?=$rowPages['page_title']?>
								  </option>
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
      <dt>
        <label for="email" class="NewsletterLabel">Who can see this slide?:<span class="star"> *</span> </label>
      </dt>
      <dd>
        <?php
			$strChecked = '';
			if($gallery_access == 'Everyone')
			{
				$strChecked = 'checked="checked"';    
			}
			?>
        <label class="check_label">Every one</label>
        <input type="radio" value="Everyone" name="slide_access" id="slide_access1" <?=$strChecked?> />
        <?php
			$strChecked = '';
			if($gallery_access == 'Registered')
			{
 				$strChecked = 'checked="checked"';    
			}
			?>
        <label class="check_label">Registered</label>
        <input type="radio" value="Registered" name="slide_access" id="slide_access2" <?=$strChecked?> />
        <?php
            $strChecked = '';
            $strStyle = 'display: none;';
            if($gallery_access == 'Other')
            {
                $strChecked = 'checked="checked"'; 
                $strStyle = '';   
            }
            ?>
        <label class="check_label">Other</label>
        <input type="radio" value="Other" name="slide_access" id="slide_access3" <?=$strChecked?> />
        <div id="slide_roles" style=" <?=$strStyle?> clear:both;">
          <div style=" position:relative;">
            <select name="slide_roles_list[]" multiple="multiple" size="5" >
              <?php
						if($gallery_access != 'Other')
						{ 
							foreach($groups as $rowRoles)
							{
						?>
              <option value="<?=$rowRoles['id']?>">
              <?=$rowRoles['group_name']?>
              </option>
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
              <option value="<?=$rowRoles['id']?>" <?=$strSelected?>>
              <?=$rowRoles['group_name']?>
              </option>
              <?php
							}
						}
						?>
            </select>
          </div>
        </div>
      </dd>
    </dl>
    </fieldset>
    <div class="ButtonRow"> <a href="<?=base_url().index_page();?>site_slides/index/<?=$_SESSION['site_id'];?>/0"><img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="CancelButton"/></a>
      <button type="submit" > <img src="<?=base_url();?>images/webpowerup/Create.png" alt="Create"/> </button>
    </div>
  </form>
</div>
