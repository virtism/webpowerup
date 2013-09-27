<html>

<head>

<title>Edit Page Header</title> 

<style type="text/css">
code
{
    font-size: 11px;
    color: red;
}
</style>                          
                        
<script language="javascript" type="text/javascript" src="<?=base_url();?>js/jquery-1.5.1.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url();?>js/jscolor/jscolor.js"></script>
 
<script type="text/javascript" language="javascript">

$(document).ready(function(){
    
    $('#page_header_1').click(function(){
        $('#hdr_bg_area').slideUp('slow');  
        $('#div_header_image').slideUp('slow');
        $('#div_slideshow_image').slideUp('slow');  
    });
    
    $('#page_header_2').click(function(){
        $('#hdr_bg_area').slideDown('slow');  
        $('#div_header_image').slideDown('slow');
        $('#div_slideshow_image').slideUp('slow');  
    });
    
    $('#page_header_3').click(function(){
        $('#hdr_bg_area').slideDown('slow');   
        $('#div_header_image').slideUp('slow'); 
        $('#div_slideshow_image').slideDown('slow'); 
    });
    $('#header_background_1').click(function(){
        $('#color').slideUp('slow');   
        $('#hdr_bg_img').slideUp('slow');    
    });
    $('#header_background_2').click(function(){
        $('#color').slideDown('slow');
        $('#hdr_bg_img').slideUp('slow');       
    });
    $('#header_background_3').click(function(){
        $('#color').slideUp('slow');
        $('#hdr_bg_img').slideDown('slow'); 
    });
    
});

var numSliderImages = <?=$slideshow_header_image->num_rows()?>;

function delete_slider_image(slider_images_row, id)
{
    bool = confirm("Are you sure to delete this header image?");
    if(bool == true)
    {
        numSliderImages--;
        $(slider_images_row).fadeOut('slow'); 
        $.ajax({
        url: "<?=base_url().index_page()?>pagesController/deleteHeader/"+id,
        success: function(data){
            }
        }); 
        if(numSliderImages==0)
        {
            $('#slideshow_header_image_exist').val('');
            $('#page_header_1').click();    
        }
    }
    else
    {
        return;
    }    
}

countHeaderImages = 0;

