<?php
class Newsletter extends CI_Controller
{
    function newsletter()
    {
        parent::__construct();
        
        //load template library for gws_admin template
        $this->load->library('Template');
        
        //set views gws_admin/template.php as template
        $this->template->set_template('gws_admin');
        
        //load session library for using sessions
        $this->load->library('session');
        
        //load URL helper
        $this->load->helper('url');
        
        //load Newsletter_Model for this controller
        $this->load->model('admin/Newsletter_Model');
        
       //call load_asset_form
       $this->load_asset_form(); 
       
    }  
    
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        
        if($user_info=='' && $user_role=='')
        {
            //go to login controller
            redirect('administrator/index');
        }
        else
        {
            //ok, let go
            return;
        }   
         
    }  
    
    function index()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //load admin/newsletter/index(view) in content region of the admin template
        $show_data['view_all_records'] = $this->Newsletter_Model->show_all_newsletter();
        $this->template->write_view('content','admin/newsletter/index',$show_data); 
        
        //display the template with its regions written above
        $this->template->render();    
    }
    
    // method load_asset_form used to load ckeditor and ckfinder
    function load_asset_form ()
    {
        $this->load->helper('ckeditor');

        //Ckeditor's configuration
        $this->ck_data['ckeditor'] = array(

            //ID of the textarea that will be replaced
            'id'=>'ck_content',
            'path'=>'js/ckeditor',

            //Optionnal values
            'config' => array(
                'toolbar'=>"Full",     //Using the Full toolbar
                'width'=>"550px",    //Setting a custom width
                'height'=>'100px',    //Setting a custom height
            ),

        //Replacing styles from the "Styles tool"
            'styles' => array(

                //Creating a new style named "style 1"
                'style 1' => array (
                    'name'=>'Blue Title',
                    'element'=>'h2',
                    'styles' => array(
                        'color'=>'Blue',
                        'font-weight'=>'bold'
                    )
                ),

                //Creating a new style named "style 2"
                'style 2' => array (
                    'name'=>'Red Title',
                    'element'=>'h2',
                    'styles' => array(
                        'color'=>'Red',
                        'font-weight'=>'bold',
                        'text-decoration'=>'underline'
                    )
                )                
            )
        );

    }  // end  load_asset_form
    
    function create()
    {
        //confirm that user has logged-in    
        $this->check_login();

        //write admin/sidebar(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');

        //load create newsletter form(view) in content region of the admin template
        $this->template->write_view('content', 'admin/newsletter/create', $this->ck_data);

        //display the template with its regions filled above
        $this->template->render();    
    }
    
    function create_newsletter()
    {
        //confirm that user has logged-in    
        $this->check_login();

        $data = array();
        $current = date("Y-m-d  H:i:s", time());

        $data[1] = $this->input->post('subject'); 
        $data[2] = $this->input->post('body');
        $data[3] = $this->input->post('user_group');
        $data[4] = $current;

        $this->Newsletter_Model->save_newsletter($data); 
        echo "Data saved Successfully ....."; 

        if($data[3]== '1'){
            
        }    

    }
      
    // method to send news letter at create news letter 
    function send($data)
    {
        //confirm that user has logged-in    
        $this->check_login();
        
        $rec_id = $this->uri->segment(4);     
         
        echo  $rec_id;    
          
    }
    
    //this function shows the newsletter
    function view($page_id)
    {
        //confirm that user has logged-in    
        $this->check_login();
        
        //$page_id = $this->uri->segment(3);
        
        if(!$page_id)
        {
            $page_id = 1;
        }
        
        $data_fetch= array ();

        $data_fetch = $this->Newsletter_Model->get_newsletter($page_id);

        $data['left_menu'] = $this->Newsletter_Model->left_menu();
        $data['right_menu'] = $this->Newsletter_Model->right_menu(); 

        $data['news_id'] = $data_fetch['news_id'];
        $data['news_subject'] = $data_fetch['news_subject'];
        $data['news_body'] = $data_fetch['news_body'];
        $data['news_recipient_group'] = $data_fetch['news_recipient_group'];
        $data['news_date_created'] = $data_fetch['news_date_created'];
        $data['news_date_sent'] = $data_fetch['news_date_sent'];
        
        $this->load->view('admin/newsletter/view',$data); 
                 
    }
    
    function edit($news_id)
    {
        //confirm that user has logged-in    
        $this->check_login();
        
        //$rec_id = $this->uri->segment(4);
        $rec_id = $news_id;
        $data['values']= $this->Newsletter_Model->get_newsletter_data($rec_id);
        $data['ck_data']= $this->ck_data;   

        //write admin/sidebar(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');

        //write view at the content region of the template
        $this->template->write_view('content','admin/newsletter/edit',$data);
        //display the template
        $this->template->render();
    }
    
    function edit_newsletter()
    {
        //confirm that user has logged in 
        $this->check_login();
        
        // $this->load->view('users_registration'); 
        // $this->load->helper(array('form', 'url'));
        $this->load->library('');  
        $this->load->library('form_validation'); 

        /*
        $this->form_validation->set_rules('user_fname', 'User First Name : ', 'required');
        $this->form_validation->set_rules('user_lname', 'User Last Name : ', 'required');
        $this->form_validation->set_rules('user_zip', 'User Last Name : ', 'trim|required|max_length[6]|integer'); 
        $this->form_validation->set_rules('user_password', 'User Pasasword', 'trim|required|min_length[5]');  
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_email_not_exist');
        */
        /* 
        if ($this->form_validation->run() == FALSE)
        {
        // error in form validation 
        $this->load->view('Contact_Management_View');

        }else{ */
        // fetch the form value into array
        $data = array();
        $current = date("Y-m-d  H:i:s", time()); 
        $data[0] = $this->input->post('id');
        $data[1] = $this->input->post('subject'); 
        $data[2] = $this->input->post('body');
        $data[3] = $this->input->post('user_group');
        $data[4] = $current;
        //$data[3] = $this->input->post('send_now'); 


        // $new_date = date("l jS of F Y",strtotime($current));
        //$new_date2 = date("M j, Y ",strtotime($current)); 
        //  echo  $new_date.">>>>>>>>>>>>".$new_date2;
        //$data[3] = $this->input->post('send_now');
                                                   

        $this->Newsletter_Model->update_newsletter($data); 
        echo "Data saved Successfully ....."; 

        if($this->input->post('send_now') == '1')
        {
        // $this->send_newsletter($data);   
        }    
            
    }
    
    // method to soft delete contact
    function delete()
    {
        //confirm that user has logged-in    
        $this->check_login();
        
        $page_id = $this->uri->segment(4);
        $contact_data = $this->Newsletter_Model->delete_soft($page_id);
        // $contact_data = $this->Registration_Forms_Model->delete_hard($page_id); 
    }
    
}
?>
