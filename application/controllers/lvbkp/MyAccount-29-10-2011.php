<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class MyAccount extends CI_Controller {
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
        $this->load->library('cart');
        
        $this->load->helper('security');
        if(isset($_SESSION['login_info']['customer_id'])){
          $this->customer_id =  $_SESSION['login_info']['customer_id'];
        }
        $this->site_id = $_SESSION['site_id'];
      //  $_SESSION['step'] = 'step1';
       // $this->flage_step = ''; 
       
         $this->load->helper('url');      
         $this->load->helper('html'); 
         $this->load->library('template');
         $this->load->library('my_template_menu');
         $this->site_id = $_SESSION['site_id'];   
         $this->user_id = $_SESSION['user_info']['user_id']; 
         $this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
 
    }
 
  function index()
  {
     // echo '<pre>';
     // print_r($_SESSION);
     // exit();
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
           
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data);  
           $data['customers'] = $this->customers_model->getAllCustomers();
           $data['module'] = 'customers';

            $this->template->write_view('content','ecommerce/MyAccount_Home',$data);
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

                      $Regions = $this->template->regions;
        if(isset($Regions['sidebar']))
        {
          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
           
        }
        else
        {  
            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
        } 
            
            
            $this->template->render();
  }

  function login()
  {

        $data["log_in"] = $this->input->post('log_in');  
        if ($this->input->post('action') && $this->input->post('action') == 'do_login'){
                
                if($this->customers_model->do_login($this->site_id))
                {
                    redirect(base_url().index_page().'MyAccount','refresh');        
                }
                else
                {
                    if($this->input->post('log_in') == 'shiptime')
                    {
                        redirect(base_url().index_page().'site_preview/site/'.$this->site_id);   
                    }else
                    {
                        redirect(base_url().index_page().'MyAccount/login','refresh'); 
                        
                    }
                    
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
            
            
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            /*$this->template->write('title', 'Online Shop'); */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

            
            $data['title'] = "Authentication";
            $data['module'] = 'MyAccount';
            $data['log_in'] = 'Myshop';
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/Login.php',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

            $Regions = $this->template->regions;
            if(isset($Regions['sidebar']))
            {
              $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
              $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
               
            }
            else
            {  
                $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
                $data['left_menus_type'] = 'site'; 
                $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
                
                $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
                $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
            } 
                
                $this->template->render();
                
                
        }    
      
      
  }
  function logout ()
  {
      //@@@@ For Only PHP Session @@@//
        
           // session_unset();
           // session_destroy();  
            unset($_SESSION['login_info']);
         //  session_destroy($_SESSION['login_info']);
            
          //  $_SESSION[] = array();
            //$_SESSION['user_info'] = array();
           redirect(base_url().index_page().'MyAccount/login','refresh'); 
        //---------------------------------------------------------------------//
        
        //######## For Using Codeigniter Session Class ####### //
        
       /* $this->session->sess_destroy();
        $this->session->unset_userdata('is_logged_in');
        redirect(base_url().index_page().'UsersController/login/sitelogin');   */
      
  }
  
  function register ()
  {
         if ($this->input->post('action') && $this->input->post('action') == 'addCustomer'){
                $mail = $this->input->post('email');
                $password = $this->input->post('password');
                     
                if($this->customers_model->addCustomer($this->site_id))
                {
                    $message = '';
                    $message .=  "Congratulation !  \n\n Your signup process copmlete \n ";
                    $message .=  ' \n
                                  
                                    # ------------------------ 
                                    # Login Mail: '.$mail.' 
                                    # Password: '.$password.' 
                                    # ------------------------ 
                                  \n
                                  ';
                    $message .= "Thanks for using Our Services 
                                \n ";
                    $message .= 'http://globalonlinewebsitesolutions.com/';
                    
                   // echo   $message;
                   // exit;  
                    // #### send mail #### //
                    
                    $this->load->library('email');
                    
                    $this->email->from('admin@globalonlinewebsitesolutions.com', 'Global Online Website Solutions : sahil_bwp@yahoo.com');
                    $this->email->to($mail);
                    $this->email->cc('sahil_bwp@yahoo.com');
                   // $this->email->bcc('them@their-example.com');

                    $this->email->subject('Signup | System Confirmation Mail');
                    $this->email->message($message);

                    $this->email->send();
                   // echo $this->email->print_debugger();
                    
                    
                    
                    
                    
                    redirect(base_url().index_page().'MyAccount/login','refresh');
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
            
            
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            /*$this->template->write('title', 'Online Shop');  */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 
           
             $this->template->add_js('js/validation/jquery.js');    
            $this->template->add_js('js/validation/jquery.validate.js');    
           // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
           // $this->template->add_js($my_js, 'embed'); 
            
            $data['title'] = "Create Profile";
            $data['module'] = 'MyAccount';
            $data['membership'] = $this->Groups_Model->dropdown_site_gropus();    
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/customers_create',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

                      $Regions = $this->template->regions;
        if(isset($Regions['sidebar']))
        {
          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
           
        }
        else
        {  
            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
        } 
            
            $this->template->render();      
        }
  }
  
  function AddressBook ()
  {
         if ($this->input->post('action') && $this->input->post('action') == 'addCustomer'){
                
               $this->customer_id = $_SESSION['login_info']['customer_id'];
                if($this->customers_model->address_book_ad($this->site_id, $this->customer_id))
                {
                    
                    redirect(base_url().index_page().'MyAccount/login','refresh');
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
            
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            /*$this->template->write('title', 'Online Shop');  */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

            
            $data['title'] = "Address book";
            $data['module'] = 'MyAccount';
            $data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
            $data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id);     
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/AddressBook',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

                          $Regions = $this->template->regions;
        if(isset($Regions['sidebar']))
        {
          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
           
        }
        else
        {  
            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
        } 
            
            $this->template->render();      
        }
  }
  
  
  function Password_Recovery()
  {
      
      
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
  
  function AddressBook_new ()
  {
         if ($this->input->post('action') && $this->input->post('action') == 'address_book_add'){
                
               $this->customer_id = $_SESSION['login_info']['customer_id'];
                if($this->customers_model->address_book_ad($this->site_id, $this->customer_id))
                {
                    
                    redirect(base_url().index_page().'MyAccount/AddressBook','refresh');
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
            
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            /*$this->template->write('title', 'Online Shop');  */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

           
            $this->template->add_js('js/validation/jquery.js');    
            $this->template->add_js('js/validation/jquery.validate.js');    
           // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
           // $this->template->add_js($my_js, 'embed');  
            
            $data['title'] = "Address book";
            $data['module'] = 'MyAccount';
            $data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
            $data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id);     
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/AddressBook_add',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

                        $Regions = $this->template->regions;
        if(isset($Regions['sidebar']))
        {
          $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
          $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
           
        }
        else
        {  
            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
        } 
            
            $this->template->render();      
        }
  }
  
  
   function account ()
  {
         if ($this->input->post('action') && $this->input->post('action') == 'updat_account'){
                
               $this->customer_id = $_SESSION['login_info']['customer_id'];
                if($this->customers_model->updateCustomer($this->site_id, $this->customer_id))
                {
                    
                    redirect(base_url().index_page().'MyAccount','refresh');
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
                    
                    
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            /*$this->template->write('title', 'Online Shop');  */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  

            
            $this->template->add_js('js/validation/jquery.js');    
            $this->template->add_js('js/validation/jquery.validate.js');    
           // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
           // $this->template->add_js($my_js, 'embed');  
            

           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

            
            $data['title'] = "My Account Informations";
            $data['module'] = 'MyAccount';
            $data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
            $data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
            $data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/customers_edit',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

               
              $Regions = $this->template->regions;
            if(isset($Regions['sidebar']))
            {
              $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
              $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
               
            }
            else
            {  
                $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
                $data['left_menus_type'] = 'site'; 
                $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
                
                $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
                $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
            }  
            
            $this->template->render();      
        }
  }
 
    function password_change ()
  {
      
         if ($this->input->post('action') && $this->input->post('action') == 'change_pass'){
                
               $this->customer_id = $_SESSION['login_info']['customer_id'];
                if($this->customers_model->change_password($this->site_id, $this->customer_id))
                {
                    
                    redirect(base_url().index_page().'MyAccount','refresh');
                }
                 
        }else{
            // print_r($_SESSION);  exit();
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
            
            
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
/*            $this->template->write('title', 'Online Shop'); */
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

            $this->template->add_js('js/validation/jquery.js');    
            $this->template->add_js('js/validation/jquery.validate.js');    
           // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
           // $this->template->add_js($my_js, 'embed'); 
           
            
            $data['title'] = "My Account Informations";
            $data['module'] = 'MyAccount';
            $data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
            $data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
            $data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
           // $this->load->view($this->_container,$data);
            $this->template->write_view('content','ecommerce/Password_change',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

               
              $Regions = $this->template->regions;
            if(isset($Regions['sidebar']))
            {
              $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
              $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
               
            }
            else
            {  
                $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
                $data['left_menus_type'] = 'site'; 
                $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
                
                $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
                $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
            }  
            
            $this->template->render();      
        }
  }
 
 
 
}//end class
?>