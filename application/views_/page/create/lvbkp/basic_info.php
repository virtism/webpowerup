<html>
<head>
<title></title>
<script type="text/javascript" language="javascript">


submitFlag = true; 
function popMenu()
{
    var width = 800;
    var height = 600;
    var page_title = document.getElementById("page_title");
    
    window.open("<?=base_url()?>index.php/menusController/addMenuForm", "CreateMenu", "width=800, height=600, scrollbars=yes");   
}

function prefill_page_link(){
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
function trim(s) {
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
        url: "<?=base_url()?>index.php/pagesController/isPageAlready/<?=$site_id?>/",
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
        url: "<?=base_url()?>index.php/pagesController/isPageAlready/<?=$site_id?>/",
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

function setForm(){    
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
</script>
</head>
<?php
    /*if(sizeof($_POST)<1){
        $strOnLoad = 'onload="setForm()"';    
    }
    else if($this->input->post("page_link")=="Create")
    {
        $strOnLoad = 'onload="document.getElementById('."'page_link'".').checked=true;"';            
    }
    else{
        $strOnLoad = 'onload="document.getElementById('."'page_link'".').checked=false;"';            
    }*/    

    /*echo "<pre>";
    print_r($_REQUEST);
    print_r($_POST); */
    
    
    ?>
<body>

<!--
<?php
if($action == "edit")
{
    $form_action = base_url().'index.php/pagesController/edit_basic_info/'.$site_id;     
}
else
{
    $form_action = base_url().'index.php/pagesController/create_page';   
}
?>
<form id="frmBasicInfo" name="frmBasicInfo" action="<?=$form_action?>" method="post" onsubmit="return validate()">
<input type="hidden" name="site_id" value="<?=$site_id?>" />
<input type="hidden" name="page_id" value="<?=$page_id?>" />
<input type="hidden" name="page_header" value="Default" /> 
<input type="hidden" name="page_background" value="Default" />
<input type="hidden" name="page_status" value="Published" /> 
<input type="hidden" name="page_access" value="Everyone" />
<input type="hidden" name="page_show_title" value="Yes" /> 
<table width="100%" border="0" cellspacing="5" cellpadding="0">
    <tr>
        <td colspan="2">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><h1 style="padding:0px;">Create A New Page</h1></td>
                </tr>
                <tr>
                    <td><h3>Basic Information - Step 1</h3></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="20%">Page Title: <span style="color: red">*</span></td>
        <td>
        <?php                        
            if($this->input->post("page_title")){
                $page_title = $this->input->post("page_title");    
            }
            
            if($action == 'edit')
            {
                $strOnBlur = 'onblur="checkAvail2(this.value, '.$page_id.')"';
            }
            else
            {
                $strOnBlur = 'onblur="checkAvail1(this.value)"';    
            }
        ?>
            <input id="page_title" name="page_title" value="<?=$page_title?>" size="30" <?=$strOnBlur?> />
            &nbsp;
            <span id="message" style="font-size: 12px; color: red; font-style: italic;"><?=form_error("page_title")?>&nbsp;</span>    
        </td>
        
    </tr>
    
    <tr>
        <td>Menu Link Text: <span style="color: red">*</span></td>
        <td>
        <?php                        
            if($this->input->post("item_name")){
                $item_name = $this->input->post("item_name");    
            }
        ?>
            <input id="item_name" name="item_name" value="<?=$item_name?>" size="30" />
            &nbsp;<?=form_error("item_name")?>
            <br />
            eg, <a href="javascript: void(0);">Link Text</a>
        </td>
    </tr>
    <tr>
        <td>Page SEO URL: <span style="color: red">*</span></td>
        <td>
        <?php                        
            if($this->input->post("page_seo_url")){
                $page_seo_url = $this->input->post("page_seo_url");    
            }
        ?>
            <input id="page_seo_url" name="page_seo_url" value="<?=$page_seo_url?>" size="30" onblur="format_link()" />
            &nbsp;<?=form_error("page_seo_url")?>
        </td>
    </tr>
     <tr>
        <td valign="top">Keywords:</td>
        <td>
        <?php                                        
            if($this->input->post("page_keywords")){
                $page_keywords = $this->input->post("page_keywords");    
            }
        ?>
            <textarea id="page_keywords" name="page_keywords" cols="30" rows="5"><?=$page_keywords?></textarea>
        </td>        
    </tr>
    <tr>
        <td valign="top">Description:</td>
        <td>
        <?php
            if($this->input->post("page_desc")){
                $page_desc = $this->input->post("page_desc");
            }
        ?>
            <textarea id="page_desc" name="page_desc" cols="30" rows="5"><?=$page_desc?></textarea>
        </td>
    </tr>
    
    
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php
            if($action=='edit')
            {
                $strOnclick = "document.getElementById('frmDeleteBasicInfo').submit();";    
            }
            else
            {
                $strOnclick = "document.location='".base_url()."index.php/pagesController/index/".$site_id."/0';"; 
            }
            ?>
            <input type="button" value="Back" onclick="<?=$strOnclick?>" /> &nbsp; 
            <input type="submit" value="Continue" /></td>        
    </tr>    
</table>
</form> 
<?php
if($action == 'edit')
{
?>
<form id="frmDeleteBasicInfo" action="<?=base_url()?>index.php/pagesController/DeleteBasicInfo/<?=$site_id?>" method="post">
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

<?php
if($action == "edit")
{
    $form_action = base_url().'index.php/pagesController/edit_basic_info/'.$site_id;     
}
else
{
    $form_action = base_url().'index.php/pagesController/create_page';   
}
?>
-->



<form id="frmBasicInfo" name="frmBasicInfo" action="<?=$form_action?>" method="post" onsubmit="return validate()">

    <fieldset>
        <input type="hidden" name="site_id" value="<?=$site_id?>" />
        <input type="hidden" name="page_id" value="<?=$page_id?>" />
        <input type="hidden" name="page_header" value="Default" /> 
        <input type="hidden" name="page_background" value="Default" />
        <input type="hidden" name="page_status" value="Published" /> 
        <input type="hidden" name="page_access" value="Everyone" />
        <input type="hidden" name="page_show_title" value="Yes" />
        
        <label>Create a New Page : Basic Information (Step 1)</label>
        
        <div class="section">
            <label>Page Title <span class="required">&nbsp;</span></label>
            <?php                        
            if($this->input->post("page_title")){
                $page_title = $this->input->post("page_title");    
            }
            
            if($action == 'edit')
            {
                $strOnBlur = 'onblur="checkAvail2(this.value, '.$page_id.')"';
            }
            else
            {
                $strOnBlur = 'onblur="checkAvail1(this.value)"';    
            }
            ?>
            <div>
                <input id="page_title" name="page_title" value="<?=$page_title?>" maxlength="30" <?=$strOnBlur?> />
                
                <span id="message"><?=form_error('page_title')?>&nbsp;</span>
            </div>
        </div>
        
        <div class="section">
            <label>Menu Link Text <span class="required">&nbsp;</span></label>
            <div>
                <?php                        
                if($this->input->post("item_name"))
                {
                    $item_name = $this->input->post("item_name");    
                }
                ?>     
                <input id="item_name" name="item_name" value="<?=$item_name?>" maxlength="30" />
                <?=form_error('item_name')?>
                <br />
                eg, <a href="javascript: void(0);">Link Text</a>
            </div>
        </div>
        
        <div class="section">
            <label>Page SEO URL <span class="required">&nbsp;</span></label>
            <div>
                <?php                        
                if($this->input->post("page_seo_url"))
                {
                    $page_seo_url = $this->input->post("page_seo_url");    
                }
                ?>
                <input id="page_seo_url" name="page_seo_url" value="<?=$page_seo_url?>" maxlength="30" onblur="format_link()" />
                <?=form_error("page_seo_url")?>
            </div>
        </div>
        
        <div class="section">
            <label>Keywords</label>
            <div>
                <?php                                        
                if($this->input->post("page_keywords"))
                {
                    $page_keywords = $this->input->post("page_keywords");    
                }
                ?>
                <textarea id="page_keywords" name="page_keywords" cols="30" rows="5"><?=$page_keywords?></textarea>
            </div>
        </div>
        
        <div class="section">
            <label>Description</label>
            <div>
                <?php
                if($this->input->post("page_desc")){
                    $page_desc = $this->input->post("page_desc");
                }
                ?>
                <textarea id="page_desc" name="page_desc" cols="30" rows="5"><?=$page_desc?></textarea>
            </div>
        </div>
        
        <div class="section">
            <div>
                <?php
                if($action=='edit')
                {
                    $strOnclick = "document.getElementById('frmDeleteBasicInfo').submit();";    
                }
                else
                {
                    $strOnclick = "document.location='".base_url()."index.php/pagesController/index/".$site_id."/0';"; 
                }
                ?>
                <input type="button" value="Back" onclick="<?=$strOnclick?>" /> &nbsp; <input type="submit" value="Continue" />
            </div>
        </div>   
        
    </fieldset>
</form>

<?php
if($action == 'edit')
{
?>
<form id="frmDeleteBasicInfo" action="<?=base_url()?>index.php/pagesController/DeleteBasicInfo/<?=$site_id?>" method="post">
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
</body>
</html>
