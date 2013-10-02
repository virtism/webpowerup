<html>
<body>
<script type="text/javascript" src="<?=base_url();?>js/ajaxupload/ajaxupload.js"></script>
<script type="text/javascript">
function load_image(image_name)
{
	//alert(image_name);
	var image_id = document.getElementById("popup_id").value;
	//alert(image_id);
	//var input_image_id = document.getElementById("input_"+image_id).value;
	var input_image_id = document.getElementById("input_"+image_id);
	input_image_id.value = image_name;
	//alert(input_image_id);
	
	//alert('<?=base_url()?>media/uploads/'+image_name);
	document.getElementById(image_id).src = '<?=base_url()?>media/uploads/'+image_name;
	
}
</script>
<table cellpadding="0" cellspacing="0" border="0" width="800px">
	<tr>
		<td>
			<h1>Media Gallery</h1>
		</td>
	</tr>
	<? if(isset($gallery_images)) {?>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				 <tr> 
					<? for($i=0; $i<count($gallery_images);$i++) {
						if($i%6 == 0 )
						{
							$end = "</tr><tr>";
							echo $end;
						}
						?>
							<td>
								<img src="<?=base_url()?>media/uploads/<?=$gallery_images[$i]["image_name"]?>" alt="<?=$gallery_images[$i]["image_name"]?>" style="width: 100px; height: 100px;">	 <br>
								 <input type="radio" name="selected_image" value="<?=$gallery_images[$i]["image_name"]?>" id="image_<?=$i?>" onclick="load_image(this.value);"> Select
								 
							</td>
					<? }?>
				   </tr>  		
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
	<tr>
			<td>&nbsp;</td>
	</tr>	
	<tr>
		<td>
			<!--<form action="<?=base_url()?>/media/scripts/ajaxupload.php" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">
							
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
							<input type="file" name="filename"> <br> 
							<button onclick="ajaxUpload(this.form,'<?=base_url()?>/media/scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath=<?=base_url()?>media/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>
						</td>
					</tr>
					<tr>
						<td>
						<div id="upload_area">
						Images Will Be uploaded here for the demo.<br /><br />
						You can direct them to do any thing you want!
					</div>
						</td>
					</tr>
				</table>
			</form>	         -->
			<form action="<?=base_url().index_page()?>media/ajax_image_upload" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">
							
					<input type="hidden" name="filename" value="filename">
					<input type="hidden" name="maxSize" value="9999999999">
					<input type="hidden" name="maxW" value="200">
					<input type="hidden" name="fullPath" value="<?=base_url()?>media/uploads/">
					<input type="hidden" name="relPath" value="../uploads/">
					
					 
							
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
						Via Contoler 
							<input type="file" name="filename"> <br> 
							<button onclick="ajaxUpload(this.form,'<?=base_url().index_page()?>media/ajax_image_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>
						</td>
					</tr>
					<tr>
						<td>
						<div id="upload_area">
						Images Will Be uploaded here for the demo.<br /><br />
						You can direct them to do any thing you want!
					</div>
						</td>                                                
					</tr>
				</table>
						
			</form>	
		</td>
	</tr>
</table>
</body>
</html>