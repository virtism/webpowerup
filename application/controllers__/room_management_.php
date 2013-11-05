<?php
if(!session_start()){
    session_start();
}
  class Room_Management extends CI_Controller{
  
      public $ck_data     =     array(); 
      var $site_id;  
      
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
         // call load_asset_form
        
		$this->load->model("Groups_Model"); 
        $this->load->model('Registration_Forms_Model');  
        $this->load->model('Menus_Model');  
        $this->load->model('Pages_Model');  
        $this->load->model('PagesModel');
		$this->load->model('Room_Model');  
		$this->site_id = $_SESSION['site_id'];
             
      }
      
	  
		function index()
		{ 
			$show_data = '';
			$show_data['view_all_records'] =  $this->Room_Model->show_all_rooms($this->site_id);
			$this->template->write_view('content','Room_Froms_View',$show_data);
			$this->template->render();
		
		}     
		function create_room()
		{
			$data = '';
			$data['groups'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($this->site_id);
			$this->template->write_view('content','create_room',$data);
			$this->template->render();
		}
		
		function create_new_room()
		{
			$action = $this->input->post('save-start');
			$room_data['customers'] = '';
			$room_data['non_group'] = '';
			$email1[] = '';
			$email2[] = '';
			$room_data['site_id'] = $this->site_id;
			$room_data['name'] = $this->input->post('name');
            $room_data['topic'] = $this->input->post('topic');
            $room_data['password'] = $this->input->post('password');
			$room_data['approval'] = $this->input->post('approval');
			$customers =$this->input->post('customers');
			$room_data['non_group'] = $this->input->post('non_group');
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');		
			if(isset($customers)&&!empty($customers))
			{
					$room_data['customers'] = implode(",", $customers);					
			}
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data['customers']);							
				$email2 = explode(",", $room_data['non_group']);
				if(is_array($email1)&&is_array($email1))
				{
					$emails = array_merge($email1,$email2);
				}
				else if(is_array($email1))
				{	
					$emails = $email1;
				}
				else if(is_array($email2))
				{
					$emails = $email2;
				}			
				
				$message ="Event Name: ".$room_data['name']."\n\nTopic Name: ".$room_data['topic']."\n\nStart Date: ".$room_data['reg_date_start']."\n\nMessage: ".$room_data['message'];
				$this->send_mail($emails, $room_data['topic'], $message);
			}
			$save = $this->Room_Model->create_room($room_data);			
			redirect(base_url().index_page().'room_management/index/'); 
			
		}
		
		function send_mail($customers, $sub, $mess)
		{
		
				$subject = $sub;
				$body = $mess;
				$this->load->library('email');
				foreach($customers as $mail)
				{
					$this->email->from('join_meeting@gws.com', 'Your Name');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail); 
					$send = $this->email->send();			
				}		
		}
	  function delete_room($room_id)
	  {
	  	$delete = $this->Room_Model->delete_room($room_id);
		redirect(base_url().index_page().'room_management/index/'); 
	  }
	  
	  function edit_room($room_id)
	  {
	  		$edit['user_gruop_options'] = $this->Room_Model->edit_room($room_id);
			$edit['groups'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($this->site_id);
			if(isset($edit) && !empty($edit))
			{
				$this->template->write_view('content','edit_room',$edit);
				$this->template->render();
			}
			else
			{
				redirect(base_url().index_page().'room_management/index/'); 			
			}		
	  }
	  
	  function save_edit_room($room_id)
	  {
	  		//$room_data['room_id'] = $room_id;
			$action = $this->input->post('save-start');
			$room_data['customers'] = '';
			$email1[] = '';
			$email2[] = '';
			$room_data['name'] = $this->input->post('name');
            $room_data['topic'] = $this->input->post('topic');
            $room_data['password'] = $this->input->post('password');
			$room_data['approval'] = $this->input->post('approval');
			$customers =$this->input->post('customers');
			$room_data['non_group'] = $this->input->post('non_group');
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');
			if(isset($customers)&&!empty($customers))
			{
					$room_data['customers'] = implode(",", $customers);					
			}
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data['customers']);							
				$email2 = explode(",", $room_data['non_group']);
				$emails = array_merge($email1,$email2);
				$this->send_mail($emails, $room_data['topic'], $room_data['message']);
			}
			$save = $this->Room_Model->save_edit_room($room_data, $room_id);
			redirect(base_url().index_page().'room_management/index/'); 
	  
	  }
	  
      function index_old()
      {
    
       
       // $this->load->view('Create_Registration_Form_View', $this->ck_data);
       /*$data = array ();
       $data[''] = '';
       $data['menus'] = $this->Menus_Model->getAllMenus($this->site_id);
       $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
	   $data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);*/
	   /*echo "<pre>";
	   print_r($data['groups']);
	   exit;*/
   //    $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
       //$data['role'] = $this->Menus_Model->getRolesDropdown(); 
       //$data['ck_data'] = $this->ck_data;
      
       $this->template->write_view('content','Create_Room_Form_View');
       $this->template->render();
 
      }
}
?>