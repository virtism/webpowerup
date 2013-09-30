<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_start()){

    session_start(); }  

class Font_setting extends CI_Controller {

    var $site_id;  

    var $user_id;  



    function __construct()

    {

        parent::__construct();

        

        $this->load->helper('url');
		
		$this->load->helper('custom_helper');

        $this->load->library('Template');

        $this->template->set_template('gws');

        $this->load->model('font_setting_model');

        $this->load->helper('security');

        $this->site_id = $_SESSION['site_id'];

		$this->load->library('session');

        //$this->user_id = $_SESSION['user_info']['user_id'];

        

      

 

    }

    function index($site_id = ""){

	
		is_login();
        // Setting variables

		$this->breadcrumb->clear();

		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );

		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 

		$this->breadcrumb->add_crumb('Font Setting' );

		

		$data['title'] = "Font Setting";

        //$data['module'] = 'Products_Management';

        $data['font'] = $this->font_setting_model->get_font_title($this->site_id);

		$this->template->write_view('content','font_setting/font_setting_form',$data);

        $this->template->render();

    }

    

	function save_font()

    {

        if($this->font_setting_model->save_font($this->site_id))

        {

			echo "TRUE";

			//return true;

        }

        else

        {

			echo "FALSE";

            //return false;

        }

        

        

    }      

    

    

    

}  

?>

