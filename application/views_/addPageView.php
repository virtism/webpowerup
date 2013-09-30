<?php echo doctype();?>
<html>
<head>
<title>Web Builder - Add Page</title>
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url();?>ckeditor/ckeditor.js"></script> 
<script language="javascript" type="text/javascript" src="<?=base_url();?>js/jquery-1.1.4.pack.js"></script> 
<script type="text/javascript" language="javascript">
submitFlag = true;
numMenus = <?=$menus->num_rows()?>; 

function showHeaderUploader()
{
    var header_uploader = document.getElementById("header_uploader");
    
    if(uploader.style.visibility == "hidden")
    {
        uploader.style.visibility = "visible";
        uploader.style.position = "relative";          
    }    
}
function hideHeaderUploader()
{
    var header_uploader = document.getElementById("header_uploader");
    
    if(uploader.style.visibility == "visible")
    {
        uploader.style.visibility = "hidden";
        uploader.style.position = "absolute";          
    }    
}
function showSlideshowUploader()
{
    var slideshow_uploader = document.getElementById("slideshow_uploader");
    
    if(uploader.style.visibility == "hidden")
    {
        uploader.style.visibility = "visible";
        uploader.style.position = "relative";          
    }    
}
function hideSlideshowUploader()
{
    var slideshow_uploader = document.getElementById("slideshow_uploader");
    
    if(uploader.style.visibility == "visible")
    {
        uploader.style.visibility = "hidden";
        uploader.style.position = "absolute";          
    }    
}
function hideHeaderUpload()
{
    hideHeaderUploader();    
    hideSlideshowUploader();  
}

function uncheckMenus()
{
    for(i=1;i<=numMenus;i++)
    {
        var chkMenu = document.getElementById("menu_id_"+i);
        if(chkMenu.checked == true)
        {
            chkMenu.checked = false;    
        }    
    }   
}
function showRoles(){
    var role = document.getElementById("roles");        
    
    if(role.style.visibility=="hidden"){
        role.style.visibility="visible";
        role.style.position="relative";
    }    
}

function hideRoles(){
    var role = document.getElementById("roles");        
    
    if(role.style.visibility=="visible"){
        role.style.visibility="hidden";
        role.style.position="absolute";
    }    
}

function hideSchedule(){
    var schedule = document.getElementById("schedular");        
    
    if(schedule.style.visibility=="visible"){
        schedule.style.visibility="hidden";
        schedule.style.position="absolute";
    }    
}

function showSchedule(){
    var schedule = document.getElementById("schedular");        
    
    if(schedule.style.visibility=="hidden"){
        schedule.style.visibility="visible";
        schedule.style.position="relative";
    }    
}
function setForm(){
    var page_header_1 = document.getElementById("page_header_1");
    var page_background_1 = document.getElementById("page_background_1");
    var page_access_1 = document.getElementById("page_access_1");
    var page_status_1 = document.getElementById("page_status_1");
    var page_link =  document.getElementById("page_link");
    
    page_header_1.checked = true;
    page_background_1.checked = true; 
    page_access_1.checked = true;
    page_status_1.checked = true;
    page_link.checked = false;
}
function uncheckCreateLink()
{
    var page_link =  document.getElementById("page_link");
    
    if(page_link.checked == true)
    {
        page_link.checked = false;           
    }   
}

function validateFileUpload(fup)
{    
    var fileName = fup.value;
    
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
    if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG")
    {
        return true;
    } 
    else
    {        
        return false;
    }
}


countHeaderImages = 3;
function addMore()
{
    
    countHeaderImages++;
    var numHeaderImages = document.getElementById('numHeaderImages');         
    numHeaderImages.value++;    
    var tbl = document.getElementById('tbl_header_images');
    var lastRow = tbl.rows.length;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = 'Image '+countHeaderImages;
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<input type="file" id="header_image_'+countHeaderImages+'" name="header_image_'+countHeaderImages+'" />';              
}

