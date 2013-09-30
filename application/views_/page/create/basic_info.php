<style>
label.error{
	clear: both;
    color: #D8000C;
    float: left;
    font-size: 11px;
    left: 4px;
    position: absolute;
    top: 40px;
    width: 100%;
	font-weight:normal;
	background:none;
	margin:0;
	padding:0;
}
</style>
<script type="text/javascript" >
submitFlag = true; 
function popMenu()
{
	
    var width = 800;
    var height = 600;
    var page_title = document.getElementById("page_title");
    
    window.open("<?=base_url().index_page()?>menusController/addMenuForm", "CreateMenu", "width=800, height=600, scrollbars=yes");   
}
function prefill_page_link()
{
	
    var page_title = document.getElementById('page_title');
    var page_title_text = page_title.value;
    var item_name = document.getElementById('item_name');
    
    var page_seo_url = document.getElementById('page_seo_url');
    page_seo_url.value = "";
    if(page_title.value != "")
    {
        page_title_text = trim(page_title_text);
        page_title_parts = page_title_text.split(" ");
        item_name.value = page_title_text;
        
        page_seo_url_new = "";
        
        for(i=0; i<page_title_parts.length; i++)
        {
            if(page_title_parts[i+1])
            {
                page_title_parts[i] += "-";
            }
            if(page_title_parts[i])
            {
                page_seo_url_new += page_title_parts[i];    
            }    
        }
        page_seo_url_new = page_seo_url_new.toLowerCase();
        //alert(item_name_new);
        page_seo_url.value = page_seo_url_new;
    }
}
// remove multiple, leading or trailing spaces
function trim(s)
{
	
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," ");
    s = s.replace(/\n /,"\n");
    return s;
}
function format_link()
{
	
    page_seo_url = document.getElementById("page_seo_url");
    page_seo_url_parts = trim(page_seo_url.value);
    page_seo_url_parts = page_seo_url_parts.split(" ");
    
    page_seo_url_new = "";
    
    for(i=0; i<page_seo_url_parts.length; i++)
    {
        if(page_seo_url_parts[i+1])
        {
            page_seo_url_parts[i] += "-";
        }
        if(page_seo_url_parts[i])
        {
            page_seo_url_new += page_seo_url_parts[i];    
        }    
    }
    
    page_seo_url_new = page_seo_url_new.toLowerCase();
    page_seo_url.value = page_seo_url_new;
}
function checkAvail1(page_title)
{
	
    var message = document.getElementById("message");
    prefill_page_link();
    dataString = "page_title="+page_title;
    if(page_title != ""){
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>pagesController/isPageAlready/<?=$site_id?>/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'True')
                {
                    submitFlag = false;
                    //message.innerHTML = "<font style='color:red;'>Page Title already exist.</font>"; 
                    message.innerHTML = '<label class="error">Page Title already exist.</label>';    
                }
                else{
                    submitFlag = true;    
                    //message.innerHTML = "<font style='color:green;'>OK!</font>";
                    message.innerHTML = '<label class="error" style="color: green">Page Title is available.</label>';
                }
            }
        });
    }
}
function checkAvail2(page_title, page_id)
{
	
    var message = document.getElementById("message");
    prefill_page_link();
    dataString = "page_title="+page_title+"&page_id="+page_id;
    if(page_title != ""){
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>pagesController/isPageAlready/<?=$site_id?>/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'True')
                {
                    submitFlag = false;
                    message.innerHTML = "<font style='color:red;'>Page Title already exist.</font>";     
                }
                else{
                    submitFlag = true;     
                    message.innerHTML = "<font style='color:green;'>OK!</font>";
                }
            }
        });
    }
}
function setForm()
{
	    
    //var page_access_1 = document.getElementById("page_access_1");    
    //var page_link =  document.getElementById("page_link");
    //page_access_1.checked = true;
    //page_link.checked = true;
    var page_title = document.getElementById("page_title");
    page_title.focus();
}
function validate()
{
	
    if(submitFlag == true)
    {
        return true;    
    }
    else
    {
        window.alert("Please enter valid Page Title to continue.");
        return false;   
    }
}
function get_group_member()
{
	var group_ids = $("#group_access").val();
	//alert(group_ids);
	dataString = "groups_ids="+group_ids; 
	
	$.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>pagesController/get_groups_members",
        data: dataString,
        success: function(response){
              	//alert(response);
 				
                
				if(response != ""){                                               
                    $("#memberDropdown").show();
                    $("#memberDropdown").html(response);
                }
				else
				{
					$("#memberDropdown").show();
                    $("#memberDropdown").html("No member found in this group");
				}
               
				
            }
        });
		
	
}

$(document).ready(function(e) {
	
	
    $("#page_title").blur(function(e) {
		var v = $(this).val();
        <?php 
		if($action == "edit")
		{
			echo "checkAvail2(v,".$page_id.")";
		}
		else
		{
			echo "checkAvail1(v)";
		} 
		?>
    });
	
	
	 $("#page_seo_url").blur(function(e) {
		
        format_link();
    });
});
</script>

<?php
if($action == "edit")
{
    $form_action = base_url().index_page().'pagesController/edit_basic_info/'.$site_id;     
}
else
{
    $form_action = base_url().index_page().'pagesController/create_page';   
}
?>
-->
<div class="RightColumnHeading">
    <h1>
        <span>Create a New Page : Basic Information (Step 1)</span>
    </h1>
