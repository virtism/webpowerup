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
	
	
	// FORM Validation 
	$("#slider_upload").submit(function(e) {
        
		if ( $("#slide_width").val() == "" )
		{
			alert("You Must enter Width");
			return false;
		}
		else if ( $("#slide_height").val() == "" )
		{
			alert("You Must enter Height");
			return false;
		}
		else if ( $("#slide_title").val() == "" )
		{
			alert("You Must enter title");
			return false;
		}
		
		return true;
		
    });
});

    
</script>




<div class="RightColumnHeading">
        	<h1>
            	<img src="<?=base_url();?>images/webpowerup/CreateGallery.png" alt="CreateGallery"/>
                <span>Create a Video Gallery</span>
            </h1>
            
        </div>       
        
    <div class="form">

<form class="niceform" action="<?=base_url().index_page()?>site_slides/create_slide/<?=$site_id?>" onsubmit="return validate();" enctype="multipart/form-data" method="post" id="slider_upload" name="slider_upload">
<input type="hidden" id="count" name="numImages" value="3" />

    <dl>
           <dt>
                 <label  class="NewsletterLabel">Slider (Width*Height)<span class="star">*</span></label>
           </dt>
           <dd>
           		<div>
           		<input type="text" name="slide_width" id="slide_width" size="4" style="float:left;" />
                </div>
                <span style="width:25px; float:left; padding:0 5px 0 5px; line-height:35px;">PX &nbsp;</span>
                
                
                <div>
                <input type="text" name="slide_height" id="slide_height" size="4" style="float:left;" />
                </div>
                <span style="width:25px; float:left; padding:0 5px 0 5px; line-height:35px;">PX &nbsp;</span>
                
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Captions Position<span class="star">*</span></label>
           </dt>
           <dd>
           		<label class="check_label">Bottom of Slider</label>
           		<input type="radio" value="Bottom" name="slide_dec_position" id="slide_dec_position1" checked="checked" />
                
                <label class="check_label">Top of Slider</label>
           		<input type="radio" value="Top" name="slide_dec_position" id="slide_dec_position2" />
           </dd>
    </dl>
    
    <div class="DoubleColumn" style="padding-left:5px; margin:5px 0 5px 0;">
             <ul>
                <li> <label class="NewsletterLabel">Images <span class="star">*</span></label> </li>
                <li>  <label class="NewsletterLabel"><a href="javascript: void(0)" id="addRow">Add more images</a> </label> </li>
            </ul>
    </div>
    
    <span id="rowDiv">
    
    <div class="DoubleColumn">
        
        
        <div class="ColumnA">
            <ul>
            <li>
             <input type="text" name="slide_title1" id="slide_main" size="45" />
             </li>
             <li>
             <textarea id="slide_desc" name="slide_description1" rows="10" cols="40"></textarea>
             </li>
            <li> <div style=" float:left; width:100%; position:relative;">
                <select size="1" name="slide_target1" id="slide_target1" style="width:340px"> 
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
             <input type="text" id="slide_image_url" name="slide_image_url1" size="45" value="URL" />
             </li>
              <li>
             <input type="file" name="slide_image1" id="slide_image1" size="35" />
             </li>
            </ul>
        </div>
        
    </div>
    
    <div class="DoubleColumn">
        <div class="ColumnA">
            <ul>
            <li>
             <input type="text" id="slide_main" name="slide_title2" size="45"  />
             </li>
             <li>
             <textarea id="slide_desc" name="slide_description2" rows="10" cols="40"></textarea>
             </li>
            <li> <div style=" float:left; width:100%; position:relative;">
                <select size="1" name="slide_target2" id="slide_target2"  style="width:340px"> 
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
             <input type="text" id="slide_image_url" name="slide_image_url2" size="45" value="URL" />
             </li>
              <li>
             <input type="file" name="slide_image2" id="slide_image2" size="35" />
             </li>
            </ul>
        </div>
     </div>
        
    <div class="DoubleColumn">
        <div class="ColumnA">
            <ul>
            <li>
             <input type="text" id="slide_title3" name="slide_title3" size="45" />
             </li>
             <li>
             <textarea id="slide_description3" name="slide_description3" rows="10" cols="40"></textarea>
             </li>
            <li> <div style=" float:left; width:100%; position:relative;">
                <select size="1" name="slide_target3" id="slide_target3" style="width:340px"> 
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
             <input type="text" id="slide_image_url" name="slide_image_url3" size="45" value="URL" />
             </li>
              <li>
             <input type="file" name="slide_image3" id="slide_image3" size="35" />
             </li>
            </ul>
        </div>
     
    </div>
    
    </span>
    
    <fieldset>
        
         <dl>
            <dt><label for="email" class="NewsletterLabel">Title:<span class="star"> *</span> </label></dt>
            <dd><input type="text" id="slide_title" name="slider_title" size="53"  />
            </dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel">Description:<span class="star"> *</span> </label></dt>
            <dd>
            <textarea id="slide_description" name="slider_description" rows="10" cols="42"></textarea>
            </dd>
        </dl>
        <dl>
            <dt><label for="email" class="NewsletterLabel">Position:<span class="star"> *</span> </label></dt>
            <dd>
            	
                <label class="check_label">Main Slider (Above menu & content) </label>
                <input type="radio" value="Main" name="slide_position" id="slide_position1" checked="checked" />
                
                <label class="check_label">Top (Content)</label>
                <input type="radio" value="Top" name="slide_position" id="slide_position2" />
                
                <label class="check_label">Right (Content)</label>
                <input type="radio" value="Right" name="slide_position" id="slide_position3" />
                <br />
                <br />
                
                <label class="check_label">Left (Content)</label>
                <input type="radio" value="Left" name="slide_position" id="slide_position4" />
                
                <label class="check_label">Bottom (Content)</label>
                <input type="radio" value="Bottom" name="slide_position" id="slide_position5" />

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
            <label class="check_label">Yes</label>
             <input type="radio" name="slide_published" id="slide_published2" value="Yes"  checked="checked"/>
             <label class="check_label">No</label>
             <input type="radio" name="slide_published" id="slide_published2" value="No" />
            </dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Display on Pages:<span class="star"> *</span> </label></dt>
            <dd>
            <label class="check_label">All Pages</label>
             <input type="radio" value="All" name="slide_pages" id="slide_pages1"  checked="checked"/>
             <label class="check_label">Some Pages</label>
             <input type="radio" value="Other" name="slide_pages" id="slide_pages2" />
             
                <div style="display: none; clear:both; " id="slide_pages">
                    <div  style=" position:relative;">
                    <select name="slide_pages_list[]" multiple="multiple" size="5" >
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
                
            </dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Who can see this slide?:<span class="star"> *</span> </label></dt>
            <dd>
            <label class="check_label">Every one</label>
             <input type="radio" value="Everyone" name="slide_access" id="slide_access1" checked="checked"/>
            <? if($template_name!='gymnastic')
            {
            ?>
             <label class="check_label">Registered</label>
             <input type="radio" value="Registered" name="slide_access" id="slide_access2" />
              <label class="check_label">Other</label>
             <input type="radio" value="Other" name="slide_access" id="slide_access3" />
             
                <div id="slide_roles" style="display:none; clear:both;">
                     <div style=" position:relative;">
                     <select name="slide_roles_list[]" multiple="multiple" size="5" >
                        <?php 
                        foreach($groups as $group)
                        {
                        ?>
                            <option value="<?=$group['id']?>"><?=$group['group_name']?></option>
                        <?php 
                        }
                        ?>
                    </select>
                    </div>
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