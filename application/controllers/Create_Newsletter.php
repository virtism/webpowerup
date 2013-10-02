<?php
if(!session_start()){
    session_start();
}
  class Create_Newsletter extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
			parent::__construct();
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('Template');
			$this->load->library('session');
			$this->load->model('Groups_Model');
            $this->load->model("Site_Preview");
            $this->load->model("Menus_Model"); 
			$this->load->model('Newsletter_Model'); 
			$this->load_asset_form(); 
			$this->load->library('session');
			if(isset($_SESSION['current_site_info']['site_id']))
			{
				$this->site_id = $_SESSION['current_site_info']['site_id']; 
			}			
			$this->load->library('Webpowerup');
            $this->load->library('form_validation'); 
			$this->webpowerup->initialize_template();
      }
      
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        /*
        echo "<pre>";
        print_r($user_role);
        exit;
        */
        
        if($user_info=='' && $user_role=='')
        {
            redirect('administrator/index');
        }
        else
        {
            return;
        }   
    }
    //end
    
      function index()
      {
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Newsletter Management', $this->session->userdata("news_link") ); 
		$this->breadcrumb->add_crumb('Create' );
		  
		$data['ck_data']= $this->ck_data;
		
		$data['groups'] = $this->Groups_Model->get_groups_by_site_id($this->site_id);
		
		$this->template->write_view('content','newsletter/Create_Newsletter_View',$data);
		$this->template->render(); 
      }
      
      // method load_asset_form used to load ckeditor and ckfinder
      function load_asset_form ()
      {
        $this->load->helper('url'); //You should autoload this one ;)
        $this->load->helper('ckeditor');
 
 
        //Ckeditor's configuration
        $this->ck_data['ckeditor'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content',
            'path'    =>    'js/ckeditor',
 
            //Optionnal values
            'config' => array(
                'toolbar'     =>     "Full",     //Using the Full toolbar
                'width'     =>     "550px",    //Setting a custom width
                'height'     =>     '100px',    //Setting a custom height
 
            ),
 
            //Replacing styles from the "Styles tool"
            'styles' => array(
 
                //Creating a new style named "style 1"
                'style 1' => array (
                    'name'         =>     'Blue Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'     =>     'Blue',
                        'font-weight'     =>     'bold'
                    )
                ),
 
                //Creating a new style named "style 2"
                'style 2' => array (
                    'name'     =>     'Red Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'         =>     'Red',
                        'font-weight'         =>     'bold',
                        'text-decoration'    =>     'underline'
                    )
                )                
            )
        );
 
     
       
      }  // end  load_asset_form
      
      // method used for contact save data 
 function create_newsletter ()
      {
       
       //echo "<pre>";print_r($_REQUEST);exit;
		$this->load->library('form_validation'); 
        $data = array();
        $current 						= date("Y-m-d  H:i:s", time());
		$data['news_subject'] 			= $this->input->post('subject'); 
		$data['news_body'] 				= $this->input->post('body');
		$groups 						= $this->input->post('user_group');
		$data['news_recipient_group'] 	= implode(',',$groups);
		$data['news_date_created'] 		= $current;
		$data['site_id'] 				= $_SESSION['site_id'];
		$data['from'] 					= $_REQUEST['from'];
		$send_now						= $this->input->post('send_now');
		//echo "<pre>";print_r($data);exit;
		$this->Newsletter_Model->save_newsletter($data);
		if(isset($groups) && $send_now == 1)
		{
		 	
		  $this->send_newsletter($data);
		}    
		 redirect('Newsletter_Management');
			 
      }
      // method to send news letter at create news letter 
      function send_newsletter($data)
      {
         	$this->load->library('email');
            $subject = $data['news_subject'];
            $body = $data['news_body'];
            $user_gruop = explode(',',$data['news_recipient_group']);
			//print_r($user_gruop);exit;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			//print_r($user_gruop);exit;
			foreach($user_gruop as $group_id)
			{
				
				$customers = $this->Newsletter_Model->get_site_gropus_customer_by_group_id($group_id);
				//print_r($customers);exit;
				foreach($customers as $mail)
				{
					$this->email->from($data['from'] , 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail); 
					$send = $this->email->send();
				}
			}
		
			
      }
 //////////////////// under this all function is for news letter Goroup////////////////////////
 
     function creat_newsletter_group($id=false)
     {
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
        $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
        $this->breadcrumb->add_crumb('Newsletter Management', $this->session->userdata("news_link") ); 
        $this->breadcrumb->add_crumb('Create' );
        $site_id                                = $_SESSION['site_id'];  
        $data['ck_data']                        = $this->ck_data;
        $data['pages']                          = $this->Menus_Model->get_page_with_type($site_id,"Normal");
        $data['template_name']                  = $this->Site_Preview->getSiteTemplate($site_id);  
        $data['groups']                         = $this->Groups_Model->get_all_site_gropus($site_id);
        $data['id']                             = '';
        $data['ngroup_name']                    = '';
        $data['position']                       = '';
        $data['publish']                        = '';
        $data['dispaly_page']                   = '';
        $data['user_see']                       = '';
        $data['signup_titile']                  = '';
        $data['intro_text']                     = '';
        
        if($id!='')
         {
            $getnewlerer = $this->Newsletter_Model->get_newsletter_groups($id ,$site_id);
            $data['id']                             = $id;
            $data['ngroup_name']                    = $getnewlerer['0']->newsgroup_name;
            $data['position']                       = $getnewlerer['0']->newsgroup_position;
            $data['publish']                        = $getnewlerer['0']->newsgroup_publish;
            $data['dispaly_page']                   = $getnewlerer['0']->newsgroup_page;
            $data['user_see']                       = $getnewlerer['0']->newsgroup_how_see;
            $data['signup_titile']                  = $getnewlerer['0']->newsgroup_sup_title;
            $data['intro_text']                     = $getnewlerer['0']->newsgroup_intro_text;
             
            // $getnewlerer = $this->Newsletter_Model->get_newsletter_groups($id ,$site_id);
             //echo '<pre>'; print_r($getnewlerer);exit;
             
         }
         $this->form_validation->set_rules('subject', 'Group Name', 'trim|required');
         if ($this->form_validation->run() == FALSE)
        {
            $this->template->write_view('content','newsletter/Cereat_NewsletterGroup_view',$data);
            $this->template->render();
        }
        else{
        if($this->input->post('lstPages') != '')
            {
                $array_m = $this->input->post('lstPages');
                $selected_pages = '';
                foreach($array_m as $key=>$item){
                    $selected_pages .=  $item; 
                    if($key != sizeof($array_m)-1){
                    $selected_pages .= ','  ; 
                        }
                }
                $selected_pages;
            }
            else{
                $selected_pages='';    
            }
            

          
             $save                                      = array();
             $save['newsgroup_id']                      = $id;
             $save['newsgroup_site_id']                 = $_SESSION['site_id'];  
             $save['newsgroup_name']                    = $this->input->post('subject');
             $save['newsgroup_position']                = $this->input->post('positionorder');
             $save['newsgroup_publish']                 = $this->input->post('published');
             $save['newsgroup_page']                    = $this->input->post('displayonpage');
             
             $save['newsgroup_page_ids']                    = $selected_pages;
             
             $save['newsgroup_how_see']                 = $this->input->post('rdoRights');
             if($id == ''){
             $save['newsgroup_date']                    = date("Y-m-d  H:i:s", time());
             }
             //$save['newsgroup_pcolor']                  = $this->input->post('prim_color');
             //$save['newsgroup_tcolor']                  = $this->input->post('prim_txt');
             $save['newsgroup_sup_title']               = $this->input->post('sup_title');
             $save['newsgroup_intro_text']              = $this->input->post('body');
             $this->Newsletter_Model->save_newsletter_group($save);
             redirect('Newsletter_Management');
            
        }
         
        
        
           
     }
     function save_newsletter_user()
     {
         if($this->input->post('user_name') == '')
         {
             $this->session->set_flashdata('error_name', 'Enter The User Name'); 
             redirect($this->input->post('url'));
         }
         else if($this->input->post('user_email') == '')
         {
            $this->session->set_flashdata('error_email', 'Enter The E-mail');
            redirect($this->input->post('url'));   
         }
         
         else if($this->input->post('user_name')!='')
         {
         $save['user_name']             = $this->input->post('user_name');
         $save['user_email']            = $this->input->post('user_email');
         $save['site_id']               = $_SESSION['site_id']; 
         $save['newsgroup_id']          = $this->input->post('NL_group_id');
         $this->Newsletter_Model->save_group_NLuser($save);
         }
         
         $this->session->set_flashdata('success_msg', 'Message is successfull send');
         $this->send_newsletter_group($this->input->post('NL_group_id'),$this->input->post('url'),$this->input->post('user_email'));
         redirect($this->input->post('url')); 
         //echo'<pre>'; print_r($_POST); exit;
         //$this->Newsletter_Model->save_NLuser_ajax($save);
         
     }
     function send_newsletter_group($group_id , $site_id , $email_NL)
      {
          $this->load->library('email'); 
          $exp                              = explode('/', $site_id);
          $data['NLgroup']                  = $this->Newsletter_Model->get_newsletter_groups($group_id,$exp['2']);
          $subject                          = $data['NLgroup']['0']->newsgroup_name;
          $body                             =  $data['NLgroup']['0']->newsgroup_intro_text;
            //$user_gruop = explode(',',$data['news_recipient_group']);
            //print_r($user_gruop);exit;
            $config['mailtype']             = 'html';
            $config['protocol']             = 'sendmail';
            $config['charset']              = 'utf-8';
            $config['wordwrap']             = TRUE;
            $this->email->initialize($config);
            //print_r($user_gruop);exit;
            //$customers = $this->Newsletter_Model->get_site_gropus_customer_by_group_id($group_id);
                    //print_r($customers);exit;                   
            $this->email->from('info@WebpowerUp.com' , 'WebpowerUp');
            $this->email->subject($subject);
            $this->email->message($body);    
            $this->email->to($email_NL); 
            $send = $this->email->send();
      }
     function sent_newsletter_toAll ($group_id)
      {
        $group_delait                     = $this->Newsletter_Model->get_newsletter_groups($group_id , $_SESSION['site_id']);
        $this->load->library('email');
        $subject                        = $group_delait['0']->newsgroup_name;
        $body                           = $group_delait['0']->newsgroup_intro_text;
        $get_group_user                 = $this->Newsletter_Model->get_userBy_NLgroup($group_id , $_SESSION['site_id']);

        $config['mailtype']             = 'html';
        $config['protocol']             = 'sendmail';
        $config['charset']              = 'utf-8';
        $config['wordwrap']             = TRUE;
        $this->email->initialize($config);
        foreach($get_group_user as $get_group_users)
        {
            $this->email->from('info@webpowerup.com' , 'WebpowerUp');
            $this->email->subject($subject);
            $this->email->message($body);    
            $this->email->to($get_group_users->user_email); 
            $send = $this->email->send();
        }
        $this->session->set_flashdata('group_success_send', 'Message is successfull send to all'); 
        redirect('Newsletter_Management'); 
      }
      
      
      
  }
?>