</div>
<div class="clr"></div>
<div class="InnerMain" >
<form id="frmBasicInfo" name="frmBasicInfo" action="<?=$form_action?>" method="post" onSubmit="return validate()" class="niceform">
    <fieldset>
        <input type="hidden" name="site_id" value="<?=$site_id?>" />
        <input type="hidden" name="page_id" value="<?=$page_id?>" />
        <input type="hidden" name="page_header" value="Default" /> 
        <input type="hidden" name="page_background" value="Default" />
        <input type="hidden" name="page_status" value="Published" /> 
        <input type="hidden" name="page_access" value="Everyone" />
        <input type="hidden" name="page_show_title" value="Yes" />
        
        
        
         <dl>
         	 <dt><label for="page_title" class="NewsletterLabel">Page Title <span class="star">*</span></label></dt>
              <dd>
             
              <!--<input type="text" name="page_title" id="" size="55" />-->
              <input id="page_title" name="page_title" value="<?=$page_title?>" maxlength="30" size="55"  />              
                <span id="message"><?=form_error('page_title')?>&nbsp;</span>
              </dd>
         </dl>
         
         
        <!----- Start Private member area  ----->
		<?  if(isset($private)&& $private=='private')
		{  ?>
        <dl>
            <dt><label for="email" class="NewsletterLabel"> Who can see this page? <span class="star">*</span></label></dt>
            <dd>
				<div>
				<?php 
				if ($private_user_id == 0 )
				{ 
					
					if(isset($groups) && !empty($groups))
					{ 
					?>
					<div  style=" position:relative; margin-top:10px; float:left">
					<select name="group_access[]" id="group_access_privatePage" style="width:360px;" size="1" onChange="get_group_member();">
                   		<option value="">Select Group</option>
					<?
					foreach($groups as $group)
					{
					?>
						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>		
					<? 	
					} ?>
					</select>
					</div>
					<?php 
					}
					else 
					{
						echo "No group exist. First create group.";
					}
				}
				else
				{
					echo $private_user['customer_login'];
					echo '<input type="hidden" value="'.$private_user['customer_id'].'" name="members" />'; 
				}
                ?>
                </div>
                
            </dd>
        </dl>
         <dl>
            <dt><label for="email" class="NewsletterLabel"></label></dt>
            <dd>
            <div id="memberDropdown" style="display:none;"></div>
            </dd>
        </dl>
          <input type="hidden" value="private" name="page_type" />
		<?php } 
		else 
		{ ?>
			<input type="hidden" value="Normal" name="page_type" />
		<?php 
		} ?>
        <!----- End Private member area  ----->
        
        <dl>
            <dt><label for="email" class="NewsletterLabel"> Menu Link Text<span class="star">*</span></label></dt>
            <dd><?php                        
                if($this->input->post("item_name"))
                {
                    $item_name = $this->input->post("item_name");    
                }
                ?>     
                <input id="item_name" name="item_name" value="<?=$item_name?>" maxlength="30" size="55" />
                <?=form_error('item_name')?>
            </dd>
        </dl>
        
        
        
        <dl>
            <dt><label for="email" class="NewsletterLabel">Page SEO URL<span class="star">*</span></label></dt>
            <dd>
            <?php                        
                if($this->input->post("page_seo_url"))
                {
                    $page_seo_url = $this->input->post("page_seo_url");    
                }
                ?>
                <input id="page_seo_url" name="page_seo_url" value="<?=$page_seo_url?>" maxlength="30" size="55" />
                <?=form_error("page_seo_url")?>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="" class="NewsletterLabel">Keywords</label></dt>
            <dd>
            	<?php                                        
                if($this->input->post("page_keywords"))
                {
                    $page_keywords = $this->input->post("page_keywords");    
                }
                ?>
                <textarea id="page_keywords" name="page_keywords"  rows="10" cols="42"><?=$page_keywords?></textarea>
            </dd>
        </dl>

        
        <dl>
            <dt><label for="" class="NewsletterLabel">Description</label></dt>
            <dd>
            	 <?php
                if($this->input->post("page_desc")){
                    $page_desc = $this->input->post("page_desc");
                }
                ?>
                <textarea id="page_desc" name="page_desc" rows="10" cols="42" ><?=$page_desc?></textarea>
            </dd>
        </dl>
        
        		
        
        <dl>
            <dt><label for="" class=""></label></dt>
            <dd>
            	<?php
                if($action=='edit')
                {
                    $strOnclick = "document.getElementById('frmDeleteBasicInfo').submit();";    
                }
                else
                {
                    $strOnclick = "document.location='".base_url().index_page()."pagesController/index/".$site_id."/0';"; 
                }
                ?>
                <input type="button" value="Back" onClick="<?=$strOnclick?>" />
                &nbsp; 
                <input type="submit" value="Continue" />
            </dd>
        </dl>        
                
    </fieldset>
</form>
</div>
<?php
if($action == 'edit')
{
?>
<form id="frmDeleteBasicInfo" action="<?=base_url().index_page()?>pagesController/DeleteBasicInfo/<?=$site_id?>" method="post">
    <input type="hidden" name="page_id" value="<?=$page_id?>" />
</form>
<?php    
}
?> 
<?php 
if(isset($_POST['page_title']))
{
?>
	<script language="javascript">
        page_title = document.getElementById('page_title');
        page_title.value = "";
        page_title.focus();
    </script>   
<?php  
}
?>
