<?php
@session_start();
class UsersModel extends CI_Model {

    function UsersModel()
    {
        parent::__construct();
        $this->load->model("sitesmodel");
    }
	function do_login()
	{
		
		$this->db->where('user_login', $this->input->post('user_login'));
		$this->db->where('user_password', $this->input->post('user_password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1)
		{
			$userDate = $query->result();
			
            
			foreach($userDate[0] as $key => $val)
			{
				$userInfo[$key] = $val; 
			}
            
            $_SESSION["user_info"] = $userInfo;
            $user_id =$userDate[0]->user_id;  
            
            $rowSites = $this->sitesmodel->get_all_sites_by_user($user_id);
            
            $_SESSION["site_info"] = $rowSites; 
            
           // print_r($_SESSION["site_info"]);exit;
			
            return true; 
			//exit;  
		}
		else
		{
			return false;
		}
		
	}
    
    function get_user_role_id($user_id)
    {
        $result = $this->db->query("SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id)); 
        $row = $result->result_array();
        return $row["role_id"];       
    }
    
	function if_user_login_exists()
	{
		$this->db->where('user_login', $this->input->post('user_login'));
		$this->db->where('user_password', $this->input->post('user_password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function register()
	{
			
			//echo "<pre>";
			//print_r($_POST);
			//exit;
			
			
		$new_user_data = array(
				'user_fname' => $this->input->post('user_fname'),
				'user_lname' => $this->input->post('user_lname'),
				'user_email' => $this->input->post('user_email'),			
				'user_login' => $this->input->post('user_login'),
				'user_password' => $this->input->post('user_password')						
			);
		
		$user_id = $this->db->insert('users', $new_user_data);
		$user_id = $this->db->insert_id();
	
		if(isset($_POST["request_from"]))
			{
				$package_array_data = array (
						'user_id' =>  $user_id,
						'package_id' => $this->input->post('package_id')
						);
			
				$this->db->insert('user_packages_xref',$package_array_data)  ;
			}
			//exit;
		//if(isset($_POST('request_from')))	
		//{
		//	$package_array_data = array (
				//	'user_id' =>  $user_id,
			//		'package_id' => $this->input->post('package_id');
			//);
			
			//$this->db->insert('user_packages_xref',$package_array_data)
	//	}																
		//if(isset($this->input->post('request_from')))
//		{
//			$arrayUserRole = array('user_id' => $user_id,'role_id' => '3');
//			$this->db->insert('user_role_xref', $arrayUserRole);	
//		}
//		else 
{
	//if(isset($_POST('user_role'))){		
	foreach($this->input->post('user_role') as $key => $val)
			{
				//$this->$db->query("INSERT INTO user_role_xref(user_id,role_id)VALUES('".$user_id."','".$val."')");
				$arrayUserRole = array('user_id' => $user_id,'role_id' => $val);
				$this->db->insert('user_role_xref', $arrayUserRole);
				
			}
		//}
}
				
		return $user_id;
	}
	
	function if_user_email_exists()
	{
		$this->db->where('email',$this->input->post('email'));
		$query = $this->db->get('membership');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	function get_user_by_id()
	{
		//Will return all data of Users
		$query = $this->db->get('users');
		return $query->result(); 
		
	}
	function set_status()
	{
		//Will Update Status Deleted Active Pending etc
	}
	function get_package_by_user_id($user_id)
	{
		$qry = "SELECT package_id from user_packages_xref WHERE user_id = '".$user_id."'";
		//echo $qry;exit; 
		$records = $this->db->query($qry);
		
		if($records)
		{
			$package_array = $records->result_array();
			
		}
		 //echo "<pre>";
		 //print_r($package_array);
		 //exit;
		return $package_array[0]["package_id"];
		 
	}
    
    
   
   // method to save signup process values  into DB
    function do_signup($get_value)
    {
        $new_user_data = array(
                'user_login' => $get_value['log_in'],  
                'user_fname' => $get_value['user_fname'],
                'user_lname' => $get_value['user_lname'],
                'user_email' => $get_value['user_email'],
                'user_password' => $get_value['user_password'],
                'user_reg_date' => time()                       
            );
           
        $user_id = $this->db->insert('users', $new_user_data);
        $user_id = $this->db->insert_id();

                $package_array_data = array (
                        'user_id' =>  $user_id,
                        'package_id' => $get_value['package']
                        );
            
                $this->db->insert('user_packages_xref',$package_array_data);
    
        return $user_id;
    }
     
     // method to check email already exist or not   
    function  email_exists ($user_email)
    {
       $query_string = "SELECT user_email FROM users where user_email = ?"; 
       $result = $this->db->query($query_string,$user_email);
       if ($result->num_rows() > 0){
           // true
           return true;
       }else{
           // false
           return false;
       }
        
    }
    
    // method to check email already exist or not   
    function  login_exists ($user_email)
    {
       $query_string = "SELECT user_login FROM users where user_login = ?"; 
       $result = $this->db->query($query_string,$user_email);
       if ($result->num_rows() > 0){
           // true
           return true;
       }else{
           // false
           return false;
       }
        
    }
    
   // method to check email already exist or not   
    function  user_sites_check ($user_id)
    {
        //echo $user_id .">>>>>>";
       $query_string = "SELECT user_id FROM sites where user_id = ?"; 
       $result = $this->db->query($query_string,$user_id);
     //  print_r($result->num_rows());
       if ($result->num_rows() > 0 && $result->num_rows() != 0 )
       {
           return true;
       }
       else
       {
           return false;
       }
        
    }
    
    function isUserLoginExist()
    {
        $user_login = $this->input->post('user_login');
        
        $qryUserLogin = "SELECT user_id FROM users WHERE user_login=".$this->db->escape($user_login);
        $rsltUserLogin = $this->db->query($qryUserLogin);
        if($rsltUserLogin->num_rows()>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function isUserEmailExist()
    {
        $user_email = $this->input->post('user_email');
        $qryUserEmail = "SELECT user_id FROM users WHERE user_email=".$this->db->escape($user_email);
        
        $rsltUserEmail = $this->db->query($qryUserEmail);
        if($rsltUserEmail->num_rows()>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function updateUserInfo()
    {
        $user_id = $this->input->post('user_id');
        $user_fname = $this->input->post('user_fname');
        $user_lname = $this->input->post('user_lname');
        //$user_password = $this->input->post('user_password');
        
        $_SESSION['user_info']['user_fname'] = $user_fname;
        $_SESSION['user_info']['user_lname'] = $user_lname;
        
        $qryUpdateUserInfo = "UPDATE users SET user_fname=".$this->db->escape($user_fname).", user_lname=".$this->db->escape($user_lname)." WHERE user_id=".$this->db->escape($user_id);
        /*if($user_password=="")
        {
            $qryUpdateUserInfo = "UPDATE users SET user_fname=".$this->db->escape($user_fname).", user_lname=".$this->db->escape($user_lname)." WHERE user_id=".$this->db->escape($user_id);    
        }
        else
        {
            $qryUpdateUserInfo = "UPDATE users SET user_fname=".$this->db->escape($user_fname).", user_lname=".$this->db->escape($user_lname).", user_password=".$this->db->escape($user_password)." WHERE user_id=".$this->db->escape($user_id);    
        }*/
        //echo $qryUpdateUserInfo;exit();
        $this->db->query($qryUpdateUserInfo);
        
        return;
        
    }
    
    function updatePassword()
    {
        $user_password = $this->input->post('txtNewPassword');
        $user_id = $_SESSION['user_info']['user_id'];
        $qryUpdatePassword = "UPDATE users SET user_password=".$this->db->escape($user_password)." WHERE user_id=".$this->db->escape($user_id);
        $this->db->query($qryUpdatePassword);
        return;
    }
    
    //checks if the password provided in correct for this user, ajax call from changePassword.php(view)
    function isUserPassword()
    {
        $user_id = $_SESSION['user_info']['user_id'];
        $user_password = $this->input->post('password');
        $qryUserPassword = "SELECT user_id FROM users WHERE user_id=".$this->db->escape($user_id)." AND user_password=".$this->db->escape($user_password);  
        //echo $qryUserPassword;exit();
        $result = $this->db->query($qryUserPassword);
        if($result->num_rows()>0)
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }   
	
}
?>