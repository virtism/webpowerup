<?php
if(!session_start()){
    session_start();
}
class MenusController extends CI_Controller{
    //Controller's constructor definition
    function MenusController(){
        parent::__construct(); 
        $this->load->model("Menus_Model");
        $this->load->model("usersmodel");		
        $this->load->model("Groups_Model");
		
		$this->load->model("customers_model");
		$this->load->model("Site_Preview");		
        $this->load->library('pagination');
        $this->load->library('session');    
        $this->load->helper('url');   
        $this->load->library('form_validation'); 
        $this->load->library('calendar');
        $this->load->helper('html'); 
        $this->load->library('Template');
		
        $this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();             
    }
    
    //verifies if user is logged in
    //redirects to login screeen if user is not logged in
    function checkLogin()
    {
        if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
        {
            //user not logged in, go to login screen
            redirect("UsersController/login/sitelogin");
        }
        else
        {
            //logged in confirm, OK!
            return;
        }
    }
    
    //menu update info form is posted here from menuInfo.php view
    //validates menu info then performs menu update by menus_model
    function updateMenu()
    {
        /*
        echo "<pre>";
        print_r($_POST);
        exit;
        */
        //confirms user is logged in 
        $this->checkLogin();
        
        $site_id = $this->input->post("site_id"); 
        
        if($_POST)
        {  
            /*echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            exit();*/
            
            
            $this->Menus_Model->updateMenu();
        }
        if(isset($_POST['fancy']))
        {
            $this->load->view('slides/fancy_close');    
        }
        else
        {
            redirect("menusController/index/".$site_id."/0");         
        }
        
                
    }
    
    function updateMainMenu()
    {
        $this->checkLogin();
        
       //echo "<pre>";
       //print_r($_POST);
       //exit;
        $site_id = $this->input->post("site_id"); 
        
        if($_POST)
        {  
            $this->Menus_Model->updateMainMenu();
        } 
        if(isset($_POST['fancy']))
        {
            $this->load->view('slides/fancy_close');    
        }
        else
        {
            redirect("menusController/index/".$site_id."/0");     
        }   
        
    }
    
    function showMenuInfo($site_id, $id)
    {
        
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Menus', $this->session->userdata("menu_link") ); 
		$this->breadcrumb->add_crumb('Edit'); 
		//confirms user is logged in
        $this->checkLogin();
        
        //prepares $data
        $data['site_id'] = $site_id;
        $data['is_main_menu'] = $this->Menus_Model->is_main_menu($site_id, $id);; 
        $data['id'] = $id;
        $data['pages'] = $this->Menus_Model->get_page_with_type($site_id,"Normal");
        $data['parent_array'] = $this->Menus_Model->get_parent($site_id);
        $data['menus'] = $this->Menus_Model->getAllMenus($site_id);         
        $data['roles'] = $this->Menus_Model->getRoles();
        $result = $this->Menus_Model->menuInfo($id); 
        $row = $result->row_array();
        $data["parent_menu"] = $row["parent_menu"];
        $data["menu_name"] = $row["menu_name"];
        $data["menu_position"] = $row["menu_position"];        
        $data["menu_published"] = $row["menu_published"];
        if($data["menu_published"]=="Schedule")
        { 
            //get menu date info if menu is scheduled for display           
            $data["menu_start"] = $row["menu_start"]; 
            $data["menu_end"] = $row["menu_end"];
        }
        else
        {
            //set dates to empty for $data preparation
            $data["menu_start"] = "";
            $data["menu_end"] = "";
        }
        //prepare $data
		
        $data["menu_pages"] = $row["menu_pages"];        
		$selected_pages = array();
		if($data["menu_pages"] == "Other")
		{
			$selected_pages = $this->Menus_Model->get_menu_selected_pages($id);
		}
		$data['selected_pages'] = $selected_pages;
		
        $data["menu_access"] = $row["menu_access"];
        $data["menu_items"] =  $this->Menus_Model->menuItemsInfo($id); 
        $data["numItems"] = $data["menu_items"]->num_rows();
        $data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);
        //fill content region of the template with view menuInfoView.php having $data
        $this->template->write_view('content','menuInfoView', $data);
        
