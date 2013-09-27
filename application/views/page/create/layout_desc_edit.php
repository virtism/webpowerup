<script src="<?=base_url()?>js/jquery-1.5.1.min.js" type="text/javascript" language="javascript"></script> 
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>   
<?php /*?><script src="http://connect.facebook.net/en_US/all.js"></script><?php */?>   
<script language="javascript" type="text/javascript">

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
    cell1.innerHTML = '<label for="header_image_'+countHeaderImages+'">Image '+countHeaderImages+'</label>';
    var cell2 = row.insertCell(1);
    
	// cell2.innerHTML = '<input type="file" id="header_image_'+countHeaderImages+'" name="header_image_'+countHeaderImages+'" />';              
    cell2.innerHTML = '<input type="file" name="header_image_'+countHeaderImages+'" id="header_image_'+countHeaderImages+'" size="35" />'
	
	
	var cell3 = row.insertCell(2);
    cell3.innerHTML = '<label class="messages" id="header_slideshow_image_message'+countHeaderImages+'"></label>'; 
	NFFix();	
}


$(document).ready(function(){
    
    
        
});

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
    
    $('.messages').empty();
    
    if($('#page_header_2').is(':checked')==true)
    {
        if($('#header_image').val()=='')
        {
            $('#header_image_message').html('<code>Please select header image.</code>');
            submitFlag = false;         
        }   
        else
        {
            if(validateFileUpload($('#header_image'))==false)
            {
                $('#header_image_message').html('<code>Invalid header image file format(Gif, Jpg Or Png)</code>'); 
                submitFlag = false; 
            }
        }
    }
    
    if($('#page_header_3').is(':checked')==true)
    {
        flagSelected = false;
        for( i=1; i<=countHeaderImages; i++ )
        {
            if($('#header_image_'+i).val()!="")
            {
                flagSelected = true;   
            }    
        }
        
        if(flagSelected == false)
        {
            $('#header_slideshow_message').html('<code>Please select Slideshow header images.</code>');
            submitFlag = false; 
        }  
        
        for( i=1; i<=countHeaderImages; i++ )
        {
            
            if($('#header_image_'+i).val() != "")
            {
                flagFile = validateFileUpload($('#header_image_'+i));
                if(flagFile == false)
                {
                    $('#header_slideshow_image_message'+i).html('<code>Invalid Header Image(Gif, Jpg or Png).</code>');
                    submitFlag = false;     
                }    
            }             
        }
          
    }
    
    if($('#header_background_3').is(':checked')==true)
    {
        if($('#header_background_image').val()=='')
        {
             $('#header_background__message').html('<code>Please select header background image.</code>'); 
             submitFlag = false; 
        }
         else
         {
            if(validateFileUpload($('#header_background_image'))==false)
            {
                $('#header_background__message').html('<code>Invalid header background image(Gif, Jpg Or Png)</code>');
                submitFlag = false; 
            }           
        }        
    }
    
   if($('#page_status_3').is(':checked')==true)
   {
        if($('#page_start_date').val()=='' || $('#page_end_date').val()=='')
        {
            $('#page_pub_date_message').html('<code>Please select Start and/or End Date/Time for this page.</code>');
            submitFlag = false;     
        }   
        else
        {
            var splitString = $('#page_start_date').val().split("-");

            date1 = splitString[0];
            month1 = splitString[1];
            year1 = splitString[2].substring(0, 4);       

            var splitString = $('#page_end_date').val().split("-");        
            date2 = splitString[0];
            month2 = splitString[1];
            year2 = splitString[2].substring(0, 4);

            date1 = new Date(year1, month1, date1);
            date2 = new Date(year2, month2, date2); 
               if(date1>date2)
               {
                    $('#page_pub_date_message').html('<code>Start Date/Time should be earlier then End Date/Time.</code>');    
                    submitFlag = false; 
               } 
            }
        } 
        
        if($('#page_background_2').is(':checked')==true)
        {
            if($('#background_image').val()=='')
            {
                $('#page_background_message').html('<code>Please select page background image.</code>');
                submitFlag = false;    
            }
            else
            {
                if(validateFileUpload($('#background_image'))==false)
                {
                    $('#page_background_message').html('<code>Invalid page background(Gif, Jpg Or Png)</code>');  
                    submitFlag = false;        
                }    
            }
        }
   
    return submitFlag;
    
}
function onFacebookLoginStatus(response)
{   
	if (response.authResponse)
	  { 
	 	 var query = FB.Data.query('SELECT uid, first_name, last_name, email, sex, pic_square, timezone, birthday_date, current_location FROM user WHERE uid = me()', response.authResponse.id);
		query.wait(function(rows) { 
		
		 console.log('fName : '+ rows[0].first_name);
		 console.log('Email : ' +rows[0].email);
		 console.log('User Id:' +rows[0].uid);
		 console.log('LasName:' +rows[0].last_name);
		 console.log('sex:' +rows[0].sex);
		 console.log('Birthday:' +rows[0].birthday_date);
		
			var userId = rows[0].uid;     //user id which is unique to every user
			var fname = rows[0].first_name  //split it to make username
			//var userName = fname+ userId.substring(0,8);  //unique username for every incoming user
			var email = rows[0].email;
			var password = "1234";
			var surname = rows[0].last_name;
			var sex = rows[0].sex;

			if($("#fb_status").val() != "What is in your mind?")
			{
				str_text = $("#fb_status").val();		
			}
			else
			{
				str_text = "GWS is sharing a Link With You.";	
			}
			
			site_id = $('#fb_site_id').val();
			page_id = $('#fb_page_id').val();
			
			str_link = "<?=base_url().index_page()?>site_preview/page/"+site_id+"/"+page_id;

				
			var body = str_text+" "+str_link; 
		  
				// logged in and connected user, someone you know
			  	FB.getLoginStatus(function(response) {
			  if (response.authResponse) {
				// logged in and connected user, someone you know
			  FB.api('/'+userId+'/feed', 'post', { message: body }, function(response) {       
								if (!response || response.error) {
									alert('There is some Techinal Error Occured Please Try Some Later!'); 
								} else {
									alert('Request is Successfully Processed.');
								}
							});  
			  } else {
				// no user session available, someone you dont know
				 alert("yor are not with facebook connected");
			  }
			});        
			  
			 
				
			
		//  var dataString = 'facebook_userId='+userId+'&email='+ email+'&userName='+userName+'&fName='+fname+'&lName='+surname+'&sex='+sex+'&password='+password;
			 //  var path='<?=base_url().index_page()?>html5/login';
			   //alert(dataString)
			  //alert(path)
			/* $.ajax({
			type: "POST",
			url: path,
			data: dataString, 
			async : false,
			success: function(data) {
			 
					alert("data is saved via ajax");
					 var body = "you can get free 1GB online storage, Please click on this link: http://www.cloudify.in"  ;
			FB.getLoginStatus(function(response) {
			  if (response.authResponse) {
				// logged in and connected user, someone you know
			  FB.api('/'+f_id+'/feed', 'post', { message: body }, function(response) {       
								if (!response || response.error) {
									alert('Error occured');
								} else {
									alert('Successfully added 10MB in your storage quato');
								}
							});  
			  } else {
				// no user session available, someone you dont know
				 alert("yor are not with facebook connected");
			  }
			});        
			
			
				},
			error:function(){
				alert('Problem in your connection');
				}
			});*/
		  
		 });                      
	  }
	  else
	  {
		console.log('User cancelled login or did not fully authorize.');
	  }
}

