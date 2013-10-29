<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class FooterController extends CI_Controller {
    var $site_id;  
    var $user_id;  

    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->load->model('Footer_Model');
        $this->load->helper('security');
        $this->site_id = $_SESSION['site_id'];
        //$this->user_id = $_SESSION['user_info']['user_id'];
        
      
 
    }
    function index(){
        // Setting variables
        $site_id = $_SESSION['site_id'];
        
        $data["site_id"] = "";
        $data["content"] = "";        
        
//    echo $site_id;exit;
        $footer_content = $this->Footer_Model->get_footer_content($site_id);
        if(empty($footer_content))
        {
            /*$this->Footer_Model->create_footer($site_id);
            $footer_content = $this->Footer_Model->get_footer_content($site_id);
            $data["site_id"] = $footer_content["site_id"];
            $data["content"] = $footer_content["content"];*/
            $data["content"] = '';
        }
        else
        {
            $data["site_id"] = $footer_content["site_id"];
            $data["content"] = $footer_content["content"];        
        }
        //echo "<pre>";
        //print_r($footer_content);
        //exit;
        
        $this->template->write_view('content','all_common/footer_content', $data); 
        $this->template->render();   
            
    }
    function update_footer()
    {
        
        
        //echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        $footer_content = $this->Footer_Model->update_footer_content($_REQUEST['content'], $this->site_id);
        if($footer_content){
        $this->index();       
        }    
     }
    
}  
?>
