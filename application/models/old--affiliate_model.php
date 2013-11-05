<?php
class Affiliate_Model extends CI_Model{

    //Constructor for this model

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function insert_affiliate($data)
    {
        if($data['user_id'] != '')
            {
                $this->db->where('user_id', $data['user_id']);
                $this->db->update("users", $data);
                $success                = 'success'; 
                return $success;
            }
        else
        {
            $checkLogin                 = $this->checkUserLogin(trim($data['user_login']));
            $checkEmail                 = $this->checkUserEmail(trim($data['user_email']));
            if($checkLogin == '' && $checkEmail == '')
            { 
                
                
                $this->db->insert('users', $data);
                $success                = 'success'; 
                return $success;
                
            }
            else
            {
                  
                $error                  = 'error';
                return $error;
            }
        }
    }
    function checkUserLogin($user_login)
    {
        $this->db->where('user_login', $user_login);
        $result                     = $this->db->get('users');
        $rows                       = $result->result();
        $num                        = count($rows);
        if($num > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;           
        }
    }
    function checkUserEmail($user_Email)
    {
        $this->db->where('user_email', $user_Email);
        $result                     = $this->db->get('users');
        $rows                       = $result->result();
        $num                        = count($rows);
        if($num > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;           
        }
    }
    function checkAffiliatePassword($affiliate_id , $password)
    {
        $this->db->where('user_id' , $affiliate_id);
        $this->db->where('user_password', $password);
        $result                     = $this->db->get('users');
        $rows                       = $result->result();
        $num                        = count($rows);
        if($num > 0)
        {
            return 'correct';   
        }
        else
        {
            return 'incorrect';   
        }
        
    }
    function admin_login($login=false, $password=false)
    {
        $this->db->where('user_login', $login);
        $this->db->where('user_password' , md5($password));
        $this->db->where('user_status' , 'Active');
        $this->db->where('user_role' , 'affiliate');
        $query                      = $this->db->get('users');
        return $query->result();
    }
    function get_admin($login , $id)
    {
        $this->db->where('user_login', $login);
        $this->db->where('user_id', $id);
        $query                      = $this->db->get('users');
        return $query->result();
        
    }
    function get_affiliate_member($affiliate_id)
    {
        $this->db->where('affiliate_id', $affiliate_id);
        $query                      = $this->db->get('users');
        return $query->result();
    }
 

}

?>