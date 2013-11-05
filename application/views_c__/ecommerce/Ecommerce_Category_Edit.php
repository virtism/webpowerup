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
<form class="niceform" id="cat_add" name="cat_add" method="post" enctype="multipart/form-data" action="<?=site_url();?>Categories_Management/edit">

	<input type="hidden" name="action" value="edit_category">
	<input type="hidden" name="id" value="<?=$category['cat_id']?>">


    <dl>
           <dt>
                 <label  class="NewsletterLabel">category name</label>
           </dt>
           <dd>
                <input type="text" name="cat_name" id="cat_name" size="53" value="<?=$category['cat_name'];?>" />
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Short Description</label>
           </dt>
           <dd>
                <textarea id="short_desc" name="short_desc"  rows="10" cols="42"><?=$category['shortdesc'];?></textarea>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Long Description</label>
           </dt>
           <dd>
                <textarea id="long_desc" name="long_desc"  rows="10" cols="42"><?=$category['longdesc'];?></textarea>
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
                <input type="radio" name="is_default"  value="No" <?php if( $category['is_default'] == 'No' ){ echo "checked='checked'" ;}?>  /> 
                <label class="check_label">Yes</label>
                <input type="radio" name="is_default"  value="Yes" <?php if( $category['is_default'] == 'Yes' ){ echo "checked='checked'" ;}?>/>
                
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Members</label>
           </dt>
           <dd>
                <div style=" position:relative;" >
                    <select size="1" name="members" style="width:360px;"> 
                       <option <?php ( $category['member_id'] == 1 ) ? "selected='selected'" : "" ;?> value="1">All Members</option>
                       <option <?php ( $category['member_id'] == 2 ) ? "selected='selected'" : "" ;?> value="2">Restrict Members</option>
                       <option <?php ( $category['member_id'] == 3 ) ? "selected='selected'" : "" ;?> value="3">Registered Members</option>
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
                           <option <?= ( $category['status'] == "Active" ) ? "selected='selected'" : "" ;?> value="Active">Active</option>
                           <option <?= ( $category['status'] == "Inactive" ) ? "selected='selected'" : "" ;?> value="Inactive">Inactive</option>
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
					   { 
					   		
					   ?>
                       		<option <?php ( $category['parentid'] == $key ) ? "selected='selected'" : "" ;?> value="<?=$key?>"><?=$val?></option>
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

