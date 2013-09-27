<script type="text/javascript">

$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	if(id == "image_rd1" )
	{
		$("#imageFld").fadeOut();
	}
	if(id == "image_rd2" )
	{
		$("#imageFld").fadeIn();
	}
	
});

$(document).ready(function(e) {
	
	
	$("#cat_add").submit(function(){
		
		var name = $("#cat_name").val();
		name = $.trim(name);
	
		if ( name == "" )
	    {
			alert("Please enter category name");
			return false;
	    }	
	});
   
});
</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/AddNewProducts.png" alt="Add Category"/>
        <span>Create Category</span>
    </h1>
</div>

<div class="PageDetail">
	<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
</div>





<div class="InnerMain">
<form class="niceform" id="cat_add" name="cat_add" method="post" enctype="multipart/form-data" action="<?=site_url();?>Categories_Management/create">
<input type="hidden" name="action" value="create_category">


    <dl>
           <dt>
                 <label  class="NewsletterLabel">category name</label>
           </dt>
           <dd>
                <input type="text" name="cat_name" id="cat_name" size="53" />
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Short Description</label>
           </dt>
           <dd>
                <textarea id="short_desc" name="short_desc"  rows="10" cols="42"></textarea>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Long Description</label>
           </dt>
           <dd>
                <textarea id="long_desc" name="long_desc"  rows="10" cols="42"></textarea>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Image</label>
           </dt>
           <dd>
                <label class="check_label">None</label>
                <input type="radio" name="image_rd" id="image_rd1" value="No" checked="checked" /> 
                <label class="check_label">Upload a new image </label>
                <input type="radio" name="image_rd" id="image_rd2" value="Yes"/>
                
                <div id="imageFld" style="display:none;">
                
                    <br /><br />
                    <input type="file" name="cat_image" id="">
                
                </div>
           </dd>
    </dl>
    
     <dl>
           <dt>
                 <label  class="NewsletterLabel">Default Category</label>
           </dt>
           <dd>
                <label class="check_label">No</label>
                <input type="radio" name="is_default"  value="No" checked="checked" /> 
                <label class="check_label">Yes</label>
                <input type="radio" name="is_default"  value="Yes"/>
                
           </dd>
    </dl>
     
     <dl>
           <dt>
                 <label  class="NewsletterLabel">Members</label>
           </dt>
           <dd>
                <div style=" position:relative;" >
                    <select size="1" name="members" style="width:360px;"> 
                       <option value="1">All Members</option>
                       <option value="2">Restrict Members</option>
                       <option value="3">Registered Members</option>
                    </select>
                </div>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Status</label>
           </dt>
           <dd>
                <div style=" position:relative;" >
                    <select size="1" name="status" style="width:360px;"> 
                           <option value="Active">Active</option>
                           <option value="Inactive">Inactive</option>
                    </select>
                </div>
           </dd>
    </dl>
    
   
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Current Parent</label>
           </dt>
           <dd>
                <div style=" position:relative;" >
                    <select size="1" name="parentid" style="width:360px;"> 
                       <?php
					   foreach($categories as $key => $val )
					   { ?>
                       		<option value="<?=$key?>"><?=$val?></option>
                       <?php
					   } ?>
                       
                    </select>
                </div>
           </dd>
    </dl>
    
	<div class="ButtonRow">
        <a href="<?=site_url();?>Categories_Management"><img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="CancelButton"/></a>
        
        <button type="submit" >
            <img src="<?=base_url();?>images/webpowerup/Create.png" alt="Create"/>
        </button>
       
    </div>
    
</form>
</div>

