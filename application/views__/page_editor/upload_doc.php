<html>
<head>
<link rel="stylesheet" href="<?=base_url()?>css/gws/style.css" />
 
</head>
<body>

<script type="text/javascript">
function preview_video(video_name)
{
	//alert(video_name);
	if($("#preview_a").html())
	{
		$("#preview_a").html('');
		$("#preview_a").html('<a class="media" id="preview_b" href="<?=base_url()?>media/uploads/'+video_name+'"></a>');
		$('a.media').media();
		$('#video_preview').show();
	}
	else
	{
		$("#preview_a").attr("href", "<?=base_url()?>media/uploads/"+video_name)
		$('a.media').media();
		$('#video_preview').show();	
	}
}

function save_data(val)
{
	//input_temp_video_1
	
	
	video_div_id = document.getElementById("popup_id").value;
	embed_code = $("#embed_input").val();
	if(embed_code!='')
	{
		$('#'+video_div_id).html('');
		//alert(video_div_id);
		var doc_new_id = video_div_id.split("_");
		
		$('#'+video_div_id).html('');  
		
		//Passing To Server Using Hidden field
		var form_to_server = $("#control_id").val();
		$("#"+form_to_server).val(embed_code);
		
		$('#'+video_div_id).html(embed_code); 
		
		var doc_dis = '';
		
		if(document.getElementById('input_message').value!='')
		{
			$("#input_temp_doc_"+doc_new_id[1]).val(embed_code+'*'+document.getElementById('input_message').value);
		}
		else
		{
			$("#input_temp_doc_"+doc_new_id[1]).val(embed_code);
		}	
		
		if(document.getElementById("blank").checked)
		{
			$("#target"+doc_new_id[1]).val(document.getElementById("blank").value);
		}
		//alert($("#input_temp_doc_"+doc_new_id[1]).val());
		
	}
	
	$.fancybox.close();
	//var video_id = document.getElementById("input_temp_video_1").value;
	//alert(video_id);	
}

$(document).ready(function() {
//Making Global the value of activ control
  var video_id = document.getElementById("popup_id").value;  

  $("#control_id").val("input_"+video_id);         
}); 
// save_data('usman');

		// Junaid n Mohsin 7 March 2012
		// Mohsin 8 March 2012  
function apply_doc_link()
{
	 
	var doc_link = document.getElementById('filename_doc').value;
	
	var link_id = document.getElementById("popup_id").value;
	//alert("you call me...");
	//	alert(doc_link);
	//	alert(link_id);
	//	Origional URL
	//	var org_url = doc_link.split("\");
	//	alert(org_url[2]); 

	var doc_new_id = link_id.split("_");
	//	alert(doc_new_id[1]);
	var file_name = doc_link.split("/");
	
	
		$("#"+link_id).html('');
		$("#"+link_id).html('<a class="media" id="doc_link" href="'+doc_link+'">"'+file_name[7]+'"</a>');
	
	//$("#"+link_id).html('<a class="media" id="doc_link" href="'+doc_link+'">Document</a>');
	
	//	$("#input_temp_doc_"+1).val();
	//$("#input_temp_doc_"+doc_new_id[1]).val(doc_link);
	var doc_dis = '';
	if(document.getElementById('input_message').value!='')
	{
		$("#input_temp_doc_"+doc_new_id[1]).val(doc_link+'*'+document.getElementById('input_message').value);
	}
	else
	{
		$("#input_temp_doc_"+doc_new_id[1]).val(doc_link);
	}	
	
	
	
	if(document.getElementById("blank").checked)
	{
		$("#target"+doc_new_id[1]).val(document.getElementById("blank").value);
	}
	$.fancybox.close();
	//item_cart_
	
}
		// Mohsin 8 March 2012
		// Junaid n Mohsin 7 March 2012

</script>
<style>

#btn_save,#new_save, #btn_new {
 
  padding : 5px 10px;
  box-shadow : 0 1px 4px rgba(0,0,0,.6);
  font-size : 9.5pt;
  font-weight : bold;
 /* color : #fff;
  text-shadow : 0 1px 3px rgba(0,0,0,.4);*/
  font-family : sans-serif;
  text-decoration : none;
}


</style>
<form action="<?=base_url().index_page()?>media/ajax_file_upload" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">

