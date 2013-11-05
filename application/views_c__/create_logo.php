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

<div >

	<?php echo($this->breadcrumb->output()); ?>

</div>

<form method="post" action="<?=base_url().index_page()?>SiteController/save_logo/<?=$site_id?>" onsubmit="return validate()" enctype="multipart/form-data" id="logoUploadForm">



    <fieldset>

        <input type="hidden" name="site_id" value="<?=$site_id?>" />

        <input type="hidden" name="code" value="<?=date('his')?>" />

         <label>Create Your Site Logo</label>

         

        <?php 

		

		if($logo != "") 

		{ ?>

        

            <div class="section">

                <label>Your current site Logo</label>

                <div>

                    <img src="<?=base_url(); ?>headers/<?php echo $logo; ?>" alt="Your current site logo"  />  

                </div>

            </div>

        

        <?php 

		} ?>

        

       

        

        <div class="section">

            <label>Upload Logo Image <span class="required">&nbsp;</span></label>

            <div>

             		<div id="busy" style="display:none; margin:5px;">

                    	<img src="<?=base_url(); ?>/images/clock.gif" />

                    </div>

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

            

                <div class="uploader" style="width: 181px;">

                    <input type="file" name="logo_image" id="logo_image" size="19" style="opacity: 0;">

                    <span class="filename" style="-moz-user-select: none;">No file selected</span>

                    <span class="action" style="-moz-user-select: none;">Choose File</span>

                    

                </div>

                

            </div>

           

        </div>   

        

        <div class="section">

            <div>

                <input type="submit" value="UPLOAD" />

            </div>

        </div>
        
        <div class="section">

                <label>Published ??</label>

                <div>
      <? 
	  if(isset($logo_view['publish']) && $logo_view['publish'] == "Yes")
		{
	  ?>
                   <input type="checkbox" name="logo_check" id="logo_check" value="Yes" checked="checked"/> Yes 
<? } else {?>
              <input type="checkbox" name="logo_check" id="logo_check" value="Yes"/> Yes 
              <? }?>
                </div>

            </div>

     
           <div class="section">

            <div>

                <input type="submit" value="save" name="save_publish" />

            </div>

        </div>

    </fieldset>

</form>



<script type="text/javascript" language="javascript">

    //jquery for file upload control

    $('div.uploader input').change(function() {

        $(this).parent().find('span.filename').text(this.value) ; 

    });    

</script>