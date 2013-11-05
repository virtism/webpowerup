<?
class media extends CI_Controller {
	
	function media()
	{
		$error = false;
		$result='';
		$errorList = array();
		parent::__construct();
		$this->load->helper('url');
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel'); 
		$this->load->Model('Media_Model');
		$this->load->library('template');      	
		$this->output->cache(0);  // caches
	}
	
	function load_properties($plugin_id)
	{
		//echo $plugin_id;exit; 
		$data["counter"] = $plugin_id;
		$this->load->view('media/image_properties',$data);	   
	}
	
	function index()
	{
		
		$images = $this->Media_Model->get_images_by_user_id($_SESSION["user_info"]["user_id"]);
		if($images)
		{
			$data["gallery_images"]  = $images;
		}
		$control_counter =  $this->uri->segment(3) ; 
		$data["counter"]  = $control_counter;		
		//echo $control_counter; 
		$this->load->view('media/index',$data);	   
	}
	
	//Video Index Page
	function video_index($counter)
	{
		//$images = $this->Media_Model->get_images_by_user_id($_SESSION["user_info"]["user_id"]);
//		
//		if($images)
//		{
//			$data["gallery_images"]  = $images;
//		}
		$this->template->add_js('js/jwplayer.js'); 
		
		$control_counter =  $counter ; 
		$data["counter"]  = $control_counter;
		//echo $control_counter; 
		$this->load->view('media/video_index',$data);	   
	}
	
	
	// The function will triverse folders
	function get_all_folders_images($relPath_thumb)
	{
		$empty_folder_path = $relPath_thumb;
		$folder=dir($relPath_thumb);
		?>
		<li><a id="back_link" href="javascript:void(0);" onClick="back_link()" ><img style="margin-top:25px;" src="<?=base_url()?>/images/up2.png"/></a></li>
		<?
		$i = 0;
		while($folderEntry=$folder->read())
		{
					 
			  if($folderEntry!='.'&&$folderEntry!='..')
			  {
				$i = $i+1;
				echo "<li id='li_".$i."'>"; 
				if(is_dir($relPath_thumb.$folderEntry))
				{
					
					$Path_for_click_folder = explode("Images",$relPath_thumb.$folderEntry);							
					$stack = explode("/",$Path_for_click_folder[1]);
					$P = array_pop($stack);
					$Path_for_create_folder = implode("/", $stack);			
				?>
							<input type="hidden" disabled="disabled" id="create_folder_path" value="<?=$Path_for_create_folder?>"/>
							<a  href="javascript:void(0);" onClick="get_images_created_folder('<?=$Path_for_click_folder[1]?>');"><img style=" width:70px; height:70px; border:0; padding-top:6px;" src="<?=base_url()?>/images/w_folder.png"/></a>
						<span>	<?=$folderEntry?></span>
				<?
				}
				else
				{
						$i++;
						$Path_for_click_folder = explode("Images",$relPath_thumb.$folderEntry);
				?>
						<a  id="various<?=$i?>" href="<?=base_url().index_page();?>media/load_properties/<?=$i?>" ><img  onMouseOver ="load_image('<?=$folderEntry?>','<?=$i?>');"  src="<?=base_url()?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']?>/_thumbs/Images/<?=$Path_for_click_folder[1]?>" alt="<?=$folderEntry?>" style=" width:100px; height:100px;"></a><br>
						<span><input type="radio" name="selected_image_<?=$i?>" value="<?=$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']?>/_thumbs/Images<?=$Path_for_click_folder[1]?>" onClick="delete_image(this.value,'<?=$i-1?>');" id="cross_image_<?=$i?>">Delete<input type="radio" name="selected_image" value="<?=$folderEntry?>"  onClick="load_image(this.value);" > Select</span>
				<?
				}
				echo "</li>";
			  }
			  else
			  {
					
					$Path_for_click_folder = explode("Images",$empty_folder_path);							
					$stack = explode("/",$Path_for_click_folder[1]);
					$P = array_pop($stack);
					$Path_for_create_folder = implode("/", $stack);
				?>
					<input type="hidden" disabled="disabled" id="create_folder_path" value="<?=$Path_for_create_folder?>"/>
				<?
			  }
			  
		}				
			 $folder->close();
	}
	
