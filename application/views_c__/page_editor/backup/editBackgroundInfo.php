<html>
<head>
<title>Edit Page Background Info</title>
<script type="text/javascript" language="javascript">

function reloadParent()
{
    parent.window.document.location.reload();
}  

function hideBackgroundUploader()
{
    var div_background_image = document.getElementById("div_background_image");
    
    if(div_background_image.style.visibility == "visible")
    {
        div_background_image.style.visibility = "hidden";
        div_background_image.style.position = "absolute";          
    }    
}

function showBackgroundUploader()
{
    var div_background_image = document.getElementById("div_background_image");
    
    if(div_background_image.style.visibility == "hidden")
    {
        div_background_image.style.visibility = "visible";
        div_background_image.style.position = "relative";          
    }    
}

function validateFileUpload(fup)
{    
    var fileName = fup.value;
    
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
    /*
    
    */
    var page_background_2 = document.getElementById("page_background_2");
    var background_image = document.getElementById("background_image");
    
    if(page_background_2.checked == true)
    {
        if(background_image.value == "")
        {
            window.alert("Please select background image.");
            return false;    
        }
        else
        {
            if(validateFileUpload(background_image)==false)
            {
            window.alert("Please select a valid background image file format(Gif, Jpg, Png)");
            return false;
            }    
        }
   }
}
</script>
</head>
<body onunload="reloadParent()">
<h2>Page Background</h2>
<form id="frmEditPageBackground" method="post" action="<?=base_url().index_page()?>page_editor/updateBackgroundInfo/<?=$site_id?>/<?=$page_id?>" onsubmit="return validate()" enctype="multipart/form-data">
<input type="hidden" name="background_id" value="<?=$background_id?>" />
<input type="hidden" name="background_image" value="<?=$background_image?>" />   
<input type="hidden" id="DateTime" name="DateTime" value="<?=date("his")?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">Background Pattern <span style="color: red">*</span></td>
            <td valign="top">
                <?php
                if($page_background == "Default")
                {
                    $strChecked = 'checked="checked"';
                }
                else
                {
                    $strChecked = "";
                }
                ?>
                <label>
                    <input id="page_background_1" name="page_background" type="radio" value="Default" <?=$strChecked;?> onclick="hideBackgroundUploader()" />
                    Use An Existing Background
                </label>
                <br />
                <?php
                if($page_background == "Other")
                {
                ?>
                    <label>
                        <input type="radio" id="page_background_other" name="page_background" value="<?=$background_image?>" checked="checked"><?=$background_image?></option>
                    </label>
                    <br />
                <?php
                }
                ?>
                <label>
                    <input id="page_background_2" name="page_background" value="Other" type="radio" onclick="showBackgroundUploader()" />
                    Upload Your Own Image (Advance Feature)
                </label>             
                <?=nbs(5);?>
                <?php
                if($page_background == 'Default')
                {
                    $strStyle = 'width: 300px; visibility: hidden; position: absolute;';      
                }
                else
                {
                    $strStyle = 'width: 300px; visibility: visible; position: relative;';    
                }
                ?>            
                <div id="div_background_image" style="<?=$strStyle?>"> 
                <input type="file" id="background_image" name="background_image" />
                <br />
                <strong>Background Area</strong> :
                <br />
                <?php
                if(($page_background == 'Other' && $background_area == 'page') || $page_background == 'Default')
                {
                    $strChecked = 'checked="checked"';    
                }
                else
                {
                    $strChecked = '';    
                }
                ?>
                <label for="background_area_1">
                    <input type="radio" id="background_area_1" name="background_area" value="page" <?=$strChecked?> />
                    Whole Page
                </label>
                <br />
                <?php
                if($page_background == 'Other' && $background_area == 'content')
                {
                    $strChecked = 'checked="checked"';    
                }
                else
                {
                    $strChecked = '';    
                }
                ?>
                <label for="background_area_2">
                    <input type="radio" id="background_area_2" name="background_area" value="content" <?=$strChecked?> />
                    Only Page Content  
                </label>
                <br />
                <br />
                <strong>Background Style</strong> :
                <br />
                <?php
                if(($page_background == 'Other' && $background_style == 'stretch') || $page_background == 'Default')
                {
                    $strChecked = 'checked="checked"';    
                }
                else
                {
                    $strChecked = '';    
                }
                ?>
                <label for="background_style_1">
                    <input type="radio" id="background_style_1" name="background_style" value="stretch" <?=$strChecked?> />
                    Stretch(to fit the area)
                </label>
                <br />
                <?php
                if($page_background == 'Other' && $background_style == 'tile')
                {
                    $strChecked = 'checked="checked"';    
                }
                else
                {
                    $strChecked = '';    
                }
                ?>
                <label for="background_area_2">
                    <input type="radio" id="background_style_2" name="background_style" value="tile" <?=$strChecked?> />
                    Tile(the area)
                </label>
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <br />
                <input type="submit" value="Save Changes" />
            </td>
        </tr>
    </table>    
</form>
</body>
</html>
