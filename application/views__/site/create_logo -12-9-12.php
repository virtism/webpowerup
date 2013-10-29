<script type="text/javascript" language="javascript">
function validateFileUpload(fup)
{    
    var fileName = fup.value;
    
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
    if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "PNG" || ext == "png")
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
    var logo_image = document.getElementById('logo_image');
    if(logo_image.value=='')
    {
        alert('Please select logo file to continue.'); 
        return false;   
    }
    else
    {
        if(validateFileUpload(logo_image)==false)
        {
            window.alert("Please select a valid logo image file format(Gif, Jpg Or Png)");
            return false;
        }
    }
    return true;
}  
function hideBusy()
{
	$("#busy").fadeOut();
}

$(document).ready(function() {
    
	$("#logoUploadForm").submit(function(){
		$("#busy").fadeIn();
	});
	
});
</script>

<style>
.canvas{
	background:#EBEDF2;
	border:solid 1px #D0DAE3;
	width:auto !important;
	height:auto !important;
	float:left;
}
.canvas img{
	padding:5px;
}

.info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
}

.info {
    color: #00529B;
    background-color: #BDE5F8;
}

.success {
    color: #4F8A10;
    background-color: #DFF2BF;
}

.warning {
    color: #9F6000;
    background-color: #FEEFB3;
}

.error {
    color: #D8000C;
    background-color: #FFBABA;
}	
</style>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/SiteLogo.png" alt="SiteLogo"/>
        <span>Create Your Site Logo</span>
    </h1>
    
</div>

<div class="form">
<?php
 if ( $this->session->flashdata('rsp_logo') != "")
 {
		if ( $error == 1 )
		{
			$style = "color:red; border:solid 1px red; padding:5px; margin:5px;";
		}
		else
		{
			$style = "color:green; border:solid 1px green; padding:5px; margin:5px; ";
		}
		?>
		 <div id="response" style=" <?php echo $style; ?> ">
			<?php echo $this->session->flashdata('rsp_logo'); ?>
		</div>
   <?php
   } ?>
     <form class="niceform" method="post" action="<?=base_url().index_page()?>SiteController/save_logo/<?=$site_id?>" onsubmit="return validate()" enctype="multipart/form-data" id="logoUploadForm">
     <input type="hidden" name="site_id" value="<?=$site_id?>" />
     <input type="hidden" name="code" value="<?=$site_id.date('his')?>" />

                <div class="DoubleColumn">
                <div class="ColumnA" style="width:480px;">
                    <ul>
                    <li>
                    <label class="NewsletterLabel">Upload Logo Image: <span class="star">*</span></label>
                    <div style=" float:left; display:inline; width:290px;">
                     <input type="file" name="logo_image" id="logo_image"  />
                     </div>
                     
                     
                     </li>
                      
                    </ul>
                    
                     <div class="ButtonRow">
                    <div style=" width:160px; float:left; min-width:160px;">
                    <br />
                    </div>
                        <button type="submit" >
                            <img src="<?=base_url();?>images/webpowerup/UploadGreen.png" alt="UploadGreen"/>
                        </button>
                    </div>
                </div>
                
                
                <div class="ColumnB" style="width:230px; text-align:right;">
                    <ul>
                    <li>
                     <?php 
					 if($logo != "") 
					 { ?>
        				<div class="canvas">
                    	<img class="logo" src="<?=base_url()?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/images/<?=$logo?>" alt="Logo" />
                        </div>
                     <?php 
					 } ?>
                    </li>
                    </ul>
                </div>
             
            </div>
            
     </form>
     </div>


<script type="text/javascript" language="javascript">
    //jquery for file upload control
    $('div.uploader input').change(function() {
        $(this).parent().find('span.filename').text(this.value) ; 
    });    
</script>