	// The function will create new folder	
	function ajax_folder_create()
	{
		$sub_folder_name =  $this->input->post('folder_name');		
		$relPath = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/images/".$sub_folder_name;
		$relPath_thumb = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images/".$sub_folder_name;
		$stack = explode("/",$sub_folder_name);
		$P = array_pop($stack);
		$Path_for_create_folder = implode("/", $stack);
		if(!is_dir($relPath)){	
			mkdir($relPath,0777,true);
		}
		if(!is_dir($relPath_thumb)){	
			mkdir($relPath_thumb,0777,true);
		}
			$relPath_thumb = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images".$Path_for_create_folder."/";
			$get_data = new media();
			$get_data->get_all_folders_images($relPath_thumb);
		
	}
	
	// The function will get images from created folder
	function ajax_created_folder()
	{
		//print_r($_POST);
		if(isset($_POST['back_folder_name'])&&!empty($_POST['back_folder_name']))
		{
			$full_path =  $this->input->post('back_folder_name');		
			$explode_for_previous_folder = explode("/",$full_path);
			
			$remove_current_folder = array_pop($explode_for_previous_folder);
			$remove_current_folder = array_pop($explode_for_previous_folder);
			
			$sub_folder_path = implode("/", $explode_for_previous_folder);
			
		}
		else
		{
			$sub_folder_path =  $this->input->post('dir_name');		
		}
		
		
		if(isset($sub_folder_path)&&!empty($sub_folder_path)){
		$relPath_thumb = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images".$sub_folder_path."/";	
					
				
			}else
			{
				$relPath_thumb = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images/";
				
			}
		$get_data = new media();	
		//echo $relPath_thumb;
		$get_data->get_all_folders_images($relPath_thumb);
		
	}
	
	function delete_image_from_folder()
	{
		  //echo 'junaid';
		 $path = $this->input->post('dir_name');
		// echo realpath(".");
		 unlink(realpath(".")."/media/ckeditor_uploads/".$path);
		 return true;
	}	
	
	
	function ajax_file_upload()
	{
		
		$this->load->library('upload');  		
		$config = array();
		$config_resize = array(); 
		$data = array(); 			
		$filename = $_FILES['filename']['name'];
		$filename = preg_replace('/\s/', '_', $filename);
		$config['file_name'] = $filename; 
		//$relPath = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/files/";			 		
		$relPath =  realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/files/'; 
		
/*		echo $relPath;
		exit;*/
		$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/files'; 
				if(!is_dir($config['upload_path']))
				  {
				     mkdir($config['upload_path'],0777,true);
				  }
	  	//  $config['upload_path'] = './media/uploads/';
		$config['allowed_types'] = 'txt|csv|htm|html|xml|css|doc|docx|xls|rtf|ppt|pptx|pdf';
		$config['max_size']    = '20480';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';		
		$files =  'filename';
		$this->upload->initialize($config); 
		$retrive_img = $this->upload->do_upload($files);		
		if($retrive_img)
		{
			$return_valu =  $this->upload->data(); 	
			 $html = '<input type="hidden" name="filename_doc" id="filename_doc" value="'.$relPath.$filename.'" /><a style="padding-left:166px;" href="javascript:void(0);"><b>Uploaded Successfully!</b></a>';		  
			  
			  echo $html; 	
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			 //return $error;
			// echo "ddsdsd <br>";
			 echo $error["error"];
			// print_r($error);exit;
			 //return $error;
		}
	}

