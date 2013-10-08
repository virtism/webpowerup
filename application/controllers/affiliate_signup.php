<?php
class affiliate_signup extends Affiliate_Controller
{
    function All_Members()
    {
        parent::__construct();

    }
    function index()
    {
        $this->template->write_view('content', 'index');
        echo "i am in affiliate_signup"; exit;
        
    }    
    
}
?>