function fblogin(){
// document.getElementById('loading').style.display='block';
	  FB.init({ 
			appId:'293519274018980', cookie:true, 
			status:true, xfbml:true });   
	  
	 
	  FB.api('/me', function(response) {
			   
			   FB.login(onFacebookLoginStatus, {scope: 'email,publish_stream,user_birthday,user_location' });
		  });    
}
function fb_authentication(element)
{
	//alert(element);
	if ($('#'+element.id).attr('checked'))
	{
		//alert("ok");	
		fblogin();
	}
	else
	{
		//alert("not required");
	}

}
function check_value(obj, text, valCheck)
{
	var objValue = obj.value;
	if(valCheck != objValue)
	{
		if(objValue.length == 0)
		{
		
			$(obj).css("border","solid 1px #e1e1e1");
			obj.value = text;
		}
		
	}
	else
	{
		if(valCheck == "")
		{
			//$(obj).css("border","solid 1px #FF0000");
		}
		else
		{
			$(obj).css("border","solid 1px #e1e1e1");
		}

		obj.value = text;
	}	
}



$(".NFCheck").live("click",function(){

	var id = $(this).next("input").attr("id");
	if(id == 'page_temp_on')
	{
		if(document.getElementById('page_temp_on').checked)
		{ 
			$('#temp_option_name_field').show();
		}
		else
		{
			$('#temp_option_name_field').hide();
		}	
	}
	
	
});