function addMore()
{
    countHeaderImages++;
    var numHeaderImages = document.getElementById('numHeaderImages');         
    numHeaderImages.value++;    
    var tbl = document.getElementById('tbl_header_images');
    var lastRow = tbl.rows.length;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = countHeaderImages+':';
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<input type="file" id="header_image_'+countHeaderImages+'" name="header_image_'+countHeaderImages+'" />';  
    var cell3 = row.insertCell(2);
    cell3.innerHTML = '<label class="messages" id="page_header_slider_image_message'+countHeaderImages+'"></label>';
}
function validateFileUpload(fup)
{    
    var fileName = fup.val();
    
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
    submitFlag = true;
    
    $('label.messages').empty();
    
    if($('#page_header_2').is(':checked')==true && $('#other_header_image_exist').val()=='')
    {
        if($('#header_image').val()=='')
        {
            $('#page_header_image_message').html('<code>Please select header image.</code>');
            submitFlag = false;          
        }  
        else
        {
            if(validateFileUpload($('#header_image'))==false) 
            {
                $('#page_header_image_message').html('<code>Invalid header image(Gif, Jpg, Png)</code>');
                submitFlag = false;              
            }   
        }  
    }
    
    if($('#page_header_2').is(':checked')==true && $('#other_header_image_exist').val()!='' && $('#header_image').val()!='')
    {
        if(validateFileUpload($('#header_image'))==false) 
        {
            $('#page_header_image_message').html('<code>Invalid header image(Gif, Jpg, Png)</code>'); 
            submitFlag = false;              
        }   
    }
    
    if($('#page_header_3').is(':checked')==true && $('#slideshow_header_image_exist').val()=='') 
    {
        if(countHeaderImages==0)
        {
            $('#page_header_slider_message').html('<code>Please select slideshow header images.</code>');
            submitFlag = false;              
        }
        else
        {
            flagSelected = false;
            for(i=1;i<=countHeaderImages;i++)
            {
                var slideshow_header_image = $("#header_image_"+i);
                
                if(slideshow_header_image.val() != "")
                {
                    flagSelected = true;   
                }    
            }
            if(flagSelected == false)
            {
                $('#page_header_slider_message').html('<code>Please select slideshow header images.</code>');      
                submitFlag = false;                 
            }
            
            for(i=1;i<=countHeaderImages;i++)
            {
                var slideshow_header_image = $("#header_image_"+i);
                if(slideshow_header_image.val() != "")
                {
                    flagFile = validateFileUpload(slideshow_header_image);
                    if(flagFile == false)
                    {
                        $('#page_header_slider_image_message'+i).html('<code>Invalid Image format(Gif, Jpg, Png).</code>');
                        submitFlag = false;                     
                    }    
                }             
            }    
        }
        
    }
    
    if($('#page_header_3').is(':checked')==true && $('#slideshow_header_image_exist').val()!='')
    {
        flagSelected = false;
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = $("#header_image_"+i);
            
            if(slideshow_header_image.val() != "")
            {
                flagSelected = true;   
            }    
        }
        if(flagSelected == false)
        {
            $('#page_header_slider_message').html('<code>Please select slideshow header images.</code>');      
            submitFlag = false;                 
        }
        
        for(i=1;i<=countHeaderImages;i++)
        {
            var slideshow_header_image = $("#header_image_"+i);
            if(slideshow_header_image.val() != "")
            {
                flagFile = validateFileUpload(slideshow_header_image);
                if(flagFile == false)
                {
                    $('#page_header_slider_image_message'+i).html('<code>Invalid Image format(Gif, Jpg, Png).</code>');
                    submitFlag = false;                     
                }    
            }             
        }    
    }
    
    if(($('#page_header_3').is(':checked')==true || $('#page_header_2').is(':checked')==true) && $('#header_background_3').is(':checked')==true && $('#header_background_image_exist').val()=="")
    {
        if($('#header_background_image').val()== "")
        {
            $('#header_background_image_message').html('<code>Please select header background image.</code>'); 
            submitFlag = false;                 
        }
         else
         {
            flagFile = validateFileUpload($('#header_background_image'));
            if(flagFile == false)
            {
                $('#header_background_image_message').html('<code>Invalid Backgrond Image(Gif, Jpg or Png).</code>');     
                submitFlag = false;                     
            } 
         }
    } 
    
    if(($('#page_header_3').is(':checked')==true || $('#page_header_2').is(':checked')==true) && $('#header_background_3').is(':checked')==true && $('#header_background_image_exist').val()!="")
    {
        if($('#header_background_image').val() != "")
        {
            flagFile = validateFileUpload($('#header_background_image'));
            if(flagFile == false)
            {
                $('#header_background_image_message').html('<code>Invalid Backgrond Image(Gif, Jpg or Png).</code>'); 
                submitFlag = false;    
            }
        }
    }
    
    return submitFlag; 
    
}
</script>
</head>
<body>

<h1>Page Header</h1>