	function ajax_video_upload()
	{
		//   echo "abc";exit;
	//echo "<pre>";
//print_r($_POST);
	//print_r($_REQUEST);
		//print_r($_FILES);
	//	exit;
				$this->load->library('upload');  
		
		$config = array();
		$config_resize = array(); 
		$data = array(); 
			
		$filename = $_FILES['filename']['name'];
		$filename = preg_replace('/\s/', '_', $filename);
	
		$config['file_name'] = $filename; 
		$relPath = realpath(".")."/media/uploads/";   
		$config['upload_path'] = $relPath;
	  //  $config['upload_path'] = './media/uploads/';
		  $config['allowed_types'] = 'mp4|m4v|mov|avi|flv|wmv|swf';
		$config['max_size'] = 51200; //15 MB
		$files =  'filename';
		$this->upload->initialize($config); 
		$retrive_img = $this->upload->do_upload($files);
		// echo "<pre>";
		// print_r($this->upload->data());
		// exit;
		
		if($retrive_img)
		{
			 $uploadedData = $this->upload->data();
			  $file = "'".$uploadedData["file_name"]."'";
			  $control_id = "'".$_POST["control_id"]."'";
			  $file_path = base_url().'media/uploads';
			//echo $control_id;exit;
//			  $html = '<script type="text/javascript">';
			 // $html .= 'setTimeout("load_image('.$file.')",4000);';
		//	  $html .= 'function load_image(){alert("i m called");}';
			  //$html .= 'load_image();';
			  
			 /*
				Below code is used here for Fancybox is not calling direct function to implement the code
			 */
			  //$html .= 'function load_video(video_name)';
			  //$html .= '{';
			  //$html .= 	 'alert(video_name);';	
			//  $html .=	 'var video_id = document.getElementById("popup_id").value;';
			 // $html .=	 'var input_video_id = document.getElementById('.$control_id.');';			
			 // $html .=	 'input_video_id.value = video_name;alert(input_video_id);';
			//  $html .=	 '$.fancybox.close()';
			  //$html .= '}';
			  //$html .= 'load_video('.$file.');';
			 // $html .= 'test_call();';
	//		  $html .= '$("a.media").media()';
		//	  $html .= '<//script>';
			  
			  
			  //onclick="apply_video('.$file.');"
			  
			  $html = '<input type="hidden" name="filename_temp" id="filename_temp" value="'.$uploadedData["file_name"].'" /> <br><div id="mediaplayer">JW Player goes here</div><div style="padding-left:10px;padding-top:5px;"><a href="javascript:void(0);" >Uploaded Successfully!</a></div><br><br>';
			  $html = $html.'<script type="text/javascript" src="'.base_url().'js/jwplayer.js"></script><script type="text/javascript">jwplayer("mediaplayer").setup({flashplayer: "'.base_url().'js/player.swf",file: "'.$file_path.'/'.$uploadedData["file_name"].'",image: "preview.jpg"});</script>';
			  
			  echo $html; 
			   
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			 //return $error;
			// echo "ddsdsd <br>";
			 echo $error["error"];exit;
		}
	}
	
	
	
	
	function ajax_image_upload()
	{
		$dir_name = $this->input->post('image_path');
		$imge_count = $this->input->post('image_count');
			
		//print_r($_FILES);		
		//echo realpath(".")."<br>";
		$this->load->library('upload');  
		
		$config = array();
		$config_resize = array(); 
		$data = array(); 
			
		$filename = $_FILES['filename']['name'];
		$filename = preg_replace('/\s/', '_', $filename);
	
		$config['file_name'] = $filename; 
			
			$relPath = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/images".$dir_name; 
		$config['upload_path'] = $relPath;
	  //  $config['upload_path'] = './media/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|GIF|JPG|PNG';
		$config['max_size']    = '2000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$files =  'filename';
		$this->upload->initialize($config); 
		$retrive_img = $this->upload->do_upload($files);
		
		if($retrive_img)
		{
			$return_valu =  $this->upload->data(); 
			 
			$config_resize['source_image'] = $return_valu['full_path'];
			
			$relPath = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images".$dir_name;		
			 
			$config_resize['new_image'] = $relPath;
			// $config_resize['new_image'] = './media/uploads/';
			// $config_resize['maintain_ratio'] = false;
			$config_resize['maintain_ratio'] = TRUE;
			$config_resize['create_thumb'] = TRUE;
			$config_resize['thumb_marker'] = "_thumb";
			$config_resize['width'] = 400;
			$config_resize['height'] = 400;

			$this->load->library('image_lib', $config_resize);
			$resize_img = $this->image_lib->resize();

			//  $return_data = array('upload_data' => $this->upload->data());  
			if($resize_img)
			{
				$filename_display = explode(".",$filename);
				$filename_thumb =  $filename_display[0].".".$filename_display[1];
				$filename_thumb_all = $filename_display[0]."_thumb.".$filename_display[1];
				$store_to_db = $this->Media_Model->store_image_to_db($filename_thumb);    
				$filename_thumb_java = "'".$filename_thumb."'";
				echo '<a id="various'.($imge_count+1).'" href="'.base_url().index_page().'media/load_properties/'.($imge_count+1).'"><img src="'.base_url().'media/ckeditor_uploads/'.$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id'].'/_thumbs/Images/'.$dir_name."/".$filename_thumb_all.'" onMouseOver="load_image(&#39;'.$filename_thumb_all.'&#39;,&#39;'.($imge_count+1).'&#39;);"   border="0" style="width: 100px; height: 100px;"/></a><br><input type="radio" name="selected_image" value="'.$filename_thumb_all.'" id="image_new" onclick="load_image(this.value);"> Select';
				/*echo '<a href="javascript:void();" onclick="load_image('.$filename_thumb_all.');"><img src="'.base_url().'media/ckeditor_uploads/'.$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id'].'/_thumbs/Images/'.$dir_name."/".$filename_thumb_all.'" border="0" style="width: 100px; height: 100px;" /></a><br><input type="radio" name="selected_image" value="'.$filename_thumb_all.'" id="image_new" onclick="load_image(this.value);"> Select'; */ 
			}
			else
			{
				
				echo $this->image_lib->display_errors('<p class="error">', '</p>');
				echo '<img src="/php_ajax_image_upload/images/error.gif" width="16" height="16px" border="0" style="marin-bottom: -3px;" /> Error(s) Found: ';
				
			}	


			// return true;
			// return $retrive_img;
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			 //return $error;
			// echo "ddsdsd <br>";
			 echo $error["error"];
			// print_r($error);exit;
			 //return $error;
		}
		
	}
	
	function ajax_image_upload_old()
	{
	 //   echo "abc";exit;
		//echo "<pre>";
		//print_r($_POST);
		//print_r($_REQUEST);
		
	//	echo realpath(".")."<br>";
		//exit;
		
		$filename = strip_tags($_REQUEST['filename']);
		$maxSize = strip_tags($_REQUEST['maxSize']);
		$maxW = strip_tags($_REQUEST['maxW']);
		$fullPath = strip_tags($_REQUEST['fullPath']);
		$relPath = realpath(".")."/media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/images/";					
		
		/*
		$relPath = strip_tags($_REQUEST['relPath']);
		$colorR = strip_tags($_REQUEST['colorR']);
		$colorG = strip_tags($_REQUEST['colorG']);
		$colorB = strip_tags($_REQUEST['colorB']);*/
		
		$colorR = "255";
		$colorG = "255";
		$colorB = "255";
		
		$maxH = "300";
		$filesize_image = $_FILES[$filename]['size'];
		if($filesize_image > 0){
		
			$upload_image = $this->uploadImage($filename, $maxSize, $maxW, $fullPath, $relPath,  $colorR, $colorG, $colorB, $maxH);
			
			if(is_array($upload_image))
			{
				foreach($upload_image as $key => $value) {
					if($value == "-ERROR-") {
						unset($upload_image[$key]);
					}
				}
				$document = array_values($upload_image);
				for ($x=0; $x<sizeof($document); $x++){
					$errorList[] = $document[$x];
				}
				$imgUploaded = false;
			}else{
				$imgUploaded = true;
			}
		}
		else
		{
			$imgUploaded = false;
			$errorList[] = "File Size Empty";
		}
		
		if($imgUploaded)
		{
			
			$store_to_db = $this->Media_Model->store_image_to_db($upload_image);
			
			
		}
		else
		{
			//echo "no"; 
		}
			 // exit;
		
		if($imgUploaded){
		
		/*echo '<script type="text/javascript">location.reload(true);</script>';*/
		
	}else{
		echo '<img src="/php_ajax_image_upload/images/error.gif" width="16" height="16px" border="0" style="marin-bottom: -3px;" /> ';
		foreach($errorList as $value)
		{
				echo $value.', ';
		}
	}
		
}
	
	
function uploadImage($fileName, $maxSize, $maxW, $fullPath, $relPath, $relPath_thumb, $colorR, $colorG, $colorB, $maxH = null)
	{	
		
		//echo $maxW;
		//exit; 
		$errorList = "";
		$errorList = array();
		
		$folder = $relPath;
		$maxlimit = $maxSize;
		$allowed_ext = "jpg,jpeg,gif,png,bmp,JPG,JPEG,GIF,PNG,BMP";
		$match = "";
		$filesize = $_FILES[$fileName]['size'];
		if($filesize > 0){	
			$filename = strtolower($_FILES[$fileName]['name']);
			$filename = preg_replace('/\s/', '_', $filename);
			if($filesize < 1){ 
				$errorList[] = "File size is empty.";
			}
			if($filesize > $maxlimit){ 
				$errorList[] = "File size is too big.";
			}
			if(count($errorList)<1){
				$file_ext = preg_split("/\./",$filename);
				$allowed_ext = preg_split("/\,/",$allowed_ext);
				foreach($allowed_ext as $ext){
					if($ext==end($file_ext)){
						$match = "1"; // File is allowed
						$NUM = time();
						$front_name = substr($file_ext[0], 0, 15);
						$newfilename = $front_name."_".$NUM.".".end($file_ext);
						$filetype = end($file_ext);
						$save = $folder.$newfilename;
						 //echo $save;exit;
						if(!file_exists($save)){
							list($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
							if($maxH == null){
								if($width_orig < $maxW){
									$fwidth = $width_orig;
								}else{
									$fwidth = $maxW;
								}
								$ratio_orig = $width_orig/$height_orig;
								$fheight = $fwidth/$ratio_orig;
								
								$blank_height = $fheight;
								$top_offset = 0;
									
							}else{
								if($width_orig <= $maxW && $height_orig <= $maxH){
									$fheight = $height_orig;
									$fwidth = $width_orig;
								}else{
									if($width_orig > $maxW){
										$ratio = ($width_orig / $maxW);
										$fwidth = $maxW;
										$fheight = ($height_orig / $ratio);
										if($fheight > $maxH){
											$ratio = ($fheight / $maxH);
											$fheight = $maxH;
											$fwidth = ($fwidth / $ratio);
										}
									}
									if($height_orig > $maxH){
										$ratio = ($height_orig / $maxH);
										$fheight = $maxH;
										$fwidth = ($width_orig / $ratio);
										if($fwidth > $maxW){
											$ratio = ($fwidth / $maxW);
											$fwidth = $maxW;
											$fheight = ($fheight / $ratio);
										}
									}
								}
								if($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0){
									die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
								}
								if($fheight < 45){
									$blank_height = 45;
									$top_offset = round(($blank_height - $fheight)/2);
								}else{
									$blank_height = $fheight;
								}
							}
							$image_p = imagecreatetruecolor($fwidth, $blank_height);
							$white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
							imagefill($image_p, 0, 0, $white);
							switch($filetype){
								case "gif":
									$image = @imagecreatefromgif($_FILES[$fileName]['tmp_name']);
								break;
								case "jpg":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "jpeg":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "png":
									$image = @imagecreatefrompng($_FILES[$fileName]['tmp_name']);
								break;
								case "GIF":
									$image = @imagecreatefromgif($_FILES[$fileName]['tmp_name']);
								break;
								case "JPEG":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "JPG":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "PNG":
									$image = @imagecreatefrompng($_FILES[$fileName]['tmp_name']);
								break;
							}
							@imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
							switch($filetype){
								case "gif":
									if(!@imagegif($image_p, $save)){
										$errorList[]= "PERMISSION DENIED [GIF]";
									}
								break;
								case "jpg":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPG]";
									}
								break;
								case "jpeg":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPEG]";
									}
								break;
								case "png":
									if(!@imagepng($image_p, $save, 0)){
										$errorList[]= "PERMISSION DENIED [PNG]";
									}
								break;
								case "GIF":
									if(!@imagegif($image_p, $save)){
										$errorList[]= "PERMISSION DENIED [GIF]";
									}
								break;
								case "JPG":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPG]";
									}
								break;
								case "JPEG":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPEG]";
									}
								break;
								case "PNG":
									if(!@imagepng($image_p, $save, 0)){
										$errorList[]= "PERMISSION DENIED [PNG]";
									}
								break;
							}
							@imagedestroy($filename);
						}else{
							$errorList[]= "CANNOT MAKE IMAGE IT ALREADY EXISTS";
						}	
					}
				}		
			}
		}else{
			$errorList[]= "NO FILE SELECTED";
		}
		if(!$match){
			$errorList[]= "File type isn't allowed: $filename";
		}
		if(sizeof($errorList) == 0){
			//return $fullPath.$newfilename;
			return $newfilename;
		}else{
			$eMessage = array();
			for ($x=0; $x<sizeof($errorList); $x++){
				$eMessage[] = $errorList[$x];
			}
			return $eMessage;
		}
	}
}	
	
?>