$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	//alert(id);
	
	if( id == "page_header_1")
	{
        $('#div_header_image').fadeOut('slow');
        $('#div_slideshow_image').fadeOut('slow');
        $('#tr_header_bg').fadeOut('slow'); 
    }
    
	if( id == "page_header_2")
	{
		$('#div_header_image').fadeIn('slow');
		$('#tr_header_bg').fadeIn('slow');
		$('#div_slideshow_image').fadeOut('slow'); 
	}
    
	if( id == "page_header_3")
	{
        $('#div_header_image').fadeOut('slow');
        $('#div_slideshow_image').fadeIn('slow'); 
        $('#tr_header_bg').fadeIn('slow');
	}
    
	if( id == "page_status_1")
	{
		$('#schedular').fadeOut('slow');
	}
	if( id == "page_status_2")
	{
        $('#schedular').fadeOut('slow');
    }
	if( id == "page_status_3")
	{
        $('#schedular').fadeIn('slow'); 
    }
	
	if( id == "page_background_1")
	{
        $('#div_background_image').fadeOut('slow');
        $('#div_background_style').fadeOut('slow');
        $('#div_background_area').fadeOut('slow');
    }
	
	if( id == "page_background_2")
	{
        $('#div_background_image').fadeIn('slow');
        $('#div_background_style').fadeIn('slow');
        $('#div_background_area').fadeIn('slow');
    }
	
	if( id == "header_background_1")
	{
        $('#hdr_db_uploader').fadeOut('slow');
    }
	
	if( id == "header_background_2")
	{
        $('#hdr_db_uploader').fadeOut('slow');
    }
	
	if( id == "header_background_3")
	{
        $('#hdr_db_uploader').fadeIn('slow'); 
    }
	
});

$("img.NFCheck").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	
});

</script>


<div class="RightColumnHeading">
    <h1>
        <span>Create a New Page : Layout Description (Step 4)</span>
    </h1>
</div>
<div class="clr"></div>

<div id="fb-root"></div> 

