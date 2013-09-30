<html>

<head>

<link rel="stylesheet" href="<?=base_url()?>css/gws/style.css" />

 <script type="text/javascript" src="<?=base_url()?>/js/jwplayer.js"></script>

</head>

<body>



<script type="text/javascript">

function load_video(video_name)

{

	alert(video_name+'usmaaaaaaaaaaaaaaaaaaa');

	var video_id = document.getElementById("popup_id").value;

	var input_video_id = document.getElementById("input_"+video_id);

	input_video_id.value = video_name;

	$.fancybox.close() ;

}

//function to send upladed Video baclk to Editor Board

function apply_video(file_name)

{

	//Editor board Control ID for data passing to Server

	var form_to_server = $("#control_id").val();

	$("#"+form_to_server).val(file_name);

	

	//alert(document.getElementById("popup_id").value);

	video_div_id = document.getElementById("popup_id").value;

	//alert(video_div_id);

	$('#'+video_div_id).html('');

	

	jwplayer(video_div_id).setup({

			flashplayer: "<?=base_url()?>js/player.swf",

			file: "<?=base_url()?>media/uploads/"+file_name,

			image: "preview.jpg"

		});     

	

	var id_pieces = video_div_id.split('_');

	control_count = id_pieces[2];

	

	 

	//html_link = '<br><a class="menu-instruction" id="video_'+control_count+'" href="<?=base_url()?>index.php/media/video_index/'+control_count+'" onclick="video_box_load(\'video_'+control_count+'\')" >Change Video</a>';

	

	//$("#video_edit_"+control_count).html(html_link);	

	$.fancybox.close();  

	

	

}

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

	var split_array = video_div_id.split("_");

	

	if ($('input[name=video_alignment]:checked').length > 0)

	{

		//alert($('input[name=video_alignment]:checked').val());

		$('#align'+split_array[2]).val($('input[name=video_alignment]:checked').val());	

	}

	

	

	$('#'+video_div_id).html('');

	//alert("asasa");

	embed_code = $("#embed_input").val();

	$('#'+video_div_id).html('');  

	

	//Passing To Server Using Hidden field

	var form_to_server = $("#control_id").val();

	$("#"+form_to_server).val(embed_code);

	

	$('#'+video_div_id).html(embed_code);  

	$.fancybox.close();

	//var video_id = document.getElementById("input_temp_video_1").value;

	//alert(video_id);	

}

function test_call()

{

	alert("I m calledd from outsid");

}

$(document).ready(function() {

//Making Global the value of activ control

  var video_id = document.getElementById("popup_id").value;  



  $("#control_id").val("input_"+video_id);

    

}); 

// save_data('usman');

</script>

<form action="<?=base_url().index_page();?>video_gallery/video_upload" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">

<table cellpadding="0" cellspacing="0" border="0" width="800px">

	<tr>

		<td style="border-bottom: 1px solid;">

			<h2>Uplaod File</h2>

		</td>

	</tr>

	

	<tr>

		<td>

			<p>Choose wether you want to Upload a file from you Computer or Link to an existing file.</p>

		</td>

	</tr>

	<tr>

		<td  valign="top">

			<table cellpadding="0" cellspacing="0" border="0" width="100%">

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

											<input type="radio" checked="checked" name="file_input" value="new" onClick="show_hide(this.value)"> Upload File

										</td>

										<td valign="top">

											<input type="file" name="filename" disabled="disabled" id="file_new"> 

											<button id="btn_new" disabled="disabled" onClick="ajaxUpload(this.form,'<?=base_url().index_page();?>media/ajax_video_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?=base_url()?>images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Video</button> <span style="font-size: 10px;">Allowed Size : <b>10 MB</b></span> 

											 <div id="upload_area">

												

											 </div>

										</td>

										<td valign="top">

											  <img src="<?=base_url()?>images/video_strip.png" alt="" border="0">

										</td>

									</tr>

									<tr id="video_preview" style="display: none;">

										<td colspan="4" align="center">

												<a id="preview_a" class="media {width:480, height:280}" href="">My Audio File</a>

										</td>

									</tr>

								</table>

						</td>

					</tr>

			</table>

		</td>

	</tr>

	<tr >

		<td >

			<input type="radio" name="file_input" value="link" onClick="show_hide(this.value)"> Link to URL/Embed Code	<br>

			

			

		</td>

	</tr>

	<tr id="tr_embed" style="display: none;">

		<td  >

			<p>Enter the URL/Embed code where an existing file is resides.</p>

			<textarea cols="80" rows="5" name="embed_url"  id="embed_input" disabled="disabled" style=" margin-left:230px;resize: none;"></textarea>

		</td>

	</tr>

	<tr>

		<td>&nbsp;</td>

	</tr>

	<!-- Vedio Alignment 4-4-2012 -->

	<tr>

		<td  ><h1 style="color:#4d73b8;">VIDEO ALIGNMENT</h1></td>

	</tr>

	<tr>

		<td align="center" >

			<table class="align-options" align="center" cellpadding="2" cellspacing="2" border="0" width="100%">

				<tr>

					<td ><input  type="radio" value="bottom" id="video_alignment_bottom" name="video_alignment"/> Bottom</td>

					<td ><input  type="radio" value="left"  id="video_alignment_left" name="video_alignment"/> Left</td>

					<td ><input  type="radio" value="right"  id="video_alignment_right" name="video_alignment"/> Right</td>	

				</tr>

				<tr>

					<td><img src="http://www.webpowerup.ca/css/mashup/images/mashup.jpg" /></td>

					<td><img src="http://www.webpowerup.ca/css/mashup/images/mashup.jpg" /></td>

					<td><img src="http://www.webpowerup.ca/css/mashup/images/mashup.jpg" /></td>	

				</tr>

			</table>

		</td>

	</tr>

<!-- Vedio Alignment 4-4-2012 -->

	<tr>

		<td>

			<input type="button" name="btn_save" value="Save Link" onClick="save_data();">

		</td>

	</tr>

	

	<!--<tr>

		<td><input type="radio" name="file_input" value="library" onclick="show_hide(this.value)"> Video Library</td>

	</tr>      -->

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

		if(val == "new")

		{

		//	$("#tr_new").show();

			 $("#tr_embed").hide();	

			 $('#file_new').removeAttr('disabled');

			 $('#btn_new').removeAttr('disabled');

			

			 $('#embed_input').val(''); 

			 $('#embed_input').attr('disabled','disabled');; 

			//$("#tr_link").hide();

			//$("#tr_library").hide();

		}

		else if(val == "link")

		{

			$("#tr_embed").show();

			$('#embed_input').removeAttr('disabled');

			//Empty the File Input and Disable 

			$('#file_new').val('');   

			$('#file_new').attr('disabled','disabled');;

			$('#btn_new').attr('disabled','disabled');;

			

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