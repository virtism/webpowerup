<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class Shipping_Management extends CI_Controller {
     var $site_id;
    function __construct()
    {
        parent::__construct();
        // Check for access permission
       // check('Categories');
 
        $this->load->model('product_model');
		$this->load->model("Pages_Model");
		$this->load->model("PagesModel");
        $this->load->model('categories_model');
        $this->load->model("Groups_Model"); 
		$this->load->model('Shipping_model');
        $this->load->helper('security');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('session');
		$this->load->library('pagination');
        $this->template->set_template('gws');
        $this->site_id = $_SESSION['site_id'];
    }
	
	function index($site_id, $from = 1){ 

	 	$link = uri_string();
		$Manage_Shippment = base_url().index_page().$link;
		$this->session->set_userdata("Manage_Shippment", $Manage_Shippment); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Shippment' );
		
		$this->checkLogin();

		$data = array ();

		$data["countries"] =  $this->Shipping_model->get_countries();
		$data["country_states"] =  $this->Shipping_model->get_all_country_states($site_id);
		$data["country_ranges"] =  $this->Shipping_model->get_all_country_rates($site_id);

		$this->template->write_view('content','ecommerce/view_shipping', $data);

		$this->template->render();    

		//$this->load->view("viewPages", $data);

	}
	
	function create_shipping_rate()
	{
	
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") );
		$this->breadcrumb->add_crumb('Manage Shippment', $this->session->userdata("Manage_Shippment") );
		$this->breadcrumb->add_crumb('Create Shipping Rate');
	
		$this->template->write_view('content','ecommerce/create_shipping_rate');

		$this->template->render(); 
    }
	
	function save_shipping()
	{
	 
	  $this->Shipping_model->save_shipping_rate($this->site_id);
	  
	  redirect("Shipping_Management/select_country/");
	}
	
	function edit_shipping($site_id,$ship_id)
	{
	  $data["records"] = $this->Shipping_model->edit_shipping_rate($site_id,$ship_id);
	  $this->template->write_view('content','ecommerce/edit_shipping_rate',$data);
	  $this->template->render(); 
	}
	
	function update_shipping($site_id,$ship_id)
	{
	  $this->Shipping_model->update_shipping_rate($site_id,$ship_id);
	  redirect("Shipping_Management/index/".$this->site_id.'/0');
	}
	
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
	
	function trashPage($site_id)
	{
		if($this->input->post("chkPage"))

		{            

			$this->Shipping_model->delete_shipping($this->input->post("chkPage"));

		}         

		redirect("Shipping_Management/index/".$site_id."/0");    

	}
	
	function select_country()
	{
	    $this->Shipping_model->save_shiping($this->site_id);
	    $data['countries'] = $this->Shipping_model->get_country();
		$data['states'] = $this->Shipping_model->get_states();
		
		//$data['count'] = $this->customers_model->getAllCustomersCountBySiteID($this->site_id);
		$this->template->write_view('content','ecommerce/country_states_view',$data);
		$this->template->render();
	}
	
	 function ajax_call_states()
	  {
		
			$country_id = $_POST['country_id'];
			$country_id = str_replace("-"," ",$country_id);
			$states = $this->Shipping_model->getstates_by_country_id($country_id);
	
			if(empty($states))
			{
			?>
				<input id="state" name="state"/>
			<?
			}
			else
			{
				?>
				<select id="state" name="state" style="opacity: 1;">
					<? foreach($states as $state) 
						{
							echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
						}
					?>													
				</select>	
				
				<?
			}
		}
	

 }//end class
?>
