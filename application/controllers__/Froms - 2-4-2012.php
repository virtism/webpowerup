<?php

if(!session_start()){

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

        $this->template->set_template('gws');

        $this->load->model('Registration_Forms_Model');  

        $this->load->library('my_template_menu');

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

        if($this->input->post('action') == 'done')

        {

           //print_r($_REQUEST);

		   //exit;

		   $this->form_id = trim($this->input->post('form_id'));

           $form_detail = $this->Registration_Forms_Model->get_Form($this->form_id);

		   if($form_detail['form_payment_required'] == 1)

           {

              // go to google check out                 

           } 

           

            $total = count($this->input->post('field'));

           // echo $total.":: ToTal >>>>>>>>>>>>";  exit();

            $items = $this->input->post('field');

            $form_values_arr = array ();

            $msg_bdy = ''; 

            $i=0;  

            foreach($items as $key => $item)

            {   //  is_array($items)

                

                $form_values_arr[$i]['value'] = $item['value'];

                $form_values_arr[$i]['name'] = $item['name'];

                

                $msg_bdy .=  $form_values_arr[$i]['name'].' : '.$form_values_arr[$i]['value'].' \n ';

                $i++;

               // $form_data = $this->Registration_Forms_Model->form_fields_value_save($field,$id );    

            } 

            //echo '<pre>'; print_r($form_values_arr); exit();

            

            		$message = '';

                    $message .=  "This email send via Global Online Website Solutions  \n\n Please Dont Reply it  \n ";

                    $message .=  " \n                                

                                    # ------------------------ 

                                    ";

                    $message .=  $msg_bdy;

                    $message .=  "               

                                    # ------------------------ 

                                  \n

                                  ";

                    $message .= "Thanks for using Our Forms 

                                \n ";

                    $message .= 'http://globalonlinewebsitesolutions.com/';

                    

                    //echo   $message;

                   // exit;  

                    // #### send mail #### //

                    

                    $this->load->library('email');

                    

                    $this->email->from('admin@globalonlinewebsitesolutions.com', 'Global Online Website Solutions : sahil_bwp@yahoo.com');

                    $this->email->to($form_detail['form_email_to']);

                   // $this->email->cc('sahil_bwp@yahoo.com');

                   // $this->email->bcc('them@their-example.com');



                    $this->email->subject($form_detail['form_title'].' | Form mail');

                    $this->email->message($message);



                    $this->email->send();

            

                if($form_detail['form_complete_action'] == 'Show Thank You'){

                  //show thank u test  

                }else if($form_detail['form_complete_action'] == 'Redirect URL'){

                   // redirect to url 

                }else if($form_detail['form_complete_action'] == 'Add User To Group'){

                    // add user to gruop

                }

            

                redirect(base_url().index_page().'Froms/show_thank_u/'.$this->form_id, 'location');

            

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

        

        $this->template->write('description', $page_desc); 

        $this->template->write('keywords', $page_keywords); 

        //$this->template->write('header', $header);

        //$this->template->write('background', $background);

           

           

         $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);

         $site_user_id = 0 ;

		 

		 if(isset($_SESSION['user_info']['user_id']))

		 {

			$site_user_id = $_SESSION['user_info']['user_id'];

		 }



		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 

		$data['other_top_navigation'] =  $other_top_navigation;   


          $data['menu'] =  $top_site_menu_basic;

         

          

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

          //echo '<pre>';   print_r($data['form_data']);  exit();

           //$this->load->view('Registration_Froms_View_User',$data); 

          $this->template->write_view('content','Registration_Froms_View_User',$data);

          $this->template->render();  

        }

         

         

     }

     

      // method to soft delete contact

      function show_thank_u($form_id =0)

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

           

           

         $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);

         /*if(isset($_SESSION['user_info']['user_id']))

         {*/

            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id); 

            $data['other_top_navigation'] =  $other_top_navigation;   

         /*} */          



          $data['menu'] =  $top_site_menu_basic;

         

          

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

      





      

      

      

      

  }

?>