        //display complete template
        $this->template->render();                 
        //$this->load->view("menuInfoView", $data);   
    }
    
    //shows menu in pop up at page editor
    function showMenu($site_id, $id)
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
        $this->load->view("menuInfoView", $data);   
    }
	
	 function createNewMenu($site_id){  
        //confirm user logged in 
        $this->checkLogin(); 
        //prepare $data         
        $data['site_id'] = $site_id;
        $data['pages'] = $this->Menus_Model->getPages($site_id);        
        $data['roles'] = $this->Menus_Model->getRoles();
        $data['menus'] = $this->Menus_Model->getAllMenus($site_id);
        $data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
	    //$this->load->view("addMenuView", $data);
        //fill content region of template with addMenuView.php(view) and $data
        $this->load->view('page_editor/createMenu', $data);
        
        //$this->template->write_view('content','addMenuView', $data);
        //dispaly the whole template
        //$this->template->render();
    }
    
    //form validation callback function written during server side validation for menu_start_date & menu_end_date
    function scheduled_dates($dateEnd){
        //convert string to time
        $dateStart = strtotime($this->input->post("startDate"));        
        $dateEnd = strtotime($dateEnd);
        
        if($dateStart>$dateEnd){ 
            //start date is later from end date (incorrect)           
            $this->form_validation->set_message('scheduled_dates', 'The %s date must be greater than Start Date.');
            return FALSE;
        }
        else{
            //start date is earlier from end date, validation passed
            return TRUE;
        }
    }
    
    function addMenu($site_id){     
        /*
        echo "<pre>";
        print_r($_POST);
        exit;
        */
        //confirm user is logged in
        $this->checkLogin();
        if($_POST)
        {
            //create menu / save menu info in case it received data from form post
            $site_id = $this->input->post('site_id');
            
            $this->Menus_Model->addMenu();
            
        }    
        
        if(isset($_POST['fancy']))
        {
            $this->load->view('slides/fancy_close');        
        }
        else
        {
            redirect("menusController/index/".$site_id."/0");         
        }
        
    }
    //shows add / create menu form in a site
    //loads addMenuView.php(view)
    function addMenuForm($site_id){  
        //confirm user logged in 
        $this->checkLogin(); 
        //prepare $data         
        $data['site_id'] = $site_id;
        $data['pages'] = $this->Menus_Model->getPages($site_id);        
        $data['roles'] = $this->Menus_Model->getRoles();
        $data['menus'] = $this->Menus_Model->getAllMenus($site_id);                
        //$this->load->view("addMenuView", $data);
        //fill content region of template with addMenuView.php(view) and $data
        $this->load->view('addMenuView', $data);
        //$this->template->write_view('content','addMenuView', $data);
        //dispaly the whole template
        //->template->render();
    }
    
    //shows add / create menu form in a site
    //loads addMenuView.php(view)
    function createMenu($site_id)
    {  
        
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Menus', $this->session->userdata("menu_link") ); 
		$this->breadcrumb->add_crumb('Create'); 
		
		//confirm user logged in 
        $this->checkLogin(); 
        
        //prepare $data         
        $data['site_id'] = $site_id;
        $data['pages'] = $this->Menus_Model->get_page_with_type($site_id,"Normal");       
        $data['roles'] = $this->Menus_Model->getRoles();
        $data['menus'] = $this->Menus_Model->getAllMenus($site_id);
        $data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
        //fill content region of the template with addMenuView.php file
		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);
        $this->template->write_view('content','addMenuView', $data);
        
        //display the whole template
        $this->template->render();
    }
    
    //shows add / create menu form in a site
    //loads addMenuView.php(view)
    //rewritten for popup open
    //wrote this function for first ever site's preview
    //loads previewView.php(view)
    function upload_doc($site_id){
		
		$this->checkLogin();
		$data['site_id'] = $site_id;
		$this->load->view('page_editor/upload_doc', $data);
				
	} 
	
    function preview(){            
        $this->load->view("previewView");
    }
    //delete menu(s): sets status to deleted
    //site_id, page_id passed to reload displayed view menusView.php
    function trashMenu($site_id, $page_id)
    {
        if($this->input->post("chkMenu"))
        {            
            $this->Menus_Model->deleteMenus($this->input->post("chkMenu"));
        }        
        redirect("menusController/index/".$site_id."/0");   
    }
    //sets menu(s) status as published
    //site_id, page_id passed to reload displayed view menusView.php
    function publishMenu($site_id, $page_id)
    {
        if($this->input->post("chkMenu"))
        {            
            $this->Menus_Model->publishMenus($this->input->post("chkMenu"));
        }  
        redirect("menusController/index/".$site_id."/0");            
    }
    //sets menu(s) status as unpublished
    //site_id, page_id passed to reload displayed view menusView.php
    function unpublishMenu($site_id)
    {
        if($this->input->post("chkMenu"))
        {            
            $this->Menus_Model->unpublishMenus($this->input->post("chkMenu"));
        }   
        redirect("menusController/index/".$site_id."/0");         
    }
    //loads menus management home menusView.php(view)
    //pagination applied from ci pagination library
    function index($site_id, $from)
    {  
		
		$menu_link = current_url();
		$this->session->set_userdata("menu_link", $menu_link); 
        
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Menus' ); 
		
        //$user_info["user_id"] = 1;
        //$user_info["role_id"] = 1;
        
        //$this->session->set_userdata($user_info);
        //$this->session->unset_userdata("user_id");
        //echo $this->session->userdata("user_id");exit(); 
        
        //confirm user is logged in
        $this->checkLogin();
        //prepare $data 
        $data["page_id"] = "";  
        //$data["id"] = $id;
        $data["site_id"] = $site_id;   
        //$data["site_id"] = $this->session->userdata("site_id");
        
        //applies / sets per page paging limit
        if($this->session->userdata("ses_showMenuLimit"))
        {
            //applies paging limit if stored in session
            $data["pageLimit"] = $this->session->userdata("ses_showMenuLimit");
        }
        else
        {
            //applies pre-defined/fixed/constant paging limit below:
            $data["pageLimit"] = 10;
        }
        
        //save paging limit in seesion, prepare $data for pagination
        if($this->input->post("numRecords"))
        {            
            $this->session->set_userdata("ses_showMenuLimit", $this->input->post("numRecords"));
            $data["pageLimit"] = $this->session->userdata("ses_showMenuLimit");
        }        
        
        //prepares $data 
        $data["records"] = $this->Menus_Model->showMenus($from, $data["pageLimit"], $site_id);
        $data["numRecords"] = $data["records"]->num_rows();
        $data["from"] = $from;        
        $data["totalRecords"] = $this->Menus_Model->totalMenus($site_id);
        
        // parameters for pagination applied  
        $config = array(
            'uri_segment' => 4,
            'base_url' => base_url().index_page().'menusController/index/'.$site_id."/",
            'per_page' => $data["pageLimit"],
            'first_link' => 'First',
            'next_link' => 'Next',
            'last_link' => 'Last',
            'next_link' => 'Next',
            'prev_link' => 'Previous',
            'display_pages' => TRUE,
            'num_links' => 2,
            'total_rows' => $data["totalRecords"]
        ); 
        /*$config['uri_segment'] = 4;              
        $config['base_url'] = base_url().index_page().'menusController/index/'.$site_id."/";
        $config['per_page'] = $data["pageLimit"];     
        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';   
        $config['prev_link'] = 'Previous';
        $config['display_pages'] = TRUE; 
        $config['num_links'] = 2;          
        $config['total_rows'] = $data["totalRecords"]; */
        
        //apply pagination parameters set earlier     
        $this->pagination->initialize($config);
        //prepare pagination $data for display
        $data["paging"] = $this->pagination->create_links();
        //echo "<pre>";
        //print_r($data);exit;
        
        //fill content region of template and $data
        $this->template->write_view('content','menusView', $data);
        //$this->template->write_view('sidebar','winglobal/sidebar', $data); 
        
        //display complete template
        $this->template->render();      
        //$this->load->view("menusView", $data);
    }    
    
    //functions below have been used in menus management screens
    //used to order menus for display
    
    function moveUp($site_id, $from, $menu_order)
    {
        //confirm user has logged-in
        $this->checkLogin();
        
        //move up the selected menu
        $this->Menus_Model->moveUp($site_id, $menu_order);
        
        //go to menus management screen
        $this->index($site_id, $from);
    }
    
    function moveDown($site_id, $from, $menu_order)
    {
        //confirm user has logged-in  
        $this->checkLogin();
        
        //move down the selected menu
        $this->Menus_Model->moveDown($site_id, $menu_order); 
        
        //go to menus management screen
        $this->index($site_id, $from);      
    }
	
	function update_menuItems_order()
	{
		
		$item_ids = $_POST['ids'];
		
		$r = $this->Menus_Model->update_menuItem_order($item_ids); 
		if($r)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
		
	}
	
}?>
