<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_start()){

    session_start(); }  

class customers extends CI_Controller {

    var $site_id;  

    var $flage_step;

    var $customer_id;

    function __construct()

    {

        parent::__construct();

        

        $this->load->helper('url');

        $this->load->library('form_validation');

        $this->load->library('Template');

        $this->template->set_template('gws');

        $this->load->model('orders_model');

        $this->load->model('Categories_model');

        $this->load->model('product_model');

        $this->load->model('customers_model');

        $this->load->model('Groups_Model');

        $this->load->helper('security');

        $this->site_id = $_SESSION['site_id'];
		
		$this->load->library('session');
		
      //  $_SESSION['step'] = 'step1';

       // $this->flage_step = ''; 

 

    }

 

  function index()

  {
	 
	$customer_link = current_url();
    $this->session->set_userdata("customer_link", $customer_link); 
	  
	$this->breadcrumb->clear();
	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
	$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
	$this->breadcrumb->add_crumb('Manage Customer'); 

    if($this->input->post('action')== 'search' && $this->input->post('sort_by') != NULL)

    {
			
			
			
          $search_by = trim($this->input->post('sort_by'));

          $search_value = trim($this->input->post('search_value'));

          $search_param = array('search_by'=> $search_by, 'search_value'=>$search_value);

    }else

    {

         $search_param = NULL;

    }  

 

    $data['title'] = "Manage Customers";
    $data['customers'] = $this->customers_model->getAllCustomers($this->site_id,$search_param);
	$data['users'] = $this->customers_model->getAllUsers($this->site_id,$search_param);
    $data['module'] = 'customers';
	$data['module'] = 'users';
    $this->template->write_view('content','ecommerce/customers_home_adm',$data);
    $this->template->render();

  }

 

  function customer_registration()

  {

	$this->breadcrumb->clear();
	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
	$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
	$this->breadcrumb->add_crumb('Manage Customer', $this->session->userdata("customer_link") ); 
	$this->breadcrumb->add_crumb('Customer Registration'); 
	
    if ($this->input->post('action')== 'addCustomer'){

        /*$this->load->library('form_validation');

        $rules['customer_first_name'] = 'required';

        $rules['password'] = 'required';

        $rules['passconf'] =  'required';

        $rules['email'] = 'required';

        $this->form_validation->set_rules($rules);

 

    if ($this->form_validation->run() == FALSE)

        {

            $this->form_validation->output_errors();

            redirect('customers/create','refresh');

        }

        else

        { */   $mail = $this->input->post('email');

                $password = $this->input->post('password');

            

                $data = array ();

                $customer_id = $this->customers_model->addCustomer($this->site_id);

                $this->customer_id = $customer_id;

                

                $message = '';

                    $message .=  "Congratulation !  \n\n Your signup process copmlete \n \n";

                    $message .=  ' 

                                  

                                    +---------------------------------------------+ 
                                    | Login Mail: '.$mail.'                       |
                                    | Password: '.$password.'                     |
                                    +---------------------------------------------+

                                  

                                  ';

                    $message .= "\nThanks for using Our Services 

                                \n ";

                    $message .= 'http://globalonlinewebsitesolutions.com/';

                    

                   // echo   $message;

                   // exit;  

                    // #### send mail #### //

                    

                    $this->load->library('email');

                    

                    $this->email->from('admin@globalonlinewebsitesolutions.com', 'Global Online Website Solutions');

                    $this->email->to($mail);

                    $this->email->cc('noreply@webpowerup.com');

                   // $this->email->bcc('them@their-example.com');



                    $this->email->subject('Signup | System Confirmation Mail');

                    $this->email->message($message);



                    $this->email->send();

                   // echo $this->email->print_debugger();

                

                

                

                

                redirect(base_url().index_page().'customers', $data);

       // }

    }else{

        $data['title'] = " Customer Registration";

        $data['module'] = 'customers';

        //Groups respect to site
			$groups = $this->Groups_Model->get_all_site_gropus_suctomer_view($this->site_id);
			$data['membership'] = $groups;

        $this->template->write_view('content','ecommerce/adm_customers_create',$data);

      //  $this->template->write_view('content','ecommerce/customers_create2',$data);

        $this->template->render();

    }

  }

 

  function edit($user_id=0)
  {
      $this->breadcrumb->clear();
	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
	  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
      $this->breadcrumb->add_crumb('Manage Customer', $this->session->userdata("customer_link") ); 
	  $this->breadcrumb->add_crumb('Edit'); 

    if ($this->input->post('action') && $this->input->post('action') == 'updat_Customer'){

        $this->customers_model->updateCustomer($this->site_id);

        redirect('customers/index','refresh');

    }else{

        $data['title'] = "Edit Customer";

        $data['customer'] = $this->customers_model->getCustomer($user_id);

        if (!count($data['customer'])){

            redirect('customers/index','refresh');

        }

        $data['module'] = 'customers';

       // $data['user_id'] = $user_id;

        $data['membership'] = $this->Groups_Model->get_all_site_gropus_suctomer_view($this->site_id); 

       // $this->load->view($this->_container,$data);

        $this->template->write_view('content','ecommerce/adm_customers_edit',$data);

        $this->template->render();

    }

  }

 

    function delete($id)

    {

    /**

     * When you delete customers, it will affect on omc_order table and it will affect omc_order_table_items

     * Check if the customer has orders, if yes, then go back with warning to delete the order first.

     *

     */

        $order_orphans = $this->customers_model->checkOrphans($id);

        if (count($order_orphans)){

            // $this->session->set_userdata($order_orphans);

            redirect('customers/index/','refresh');

        }else{

            $this->customers_model->deleteCustomer($id);

            redirect('customers/index','refresh');

        }

    }

 

    function changeUserStatus($id)

    {

        $this->customers_model->changeCustomerStatus($id);

        redirect('customers/index','refresh');

    }

    

            function  login_not_exist($log_in)

      {

          //echo $email.">>>>>>>>>";

          // exit();

          $this->form_validation->set_message('login_not_exist','This %s login Name already exists. Please try another.');

          

         if($this->UsersModel->login_exists($log_in)){

           return false;  

         }else{

             return true;

         }

      }

      

    function  code_exist ($code = '')

    {

       /* echo $code.">>>>>>>>>";

         exit();*/

       // $this->form_validation->set_message('login_not_exist','This %s login Name already exists. Please try another.');



        if($this->customers_model->code_check($code)){

          //  echo 'I am here  in true part'; exit(); 

            echo 'FALSE';

            return false;

        }else{

           // echo 'I am here  in false part'; exit(); 

             echo 'TRUE';

            return true; 

        }

    }

    

   function  email_exist()

    {

       /* echo $code.">>>>>>>>>";

         exit();*/

       // $this->form_validation->set_message('login_not_exist','This %s login Name already exists. Please try another.');

       $email =  $this->input->post('user_login');

      //  echo $this->site_id.'>>>>>'.$email;

        if($this->customers_model->email_check($email,$this->site_id)){

        // echo 'Controller  TRUE'; 

          echo 'TRUE';

            return true;  

        }else{

         //  echo 'Controller  FALSE'; 

            echo 'FALSE';

            return false;

        }

    }



}//end class

?>