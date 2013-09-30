<?php
if(!session_start()){
	session_start();
}
//controller definition
class Page_editor extends CI_Controller
{
	//constructor for this controller
	function Page_editor()
	{
		parent::__construct(); 
		$this->load->model("Pages_Model"); 
		$this->load->model("Site_Model");  
		$this->load->model("Menus_Model");
        $this->load->model("Slideshow_Model");
		$this->load->library('session');    
		$this->load->helper('url');   
		$this->load->helper('html'); 
		$this->load->library('Template');
		$this->load->library('my_template_menu');
		$this->load->library('upload');
	}
	
	//verifies if user is logged in
	//if not: redirect to login screen
	function checkLogin()
	{
		//checks if session user_info is set
		if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return;
		}
	}
	
	function index($site_id, $page_id)
	{
		
		//confirm that user has logged-in
		$this->checkLogin();
		
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		
		$rowPage = $rsltPage->row_array();
		//echo "<pre>";
		//print_r($rowPage);
		//exit;
		//$rsltHomepage = $this->Site_Model->getHomepage($site_id);
		//$rowHomepage = $rsltHomepage->row_array();
		
		$data["mode"] = 'edit';
		$data["site_id"] = $rowPage["site_id"];
		$data["page_id"] = $rowPage["page_id"];
		
		$page_status = $rowPage["page_status"];
		$page_id = $rowPage["page_id"];       
		$data["site_name"] = $rowPage["site_name"]; 
		$page_title = $rowPage["page_title"];
		$page_desc = $rowPage["page_desc"]; 
		$page_keywords = $rowPage["page_keywords"];
		$page_header = $rowPage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowPage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = '';
		
		$page_background = $rowPage["page_background"];
		$data['page_background'] = $page_background; 
		$page_start_date = $rowPage["page_start_date"];  
		$page_end_date = $rowPage["page_end_date"];  
		$page_access = $rowPage["page_access"];
		
         if(trim($page_title) == 'Home')
         {
           $data['ishome'] = 'yes';  
         }else
         {
             $data['ishome'] = 'no';
         }
		
		if($page_header == "Other")
		{
			$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
		}
		else if($page_header == "Slideshow")
		{
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
		} 
		else
		{
			$header = "";         
		}
		
		if($header_background=='Image')
		{
			$data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
		}
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		
		if($page_background == "Default")
		{
			$data['background'] = "";        
		}
		else if($page_background == "Other")
		{
			//$background_image = $this->Site_Model->getBackgroundImage($page_id);
			$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
			$rowBackgroundImage = $rsltBackgroundImage->row_array();
			$background_path = base_url()."backgrounds/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
			//$background_image = $data['background_image'];    
			//$data['background'] = 'style="height:400px;width:690px;background-image: url('."'".base_url()."backgrounds/".$background_image."'".'); background-repeat: no-repeat; background-size:100% 100%"';
		}
		
		//get site template
		  
		//echo  $_SESSION['temp_name'];exit;  
		if(isset($_SESSION['temp_name']))
		{
			$temp_name =  $_SESSION['temp_name'];  
			$this->template->set_template($_SESSION['temp_name']);     
		}
		else
		{
			$temp_name =  $this->my_template_menu->set_get_template($site_id);    
		}
		//echo $temp_name;
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id);
		 $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id,$_SESSION['user_info']['user_id']);
		 //print_r($other_top_navigation); exit(); 
		 $data['menu'] =  $top_site_menu_basic;
		 $data['other_top_navigation'] =  $other_top_navigation;
		 
		 $top_site_menu_advance =  $this->my_template_menu->getTopNavigation($site_id, $page_id); 
		 $data['adv_menu'] =  $top_site_menu_advance;
		
		 $this->template->write_view('menu', $temp_name.'/menu', $data);  
		
		
		$flag_page_status = FALSE;
		
		$this->template->add_js('js/jquery-1.5.min.js');    //echo $str;exit;
		$this->template->add_js('js/jquery-ui-1.8.12.custom.min.js');    
		$this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css');    //echo $str;exit;
		$this->template->add_css('css/sidebuilder.css');    //echo $str;exit;
		$this->template->add_css('css/styles-dragable.css');    //echo $str;exit;
		
		$this->template->add_js('ckeditor/ckeditor.js');
		$this->template->add_js('js/fancybox/jquery.easing-1.3.pack.js');
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.pack.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		$this->template->add_js('js/jquery.cycle.all.js');  
		
		$my_js = '  $(document).ready(function() {
						$("a.edit_menu").fancybox({
							"width"                : "60%",
							"height"            : "95%",
							"autoScale"            : false,
							"transitionIn"        : "none",
							"transitionOut"        : "none",
							"type"                : "iframe"
						});
						
						$("a.edit_title").fancybox({
							"width"                : "45%",
							"height"            : "25%",
							"autoScale"            : false,
							"transitionIn"        : "none",
							"transitionOut"        : "none",
							"type"                : "iframe"
						});
						
						$("a.edit_advance").fancybox({
							"width"                : "45%",
							"height"            : "80%",
							"autoScale"            : false,
							"transitionIn"        : "none",
							"transitionOut"        : "none",
							"type"                : "iframe"
						});
					});
					
					function showEditor(id)
					{
						CKEDITOR.replace(id);
						//$("#para"+id)
						para = document.getElementById("div_para"+id);
						$(para).toggle();
						//save_button = document.getElementById("save"+id);
						edit_button = document.getElementById("edit"+id);
						//alert(edit_button);
						edit_button.style.visibility = "hidden";
						if(edit_button.style.visibility=="visible")
						{
							edit_button.style.visibility="hidden";
							edit_button.style.position="absolute";        
						} 
						
						return;
					}
					
					function save_content(id)
					{
						//alert("Content Saved="+id);
						document.getElementById("frmContent"+id).submit();
						return;
					}
					
					function box_load(id)
					{   
						//alert("fancy");
						//alert(id);
						var count2 = id.split("_");
						//alert(count[1]);
						$("#popup_id").val("para_"+count2[1]);                        
						$("#"+id).fancybox({
												"width"                : "70%",
												"height"            : "95%",
												"autoScale"            : false,
												"transitionIn"        : "none",
												"transitionOut"        : "none",  
												"type"                : "ajax"
											});
						
					}'.
					"                    
					function save_to_db(element_id)
					{
						//alert(element_id.style);
						var element = document.getElementById(element_id);
						//alert(element.style.borderStyle);
						element.style.borderStyle = 'none';
						var data = $('#'+element_id).val();
					  //  var page_id = $('#page_id').val();
						//alert(data);
						
						var coordsp     =   $('#'+element_id).position();
						
						var coordTopp   =   coordsp.top ;
						var coordLeftp  =   coordsp.left;
								
							//    alert(coordTopp);
								//alert(coordLeftp);
								
								
						var dataString = 'element_id=' + element_id +'&data=' + data + '&pos_top=' + coordTopp + '&pos_left=' + coordLeftp +'&page_id=<?=".$page_id."' ;
						//alert(dataString);
						var path='".base_url()."'+'index.php/pagesController/ajax_content_add/';
						$.ajax({
								type: ".'POST'.",
								url: path,
								//data: '',
								data: dataString,
						success: function(data) {
							
								//alert(data)
								//$('#response_test', data).each( function () {
								//status = $(this).text();
						//});
						// alert(status)
							if(status==1){
							//    document.getElementById('registartion_frm').action = path+".'"#signIn"'.";
							}
						},
						error:function(){
							alert(".'"somecvcnvnc error"'.");
							}
						});
					}
					
					function save_to_db_img(element_id)
					{    
						//alert('i am here ...');
						var data = $('#'+element_id).val();
						var src = $('#'+element_id).attr('src');

						//alert(src+'this is the source ');
					   // exit();
						
						var coordsp     =   $('#'+element_id).position();
						
						var coordTopp   =   coordsp.top ;
						var coordLeftp  =   coordsp.left;
								
							//    alert(coordTopp);
								//alert(coordLeftp);
								
								
						var dataString = 'element_id=' + element_id +'&src=' + src + '&pos_top=' + coordTopp + '&pos_left=' + coordLeftp +'&page_id=".$page_id."' ;
						//alert(dataString);
						var path='".base_url()."'+'index.php/pagesController/ajax_content_image_save/';
						$.ajax({
								type: "."'POST'".",
								url: path,
								//data: '',
								data: dataString,
						success: function(data) {
							
								//alert(data)
								//$('#response_test', data).each( function () {
								//status = $(this).text();
						//});
						// alert(status)
							if(status==1){
							//    document.getElementById('registartion_frm').action = path+"."'#signIn'".";
							}
						},
						error:function(){
							alert("."'Image saving Error '".");
							}
						});
					}
					
					function toogleToolbar()
					{
						//toolbar = document.getElementById('toolbar'); 
						txt_toolbar = document.getElementById('txt_toolbar');
						if(txt_toolbar.innerHTML=='show')
						{
							txt_toolbar.innerHTML = 'hide';  
						}
						else
						{
							txt_toolbar.innerHTML = 'show';      
						}
						$('div#toolbar').slideToggle('slow');
						
					}
					
					//editor board js starts here 21/sep/2011
					//editor board js starts here 21/sep/2011
					//editor board js starts here 21/sep/2011
					//editor board js starts here 21/sep/2011
					//editor board js starts here 21/sep/2011
					//editor board js starts here 21/sep/2011
					
					function sizeBox(id)
					{
						if((document.getElementById(id).value.length % 86) == 0)
						{
							document.getElementById(id).rows +=1;
						}
						
					}
					
					function show_hide_control(show_id,hide_id)
					{
						$('#'+show_id).show(); 
						$('#'+hide_id).hide();
						
						var counter_id = hide_id.split('_');
						
						$('#textarea_'+counter_id[1]).focus();
							
					}
					
					function show_hide(show_id,hide_id)
					{
						$('#'+show_id).show(); 
						$('#'+hide_id).hide();
						var ParentDiv = document.getElementById(show_id).childNodes;
						var ChildDivs = ParentDiv[0].childNodes;
						editor = CKEDITOR.replace( ChildDivs[2], {resize_enabled : 'false', width: '100%', height: '100'} );
						
						var counter_id = hide_id.split('_');
						$('#textarea_'+counter_id[1]).focus();
							
					}
					
					function apply_style(element,event)
					{
						 var style = 'border:1px dashed black; background-color:#E9E9E9;';
					}
					
					function getFocusedElement() 
					{
					  return document.activeElement;
					}
					
					function borderCheck(element)
					{
						object = getFocusedElement();
						if (!(object==element)) 
						{
							element.style.borderStyle = 'none';    
						}
					}
					
					
	
					function remove_item(e1)
					{   
						controls_count--;  
						var numControls = document.getElementById('".'numControls'."');
						numControls.value = controls_count;
						
						element = document.getElementById(e1);
						$(element).fadeOut('".'1000'."');
						".
						'setTimeout("element.innerHTML = '."'&nbsp;'".'", 1000);'
						."
						return;  
					}
					
					//var controls_count = 0;    
					"
					.
					'
					$(document).ready(function() 
					{
						// var count = 1;
						
					$(".item").draggable({
						revert: true   
					});
						
						$("#cart_items").droppable({
							accept: ".item",
							
							drop: function(event, ui) {
							
							var coordsp=[];
							var coordsc=[];  
							var item        =   ui.draggable.html();
							var itemid      =   ui.draggable.attr("id"); 
							
							'
							.
							"
							var coordsp     =   $('#cart_toolbar').position();
							
							var coordTopp   =   coordsp.top ;
							var coordLeftp  =   coordsp.left;
							
							var coordsc     =   $('#'+itemid).position();    
							
							var coordTopc   =   coordsc.top ;
							var coordLeftc  =   coordsc.left;
							var coordLeft   =   coordLeftc-coordLeftp;
							var coordTop    =   coordTopc-coordTopp;
							
							var numControls = document.getElementById('numControls');
							controls_count += 1; 
							numControls.value = controls_count; 
							//alert(numControls.value);
							count += 1;
							"
							.
							'
							if(itemid == "i1")
							{
							'
							.
							"
								var html        =  '<div id=\"item_'+count+'\"><a href=\"javascript: void(0);\" onclick=\"show_hide_control(\'item_cart_'+count+'\',\'item_'+count+'\')\">Click here to edit.</a></div><div id=\"item_cart_'+count+'\" style=\"position:relative; left: 0px; top:-2px;width:80%; display:none\">';
													html = html + '<div>';
													html = html + '<a onclick=\"remove_item('+\"'\"+'item_cart_'+count+\"'\"+');\" id=\"remove'+itemid+count+'\" name=\"textarea_'+count+'\" class=\"remove '+itemid+count+'\">&times;</a>';
													html = html + '<div/><textarea cols=\"75\" rows=\"3\" id=\"textarea_'+count+'\" name=\"content[]\" onkeyup=\"sizeBox(this.id)\"  onfocus=\"apply_style(this,\'focus\');\" onclick=\"apply_style(this,\'click\')\" onmouseover=\"this.style.border='+\"'dashed 1px black'\"+';\" onmouseout=\"borderCheck(this)\"></textarea><input type=\"hidden\" name=\"control_type[]\" value=\"textarea\"/><input type=\"hidden\" name=\"content_id[]\" value=\"\"/><input type=\"hidden\" name=\"content_type[]\" value=\"textarea\"/></div>';
							}
							"
							.
							'                                                                                                                      
							if(itemid == "para")
							{
							'
							.
							"
								var html        =  '<div id=\"item_'+count+'\" ><a href=\"javascript: void(0);\" onclick=\"show_hide(\'item_cart_'+count+'\',\'item_'+count+'\')\">Click here to edit.</a></div><div id=\"item_cart_'+count+'\"  style=\"  position: relative; left: 0px; top:-2px;width:80%;display:none\">';
													html = html + '<div>';
													html = html + '<a onclick=\"remove_item('+\"'\"+'item_cart_'+count+\"'\"+')\" id=\"remove'+itemid+count+'\" class=\"remove'+itemid+count+'\">&times;</a>';
													html = html + '<div/><textarea cols=\"86\" class=\"editor_ta\" rows=\"1\" id=\"para_'+count+'\" name=\"content[]\" onkeyup=\"sizeBox(this.id)\" onblur=\"save_to_db(this.id);\" onmouseover=\"this.style.border='+\"'dashed 1px black'\"+';\" onmouseout=\"borderCheck(this)\" onfocus=\"this.style.border='+\"'dashed 1px black'\"+';\"></textarea><input type=\"hidden\" name=\"control_type\" value=\"para\" /><input type=\"hidden\" name=\"content_id[]\" value=\"\"/><input type=\"hidden\" name=\"content_type[]\" value=\"para\"/></div>';
							}
							"
							.
							'
							if(itemid == "image")
							{
							'
							.
							"
								var html        =  '<div id=\"item_cart_'+count+'\"  style=\"  position: relative; left: 0px; top:-2px;width:80%;\">';
													html = html + '<div><input type=\"hidden\" id=\"input_para_'+count+'\" name=\"content[]\" value=\"\" />';
													html = html + '<a onclick=\"remove_item('+\"'\"+'item_cart_'+count+\"'\"+');\" id=\"remove'+itemid+count+'\" class=\"remove '+itemid+count+'\" name=\"image_'+count+'\">&times;</a>';
													html = html + '<div/><a id=\"image_'+count+'\" href=\"".base_url()."index.php/media/index/'+count+'\" ><img src=\"".base_url()."images/na.jpg\" id=\"para_'+count+'\" name=\"para_'+count+'\" onclick=\"box_load(\'image_'+count+'\')\" title = \" \" alt = \"\"  /></a><input type=\"hidden\" name=\"control_type\" value=\"image\" /><input type=\"hidden\" name=\"content_id[]\" value=\"\"/><input type=\"hidden\" name=\"content_type[]\" value=\"image\"/></div>';
													
														
							}
							"
							.
							'
							$("#cart_items").append(html);
							//count += 1;
							'
							.
							"
							var html        =  '<div id=\"item_cart_'+count+'\"  class=\"item icart\" style=\"  position: relative; left: 0px; top:-2px;width:80%;\">';
													html = html + '<div class=\"divrm\">';
													html = html + '<a onclick=\"remove(this)\" class=\"remove '+itemid+count+'\">&times;</a>';
													html = html + '<div/><textarea cols=\"60\" rows=\"5\" name=\"textarea_'+count+'\"></textarea>   </div>';
								
							}
						});
					   
					});
					
					function deleteMenu(menu_area, menu_id)
					{
						bool = confirm('Are you sure to delete this menu?');
						if(bool == true)
						{
							$(document.getElementById(menu_area)).fadeOut();
							$.ajax({
							url: '".base_url()."index.php/pagesController/deleteMenuInfo/'+menu_id,
							success: function(data)
									{
									}
							});    
						}
						else
						{
							return;
						}
					}
					
					function deleteContent(content_area, id)
					{
						numControls = document.getElementById('numControls');
						numControls--;
						bool = confirm('Are you sure to delete this Content?');
						if(bool == true)
						{
							var contentarea = document.getElementById(content_area); 
							//alert(contentarea);return;
							$(contentarea).fadeOut('1000');
							"
							.
							'setTimeout('."contentarea.innerHTML=null".', 1000);'
							."
							$.ajax({
							url: '".base_url()."index.php/pagesController/deleteContentInfo/'+id,
							success: function(data)
									{
									}
							});    
						}
						else
						{
							return;
						}
					}
					"; 
		
		$this->template->add_js($my_js, 'embed');
		
		//$data['content'] = $this->Site_Model->getPageContent($page_id);
		$data['content'] = $this->get_page_content($site_id, $page_id); 
		
		if($data['mode']=='edit')
		{
			$data['templates'] = $this->Pages_Model->get_all_templates();
			$data['is_page_edit'] = '0';
			$this->template->write_view('content','all_common/toolbox', $data);     
		}
        
        $data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'top');
        $data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'bottom');  
        $data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'left');  
        $data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'right');
		
		$this->template->write_view('content','all_common/content', $data); 
		//15092011
		//$this->template->write_view('header', 'all_common/header', $data);
		
		//get page regions
		$Regions = $this->template->regions;
		
		//see what region(s) are defined for menus: either Sidebar or Leftbar & Rightbar
		if(isset($Regions['sidebar']))
		//case: template with a sidebar region to show menus
		{
			//echo "exist";
			$data['menus'] = $this->my_template_menu->getSidebar($site_id, $page_id);
			$this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		}
		else if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}else if(isset($Regions['rightbar'])){   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		$footer_navigation =  $this->Menus_Model->footer_navigation($site_id);
		$data['footer_navigation'] =  $footer_navigation;
		if(isset($Regions['footer']))
		{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
		}                
			
		$this->template->render();   
			
	}
	
	/*
	function save_page_content_by_id($site_id, $page_id, $content_id)
	{
		//confirm that user has logged-in
		$this->checkLogin();
		
		$content = $this->input->post('content');
		if(isset($content))
		{
			$this->Pages_Model->save_page_content_by_id($content_id);
			redirect(base_url()."index.php/page_editor/index/".$site_id."/".$page_id);
		}
	}
	*/
	
	function get_page_content($site_id, $page_id)
	{   
		//confirm that user has logged-in
		$this->checkLogin();
		$i=0;
		$result = $this->Site_Model->get_page_content($page_id);
		if($result->num_rows()>0)
		{
			$content = "";
			foreach($result->result_array() as $row)
			{
				$i++;
				if($row['type']=="para")
				{
					$content .= '
					<div id="content_area_'.$i.'" style="border:1px dotted #CCCCCC; margin-bottom:3px;">
					
					<img title="Edit" id="edit'.$row['id'].'" src="'.base_url().'images/edit_icon.jpg" style="float: right;cursor: pointer; border:none;margin:0px;padding:0px;background:none;" onclick="showEditor('.$row['id'].')" />
					
					<span title="Delete" style="float: right; cursor:pointer" onclick="deleteContent('."'content_area_".$i."'".', '.$row['id'].')"><b>&nbsp;x&nbsp;</b></span>
					
					<input type="hidden" name="content_id[]" value="'.$row['id'].'" />
					<input type="hidden" name="content_type[]" value="'.$row['type'].'" />
					<div id="div_para'.$row['id'].'" onclick="showEditor('.$row['id'].')">'.$row['data'].'</div>';
					$content .= '<textarea id="'.$row['id'].'" name="content[]" style="display:none; visibility: hidden; position absolute;">'.$row['data'].'
					</textarea>
					</div>
					';    
				}
				if($row['type']=="textarea")
				{
					$content .= '
					<div id="content_area_'.$i.'" style="border:1px dotted #CCCCCC; margin-bottom:3px;">
					
					<img title="Edit" id="edit'.$row['id'].'" src="'.base_url().'images/edit_icon.jpg" style="float: right; border:none;margin:0px;padding:0px;background:none;" onclick="document.getElementById('.$row['id'].').style.border='."'".'dotted'."'".';" />
					
					<span title="Delete" style="float: right; cursor:pointer" onclick="deleteContent('."'content_area_".$i."'".', '.$row['id'].')"><b>&nbsp;x&nbsp;</b></span>
					
					<input type="hidden" name="content_id[]" value="'.$row['id'].'" />
					<input type="hidden" name="content_type[]" value="'.$row['type'].'" />
					
					<div><textarea id="'.$row['id'].'" name="content[]">'.$row['data'].'</textarea></div>
					</div>';
						
				}
				
				if($row['type']=="image")
				{
					$image_path = base_url()."media/uploads/";
					$content .= '
					<div id="content_area_'.$i.'" style="border:1px dotted #CCCCCC; margin-bottom:3px;">
					<div>
					<a id="image_'.$i.'" href="'.base_url().index_page().'media/index/'.$i.'">
					<img name="para_'.$i.'" id="para_'.$i.'" src="'.$image_path.$row['data'].'" onclick="box_load('."'image_".$i."'".')" />
					<input type="hidden" id="input_para_'.$i.'" name="content[]" value="'.$row['data'].'" />
					<input type="hidden" name="content_type[]" value="'.$row['type'].'" />
					</a>
					<input type="hidden" name="content_id[]" value="'.$row['id'].'" />
					<img title="Edit" id="edit'.$row['id'].'" src="'.base_url().'images/edit_icon.jpg" style="cursor: pointer; float: right; border:none;margin:0px;padding:0px;background:none;" onclick="document.getElementById('."'".'para_'.$i."'".').click();" />
					<span title="Delete" style="float: right; cursor:pointer" onclick="deleteContent('."'content_area_".$i."'".', '.$row['id'].')"><b>&nbsp;x&nbsp;</b></span>
					</div></div>
					';
					
				}
			}
			$content .= '<input type="hidden" name="popup_id" id="popup_id" value="" />
			<input type="hidden" name="numControls" id="numControls" value="'.$i.'" />
			<script language="" type="text/javascript">
				var count = '.$i.';
				var controls_count = '.$i.';
			</script>
			';
			return $content;            
		}
		else
		{
			$content = '
			<input type="hidden" name="popup_id" id="popup_id" value="" />
			<input type="hidden" name="numControls" id="numControls" value="'.$i.'" />
			<script language="" type="text/javascript">
				var count = '.$i.';
				var controls_count = '.$i.';
			</script>
			';
			return $content;
		}
	}
	
	function set_site_template($site_id, $page_id)
	{
		//confirm that user has logged-in
		$this->checkLogin();
		
		//set site's template in db
		if(isset($_SESSION['temp_id']))
		{
			$this->Pages_Model->set_site_template($site_id, $_SESSION['temp_id']);    
		}
		
		//goto page's editor's screen
		redirect('page_editor/index/'.$site_id.'/'.$page_id);
	}
	
	function tmp_set_site_template($site_id, $page_id, $temp_id, $temp_name)
	{
		//confirm that user has logged-in
		$this->checkLogin();
		
		//set site's template in db
		//$this->Pages_Model->set_site_template($site_id, $temp_id);
		$_SESSION['temp_id'] = $temp_id; 
		$_SESSION['temp_name'] = $temp_name;
		//echo $_SESSION['temp_name'];exit;
		//goto page's editor's screen
		redirect('page_editor/index/'.$site_id.'/'.$page_id);
	}
	
	function editMenuInfo($site_id, $id)
	{
		//confirms user is logged in
		$this->checkLogin();
		
		//prepares $data
		$data['site_id'] = $site_id; 
		$data['id'] = $id;
		$data['pages'] = $this->Menus_Model->getPages($site_id);        
		$data['roles'] = $this->Menus_Model->getRoles();
		$result = $this->Menus_Model->menuInfo($id); 
		$row = $result->row_array();
		$data["menu_name"] = $row["menu_name"];
		$data["menu_position"] = $row["menu_position"];        
		$data["menu_published"] = $row["menu_published"];
		if($data["menu_published"]=="Schedule"){ 
			//get menu date info if menu is scheduled for display           
			$data["menu_start"] = $row["menu_start"]; 
			$data["menu_end"] = $row["menu_end"];
		}
		else{
			//set dates to empty for $data preparation
			$data["menu_start"] = "";
			$data["menu_end"] = "";
		}
		//prepare $data
		$data["menu_pages"] = $row["menu_pages"];        
		$data["menu_access"] = $row["menu_access"];
		$data["menu_items"] =  $this->Menus_Model->menuItemsInfo($id); 
		$data["numItems"] = $data["menu_items"]->num_rows();
		
		//fill content region of the template with view menuInfoView.php having $data
		//$this->template->write_view('content','menuInfoView', $data);
		
		//display complete template
		//$this->template->render();                 
		$this->load->view("page_editor/editMenuInfo", $data);
	}
	
	//used to edit page header
	function editHeaderInfo($site_id, $page_id)
	{
		$rsltPageInfo = $this->Pages_Model->pageInfo($page_id);
		$rowPageInfo = $rsltPageInfo->row_array();
		$data['site_id'] = $site_id;
		$data['page_id'] = $page_id; 
		 
		$data['page_header'] = $rowPageInfo['page_header']; 
		$page_header = $rowPageInfo['page_header'];
		$data['header_background'] = $rowPageInfo['header_background'];
		$header_background = $rowPageInfo['header_background'];
		
		//get page other header info
		$rsltOtherHeaderInfo = $this->Pages_Model->getOtherHeaderInfo($page_id);
		$data['other_header_image'] = $rsltOtherHeaderInfo;         
		
		//get page slideshow header info
		$rsltSlideshowHeaderInfo = $this->Pages_Model->getSlideshowHeaderInfo($page_id);
		$data['slideshow_header_image'] = $rsltSlideshowHeaderInfo;   
		
		if($header_background == 'Image')
		{
			$data['header_background_image'] = $this->Pages_Model->getHeaderBackgroundImage($page_id);    
		}
		else
		{
			$data['header_background_image'] = '';   
		}
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		$this->load->view("page_editor/editHeaderInfo", $data);                    
	}
	
	//used to update page header
	function updateHeaderInfo($site_id, $page_id)
	{
		/*
		echo "<pre>";
		print_r($_POST);
		//echo "<pre>";
		print_r($_FILES);
		exit;
		*/
		$page_header = $this->input->post('page_header');
		
		if($page_header == 'Other')
		{
			if($_FILES['header_image']['tmp_name']!="")
			{
				$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image']['name'];
				$config['upload_path'] = './headers/';            
				$config['allowed_types'] = 'gif|jpg|png';                       
				$this->upload->initialize($config);
				
				$this->upload->do_upload('header_image');
				
				$header_image = $config['file_name'];
				//save header info in db
				$this->Pages_Model->updateOtherHeaderInfo($site_id, $page_id, $header_image);
				
			}
		}
		else if($page_header == 'Slideshow')
		{
			//upload / add new header images
			$numHeaderImages = $this->input->post("numHeaderImages"); 
			//echo "num=".$numHeaderImages;
			//delete previous slideshow header images           
			//$this->Pages_Model->deleteSlideshowHeaderImages($site_id, $page_id);
			
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				if($_FILES['header_image_'.$i]['tmp_name']!="")
				{
					$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image_'.$i]['name'];
					$config['upload_path'] = './headers/';            
					$config['allowed_types'] = 'gif|jpg|png';                       
				
					$this->upload->initialize($config);
					$this->upload->do_upload("header_image_".$i);
					
					$header_image = $config['file_name'];
					//save header info in db
					$this->Pages_Model->updateSlideshowHeaderInfo($site_id, $page_id, $header_image);
				}
			}
			//exit;        
		}
		else
		{
			//do nothing
		}
		
		
		$header_background = $this->input->post('header_background');
		if($header_background == 'Image')
		{
			if($_FILES["header_background_image"]["tmp_name"]!="")
			{
				$config['file_name'] = "bg_".$this->input->post("DateTime").$_FILES['header_background_image']['name'];
				$config['upload_path'] = './headers/';            
				$config['allowed_types'] = 'gif|jpg|png';                       
			
				$this->upload->initialize($config);
				$this->upload->do_upload("header_background_image");
				
				$header_background_image = $config['file_name'];
				//save header background info in db
				$this->Pages_Model->updateHeaderBackgroundInfo($site_id, $page_id, $header_background_image);                   
			}    
		}
		else if($header_background == 'Color')
		{
			$header_background = $this->input->post('header_background_color');        
		}
		else
		{
			//do nothing
		}
		
		//update page header information in db
		$this->Pages_Model->updatePageHeaderInfo($site_id, $page_id, $page_header, $header_background);
		//exit;
		//see the page header updates in action
		redirect('page_editor/index/'.$site_id.'/'.$page_id);
		
	} 
	
	//used to edit page header
	function editBackgroundInfo($site_id, $page_id)
	{
		$rsltPageInfo = $this->Pages_Model->pageInfo($page_id);
		$rowPageInfo = $rsltPageInfo->row_array();
		$data['site_id'] = $site_id;
		$data['page_id'] = $page_id; 
		 
		$data['page_background'] = $rowPageInfo['page_background'];
		$page_background = $rowPageInfo['page_background'];
		$data['background_id'] = '';
		$data['background_image'] = '';
		$data['background_status'] = '';
		$data['background_area'] = '';
		$data['background_style'] = '';
			  
		if($page_background == 'Other')
		{
			$rsltBackgroundInfo = $this->Pages_Model->getBackgroundInfo($page_id);
			$rowBackgroundInfo = $rsltBackgroundInfo->row_array();
			$data['background_id'] = $rowBackgroundInfo['background_id'];
			$data['background_image'] = $rowBackgroundInfo['background_image'];
			$data['background_status'] = $rowBackgroundInfo['background_status'];
			$data['background_area'] = $rowBackgroundInfo['background_area'];
			$data['background_style'] = $rowBackgroundInfo['background_style'];    
		}
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		$this->load->view("page_editor/editBackgroundInfo", $data);        
	} 
	
	function updateBackgroundInfo($site_id, $page_id)
	{
		/*
		echo "<pre>";
		print_r($_POST);
		exit;
		*/
		$page_background = $this->input->post('page_background');
		$background_id = $this->input->post('background_id'); 
		
		if($page_background != 'Default' && $page_background != 'Other')
		{
			$background_image = $this->input->post('page_background');    
		}
		else
		{
			$background_image = $this->input->post('background_image');;    
		}
		
		$background_status = $this->input->post('background_status');
		$background_area = $this->input->post('background_area');
		$background_style = $this->input->post('background_style');
		
		//if page background is set user changes it
		if($background_id!='' && ( $page_background == 'Other' || $page_background == 'Default' ) )
		{
			//delete existing background & image file  
			$this->Pages_Model->deleteBackgroundInfo($site_id, $page_id, $background_id, $background_image);
		}
		
		//if page background is set & user modifies the existing background
		if($background_id!='' && $page_background != 'Other' && $page_background != 'Default' )
		{
			//update existing background styles
			$this->Pages_Model->updateBackgroundInfo($background_id, $background_style, $background_area);
		}
		
		//user uploads / sets new background
		if($page_background == 'Other')
		{   
			if($_FILES["background_image"]["tmp_name"]!="")
			{            
				$config['file_name'] = $this->input->post("DateTime").$_FILES['background_image']['name'];
				$config['upload_path'] = './backgrounds/';            
				$config['allowed_types'] = 'gif|jpg|png';                       
				$this->upload->initialize($config);
				
				$this->upload->do_upload("background_image");            
			}
			$background_image = $config['file_name'];
			//upload & set new background
			$this->Pages_Model->addBackgroundInfo($page_id, $background_image, $background_style, $background_area);
		}
		
		if($page_background != 'Default' && $page_background != 'Other')
		{
			$page_background = 'Other';    
		}
		//update page background info
		$this->Pages_Model->updatePageBackgroundInfo($site_id, $page_id, $page_background);
		
		return true;    
	}   
	
	//used to edit page header
	function editPageTitle($site_id, $page_id)
	{
		$rsltPageInfo = $this->Pages_Model->pageInfo($page_id);
		$rowPageInfo = $rsltPageInfo->row_array();
		$data['site_id'] = $site_id;
		$data['page_id'] = $page_id; 
		 
		$data['page_title'] = $rowPageInfo['page_title'];
		$this->load->view("page_editor/editPageTitle", $data);    
	}
	
	function updatePageTitle($site_id, $page_id)
	{
		$page_title = $this->input->post('page_title');
		$this->Pages_Model->updatePageTitle($page_id, $page_title);
		return;    
	}    
	
	function editAdvanceInfo($site_id, $page_id)
	{
		$rsltPageInfo = $this->Pages_Model->pageInfo($page_id);
		$rowPageInfo = $rsltPageInfo->row_array();
		$data['site_id'] = $site_id;
		$data['page_id'] = $page_id; 
		 
		$data['page_keywords'] = $rowPageInfo['page_keywords'];
		$data['page_desc'] = $rowPageInfo['page_desc'];  
		$this->load->view("page_editor/editAdvanceInfo", $data);    
	}
	
	function updateAdvanceInfo($site_id, $page_id)
	{
		$page_keywords = $this->input->post('page_keywords');
		$page_desc = $this->input->post('page_desc');  
		$this->Pages_Model->updateAdvanceInfo($page_id, $page_keywords, $page_desc);
		return;        
		
	}
	
	function createMenu($site_id)
	{
		//confirm user logged in 
		$this->checkLogin(); 
		
		//prepare $data         
		$data['site_id'] = $site_id;
		$data['pages'] = $this->Menus_Model->getPages($site_id);        
		$data['roles'] = $this->Menus_Model->getRoles();
		
		//fill content region of template with addMenuView.php(view) and $data
		$this->load->view('page_editor/createMenu', $data);
	}
	
}
?>
