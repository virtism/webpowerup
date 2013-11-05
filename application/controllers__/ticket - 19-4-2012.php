<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_start()){

	session_start(); }  

class Ticket extends CI_Controller {

	var $site_id;  

	var $flage_step;

	var $customer_id;

	function __construct()

	{

		parent::__construct();



		$this->load->model('orders_model');

		$this->load->model('Categories_model');

		$this->load->model('product_model');

		$this->load->model('customers_model');

		$this->load->model('Groups_Model');

		$this->load->model('cart_model'); // Load our cart model for our entire class

		$this->load->model('shop_model');  

		$this->load->model('support_ticket_model'); //ticket model

		$this->load->model("Site_Model");
		
		$this->load->model('Footer_Model');

		$this->load->library('cart');

        $this->load->library('session');

		$this->load->helper('url');      

		$this->load->helper('html'); 

		$this->load->library('template');

		$this->load->library('my_template_menu');

		

		$this->load->helper('security');

		

		//$this->site_id = $_SESSION['site_id'];   

		

		//$this->site_id = $this->uri->segment(3, 0);

		

		if(isset($_SESSION['login_info']['site_id']))

		{

			$this->site_id = $_SESSION['login_info']['site_id'];

		}

		else

		{

			$this->site_id = $this->uri->segment(3, 0);

		}

		

		$this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 

 

	}

 

   function index()

  {

	  //echo '<pre>';

	  //print_r($_SESSION);

	  //exit();

		 

		 $site_user_id = "" ;

		 /*

		 if(isset($_SESSION['user_info']['user_id']))

		 {

			$site_user_id = $_SESSION['user_info']['user_id'];

		 }

		*/

		//echo $this->site_id; 	die();



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

		

		$_SESSION['site_id'] = $this->site_id;

		

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



		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');

		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');

		

		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 

		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 

		

		//exit;

		//print_r($arrayRegions['header']);exit;

		//$this->template->set_template('vantage');

		

		$pageMenus["page_id"] = $page_id;

		$pageMenus["site_id"] = $this->site_id; 

		

		

		

		$site_id = $this->site_id;

		$temp_name =  $this->my_template_menu->set_get_template($site_id); // template name

		

		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);

		$this->template->write_view('logo', $temp_name.'/logo', $data);

		//echo "<pre>";	print_r($data);		die();

		$this->template->write('title', "Support Ticket");

		$this->template->write('description', 'Create Ticket '); 

		$this->template->write('keywords', 'Ticket , login , logout, mycart'); 

		//$this->template->write('header', $header);

		//$this->template->write('background', $background);

		

		

		

		// menu requiired variable 

		

		$is_seo_enabled = $this->config->item('seo_url');

		$site_id = $this->site_id;

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

		 

		 $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 

		 $data['other_top_navigation'] =  $other_top_navigation;    

		



		  

		 

		  

		  $this->template->write_view('menu', $this->temp_name.'/menu', $data); 

		   

		   

		   

		   

			

		   $data['customers'] = $this->customers_model->getAllCustomers();

		   $data['module'] = 'customers';

		   

            /*    getting all department    */

            $data['query'] = $this->support_ticket_model->get_all_department_by_site($this->site_id);

            /*  ticket view */

            if($this->session->flashdata('msgTicket') == 1)

            {

                $data['msgResponse'] = "Ticket added successfully"; 

            }

            

			if( $this->session->flashdata('formError') != "" )

            {

				

                $data['formError'] = $this->session->flashdata('formError'); 

				

            }

			else

			{

				$data['formError'] ="";

			}

			/*

            if( ( isset($this->session->flashdata('msgSubject')) ) || ( isset($this->session->flashdata('msgSubject')) ) )

            {

                $data['msgSubject'] = $this->session->flashdata('msgSubject'); 

				$data['msgdepartment'] = $this->session->flashdata('msgdepartment'); 

            }

			*/

			$data['site_id'] = $site_id;