<form id="frmEditPageHeader" method="post" action="<?=base_url().index_page()?>page_editor/updateHeaderInfo/<?=$site_id?>/<?=$page_id?>" onsubmit="return validate()" enctype="multipart/form-data">
    
    <input type="hidden" id="numHeaderImages" name="numHeaderImages" value="0" />
    
    <input type="hidden" name="fancy" value="1" />
    
    <?php
    $other_header_image_exist = '';
    if($other_header_image->num_rows() > 0)
    {
        $other_header_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="other_header_image_exist" name="other_header_image_exist" value="<?=$other_header_image_exist?>" />
    
    <?php
    $slideshow_header_image_exist = '';
    if($slideshow_header_image->num_rows() > 0)
    {
        $slideshow_header_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="slideshow_header_image_exist" name="slideshow_header_image_exist" value="<?=$slideshow_header_image_exist?>" />
    
    <?php
    $header_background_image_exist = '';
    if($header_background_image!='')
    {
        $header_background_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="header_background_image_exist" name="header_background_image_exist" value="<?=$header_background_image_exist?>" />
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="25%" valign="top"><b>Select Header <span style="color: red">*</span></b></td>
        <td valign="top">
            <input type="hidden" id="DateTime" name="DateTime" value="<?=date("his")?>" />
            
            <?php
            $strChecked = '';
            if($page_header == "Default")
            {
                $strChecked = 'checked="checked"'; 
            }
            ?>
            <input id="page_header_1" name="page_header" type="radio" value="Default" <?=$strChecked;?> />
            <label for="page_header_1">Use Default Banner</label>
            
            <br />
            <?php
            $strChecked = '';
            if($page_header == 'Other')
            {
                $strChecked = 'checked="checked"';
            }
            ?>
            <input id="page_header_2" name="page_header" type="radio" value="Other" <?=$strChecked?> />
            <label for="page_header_2">Display An Image As Header</label>  
            <?php
            if($other_header_image->num_rows > 0)
            {
                foreach($other_header_image->result_array() as $row_other_header_info)
                {
            ?>
                <br />
                <?=nbs(6);?><?=$row_other_header_info['header_image']?>
            <?php 
                }
                ?>
                <div id="div_header_image" style="display: block;">
                    <?=nbs(6);?><input type="file" id="header_image" name="header_image" style="margin-top: 5px;" />
                    <label class="messages" id="page_header_image_message"></label>  
                </div>
            <?php   
            }
            else
            {
            ?>
            <div id="div_header_image" style="display: none;">
                <?=nbs(6);?><input type="file" id="header_image" name="header_image" style="margin-top: 5px;" />
                <label class="messages" id="page_header_image_message"></label>  
            </div>
            <?php    
            }
            ?>                
            
            <?php
            $strChecked = '';
            $strDisplay = 'display: none;';
            if($page_header == "Slideshow")
            {
                $strChecked = 'checked="checked"';
                $strDisplay = 'display: block;';    
            }
            ?>
            <br />
            <label>
                <input type="radio" id="page_header_3" name="page_header" value="Slideshow" <?=$strChecked?> />
                Slideshow Header
                <label class="messages" id="page_header_slider_message"></label>  
            </label>
            <div id="div_slideshow_image" style="width: 500px;<?=$strDisplay?>">
                <?php 
                if($slideshow_header_image->num_rows > 0)
                {
                ?>
                <table id="tbl_header_images" border="0" width="100%"> 
                <?php
                    foreach($slideshow_header_image->result_array() as $row_slideshow_header_image)
                    {    
                ?>
                    <tr>
                        <td><?=nbs(1)?></td>
                        <td>
                            <?=$row_slideshow_header_image["header_image"]?> &nbsp; &nbsp;<img src="<?=base_url();?>/images/icon-delete.png" onclick="delete_slider_image($(this).parent().parent(), <?=$row_slideshow_header_image['header_id']?>)" />
                        </td>
                    </tr>
                <?php
                    }
                ?>
                    <tr>    
                        <td colspan="2">
                            <?=nbs(6)?><a style="font-size: 12px" href="javascript:void(0);" onclick="addMore()">Upload Image(s)</a>
                        </td>
                    </tr>
                </table>
                <?php
                }
                else
                {
                ?>
                <table id="tbl_header_images" border="0" width="100%">
                    <tr>
                        <td colspan="3">
                            <?=nbs(6)?><a style="font-size: 12px" href="javascript:void(0);" onclick="addMore()">Upload Image(s)</a>
                        </td>
                    </tr>
                </table>
                <?php
                }
                ?>
            </div>
            </td>
        </tr>
        </td>
    </tr>
    <tr>    
        <td colspan="2" valign="top">
            <?php
            $strStyle = 'style="display: none;"';    
            if($page_header != 'Default')
            {
                $strStyle = 'style="display: block;"';
            }
            ?>
            <div id="hdr_bg_area" <?=$strStyle?>>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" width="25%"><br /><b>Header Background <span style="color: red">*</span></b></td>
                        <td valign="top">
                            <br />
                            <?php
                            $strChecked = '';     
                            if($header_background == 'Default' || $header_background == '')
                            {
                                $strChecked = 'checked="checked"';
                            }
                            ?>
                            <label>
                                <input type="radio" id="header_background_1" name="header_background" value="Default" <?=$strChecked?> />Default
                            </label>
                            <br />
                            <?php
                            $strChecked = ''; 
                            $strDisplay = 'display: none;';
                            if($header_background != 'Default' && $header_background != 'Image')
                            {
                                $strChecked = 'checked="checked"';
                                $strDisplay = 'display: block;';
                            }
                            ?>
                            <label>
                                <input type="radio" id="header_background_2" name="header_background" value="Color" onclick="document.getElementById('color_picker').focus();" <?=$strChecked?> />Select Color:
                            </label>
                            <br />
                            <div id="color" style="<?=$strDisplay?> margin: 5px 0 0 20px;">
                                <input id="color_picker" class="color" name="header_background_color" onclick="document.getElementById('header_background_2').checked=true;" value="<?=$header_background?>" />        
                            </div>
                            <?php
                            if($header_background == 'Image')
                            {
                                $strChecked = 'checked="checked"';
                            }
                            else
                            {
                                $strChecked = '';    
                            }
                            ?>
                            <label>
                                <input type="radio" id="header_background_3" name="header_background" value="Image" <?=$strChecked?> />Header Background Image(Tile)
                            </label>
                            <?php
                            if($header_background == 'Image')
                            {
                            ?>
                                <br />
                                <?=nbs(5)?><?=$header_background_image?>
                            <?php
                            }
                            ?>
                            <div id="hdr_bg_img" style="display: none;height: 25px;">
                                <?=nbs(5)?><input type="file" id="header_background_image" name="header_background_image" onclick="document.getElementById('header_background_3').checked=true;" style="margin-top: 5px;"  />
                                <label class="messages" id="header_background_image_message"></label>
                            </div> 
                            
                        </td>
                    </tr>
                </table>
            </div>
            
        </td>
    </tr>
    <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">
            <br /><input type="button" value="Cancel" onclick="parent.$.fancybox.close();" />
            <input type="submit" value="Update" />
        </td>
    </tr>
</table>
</form>

<!--

<form id="frmEditPageHeader" method="post" action="<?=base_url().index_page()?>page_editor/updateHeaderInfo/<?=$site_id?>/<?=$page_id?>" onsubmit="return validate()" enctype="multipart/form-data">
    
    <input type="hidden" id="numHeaderImages" name="numHeaderImages" value="0" />
    <?php
    $other_header_image_exist = '';
    if($other_header_image->num_rows() > 0)
    {
        $other_header_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="other_header_image_exist" name="other_header_image_exist" value="<?=$other_header_image_exist?>" />
    <?php
    $slideshow_header_image_exist = '';
    if($slideshow_header_image->num_rows() > 0)
    {
        $slideshow_header_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="slideshow_header_image_exist" name="slideshow_header_image_exist" value="<?=$slideshow_header_image_exist?>" />
    <?php
    $header_background_image_exist = '';
    if($header_background_image!='')
    {
        $header_background_image_exist = 'set';    
    }
    ?>
    <input type="hidden" id="header_background_image_exist" name="header_background_image_exist" value="<?=$header_background_image_exist?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">Page Header <span style="color: red">*</span></td>
            <td valign="top">
                <input type="hidden" id="DateTime" name="DateTime" value="<?=date("his")?>" />
                <label>
                    <?php
                    if($page_header == "Default")
                    {
                        $strChecked = 'checked="checked"'; 
                    }
                    else
                    {
                        $strChecked = "";
                    }
                    ?>
                    <input id="page_header_1" name="page_header" type="radio" value="Default" <?=$strChecked;?> onclick="selectHeader(this)" />
                    USE DEFAULT BANNER
                </label>
                <br />
                <?php
                if($page_header == 'Other')
                {
                    $strChecked = 'checked="checked"';
                }
                else
                {
                    $strChecked = '';
                }
                ?>
                <label>
                    <input id="page_header_2" name="page_header" type="radio" value="Other" onclick="selectHeader(this)" <?=$strChecked?> />
                    (Other) Display An Image As Header
                </label>
                
                <?php
                if($other_header_image->num_rows > 0)
                {
                    foreach($other_header_image->result_array() as $row_other_header_info)
                    {
                ?>
                    <br />
                    <?=$row_other_header_info['header_image']?>
                <?php 
                    }
                    ?>
                    <?=nbs(5);?>
                    <div id="div_header_image">
                        <input type="file" id="header_image" name="header_image" />
                    </div>
                <?php   
                }
                else
                {
                ?>
                <br />
                Upload A Header Image
                <?=nbs(5);?>
                <div id="div_header_image">
                    <input type="file" id="header_image" name="header_image" />
                </div>
                <?php    
                }
                ?>                
                
                <?php
                $strChecked = '';
                if($page_header == "Slideshow")
                {
                    $strChecked = 'checked="checked"';    
                }
                ?>
                <br />
                <label>
                    <input type="radio" id="page_header_3" name="page_header" onclick="selectHeader(this)"  value="Slideshow" <?=$strChecked?> />
                    Slideshow Header
                </label>
                <div id="div_slideshow_image" style="width: 300px;">
                <?php 
                if($slideshow_header_image->num_rows > 0)
                {?>
                <table id="tbl_header_images" border="0"> 
                <?php
                    foreach($slideshow_header_image->result_array() as $row_slideshow_header_image)
                    {    
                ?>
                    <tr>
                        <td>
                            <?=$row_slideshow_header_image["header_image"]?>                                    
                        </td>
                        <td>
                            <img src="<?=base_url();?>/images/icon-delete.png" onclick="deleteRow(this.parentNode.parentNode.rowIndex, <?=$row_slideshow_header_image['header_id']?>)" />
                        </td>
                    </tr>
                <?php
                    }
                ?>
                    <tr>
                        <td colspan="2">
                            <a href="javascript:void(0);" onclick="addMore()">Add More Images</a>
                        </td>
                    </tr>
                </table>
                <?php
                }
                else
                {
                ?>
                <table id="tbl_header_images" border="0">
                    <tr>
                        <td colspan="2">
                            <a href="javascript:void(0);" onclick="addMore()">Add Images</a>
                        </td>
                    </tr>
                </table>
                <?php
                }?>
                </div>
            </td>
        </tr>
        <?php
        if($page_header != 'Default')
        {
            $strStyle = 'style="visibility: visible; position: relative;"';
        }
        else
        {
            $strStyle = 'style="visibility: hidden; position: absolute;"';    
        }
        ?>
        <tr id="tr_header_bg" <?=$strStyle?>>
        <td valign="top"><br />Header Background <span style="color: red">*</span></td>
        <td><br />
            <?php
            if($header_background == 'Default' || $header_background == '')
            {
                $strChecked = 'checked="checked"';
            }
            else
            {
                $strChecked = '';
            }
            ?>
            <label>
                <input type="radio" id="header_background_1" name="header_background" value="Default" <?=$strChecked?> />Default
            </label>
            <br />
            <?php
            if($header_background != 'Default' && $header_background != 'Image')
            {
                $strChecked = 'checked="checked"';
            }
            else
            {
                $strChecked = '';
            }
            ?>
            <label>
                <input type="radio" id="header_background_2" name="header_background" value="Color" onclick="document.getElementById('color_picker').focus();" <?=$strChecked?> />Select Color:
            </label>
            <br />
            <div id="color" style="margin: 5px 0 5px 20px">
                <input id="color_picker" class="color" name="header_background_color" onclick="document.getElementById('header_background_2').checked=true;" value="<?=$header_background?>" />        
            </div>
            <?php
            if($header_background == 'Image')
            {
                $strChecked = 'checked="checked"';
            }
            else
            {
                $strChecked = '';    
            }
            ?>
            <label>
                <input type="radio" id="header_background_3" name="header_background" value="Image" <?=$strChecked?> />Header Background Image(Tile)
            </label>
            <br />
            <?php
            if($header_background == 'Image')
            {
            ?>
            <?=$header_background_image?>
            <br />
            <?php
            }
            ?> 
            <input type="file" id="header_background_image" name="header_background_image" onclick="document.getElementById('header_background_3').checked=true;"  />
            
        </td>
    </tr>
    <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">
            <br />
            <input type="submit" value="Update" />      
        </td>
    </tr>
    </table>
</form>
-->

</body>
</html>