<table style="color: #000;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="border-bottom: 1px solid;">
			<h2>Upload File</h2>
		</td>
	</tr>
	
	<tr  >
		<td style="padding-top:10px; padding-bottom:10px;">
			<p>Choose wether you want to Upload a file from you Computer or Link to an existing file.</p>
		</td>
	</tr>
	<tr>
		<td  valign="top">
			<table cellpadding="0" cellspacing="0" border="0" >
					<tr>
						<td>
								<input type="hidden" name="filename" value="filename">
								<input type="hidden" name="maxSize" value="9999999999">
								<input type="hidden" name="maxW" value="200">
								<input type="hidden" name="fullPath" value="<?=base_url()?>media/uploads/">
								<input type="hidden" name="relPath" value="../uploads/">
								<input type="hidden" name="control_id" id="control_id" value="">
								<table cellpadding="0" cellspacing="0" width="100%" border="0">
									<tr>
										<td valign="top">
											<input type="radio" checked="checked" name="file_input" id="upload_new" value="new" onClick="show_hide(this.value)"> Upload File
										</td>
										<td valign="top">
											<input type="file" name="filename"  id="file_new"> 
											<button id="btn_new"  onClick="ajaxUpload(this.form,'<?=base_url().index_page()?>media/ajax_file_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?=base_url()?>images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload File</button> <span style="font-size: 10px;">Allowed Size : <b>10 MB</b></span> 
                                            <br>
                                            <br>
											 <div id="upload_area">
												
											 </div>
										</td>
										<td valign="top">
											  <img src="<?=base_url()?>images/file_script.png" alt="" border="0">
										</td>
									</tr>
									<tr id="video_preview" style="display: none;">
										<td colspan="4" align="center">
												<a id="preview_a" class="media {width:480, height:280}" href="">My Text File</a>
										</td>
									</tr>
								</table>
						</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="file_input" id="add_link" value="link" onClick="show_hide(this.value)"> Link to URL/Embed Code	<br>			
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td><input type="checkbox" name="blank" id="blank" value="_blank"/> Open in new window</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr id="tr_embed" style="display: none;">
		<td  style="padding-left: 20px;">
			<p>Enter the URL/Embed code where an existing file is resides.</p>
			<textarea cols="60" rows="5" name="embed_url" id="embed_input" disabled="disabled" style="resize: none;"></textarea>
		</td>
	</tr>
	<tr>
		<td  style="padding-left: 20px;" >Add Description For Document</td>
	</tr>
	<tr>
		<td  style="padding-left: 20px;" ><textarea cols="60" rows="5" name="input_message" id="input_message"  ></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<input type="button" name="btn_save" id="btn_save" value="Save File" onClick="save_data();" style="border:1px solid; display:none;" >
            <input type="button" name="new_save" id="new_save" value="Save File" onClick="apply_doc_link();" style="border:1px solid;" >
        </td>
	</tr>
	<!--<tr>
		<td><input type="radio" name="file_input" value="library" onclick="show_hide(this.value)"> Video Library</td>
	</tr>-->
	<tr id="tr_library" style="display: none;">
		<td style="padding-left: 20px;">
			<table cellpadding="0" cellspacing="0" border="1" width="100%">
			<? if(isset($gallery_images)) {?>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						 <tr> 
						 
							<?
							//echo "total <br>".count($gallery_images);
							$row_num = 0;
							 for($i=0; $i<count($gallery_images);$i++) {
								$is_last = $i%6;
								
								if($i%6 == 0 )
								{
									$end = "</tr><tr>";
									echo $end;
									$row_num = $row_num +1;
								}
								?>
									<td>
										<a href="javascript:void(0);" onClick="load_image('<?=$gallery_images[$i]["image_name"]?>');"><img src="<?=base_url()?>media/uploads/<?=$gallery_images[$i]["image_name"]?>" alt="<?=$gallery_images[$i]["image_name"]?>" style="width: 100px; height: 100px;">	</a><br>
										 <input type="radio" name="selected_image" value="<?=$gallery_images[$i]["image_name"]?>" id="image_<?=$i?>" onClick="load_image(this.value);"> Select
										 
									</td>
									
									
							<? }?>
							   
							   <?
									//echo $row_num;
									
									if(( count($gallery_images)%6 != $row_num)  )
									{
									?>
										<!--<td>
											 <div id="upload_area">
													  bakraaa  1
												</div>
										</td>       -->
									<?	
									}
									?>
							
						   </tr>
									<?
				//echo $row_num;

				if(( count($gallery_images)%6 == $row_num)  )
				{
				?>    <!--<tr>
					<td>
						 <div id="upload_area">
								bakra 222 
							</div>
					</td>
					</tr>      -->
				<?	
				}
				?>
					</table>
					
				</td>
				</tr>


				<? }else { ?>
				<tr>
				<td>
					<p>No Images Found. Please Upload New Images</p>
				</td>
				</tr>
				<? }?>	
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>  
 </form>	   
</table>
</body>
<script type="text/javascript">
	function show_hide(val)
	{
		
		//alert("sdf");
		if(val == "new")
		{
		
			 //$("#tr_new").show();
			 $("#tr_embed").hide();	
			 $('#file_new').removeAttr('disabled');
			 $('#btn_new').removeAttr('disabled');
			
			 $('#embed_input').val(''); 
			 $('#embed_input').attr('disabled','disabled');
			 //$('#btn_save').attr('disabled','disabled');
			 $('#btn_save').hide();
			 $('#new_save').show();
			 
			//$("#tr_link").hide();
			//$("#tr_library").hide();
		}
		else if(val == "link")
		{
			$("#tr_embed").show();
			$('#embed_input').removeAttr('disabled');
			$('#btn_save').removeAttr('disabled');
			//Empty the File Input and Disable 
			$('#file_new').val('');   
			$('#file_new').attr('disabled','disabled');
			//$('#btn_new').attr('disabled','disabled');
			$('#btn_save').show();
			 $('#new_save').hide();
			
		}
		else if(val == "library")
		{
			$("#tr_library").show();
			$("#tr_new").hide();
			$("#tr_link").hide();
		}
	}
	//By Default Video Option is Enabled
	show_hide('new');	
</script>
</html>