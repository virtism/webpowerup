<html>
<body>
<style>
.file-folder-view{
 
}
.file-folder-view ul { 
	list-style-type:none; 
	margin:0; 
	padding:0;  
	width:750px;
}
.file-folder-view  li { 
	height: 120px;
	line-height: 1em;
	float: left;
	width: 120px;
	display: block;
	border: 0.1em solid #dcdce9;
	color: #0d2474;
	text-decoration: none;
	text-align: center; 
}
.file-folder-view  li span
{
	display:block;
} 
#folder_option
{
	float: left;    
}
</style>
<script type="text/javascript" src="<?=base_url()?>js/ajaxupload/ajaxupload.js"></script>
<script type="text/javascript">
	
	function load_image(image_name, id)
	{
		<?php $relPath = "media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images"; ?>
		var image_id = document.getElementById("popup_id").value;
		var input_image_id = document.getElementById("input_"+image_id);
		var folder_path = document.getElementById('image_path').value;
		
//		input_image_id.value = image_name;	
		input_image_id.value = '<?=base_url()?><?=$relPath?>'+folder_path+"/"+image_name;
		//alert(folder_path+"/"+image_name);
		document.getElementById(image_id).src = '<?=base_url()?><?=$relPath?>'+folder_path+"/"+image_name;
		//document.getElementById("image_full_path"+image_id).value = '<?=base_url()?><?=$relPath?>'+folder_path+"/"+image_name; 
		//alert(image_name);
		$('#image_id').val(id);
		$("#various"+id).attr('href', '<?=base_url().index_page();?>media/load_properties/'+count);
		apply_context_menu(count);  
		imageproperties();
		//$.fancybox.close() ;
	}	
	
	function create_folder()
	{
		if(document.getElementById('create_folder_path')!=null)
		{
			var folder_name = document.getElementById('create_folder_path').value+"/"+document.getElementById('folder_name').value;
		}
		else
		{
			var folder_name = document.getElementById('folder_name').value;
		}    
		
		var path =  "<?=base_url().index_page()?>media/ajax_folder_create";
		if(folder_name=='Images')
		{
			var dataString = 'folder_name=';
		}
		else
		{
			var dataString = 'folder_name='+folder_name;
		}			
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#folder_data").html("<ul>"+data+"</ul>");
				//alert("success");
			}
		});
	}
	function get_images_created_folder(folder_name)
	{
		
		var dir_name = folder_name;		
		var path =  "<?=base_url().index_page()?>media/ajax_created_folder";
		var dataString = 'dir_name='+dir_name;
		document.getElementById('image_path').value = dir_name;		
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#folder_data").html("<ul>"+data+"</ul>");
				//alert("success");
			}
		});
	}
	function back_link()
	{
		
		if(document.getElementById('create_folder_path').value!=null)
		{
			var folder_name = document.getElementById('create_folder_path').value+"/"+document.getElementById('folder_name').value;
		}
		else
		{
			
			var folder_name = document.getElementById('folder_name').value;			 
		}    
		 //alert(folder_name);		
		//exit();
		var path =  "<?=base_url().index_page()?>media/ajax_created_folder";
		if(folder_name=='Images')
		{
			var dataString = 'back_folder_name=';
		}
		else
		{
			var dataString = 'back_folder_name='+folder_name;
		}
		//alert(dataString);			
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#folder_data").html("<ul>"+data+"</ul>");
				//alert("success");
			}
		});
	}
</script>
<script type="text/javascript">
		//$(document).ready(function() {
			
		function imageproperties()
		{
			var image_id = $('#image_id').val();	
			//alert(image_id);		
			$("#various"+image_id).fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		}	
		//});
		
		function delete_image(folder_name, li_id)
		{
			
			
			var r = confirm("Are you sure to delete this image.")
			if (r==true)
			  {
				var dir_name = folder_name;
				var path =  "<?=base_url().index_page();?>media/delete_image_from_folder";
				var dataString = 'dir_name='+dir_name;
				//document.getElementById('image_path').value = dir_name;		
				$.ajax({
					url: path, 
					data: dataString,
					type:'POST', 
					success: function(data){
						$("#li_"+li_id).remove();
						//alert("success");
					}
				});
			  }
			  else
			  {
				 $("#cross_image_"+li_id).removeAttr('checked');				 
			  }
		}
	</script>