<div class="InnerMain">
<form id="frmLayout" name="frmLayout" enctype="multipart/form-data" method="post" action="<?=base_url().index_page()?>pagesController/upadte_upload_page_layout_desc" onSubmit="return validate()" class="niceform">
    
    <fieldset>
    
      <input type="hidden" id="fb_site_id" name="site_id" value="<?=$site_id?>" />
		
		<input type="hidden" id="fb_page_id" name="page_id" value="<?=$page_id?>" />
        
        <input type="hidden" id="numHeaderImages" name="numHeaderImages" value="3" />
        
        <input type="hidden" name="DateTime" value="<?=date("ymdhis");?>" />
    
        <label></label>
        <!---- Page Template Section ------->
             <dl>
            <dt style="width:400px !important">
                 <label for="" class="NewsletterLabel">Change in template will apply on all pages.</label>
            </dt>
            </dl>
		<dl>
            <dt>
                 <label for="" class="NewsletterLabel">Select Page Template</label>
            </dt>
            <dd>
            	<div  style=" position:relative; margin-left:10px;">
                    <select size="1" name="page_template_options" id="page_template_options" id=""  style="width:200px;"> 
                            <option value="0">Select Template</option>
                            <?
							if(isset($template_page_names)) 
							{
							foreach($template_page_names as $temps)
							{
                                
                                if($item_id == $temps['id'])
                                {
							?>
                            <option value="<?=$temps['page_id']?>" selected="selected"><?=$temps['temp_option_name_field']?></option> 
                            <?php
                                }
                                else{ ?>
                                <option value="<?=$temps['page_id']?>" ><?=$temps['temp_option_name_field']?></option> 
   
                             <?   }
                            } 
							
							} ?>
                   </select>
                </div>

            </dd>
        </dl>
		<!---- Page Template Section ------->
            
        <!---->
        <dl>
            <dt>
                 <label for="" class="NewsletterLabel">Select Page Header <span class="star">*</span></label>
            </dt>
            <dd>
            <? //echo '<pre>';print_r($editlayot[0]);?>
            	<input id="page_header_1" name="page_header" type="radio" value="Default" checked="checked" />
                <label class="check_label" >Use default</label>
   
                <input id="page_header_2" name="page_header" type="radio" value="Other" />
                <label class="check_label" >Upload a Header Image</label>
                
                <input type="radio" id="page_header_3" name="page_header" value="Slideshow" />
                <label class="check_label" >Create Slideshow Header</label>
                
                <div id="div_header_image" style="display: none; margin:10px 0 0 0; ">
                	<input type="file" name="header_image" id="header_image" size="35" />
                    <span id="header_image_message"></span>
                </div>
               
                
                <div id="div_slideshow_image" style=" display: none; margin-top: 10px;">
                    <table id="tbl_header_images" border="0" width="100%">
                        <tr>
                            <td align="center" width="10%"><label for="">Image 1</label></td>
                            <td width="25%"> 
                               <input type="file" name="header_image_1" id="header_image_1" size="35" />
                            </td>
                            <td>
                                <span id="header_slideshow_image_message1"></span>
                                <span id="header_slideshow_message"></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><label for="">Image 2</label></td>
                            <td>
                               <input type="file" name="header_image_2" id="header_image_2" size="35" />
                            </td>
                            <td>
                            <span id="header_slideshow_image_message2"></span></td>
                        </tr>
                        <tr>
                            <td align="center"><label for="">Image 3</label></td>
                            <td>
                                <input type="file" name="header_image_3" id="header_image_3" size="35" />
                            </td>
                            <td><span id="header_slideshow_image_message3"></span></td>
                        </tr>                            
                    </table>
                    <a href="javascript: void(0);" onClick="addMore()">Add More Images</a>
                    
                </div>
                
            </dd>
        </dl>
        <!---->
        <div id="tr_header_bg" style="display:none;">
        <dl>
            <dt>
                 <label for="" class="NewsletterLabel"> Header Background<span class="star">*</span></label>
            </dt>
            <dd>
                <input type="radio" id="header_background_1" name="header_background" value="Default" checked="checked" />
                <label class="check_label" >Use default</label>
                <br><br>
 
                <input type="radio" id="header_background_2" name="header_background" value="Other" onClick="document.getElementById('color_picker').focus();" />
                <label class="check_label" >Select Color</label>
                <input id="color_picker" class="color" name="header_background_color" style="margin-top: 10px;" /> 
                
                <br><br><br>
                <input type="radio" id="header_background_3" name="header_background" value="Image" />
                <label class="check_label" >Upload Header Background Image</label>
                
                <div id="hdr_db_uploader" style="display: none; margin:10px 0 0 0;">
                	<input type="file" name="header_background_image" id="header_background_image" size="35" />
                </div>
            </dd>
        </dl>
        </div>
        
        <dl>
               <dt>
                    <label for="" class="NewsletterLabel"> Choose Background Pattern<span class="star">*</span></label>
               </dt>
               <dd>
                    <input id="page_background_1" name="page_background" type="radio" value="Default" onClick="hideBackgroundUploader()" checked="checked" />
                    <label class="check_label" >Use existing Background</label>
                    
                    <input id="page_background_2" name="page_background" value="Other" type="radio" onClick="showBackgroundUploader()" />
                    <label class="check_label" >Upload Background Image(Advance)</label>
                    
                     <div id="div_background_image" style="display: none;margin:10px 0 0 0">
                     <input type="file" name="background_image" id="background_image" size="35" />
                     <span id="page_background_message"></span>
                     </div>
               </dd>
        </dl>  
	<div id="div_background_area" style="display: none; margin:10px 0 0 0;">              
    <dl>
           <dt>
                 <label for="" class="NewsletterLabel"> Background Area<span class="star">*</span></label>
           </dt>
           <dd>
                <input type="radio" id="background_area_1" name="background_area" value="page" checked="checked" />
                <label class="check_label" >Page</label>
                
                <input type="radio" id="background_area_2" name="background_area" value="content" />
                <label class="check_label" >Content</label>
                
                <input type="radio" id="background_area_3" name="background_area" value="both" />
                <label class="check_label" >Both (Page & Content)</label>
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label for="" class="NewsletterLabel"> Background Style <span class="star">*</span></label>
           </dt>
           <dd>
                <input type="radio" id="background_style_1" name="background_style" value="stretch" checked="checked" />
                <label class="check_label" >Stretch</label>
                
                <input type="radio" id="background_style_2" name="background_style" value="tile"/>
                <label class="check_label" >Tile</label>
           </dd>
    </dl>
	</div>
    
    <!---- Page Title Section ------->
    <dl>
           <dt>
                 <label for="" class="NewsletterLabel"> Do you want to publish page title? <span class="star">*</span></label>
           </dt>
           <dd>           		
                <input type="radio" id="page_title_status_1" name="page_title_status" value="Published" onClick="hideSchedule()" checked="checked" />
                <label class="check_label" >Yes</label>
                
                <input type="radio" id="page_title_status_2" name="page_title_status" value="Not Published" onClick="hideSchedule()" />
                <label class="check_label" >No</label>
                
           </dd>
    </dl>     
    <!---- Page Title Section Ends ------->   
        
      <dl>
           <dt>
                 <label for="" class="NewsletterLabel"> Do you want to activate this page? <span class="star">*</span></label>
           </dt>
           <dd>
           		
                <input type="radio" id="page_status_1" name="page_status" value="Published" onClick="hideSchedule()" checked="checked" />
                <label class="check_label" >Yes</label>
                
                <input type="radio" id="page_status_2" name="page_status" value="Not Published" onClick="hideSchedule()" />
                <label class="check_label" >No</label>
                
                <input type="radio" id="page_status_3" name="page_status" value="Schedule" onClick="showSchedule()" />
                <label class="check_label" >Publish for specific amount of time</label>
                
                <div id="schedular" style="display: none; margin:15px 0 0 0;">
                    <div style="width:300px; height:60px;">
                        <label>Start:</label>
                        <br />
                        <label>Date/Time:</label>
                        <input id="page_start_date" name="page_start_date" type="text" value="" size="25" readOnly="readOnly">
                        <a href="javascript:NewCal('page_start_date','ddMMyyyy', true, 12)">
                            <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                        </a>
                    </div>
                    <div>    
                        <label>End:</label>
                        <br />
                        <label>Date/Time:</label> 
                        <input id="page_end_date" name="page_end_date" type="text" value="" size="25" readOnly="readOnly">
                            <a href="javascript:NewCal('page_end_date','ddMMyyyy',true,12)">
                                <img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                            </a>
                        <br />    
                    </div>
                    <label class="messages" id="page_pub_date_message"></label>
                </div>
                
           </dd>
    </dl>   
    <!---- Page Template Section ------->
   <!-- <dl>
           <dt>
                <label for="" class="NewsletterLabel">Save As Template</label>
           </dt>
           <dd>
                <input type="checkbox" onClick="showTempName()"  id="page_temp_on" name="page_temp" value="1" />
                <div style="display:none;" id="temp_option_name_field" >
					<label style="float:left; margin-right:5px;">Template Name: </label>
					<input  type="text"  name="temp_option_name_field" />
				</div>
           </dd>
    </dl>      -->
    
    <!---- Page Template Section ------->	   
      <!---- Page Template all page ------->
  <!--  <dl>
           <dt>
                <label for="" class="NewsletterLabel">Apply on All Pages</label>
           </dt>
           <dd>
                <input type="checkbox" onClick="showTempName()"  id="page_temp_on" name="page_temp" value="1" />
           </dd>
    </dl>      -->
    
    <!---- Page Template Section ------->         
		
       </fieldset>
       
       <!--<dl>
           <dt>
               
           </dt>
           <dd>
                <table cellpadding="0" cellspacing="0" border="0" width="100%" id="usman">
				<tr>
					<td colspan="2">
						<input type="checkbox" name="fb_save" id="fb_save" value="1" onClick="fb_authentication(this);" /> Add to Facebook
					</td>	
				</tr>
				<tr>
					<td width="31px"><img src="<?=base_url()?>images/fb_logo.png" alt="FB" border="0" /></td>
					<td>
                    <input type="text" name="fb_status" id="fb_status" onfocus="check_value(this,'','What is in your mind?');" onblur="check_value(this,'What is in your mind?','');" value="What is in your mind?" name="textfield">
                    </td>
				</tr>
			</table>
            <br>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
				<tr>
					<td colspan="2">
						<input type="checkbox" name="is_comments" id="is_comments" value="1"  /> Enable FaceBook Comments
					</td>	
				</tr>
				
			</table>
			<br>
            
           </dd>
    </dl>                          -->
		
       
    <div>
        <input type="button" value="Back" onClick="document.getElementById('frmEditContent').submit();" />
        <input type="submit" value="Continue" />
    </div>
       
   
</form>


<form id="frmEditContent" action="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0" method="post" style="visibility: hidden;">
    <input type="hidden" name="site_id" value="<?=$site_id?>" />
    <input type="hidden" name="page_id" value="<?=$page_id?>" />
    <input type="hidden" name="item_id" value="<?=$item_id?>" />
</form>
</div>