function validateAddPageForm(){
    var boolValidation;
    
    var page_header_2 = document.getElementById("page_header_2");
    var page_header_3 = document.getElementById("page_header_3");
    //alert(page_header_3.checked);
    var header_image = document.getElementById("header_image");
        
    if(page_header_2.checked == true && header_image.value == ""){
        window.alert("Please select header image.");
        return;
        if(validateFileUpload(header_image)==false){
            window.alert("Please select a valid header image file format(Gif, Jpg, Png)");
            return;
        }        
    }
    
    if(page_header_3.checked == true)
    {   
        
        flagSelected = false;
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = document.getElementById("header_image_"+i);
            
            if(slideshow_header_image.value != "")
            {
                flagSelected = true;   
            }    
        }
        if(flagSelected == false)
        {
            window.alert("Please select Slideshow header images.");  
            return;   
        }
          
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = document.getElementById("header_image_"+i);
            if(slideshow_header_image.value != "")
            {
                flagFile = validateFileUpload(slideshow_header_image);
                if(flagFile == false)
                {
                alert("Please select Gif, Jpg or Png file for Slideshow Header Image "+i);
                return;    
                }    
            }             
        }
            
    }     
    
    var page_background_2 = document.getElementById("page_background_2");
    var background_image = document.getElementById("background_image");
    
    if(page_background_2.checked == true && background_image.value == ""){
        window.alert("Please select background image.");
        return;
        if(validateFileUpload(background_image)==false){
            window.alert("Please select a valid header image file format(Gif, Jpg, Png)");
            return;
        }
    }
    
    var page_title = document.getElementById('page_title');  
    
    if(page_title.value == ""){
        window.alert("Please input Page Title for this Page.");
        return;
    }
    
    var sameas_page_title = document.getElementById('sameas_page_title');   
    var item_name = document.getElementById('item_name');
    if(sameas_page_title.checked == false && item_name.value==""){
        window.alert("Please input Menu Item Name to Create this Page.");
        return;
    }
    
    var page_access_3 = document.getElementById('page_access_3');
    var boolRole = false; 
    var role_id = document.getElementById('role_id[]'); 
    if(page_access_3.checked == true){
        for(i=0;i<role_id.options.length;i++){
            if(role_id.options[i].selected){
                boolRole = true;        
            }              
        }    
    }
    else{
        boolRole = true;
    }
    
    if(boolRole == false){
        window.alert("Please select access roles for this page.");
        return;
    }
    
    var page_status_3 = document.getElementById("page_status_3");
    if(page_status_3.checked == true){
        var page_start_date = document.getElementById("page_start_date");  
        var page_end_date = document.getElementById("page_end_date");
        if(page_start_date.value=="" || page_end_date.value==""){
            window.alert("Please select Start and/or End Date/Time for this page.");
            return;    
        }
        
        var splitString = page_start_date.value.split("-");

        date1 = splitString[0];
        month1 = splitString[1];
        year1 = splitString[2].substring(0, 4);       

        var splitString = page_end_date.value.split("-");        
        date2 = splitString[0];
        month2 = splitString[1];
        year2 = splitString[2].substring(0, 4);
       
       date1 = new Date(year1, month1, date1);
       date2 = new Date(year2, month2, date2); 
       if(date1>date2){
            window.alert("Start Date/Time should earlier then End Date/Time.");    
            return;
       } 
    }  
    
    if(submitFlag != true)
    {
        window.alert("Please re-enter/try different page title.");
        return;    
    }
    
    form = document.getElementById("frmAddPage");
    form.submit();        
}