			$this->template->write_view('content','ecommerce/ticketTable',$data);

			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);

			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);

			$data['left_menus'] = $all_categories;  

			$data['left_menus_type'] = 'myshop'; 



		$Regions = $this->template->regions;

		

		if(isset($Regions['sidebar']))

		{

		  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  

		  $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 

		   

		}

		if(isset($Regions['rightbar']))

		{  

			$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);

			$this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     

		}

		if(isset($Regions['leftbar']))

		{

			$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);

			$data['left_menus_type'] = 'site'; 

			$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 

		}

		 	$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			  $this->template->write_view('footer', $temp_name.'/footer', $data);          
			}

		$this->template->render();

			

			

  } // end index

  

  function new_ticket($site_id)

  {

       

	   

		   

		   $this->load->helper("form");

		   $this->load->library('form_validation');

		   

		   $this->form_validation->set_rules('t_email', 'Your Email', 'required|valid_email');

		   $this->form_validation->set_rules('t_subject', 'Support Ticket Subject', 'required|xss_clean()'); 

		   $this->form_validation->set_rules('t_department_id', 'Department', 'required');

	   

		   if ($this->form_validation->run() == FALSE)

		   {

				

				

				$this->session->set_flashdata('formError', validation_errors() );

				

				

				redirect('ticket/index/'.$site_id);

		   }

		   else

		   {

				$r = $this->support_ticket_model->add_ticket();

				if($r)

				{

				  $this->session->set_flashdata('msgTicket',"1" );

				  redirect('ticket/index/'.$site_id);

				}

       	   }

      

      

      //die();

  }

  

  function my_ticket()

  {

     

        $this->is_login();

		

		//echo "<pre>"; 	print_r( $_SESSION );		die();

        $data = array ();

		

        $this->site_id = $_SESSION['login_info']['site_id'];

		

		

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

        

        $_SESSION['site_id'] = $this->site_id;

        

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

        

        $this->template->write('description', 'Create Ticket '); 

        $this->template->write('keywords', 'Ticket , login , logout, mycart'); 

        //$this->template->write('header', $header);

        //$this->template->write('background', $background);

           

           

         // menu requiired variable 

		

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



         $site_user_id = 0 ;

         

         if(isset($_SESSION['user_info']['user_id']))

         {

            $site_user_id = $_SESSION['user_info']['user_id'];

         }



        $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 

        $data['other_top_navigation'] =  $other_top_navigation;    

        



         

         

		  

		  $this->template->write_view('menu', $this->temp_name.'/menu', $data); 

		   

		   

		   

		   

			

		   $data['customers'] = $this->customers_model->getAllCustomers();

		   $data['module'] = 'customers';

			

			

			/*    getting all department    */

        	$data['query']=$this->support_ticket_model->get_loggedInUser_ticket();

			/*  ticket view */

			

			

			$this->template->write_view('content','ecommerce/my_ticket',$data);

			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);

			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);

			$data['left_menus'] = $all_categories;  

			$data['left_menus_type'] = 'myshop'; 



        $Regions = $this->template->regions;

        

        if(isset($Regions['sidebar']))

        {

          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  

          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 

           

        }

        if(isset($Regions['rightbar']))

        {  

            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);

            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     

        }

        if(isset($Regions['leftbar']))

        {

            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);

            $data['left_menus_type'] = 'site'; 

            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 

        }

         

        $this->template->render();

  }

  

  

  function ticket_detail()

  {

  		

		/*	template 	*/

		$this->is_login();

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

        

        $this->template->write('description', 'Create Ticket '); 

        $this->template->write('keywords', 'Ticket , login , logout, mycart'); 

        //$this->template->write('header', $header);

        //$this->template->write('background', $background);

           

           

         // menu requiired variable 

		

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



         $site_user_id = 0 ;

         

         if(isset($_SESSION['user_info']['user_id']))

         {

            $site_user_id = $_SESSION['user_info']['user_id'];

         }



        $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 

        $data['other_top_navigation'] =  $other_top_navigation;    

        



         

         

		  

		  $this->template->write_view('menu', $this->temp_name.'/menu', $data); 

		   

		   

		   

		   

			

		   $data['customers'] = $this->customers_model->getAllCustomers();

		   $data['module'] = 'customers';

			

			

			/*  N~   */

			$ticket_id = $this->uri->segment(3, 0);

			

			if($this->input->post("comment_post"))

			{

				$user_id = $_SESSION['login_info']['customer_id'];

				$r = $this->support_ticket_model->add_comment($ticket_id,$user_id);

				if($r == 1)

				{

					$this->session->set_flashdata("postResponse","Post was successful");

				}

			}

			

			$data['ticket'] = $this->support_ticket_model->get_ticket_by_id_frontEnd($ticket_id);

			$data['ticketComment'] = $this->support_ticket_model->get_ticket_comment($ticket_id);

			

			$data['ticket_id'] = $ticket_id;

        	$this->template->write_view('content','ecommerce/ticket_detail',$data);

			/*  ~N   */

			

			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);

			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);

			$data['left_menus'] = $all_categories;  

			$data['left_menus_type'] = 'myshop'; 



        $Regions = $this->template->regions;

        

        if(isset($Regions['sidebar']))

        {

          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  

          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 

           

        }

        if(isset($Regions['rightbar']))

        {  

            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);

            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     

        }

        if(isset($Regions['leftbar']))

        {

            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);

            $data['left_menus_type'] = 'site'; 

            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 

        }

         

        $this->template->render();

		/*	template	*/

		

  }

  

  function is_login()

  {

	  if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) ){

		   return true;

	  }else

	  {

		  redirect('MyAccount/login','refresh'); 

	  }

  }

  

 

 

}//end class

?>

