<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */


class Front_Controller extends CI_Controller
{
    
    function __construct(){
        
        parent::__construct();


        $this->load->add_package_path(APPPATH.'third_party/affiliate_temp/');
    }
    
    /*
    This works exactly like the regular $this->load->view()
    The difference is it automatically pulls in a header and footer.
    */
    function view($view, $vars = array(), $string=false)
    {
        if($string)
        {
            $result     = $this->load->view('header', $vars, true);
            $result    .= $this->load->view($view, $vars, true);
            $result    .= $this->load->view('footer', $vars, true);
            
            return $result;
        }
        else
        {
            $this->load->view('header', $vars);
            $this->load->view($view, $vars);
            $this->load->view('footer', $vars);
        }
    }
    
    /*
    This function simple calls $this->load->view()
    */
    function partial($view, $vars = array(), $string=false)
    {
        if($string)
        {
            return $this->load->view($view, $vars, true);
        }
        else
        {
            $this->load->view($view, $vars);
        }
    }
}

