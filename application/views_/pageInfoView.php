<?php echo doctype();?>
<html>
<head>
<title>Web Builder - Add Page</title>
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url();?>ckeditor/ckeditor.js"></script> 
<script type="text/javascript" language="javascript">
submitFlag = true;
numMenus = <?=$menus->num_rows()?>; 

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
function uncheckCreateLink()
{
    var page_link =  document.getElementById("page_link");
    
    if(page_link.checked == true)
    {
        page_link.checked = false;           
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
    
    page_header_1.checked = true;
    page_background_1.checked = true; 
    page_access_1.checked = true;
    page_status_1.checked = true;
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
countHeaderImages = 1;
<?php
if($page_header == 'Slideshow')
{
    $totalSlideImgs = $header_image->num_rows();
}
else
{
    $totalSlideImgs = 0;   
}
?> 
totalSlideImgs = <?=$totalSlideImgs?>;
function validateAddPageForm(){
    var boolValidation;
    
    var page_header_2 = document.getElementById("page_header_2");
    var page_header_3 = document.getElementById("page_header_3");
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
        //alert(page_header_3);    
        if(totalSlideImgs==0 && countHeaderImages==0)
        {
            window.alert("Please select slideshow header images to continue.");
            return;
        }
        
        flagSelected = false;
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = document.getElementById("header_image_"+i);
            
            if(slideshow_header_image.value != "")
            {
                flagSelected = true;   
            }    
        }
        if(flagSelected == false && totalSlideImgs==0)
        {
            window.alert("Please select Slideshow header images.");  
            return;   
        }
        
        //alert(countHeaderImages);  
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = document.getElementById("header_image_"+i);
            //alert(slideshow_header_image);
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
    var page_link = document.getElementById('page_link');
    if(sameas_page_title.checked == false && item_name.value=="" && page_link.checked==false){
        window.alert("Please input Menu Item Name to for this Page.");
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
    
    form = document.getElementById("frmUpdatePage");
    form.submit();        
}

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
    cell2.innerHTML = '<input type="file" id="header_image_'+countHeaderImages+'" name="header_image_'+countHeaderImages+'"/>';              
}
function deleteRow(i, id){
    
    document.getElementById('tbl_images').deleteRow(i);
    totalSlideImgs--;    
    
    //var dataString = 'id='+ id;
    //alert(dataString);
    $.ajax({
    //type: "GET",
    url: "<?=base_url().index_page()?>pagesController/deleteHeader/"+id,
    //data: dataString,
    success: function(data){
        alert("Record deleted successfully.");
        }
    });
        
}

function checkAvail(page_title, page_id)
{
    
    var message = document.getElementById("message");
    
    if(page_title != ""){
        $.ajax({
        //type: "GET",
        url: "<?=base_url().index_page()?>pagesController/isPageUpdateExist/<?=$site_id?>/"+page_id+"/"+page_title,
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

function showNewBackgroundProperties()
{
    var bg_properties = document.getElementById('new_bg');
    var visible = bg_properties.style.visibility;
    
    if(visible=='hidden')
    {
        bg_properties.style.visibility = 'visible';
        bg_properties.style.position = 'relative';       
    }
    
}
function hideNewBackgroundProperties()
{
    var bg_properties = document.getElementById('new_bg');
    var visible = bg_properties.style.visibility;
    if(visible=='visible')
    {
        bg_properties.style.visibility = 'hidden';
        bg_properties.style.position = 'absolute';       
    }
    
}
</script>

</head>

<body>

<table align="center" width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <h1 style="padding: 0px;">Edit Page Details</h1>
        </td>
        <td>
            <ul>
                <li><a href="javascript: void(0)" onClick="validateAddPageForm()">Save</a></li>
                <li><a href="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0">Cancel</a></li>
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
           <form id="frmUpdatePage" name="frmUpdatePage" enctype="multipart/form-data" method="post" action="<?=base_url().index_page()?>pagesController/updatePage">
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%" valign="top">
                        <h3>CHOOSE YOUR PAGE HEADER</h3>
                        
                        
                        <input type="hidden" name="page_id" value="<?=$id;?>" />
                        <input type="hidden" name="site_id" value="<?=$site_id;?>" /> 
                        <input type="hidden" id="DateTime" name="DateTime" value="<?=date("Ymdhis")?>" />
                        <input type="hidden" id="numHeaderImages" name="numHeaderImages" value="1" />
                            <label>
                                <?php                                
                                if($page_header == "Default"){
                                    $strChecked = 'checked="checked"'; 
                                }
                                else{
                                    $strChecked = "";
                                }
                                ?>
                                <input id="page_header_1" name="page_header" type="radio" value="Default" <?=$strChecked;?> />USE DEFAULT BANNER
                            </label>
                            <br />
                            <?php                                
                            if($page_header == "Other"){?>                                    
                            <label>                                
                                <input id="page_header_now" name="page_header" type="radio" value="Current" checked="checked" /><?=$header_image;?><br />
                            </label>        
                            <?php     
                            }
                            ?>
                            <label>                                
                                <input id="page_header_2" name="page_header" type="radio" value="Other" />Upload A New Image
                            </label>
                            <br />
                            <?=nbs(5);?><input type="file" id="header_image" name="header_image" />
                            <?=form_error("header_image");?>
                    </td>
                    <td rowspan="2" valign="top">
                        <h3>CREATE SLIDESHOW HEADER</h3>
                        
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
                        <?=nbs(5);?>
                        
                        <?php
                            if($page_header == "Slideshow")
                            {
                        ?>
                        <table id="tbl_images" border="1">
                        <?php    
                                foreach($header_image->result_array() as $rowHeaderImage)
                                {    
                        ?>
                            <tr>
                                <td>
                                    <?=$rowHeaderImage["header_image"]?>                                    
                                </td>
                                <td>
                                    <img src="<?=base_url();?>/images/icon-delete.png" onClick="deleteRow(this.parentNode.parentNode.rowIndex, <?=$rowHeaderImage['header_id']?>)" />
                                </td>
                            </tr>
                        <?php
                                }
                        ?>
                        </table>
                        <?php
                            }
                        ?>                        
                        <br />
                        <table id="tbl_header_images" border="0">                            
                            <tr>
                                <td>Image 1</td> 
                                <td><input type="file" id="header_image_1" name="header_image_1" /></td>
                            </tr>                                
                        </table>
                        <?=form_error("header_image_1");?>
                        <a href="javascript:void(0);" onClick="addMore()">Add More Images</a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top">
                        <h3>Choose Background Pattern</h3>
                        
                        <?php                        
                        if($page_background == "Default"){
                            $strChecked = 'checked="checked"';
                        }
                        else{
                            $strChecked = "";
                        }
                        ?>
                        <label>
                            <input id="page_background_1" name="page_background" type="radio" value="Default" onClick="hideNewBackgroundProperties()" <?=$strChecked;?> />
                            Use An Existing Background
                        </label>
                        <br />
                        <?php                                
                        if($page_background == "Other"){?>                                    
                        <label>                                
                            <input id="page_background_now" name="page_background" type="radio" value="Current" onClick="hideNewBackgroundProperties()" checked="checked" />
                            <?=$background_image;?>
                        </label>   
                        <br />
                        <!-- Background description -->
                        <div style="margin-left: 30px">
                        <strong>Background Area</strong> :
                        <br />
                        <?php
                        $strChecked = '';
                        if($background_area=='page')
                        {
                            $strChecked = 'checked="checked"';
                        }  
                        ?>
                        <label>
                            <input type="radio" id="background_area_1" name="background_area" value="page" <?=$strChecked?> />
                            Whole Page
                        </label>
                        <br />
                        <?php
                        $strChecked = '';
                        if($background_area=='content')
                        {
                            $strChecked = 'checked="checked"';
                        }
                        ?>
                        <label>
                            <input type="radio" id="background_area_2" name="background_area" value="content" <?=$strChecked?> />
                            Only Page Content  
                        </label>
                        <br />
                        
                        <strong>Background Style</strong> :
                        <br />
                        <?php
                        $strChecked = '';
                        if($background_style=='stretch')
                        {
                            $strChecked = 'checked="checked"';
                        }  
                        ?>
                        <label for="new_background_style_1">
                            <input type="radio" id="background_style_1" name="background_style" value="stretch" <?=$strChecked?> />
                            Stretch(to fit the area)
                        </label>
                        <br />
                        <?php
                        $strChecked = '';
                        if($background_style=='tile')
                        {
                            $strChecked = 'checked="checked"';
                        }
                        ?>
                        <label for="new_background_style_2">
                            <input type="radio" id="background_style_2" name="background_style" value="tile" <?=$strChecked?> />
                            Tile(the area)
                        </label>
                        </div>
                        <!-- Background description -->     
                        <?php     
                        }
                        ?> 
                        
                        <label>
                            <input id="page_background_2" name="page_background" value="Other" type="radio" onClick="showNewBackgroundProperties()" />
                            Upload Your Own Image (Advance Feature)
                        </label>
                        
                        <?=nbs(5);?><input type="file" id="background_image" name="background_image" />
                        <?=form_error("background_image");?>
                        <!-- Background description -->
                        
                        <div id="new_bg" style="visibility: hidden; position: absolute; margin-left:30px;">
                        
                        <strong>Background Area</strong> :
                        <br />
                        <label for="background_area_1">
                            <input type="radio" id="new_background_area_1" name="new_background_area" value="page" checked="checked" />
                            Whole Page
                        </label>
                        <br />
                        <label for="background_area_2">
                            <input type="radio" id="new_background_area_2" name="new_background_area" value="content" />
                            Only Page Content  
                        </label>
                        <br />
                        
                        <strong>Background Style</strong> :
                        <br />
                        <label for="background_style_1">
                            <input type="radio" id="new_background_style_1" name="new_background_style" value="stretch" checked="checked" />
                            Stretch(to fit the area)
                        </label>
                        <br />
                        <label for="background_area_2">
                            <input type="radio" id="new_background_style_2" name="new_background_style" value="tile" />
                            Tile(the area)
                        </label>
                        
                        </div>
                        
                        <!-- Background description -->     
                        
                    </td>                    
                </tr>
                <tr>
                    <td valign="top" colspan="2">
                        <h4>Page Title</h2>
                        
                        
                        <input type="text" id="page_title" name="page_title" value="<?=$page_title;?>" onBlur="checkAvail(this.value, <?=$id?>)" />
                        <span id="message">&nbsp;</span>
                        <?=form_error("page_title");?>
                        <br />
                        <?php                            
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
                        
                        <table border="0">
                            <tr>
                                <td colspan="2">                                   
                                    Keywords:&nbsp;                                    
                                    <input type="text" id="page_keywords" name="page_keywords" value="<?=$page_keywords;?>" />
                                </td>                                
                            </tr>
                            <tr>
                                <td valign="top">Description:</td>
                                <td valign="top">                                    
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
                        
                        <?php                        
                        $strChecked = "";
                        $i=1;
                        foreach($menus->result_array() as $rowMenus){
                            //echo $item_id." ".$rowMenus['menu_id'];
                            $flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
                            if($flag == true){                               
                                $strChecked = 'checked="checked"';    
                            }
                             else{
                                 $strChecked = "";
                             }                       
                        ?>
                        <label>
                            <input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" onChange="uncheckCreateLink()" <?=$strChecked;?> /> <?=$rowMenus["menu_name"];?>
                        </label>
                        <br />
                        <?php
                        $i++;
                        }?> 
                        <?php
                        $strChecked = "";
                        if($item_name == "")
                        {
                            $strChecked = 'checked="checked"';        
                        }
                        ?>                       
                        <label>
                            <input type="radio" id="page_link" name="page_link" value="Create" <?=$strChecked?> onClick="uncheckMenus()" /> None (Don't Create a Page)<font size="-1"> &nbsp; &nbsp;Just show me the link after the page is saved</font>
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
                        
                        <input type="checkbox" id="sameas_page_title" name="sameas_page_title" value="Yes" />
                        Same As Page Title
                        <br />                        
                        <input type="text" id="item_name" name="item_name" value="<?=$item_name;?>" />
                        <?=form_error("item_name");?>
                        <br />
                        <div style="float: right;">Allows you to create a link to this page in any of your site's menus.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Who Can See This Page?</h4>
                        
                        <?php
                            if($this->input->post("page_access")){
                                $page_access = $this->input->post("page_access");
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
                                    if($this->Pages_Model->isPageRole($id, $rowRoles['role_id'])){
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
                        
                        <?php                           
                            if($this->input->post("page_status")){
                                $page_status = $this->input->post("page_status");
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
                            ?>      
                            Date/Time:
                            <input id="page_start_date" name="page_start_date" type="text" value="<?=$page_start_date;?>" size="25" readOnly="readOnly">
                            <a href="javascript:NewCal('page_start_date','ddMMyyyy',true,12)">
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
                                                
                        <textarea id="page_content" name="page_content"><?=$page_content;?></textarea>
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
                            <li><a href="javascript: void(0);" onClick="validateAddPageForm()">Save</a></li>
                            <li><a href="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0">Cancel</a></li>
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