<input type="hidden" id="image_id" value="0" />
<table cellpadding="0" cellspacing="0" border="0" width="800px">
	<tr>
		<td>
			<table  >
			  <tr>
				<td><img src="<?=base_url().index_page()?>images/media.png"/></td>
				<td><h1 style="color: maroon;">Media Gallery</h1></td>
			  </tr>
			</table>			
		</td>
	</tr>
	<tr>
		<td>
			<h2 style="color: maroon;">Existing Images</h2>
		</td>
	</tr>
	<? if(isset($gallery_images)) {?>
	<tr  style="float:left;">
		<td id="folder_data" class="file-folder-view">
		<ul>
			<li><a id="back_link" href="javascript:void(0);" onClick="back_link()" ><img style="margin-top:25px;" src="<?=base_url()?>/images/up2.png"/></a></li>
			<?php 	
				$relPath_thumb = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images/";				
				$i = 0;
				$folder= dir($relPath_thumb);
				while($folderEntry=$folder->read())				
				{
					 $folder_count = 0;
					  if($folderEntry!='.'&&$folderEntry!='..')
					  {
						$i = $i+1;
						echo "<li id='li_".$i."'>";                        
						if(is_dir($relPath_thumb.$folderEntry))
						{
							++$folder_count;
							$Path_for_click_folder = explode("Images",$relPath_thumb.$folderEntry);
							$stack = explode("/",$Path_for_click_folder[1]);
							$P = array_pop($stack);
							$Path_for_create_folder = implode("/", $stack);
							
			?>
							<input type="hidden" disabled="disabled" id="create_folder_path" value="<?=$Path_for_create_folder?>"/>							
							<a href="javascript:void(0);" onClick="get_images_created_folder('<?=$Path_for_click_folder[1]?>');"><img style=" width:70px; height:70px; border:0; padding-top:6px; " src="<?=base_url()?>images/w_folder.png"/></a>
							<span><?=$folderEntry?></span>
						<?
						}
						else
						{							
						?>	
						<a  id="various<?=$i?>" href="<?=base_url().index_page();?>media/load_properties/<?=$i?>" ><img  onMouseOver ="load_image('<?=$folderEntry?>','<?=$i?>');"  src="<?=base_url()?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']?>/_thumbs/Images/<?=$folderEntry?>" alt="<?=$folderEntry?>" style="width: 100px; height: 100px;"></a><br>
						<span><input type="radio" name="selected_image_<?=$i?>" value="<?=$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']?>/_thumbs/Images/<?=$folderEntry?>" onClick="delete_image(this.value,'<?=$i?>');" id="cross_image_<?=$i?>">Delete<input type="radio" name="selected_image" value="<?=$folderEntry?>"  onClick="load_image(this.value);" id="image_<?=$i?>"> Select</span>
						<?
						}
						echo "</li>";	
					  }
					
				}				
				$folder->close();				
			?>
			</ul>
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
			<td><h2>Upload New</h2></td>
						
	</tr>
	<tr>
		<td>
			 <div id="upload_area">
				
			 </div>
		</td>
	</tr>
	
	<tr>
		<td>
			<form action="<?=base_url().index_page()?>media/ajax_image_upload" method="post" name="standard_use" id="standard_use"  enctype="multipart/form-data">
					<input type="hidden" name="filename" value="filename">
					<input type="hidden" name="maxSize" value="9999999999">
					<input type="hidden" name="maxW" value="200">
					<input type="hidden" name="fullPath" value="<?=base_url()?>media/uploads/">
					<input type="hidden" name="relPath" value="../uploads/">
					<input type="hidden" name="image_name"  value="<? if(isset($folderEntry)){ echo $folderEntry; }?>">					
					<input type="hidden" name="image_path" id="image_path" />
					 <input type="hidden" name="image_count" id="image_count" value="<? if(isset($i)){  echo $i;}?>" />
				<table style="color: maroon;" cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
						
							<input type="file" name="filename"> 
							<button style="color: maroon;" onClick="ajaxUpload(this.form,'<?=base_url().index_page()?>media/ajax_image_upload','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?=base_url()?>images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>      <br><br>
								<p>
				Allowed Size : <b>2 MB</b>&nbsp;&nbsp; Max Width : 1024px&nbsp;&nbsp; Max Height: 786px   <br>
			</p>
						</td>
						<td>
							Create Folder<input type="text" name="folder_name"  style="border: #e9e9e9  solid 1px;" id="folder_name" />
							<input style="color: maroon;" type="button" name="folder" value="Save" onClick="create_folder()"/>  <br><br><br><br>
						</td>                                                
					</tr>  					
					
				</table>
						
			</form>	
		</td>
		
	</tr>
</table>
</body>
</html>