function checkAvail(page_title)
{
    
    var message = document.getElementById("message");
    
    if(page_title != ""){
        $.ajax({
        //type: "GET",
        url: "<?=base_url().index_page()?>pagesController/isPageAlready/<?=$site_id?>/"+page_title,
        //data: dataString,
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
</script>

</head>
<?php
    if(!$this->input->post()){
        $strOnLoad = 'onload="setForm()"';    
    }
    else{
        $strOnLoad = "";
    }    
?>
<body <?=$strOnLoad;?>>
<table align="center" width="960" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <h1>Create A New Page</h1>
        </td>
        <td>
            <ul>
                <li><a href="#" onClick="validateAddPageForm()">Save</a></li>
                <li><a href="<?=base_url().index_page()?>pagesController/index">Cancel</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p>This wizard allows you to create a <b>page</b> for your website. Pages are used to display your site's content to the people that
            visit your site = they can contain information, articales, newsflashes, and much more. This wizard also allows you to easily add images
            to your pages.
            </p>
            <p>
            Follow the numbered items below to create the page. For help with a specific item, place your cursor over the blue help icon that is located
            beside the title of each item. Also, you can right-click anywhere on the page and choose "Apply" to save your progress.
            </p>
        </td>
    </tr>
    <tr>
        <td valign="top" colspan="2">       
         <form id="frmAddPage" name="frmAddPage" enctype="multipart/form-data" method="post" action="<?=base_url().index_page()?>pagesController/addPage">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%" valign="top">
                        <h3>CHOOSE YOUR PAGE HEADER</h3>
                        <hr />
                       
                            <input type="hidden" id="DateTime" name="DateTime" value="<?=date("Ymdhis")?>" />
                            <label>
                                <?php
                                $page_header = $this->input->post("page_header");
                                if($page_header == "Default"){
                                    $strChecked = 'checked="checked"'; 
                                }
                                else{
                                    $strChecked = "";
                                }
                                ?>
                                <input id="page_header_1" name="page_header" type="radio" value="Default" <?=$strChecked;?> onClick="hideHeaderUpload()" />USE DEFAULT BANNER
                            </label>
                            <br />
                            <label>
                                <?php                                
                                if($page_header == "Other"){
                                    $strChecked = 'checked="checked"'; 
                                }
                                else{
                                    $strChecked = "";
                                }
                                ?>                     
                                <input id="page_header_2" name="page_header" type="radio" value="Other" <?=$strChecked;?> />Upload A New Image
                            </label>
                            <br />
                            <?=nbs(5);?><input type="file" id="header_image" name="header_image" />
                            <?=form_error("header_image");?>
                    </td>
                    <td rowspan="2" valign="top">
                        <h3>CREATE SLIDESHOW HEADER</h3>
                        <hr />
                        <?php                                
                        if($page_header == "Slideshow"){
                            $strChecked = 'checked="checked"'; 
                        }
                        else{
                            $strChecked = "";
                        }
                        ?>
                        <label>
                            <input type="radio" id="page_header_3" name="page_header" value="Slideshow" <?=$strChecked;?> />Upload A New Image
                        </label>
                        <br />
                        <table id="tbl_header_images" border="0">
                            <tr>
                                <td align="center">Image 1</td>
                                <td>
                                <input type="hidden" id="numHeaderImages" name="numHeaderImages" value="3" />
                                <input type="file" id="header_image_1" name="header_image_1" /></td>
                            </tr>
                            <tr>
                                <td align="center">Image 2</td>
                                <td><input type="file" id="header_image_2" name="header_image_2" /></td>
                            </tr>
                            <tr>
                                <td align="center">Image 3</td>
                                <td><input type="file" id="header_image_3" name="header_image_3" /></td>
                            </tr>                            
                        </table>
                        <?=form_error("header_image_01");?>
                        <a href="#" onClick="addMore()">Add More Images</a>                        
                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top">
                        <h3>Choose Background Pattern</h3>
                        <hr />
                        <?php
                        $page_background = $this->input->post("page_background");
                        if($page_background == "Default"){
                            $strChecked = 'checked="checked"';
                        }
                        else{
                            $strChecked = "";
                        }
                        ?>
                        <label><input id="page_background_1" name="page_background" type="radio" value="Default" <?=$strChecked;?> />Use An Existing Background</label>
                        <br />
                        <?php
                        if($page_background == "Other"){
                            $strChecked = 'checked="checked"';
                        }
                        else{
                            $strChecked = "";
                        }
                        ?>
                        <label><input id="page_background_2" name="page_background" value="Other" type="radio" <?=$strChecked;?> />Upload Your Own Image (Advance Feature)</label>
                        <br />
                        <?=nbs(5);?><input type="file" id="background_image" name="background_image" />
                        <?=form_error("background_image");?>
                    </td>                    
                </tr>
                <tr>
                    <td valign="top" colspan="2">
                        <h4>Page Title</h2>
                        <hr />
                        <?php                        
                            if($this->input->post("page_title")){
                                $page_title = $this->input->post("page_title");    
                            }
                            else{
                                $page_title = "";    
                            }
                        ?>
                        <input type="text" id="page_title" name="page_title" value="<?=$page_title;?>" onBlur="checkAvail(this.value)" />
                        <?=form_error("page_title");?><span id="message">&nbsp;</span>
                        <br />
                        <?php
                            $page_show_title = $this->input->post("page_show_title");
                            if($page_show_title == "Yes"){
                                $strChecked = 'checked="checked"';    
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <input type="checkbox" id="page_show_title" name="page_show_title" value="Yes" <?=$strChecked;?> />Show This Title On The Page?
                        <br />
                        <div style="float: right;">More detailed description of the page, which will be used by search engines</div>
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2">
                        <h4>Description & Keywords</h2>
                        <hr />
                        <table border="0">
                            <tr>
                                <td colspan="2">                                   
                                    Keywords:&nbsp;
                                    <?php                                        
                                        if($this->input->post("page_keywords")){
                                            $page_keywords = $this->input->post("page_keywords");    
                                        }
                                        else{
                                            $page_keywords ="";
                                        }
                                    ?>
                                    <input type="text" id="page_keywords" name="page_keywords" value="<?=$page_keywords;?>" />
                                </td>                                
                            </tr>
                            <tr>
                                <td valign="top">Description:</td>
                                <td valign="top">
                                    <?php
                                        if($this->input->post("page_desc")){
                                            $page_desc = $this->input->post("page_desc");
                                        }
                                        else{
                                            $page_desc = "";
                                        }
                                    ?>
                                    <textarea id="page_desc" name="page_desc" cols="25" rows="3"><?=$page_desc;?></textarea>
                                </td>
                            </tr>
                        </table>
                        <div style="float: right;">Allows you to create a link to this page in any of your site's menus.</div>
                    <td>                                        
                </tr>
                <tr>
                    <td valign="top" colspan="2">
                        <h4>Select A Menu</h2>
                        <hr />
                        <?php                        
                        $strChecked = "";
                        $i = 1;
                        foreach($menus->result_array() as $rowMenus){
                            if($this->input->post("menu_id")){
                                 $menu_id = $this->input->post("menu_id");
                                 if(in_array($rowMenus["menu_id"], $menu_id)){
                                     $strChecked = 'checked="checked"';    
                                 }
                                 else{
                                     $strChecked = "";
                                 }
                            }
                        ?>
                        <label>
                            <input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onClick="uncheckCreateLink()" /> <?=$rowMenus["menu_name"];?>
                        </label>
                        <br />
                        <?php
                        $i++;
                        }?>                        
                        <label>
                            <input type="radio" id="page_link" name="page_link" value="Create" checked="page_link" onClick="uncheckMenus()" /> None (Don't Create a Page)<font size="-1"> &nbsp; &nbsp;Just show me the link after the page is saved</font>
                        </label>
                        <br />
                        <?=nbs(5);?>Parent Item:
                        <select id="" name="" style="width:150px;">
                            <option value="0">None</option>
                        </select>
                        <span>(Choose "None" if you are unsure)</span>  
                        <br />                      
                        <div style="float: right;">This link text will be displayed in the menu(s) selected in the previous step.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Menu Item Text</h4>
                        <hr />
                        <input type="checkbox" id="sameas_page_title" name="sameas_page_title" value="Yes" />
                        Same As Page Title
                        <br />
                        <?php
                            if($this->input->post("item_name")){
                                $item_name = $this->input->post("item_name"); 
                            }
                            else{
                                $item_name = "";
                            }
                        ?>
                        <input type="text" id="item_name" name="item_name" value="<?=$item_name;?>" />
                        <?=form_error("item_name");?>
                        <br />
                        <div style="float: right;">Allows you to create a link to this page in any of your site's menus.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Who Can See This Page?</h4>
                        <hr />
                        <?php
                            if($this->input->post("page_access")){
                                $page_access = $this->input->post("page_access");
                            }
                            else{
                                $page_access = "";
                            }
                        ?>
                        <?php
                            if($page_access == "Everyone"){
                                $strChecked = 'checked="checked"';
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <label>
                            <input type="radio" id="page_access_1" name="page_access" value="Everyone" onClick="hideRoles()" <?=$strChecked;?> /> Everyone
                        </label>
                        <?php
                            if($page_access == "Registered"){
                                $strChecked = 'checked="checked"';
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <br />
                        <label>
                            <input type="radio" id="page_access_2" name="page_access" value="Registered" onClick="hideRoles()" <?=$strChecked;?> /> All Registered Users
                        </label>
                        <br />
                        <?php
                            if($page_access == "Other"){
                                $strChecked = 'checked="checked"';
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <label>
                            <input type="radio" id="page_access_3" name="page_access" value="Other" onClick="showRoles()" <?=$strChecked;?> /> Only Users With a Certain Access Level
                        </label>
                        <br />
                        <?php
                        $page_access = $this->input->post("page_access");
                        if($page_access == 'Other'){
                            $strStyle="visibility: visible; position: relative;";
                        }
                        else{
                            $strStyle="visibility: hidden; position: absolute;";    
                        }
                        ?>
                        <span id="roles" name="roles" style="<?=$strStyle;?>">    
                        <select id="role_id[]" name="role_id[]" multiple="multiple" style="width:130px; margin-left:25px;margin-bottom:10px;">
                            <?php 
                            $strSelected = "";
                            foreach($roles->result_array() as $rowRoles){?>
                            <?php
                            if($page_access == "Other"){
                                if(in_array($rowRoles['role_id'], $this->input->post("role_id"))){
                                    $strSelected = 'selected="selected"';
                                }
                                else{
                                    $strSelected = "";
                                }
                            }    
                            ?>
                            <option value="<?=$rowRoles['role_id']?>" <?=$strSelected;?>><?=$rowRoles['role_name']?></option>
                            <?php 
                            }?>        
                        </select><?=form_error("role_id[]");?>
                        </span>
                        <br />
                        <div style="float: right;">Select "Yes" to make your page available for viewing right away.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Published?</h4>
                        <hr />
                        <?php                           
                            if($this->input->post("page_status")){
                                $page_status = $this->input->post("page_status");
                            }
                            else{
                                $page_status = "";    
                            }
                        ?>
                        <?php
                            if($page_status == "Published"){
                                $strChecked = 'checked="checked"';    
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <label>
                            <input type="radio" id="page_status_1" name="page_status" value="Published" onChange="hideSchedule()" <?=$strChecked;?> /> Yes
                        </label>
                        <br />
                        <?php
                            if($page_status == "Not Published"){
                                $strChecked = 'checked="checked"';    
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <label>
                            <input type="radio" id="page_status_2" name="page_status" value="Not Published" onChange="hideSchedule()" <?=$strChecked;?> /> No
                        </label>
                        <br />
                        <?php
                            if($page_status == "Schedule"){
                                $strChecked = 'checked="checked"';    
                            }
                            else{
                                $strChecked = "";
                            }
                        ?>
                        <label>
                            <input type="radio" id="page_status_3" name="page_status" value="Schedule" onChange="showSchedule()" <?=$strChecked;?> /> Publish For A Specific Amount Of Time 
                        </label>
                        <br />
                        <?php                        
                        if($page_status == 'Schedule'){
                            $strStyle = "visibility: visible; position: relative;";    
                        }
                        else{
                            $strStyle = "visibility: hidden; position: absolute;";
                        }
                        ?>
                        <div id="schedular" style="<?=$strStyle;?>">
                        <p style="padding-left:20px;">
                            <b>Start:</b>
                            <br />
                            <?php                            
                            if($this->input->post("page_start_date")){
                                 $page_start_date = $this->input->post("page_start_date");   
                            }
                            else{
                                $page_start_date = "";      
                            }
                            ?>      
                            Date/Time:
                            <input id="page_start_date" name="page_start_date" type="text" value="<?=$page_start_date;?>" size="25" readOnly="readOnly">
                            <a href="javascript:NewCal('page_start_date','ddMMyyyy', true, 12)">
                                <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                            </a>
                            <?=form_error("page_start_date");?>    
                            </p>
                            <p style="padding-left:20px;">    
                            <b>End:</b>
                            <br />
                            <?php                            
                            if($this->input->post("page_end_date")){
                                 $page_end_date = $this->input->post("page_end_date");   
                            }
                            else{
                                $page_end_date = "";      
                            }
                            ?>    
                            Date/Time:
                            <input id="page_end_date" name="page_end_date" type="text" value="<?=$page_end_date;?>" size="25" readOnly="readOnly">
                                <a href="javascript:NewCal('page_end_date','ddMMyyyy',true,12)">
                                    <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                                </a>
                            <?=form_error("page_end_date");?><br />    
                            </p>
                        </div>
                        <div style="float: right;">Use editor area below to design your page.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Create Your Page Below</h4>
                        <hr />                        
                        <textarea id="page_content" name="page_content">&lt;p&gt;Initial value.&lt;/p&gt;</textarea>
                        <script type="text/javascript">
                            CKEDITOR.replace( 'page_content' );
                        </script>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">                                                        
                        <label><input type="checkbox" id="" value="" name="" /> ADD TO FACEBOOK AFTER SAVING</label>                       
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input type="checkbox" id="" value="" name="" /> ADD TO WORDPRESS AFTER SAVING</label>                      
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input type="checkbox" id="" value="" name="" /> Notify In This Group Of New Page or Update</label>                      
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input type="checkbox" id="" value="" name="" /> Allow Comments On This Page</label>                      
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input type="checkbox" id="" value="" name="" /> Allow Sharing</label>                      
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><input type="checkbox" id="" value="" name="" /><font size="+2">What is happening?</font> Send Tweet of this page</label>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <font size="+3">That's It,</font> <font size="+2">Now You Can </font>
                        <ul>
                            <li><a href="#" onClick="validateAddPageForm()">Save</a></li>
                            <li><a href="<?=base_url().index_page()?>pagesController/index">Cancel</a></li>
                        </ul>                      
                    </td>
                </tr>                 
            </table>
           </form>                       
        </td>
    </tr>
</table>
</body>
</html>