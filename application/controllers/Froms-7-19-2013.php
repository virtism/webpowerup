<?php
if(!session_start())
{
    session_start();
}
  class Froms extends CI_Controller{
    public $ck_data =  array(); 
    var $site_id;
    var $form_id;
    var $user_id;
    var $temp_name;
      function __construct()
      {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->load->library('session');
        $this->template->set_template('gws');
        $this->load->model('Registration_Forms_Model');  
		$this->load->model('Footer_Model'); 
        $this->load->library('my_template_menu');
		$this->load->library('Paypal_Lib');
		$this->load->model('Shop_model');
        if(isset($_SESSION['site_id']))
		{
			$this->site_id = $_SESSION['site_id'];   
		}
		else
		{
			$this->site_id = $this->uri->segment(3);
		}
        if(isset($_SESSION['user_info']['user_id']))
		{
	
			$this->user_id = $_SESSION['user_info']['user_id']; 	
	
		}
	
		else
	
		{
	
			$this->user_id = 0; 
	
		}
        $this->temp_name =  $this->my_template_menu->set_get_template($this->site_id);     
      }
      
      function index($site_id = 0, $form_id = 0)
      { 
        // $form_id = $this->uri->segment(3);
		//$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>"; 
		   //  DebugBreak();
        if($this->input->post('action') == 'done')
        {
           $this->form_id = trim($this->input->post('form_id'));
           $form_detail = $this->Registration_Forms_Model->get_Form($this->form_id);
		   /*echo '<pre>';
		   //print_r($_REQUEST);
		   print_r($form_detail);
		   exit;*/
		   if($form_detail['form_payment_required'] == 1)
           {
              // go to google check out      
			  $customer_id = ( isset($_SESSION['login_info']['customer_id']) ) ? $_SESSION['login_info']['customer_id'] : 0 ;
			  $this->Registration_Forms_Model->save_form_customer_submits($this->form_id,$customer_id);  
			  $this->session->set_userdata('payment_request', 'Your form has been submitted successfully. Please submit your payment for completing procedure.');        
           } 
           
            $total = count($this->input->post('field'));
           //echo $total.":: ToTal >>>>>>>>>>>>";  exit();
            $items = $this->input->post('field');
			//echo "<pre>";		print_r($_POST);	 
			//echo "<pre>";		print_r($items);	die();  
            $form_values_arr = array ();
            $msg_bdy = ''; 
            $i=0;  
			$flag = 0;
			
						
			foreach($items as $key => $item)
			{ 	
			
				if(!empty($item['value']) && !empty($item['name']))
				{
					if( is_array($item['value']) )
					{
						$form_values_arr[$key]['name'] = $item['name'];
						$form_values_arr[$key]['value'] = implode(",",$item['value']);
					}
					else
					{
						$form_values_arr[$key]['name'] = $item['name'];
						$form_values_arr[$key]['value'] = $item['value'];
					}
					$msg_bdy .=  $form_values_arr[$key]['name'].' : '.$form_values_arr[$key]['value']."<br>";
				}
				
				
			}
			
					// echo "<pre>";		print_r($form_values_arr);	die();  
				//	echo $form_detail['form_email_to'];
					
					$form_data_save = $this->Registration_Forms_Model->save_form_data($form_values_arr, $this->form_id);
            
            		$message = "";
                    $message .=  "This email send via WebpowerUp Please Dont Reply it"."<br>";
                    $message .=  $msg_bdy;
                    $message .= "Thanks for using Our Forms<br>";
                    $message .= "<a href='".base_url()."' >".base_url()."</a>";
                    
                    // #### send mail #### //
                    $this->load->library('email');
                    $config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = "html";
					$this->email->initialize($config);
			
					$this->email->from('support@webpowerup.com', 'WebpowerUp');
                    $this->email->to($form_detail['form_email_to']);
                    $this->email->subject("WebpowerUp | ".$form_detail['form_title']);
                    $this->email->message($message);
                    $this->email->send();
					
					//$this->email->print_debugger();
                   // echo print_r($this->session->all_userdata());     exit;
				$payment_request = $this->session->userdata('payment_request'); 
				if(!empty($payment_request))
				{
					$site_id = $form_detail['site_id']; // site id
					$form_id = $form_detail['form_id']; // page id 
				  	$action = "Froms/index/".$site_id."/".$form_id;
					redirect($action);
				}					
                else if($form_detail['form_complete_action'] == 'Redirect URL')
				{
					// redirect to url
					$site_id = $form_detail['site_id']; // site id
					$page_id = $form_detail['form_redirect_to']; // page id
					$action = "site_preview/page/".$site_id."/".$page_id;
					redirect($action);
                    
                }
				else if($form_detail['form_complete_action'] == 'Show Thank You') 
				{
                  //show thank u test 
				  	$site_id = $form_detail['site_id']; // site id
					$form_id = $form_detail['form_id']; // page id 
				  	$action = "Froms/show_thank_u/".$site_id."/".$form_id;
					redirect($action);
                }
				
				
                redirect(base_url().index_page().'Froms/show_thank_u/'.$this->site_id.'/'.$this->form_id, 'location');
        }
        else
        {
			$this->form_id  =  $form_id;    
			$data = array ();
			$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
			$rowHomepage = $rsltHomepage->row_array();
			$data["mode"] = '';
			$data["site_id"] = $rowHomepage["site_id"];
			$data["page_id"] = $rowHomepage["page_id"];
			$page_status = $rowHomepage["page_status"];
			$page_id = $rowHomepage["page_id"];       
			$data["site_name"] = $rowHomepage["site_name"];
			$page_title = $rowHomepage["page_title"];
			$page_desc = $rowHomepage["page_desc"]; 
			$page_keywords = $rowHomepage["page_keywords"];
			$page_header = $rowHomepage["page_header"];
			$data['page_header'] = $page_header;
			$header_background = $rowHomepage["header_background"];
			$data['header_background'] = $header_background;
			$data['header_background_image'] = ''; 
			$data["footer_content"] = "";
			//This is for Footer Dynamic
			$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
			if(!empty($footer_content))
			{
			  $data["footer_content"] = $footer_content["content"];
			}			
			$page_background = $rowHomepage["page_background"];
			$page_start_date = $rowHomepage["page_start_date"];
			$page_end_date = $rowHomepage["page_end_date"];
			$page_access = $rowHomepage["page_access"];
			
			$_SESSION['site_id'] = $data["site_id"];
			
			 if(trim($page_title) == 'Home')
			 {
			   $data['ishome'] = 'yes';  
			 }else
			 {
				 $data['ishome'] = 'no';
			 }
					
			if($page_header == "Other")
			{
				//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
				$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
				
				//$data["header_image"] =  '<div style="height: 100px; background-image: url('."'".$header_image."'".'); background-repeat:no-repeat; background-size:960px 100px;">
				//</div>';
			}
			else if($page_header == "Slideshow")
			{
				//$header_image = $this->Site_Model->getSlideshowHeaderImgs($page_id);
				$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
				//$header = '<div class="slideshow">';
				//foreach($header_image->result_array() as $rowImage)
				//{
				//    $header .= '<img src="'.base_url().'headers/'.$rowImage["header_image"].'" width="100%" height="150" />';    
				//}
				//$header .= '</div>';
			} 
			else
			{
				$header = "";         
			}
			
			if($header_background=='Image')
			{
				$data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
			} 
			
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
			$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
			$this->template->add_js('js/jquery-1.5.1.min.js');
			$this->template->add_js('js/jquery.cycle.all.js');
			$this->template->add_js('js/arial.js');
			$this->template->add_js('js/radius.js');
			$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
			$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
			
			$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
			$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
			
			//exit;
			//print_r($arrayRegions['header']);exit;
			//$this->template->set_template('vantage');
			
			$pageMenus["page_id"] = $page_id;
			$pageMenus["site_id"] = $this->site_id; 
			
			//$this->template->write('title', $page_title);
			
		   
			
			$this->template->write('description', $page_desc); 
			$this->template->write('keywords', $page_keywords); 
			//$this->template->write('header', $header);
			//$this->template->write('background', $background);
			   
			   
			 // menu requiired variable 
			$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
			$is_seo_enabled = $this->config->item('seo_url');
			$site_id = $_SESSION['site_id'];
			$temp_name =  $this->my_template_menu->set_get_template($site_id); // template name
			
			//get & set site template
			
			$temp_name =  $this->my_template_menu->set_get_template($site_id); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			 
			 
			 $site_user_id = 0 ;
			 if(isset($_SESSION['user_info']['user_id']))
			 {
				$site_user_id = $_SESSION['user_info']['user_id'];
			 }
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 
			$data['other_top_navigation'] =  $other_top_navigation;   
			  
			 
			  
			  $this->template->write_view('menu', $this->temp_name.'/menu', $data);  
				$data['forums'] = 'customers';
				$Regions = $this->template->regions;
				if(isset($Regions['sidebar']))
				{
					$data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);
					$this->template->write_view('sidebar',$this->temp_name.'/sidebar', $data); 
				}
				else if(isset($Regions['leftbar']))
				{
					$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
					$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
					$data['left_menus_type'] = 'site'; 
					$this->template->write_view('leftbar',$this->temp_name.'/leftbar', $data); 
				}else if(isset($Regions['rightbar'])){   
					$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
					$this->template->write_view('rightbar',$this->temp_name.'/rightbar', $data);     
				}     
				
				$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
				$data['footer_navigation'] =  $footer_navigation;
				if(isset($Regions['footer']))
				{
					$this->template->write_view('footer',$this->temp_name.'/footer', $data);          
				}
				$contact_data= array ();
				$data['form_data'] = $this->Registration_Forms_Model->registration_form_data($this->form_id); 
				$data['form_fields'] = $this->Registration_Forms_Model->registration_form_fields($this->form_id);  
				$data['form_detail'] = $this->Registration_Forms_Model->get_Form($this->form_id);
			    
				$data['is_loggedin'] = ( isset($_SESSION['login_info']['customer_id']) ) ? true : false; 
				if ( $data['is_loggedin'] )
				{
					$data['is_user_paid'] = $this->Registration_Forms_Model->if_customer_paid_for_the_form($this->form_id,$_SESSION['login_info']['customer_id']);
					$data['is_user_submit'] = $this->Registration_Forms_Model->if_customer_submitted_the_form($this->form_id,$_SESSION['login_info']['customer_id']);
				}
			   //echo '<pre>';   print_r($data['form_detail']);  exit();
			   $payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
			   $data['payPal_id'] = $payPal_id; 
			  $this->template->write_view('content','Registration_Froms_View_User',$data);
			  $this->template->render();  
        }
         
         
     }
     
      // method to soft delete contact
      function show_thank_u($site_id = 0, $form_id =0)
      {
        $this->form_id  =  $form_id;    
        $data = array ();
        $rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
        $rowHomepage = $rsltHomepage->row_array();
        
        $data["mode"] = '';
        $data["site_id"] = $rowHomepage["site_id"];
        $data["page_id"] = $rowHomepage["page_id"];
        
        $page_status = $rowHomepage["page_status"];
        $page_id = $rowHomepage["page_id"];       
        $data["site_name"] = $rowHomepage["site_name"];
        $page_title = $rowHomepage["page_title"];
        $page_desc = $rowHomepage["page_desc"]; 
        $page_keywords = $rowHomepage["page_keywords"];
        $page_header = $rowHomepage["page_header"];
        $data['page_header'] = $page_header;
        
        $header_background = $rowHomepage["header_background"];
        $data['header_background'] = $header_background;
        $data['header_background_image'] = ''; 
        
        $page_background = $rowHomepage["page_background"]; 
        $page_start_date = $rowHomepage["page_start_date"];  
        $page_end_date = $rowHomepage["page_end_date"];  
        $page_access = $rowHomepage["page_access"];
        $_SESSION['site_id'] = $data["site_id"];
        
		if(trim($page_title) == 'Home')
        {
          $data['ishome'] = 'yes';  
        }else
        {
            $data['ishome'] = 'no';
        }
        if($page_header == "Other")
        {
            //$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
            $data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
            
            //$data["header_image"] =  '<div style="height: 100px; background-image: url('."'".$header_image."'".'); background-repeat:no-repeat; background-size:960px 100px;">
            //</div>';
        }
        else if($page_header == "Slideshow")
        {
            //$header_image = $this->Site_Model->getSlideshowHeaderImgs($page_id);
            $data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
            //$header = '<div class="slideshow">';
            //foreach($header_image->result_array() as $rowImage)
            //{
            //    $header .= '<img src="'.base_url().'headers/'.$rowImage["header_image"].'" width="100%" height="150" />';    
            //}
            //$header .= '</div>';
        } 
        else
        {
            $header = "";         
        }
        
        if($header_background=='Image')
        {
            $data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
        } 
        
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
        $temp_name =  $this->my_template_menu->set_get_template($this->site_id);
        $this->template->add_js('js/jquery-1.5.1.min.js');
        $this->template->add_js('js/jquery.cycle.all.js');
        $this->template->add_js('js/arial.js');
        $this->template->add_js('js/radius.js');
        $this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
        $this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
        
        $this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
        $this->template->add_css('js/nivo-slider/nivo-slider.css'); 
        
        //exit;
        //print_r($arrayRegions['header']);exit;
        //$this->template->set_template('vantage');
        
        $pageMenus["page_id"] = $page_id;
        $pageMenus["site_id"] = $this->site_id; 
        
        //$this->template->write('title', $page_title);
        
        $data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
        $this->template->write_view('logo', $temp_name.'/logo', $data);
        
        $this->template->write('description', 'forms'); 
        $this->template->write('keywords', 'forms'); 
        //$this->template->write('header', $header);
        //$this->template->write('background', $background);
           
           
         // menu requiired variable 
			$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
			$is_seo_enabled = $this->config->item('seo_url');
			$site_id = $_SESSION['site_id'];
			$temp_name =  $this->my_template_menu->set_get_template($site_id); // template name
			
			//get & set site template
			
			$temp_name =  $this->my_template_menu->set_get_template($site_id); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
         /*if(isset($_SESSION['user_info']['user_id']))
         {*/
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id); 
            $data['other_top_navigation'] =  $other_top_navigation;   
         /*} */          
          
         
          
          $this->template->write_view('menu', $this->temp_name.'/menu', $data);
          
            $data['forums'] = 'customers';
            $Regions = $this->template->regions;
            if(isset($Regions['sidebar']))
            {
                $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);
                $this->template->write_view('sidebar',$this->temp_name.'/sidebar', $data); 
            }
            else if(isset($Regions['leftbar']))
            {
                $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
                $data['left_menus_type'] = 'site'; 
                $this->template->write_view('leftbar',$this->temp_name.'/leftbar', $data); 
            }else if(isset($Regions['rightbar'])){   
                $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
                $this->template->write_view('rightbar',$this->temp_name.'/rightbar', $data);     
            }     
            
            $footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
            $data['footer_navigation'] =  $footer_navigation;
            if(isset($Regions['footer']))
            {
                $this->template->write_view('footer',$this->temp_name.'/footer', $data);          
            }
			
            $contact_data= array();
           // $data['form_data'] = $this->Registration_Forms_Model->registration_form_data($this->form_id); 
           // $data['form_fields'] = $this->Registration_Forms_Model->registration_form_fields($this->form_id);  
           // $data['form_detail'] = $this->Registration_Forms_Model->get_Form($this->form_id);  
           //echo '<pre>';   print_r($data['form_detail']);  exit();
			$data['form_detail'] =  $this->Registration_Forms_Model->get_Form($this->form_id); 
           //$data['form_detail'] =  $form_detail['form_thank_u'];
          //$this->load->view('Registration_Froms_View_User',$data); 
          $this->template->write_view('content','thanku_form',$data);
          $this->template->render(); 
      }
	  
	  function save_payment()
	  {
		  $is_loggedin = ( isset($_SESSION['login_info']['customer_id']) ) ? true : false; 
		  
		  if ( $is_loggedin)
		  {
			  // echo "<pre>";	print_r($_REQUEST); 	die();
			  
			  $r = $this->Registration_Forms_Model->save_form_payment(); 
			  if ( $r )
			  {
				  redirect("Froms/index/".$_SESSION['site_id']."/".$_REQUEST['item_number']);
			  }
		  }
          else if(!empty($_REQUEST['payer_status']))
          {
                
                redirect("Froms/show_thank_u/".$_SESSION['site_id']."/".$_REQUEST['item_number']);
                
          }
         //echo '<pre>'; print_r($_REQUEST);    exit;
         
	  }
  }
?>