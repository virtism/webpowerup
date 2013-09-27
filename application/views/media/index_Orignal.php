<html>
<body>
<script type="text/javascript" src="<?=base_url();?>js/ajaxupload/ajaxupload.js"></script>
<script type="text/javascript">
function load_image(image_name)
{
	//alert(image_name);
	
	var image_id = document.getElementById("popup_id").value;
	//alert(image_id);
	//alert("input_"+image_id);
	//var input_image_id = document.getElementById("input_"+image_id).value;
	var input_image_id = document.getElementById("input_"+image_id);
	input_image_id.value = image_name;
	//alert(input_image_id);
	
	//alert('<?=base_url()?>media/uploads/'+image_name);
	document.getElementById(image_id).src = '<?=base_url()?>media/uploads/'+image_name;
	apply_context_menu(count);  
	$.fancybox.close() ;
	
}
</script>
<table cellpadding="0" cellspacing="0" border="0" width="800px">
	<tr>
		<td>
			<h1>Media Gallery</h1>
		</td>
	</tr>
	<tr>
		<td>
			<h2>Existing Images</h2>
		</td>
	</tr>
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
								<a href="javascript:void(0);" onclick="load_image('<?=$gallery_images[$i]["image_name"]?>');"><img src="<?=base_url()?>media/uploads/<?=$gallery_images[$i]["image_name"]?>" alt="<?=$gallery_images[$i]["image_name"]?>" style="width: 100px; height: 100px;">	</a><br>
								 <input type="radio" name="selected_image" value="<?=$gallery_images[$i]["image_name"]?>" id="image_<?=$i?>" onclick="load_image(this.value);"> Select
								 
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
	<tr>
			<td>&nbsp;</td>
	</tr>
	<tr>
						<td><h2>Upload New</h2></td>
						
					</tr>
	<tr>
		<td>
			 <div id="upload_area">
				
			 </div>
		</td>
	</tr>
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
			
			
			
			<form action="<?=base_url()?>index.php/media/ajax_image_upload" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">
							
					<input type="hidden" name="filename" value="filename">
					<input type="hidden" name="maxSize" value="9999999999">
					<input type="hidden" name="maxW" value="200">
					<input type="hidden" name="fullPath" value="<?=base_url()?>media/uploads/">
					<input type="hidden" name="relPath" value="../uploads/">
					
					 
							
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					
					
					<tr>
						<td>
						
							<input type="file" name="filename"> 
							<button onclick="ajaxUpload(this.form,'<?=base_url()?>index.php/media/ajax_image_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?=base_url()?>images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>      <br>  <br>
							<p>
								Allowed Size : <b>2 MB</b>&nbsp;&nbsp; Max Width : 1024px&nbsp;&nbsp; Max Height: 786px   <br>
							</p>
						</td>
					</tr>
					<tr>
						<td>
						
						</td>                                                
					</tr>
				</table>
						
			</form>	
		</td>
	</tr>
</table>
</body>
</html>