<?php
@session_start();
class UsersModel extends CI_Model {
	function UsersModel()
	{
		parent::__construct();
		$this->load->model("sitesmodel");
	}
    function admin_login($id)
	{
		$query = $this->db->query("SELECT user_login,user_password
						  FROM users
						   WHERE user_id=".$id."");
		if($query->num_rows == 1)
		{
			$userData = $query->result();
			foreach($userData[0] as $key => $val)
			{
				$userInfo[$key] = $val; 
			}
		}
		 
		$this->db->where('user_login', $userInfo['user_login']);
		$this->db->where('user_password', $userInfo['user_password']);
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
	/*	echo "<pre>";
		print_r($userInfo);
		echo $userInfo['user_login'];
		exit();*/
		/*$_SESSION["user_info"]['user_login'] = $userInfo['user_login'];
		$_SESSION["user_info"]['user_password'] = $userInfo['user_password'];*/
		//return true;
		
	}
	function do_login()
	{
		
		$user_email = trim($this->input->post('user_email'));
		$user_pass = trim($this->input->post('user_password'));
		$pwd = md5($user_pass);
		
		
		if(isset($user_email) && $user_email!='')
		{
			$this->db->where('user_email', $user_email);
			$this->db->where('user_password', $pwd);	
			$query = $this->db->get('users');				
		}
		else
		{
			$this->db->where('user_login', $this->input->post('user_login'));
			$this->db->where('user_password', $pwd);	
			$query = $this->db->get('users');
		}
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
		}
		else
		{
			return false;
		}
		
	}
	
 function Recover_Password($mail,$password)
   {
   	    $this->site_id = $site_id;
		$pwd = md5($password);
		
		$qry = $this->db->query("SELECT * FROM users WHERE user_email ='".$mail."'");
		
		
		if($qry->num_rows() > 0)
		{
		  $qry = "UPDATE users SET user_password ='".$pwd."' 
									 WHERE user_email ='".$mail."'
									 OR user_login = '".$mail."' ";
									 
									
  
		  $query = $this->db->query($qry);
  
	
		   if (sizeof($query) > 0)
		   {
			  return true ;
		   }
		   else
		   {
			  return false;	 
		   }
		}
		 else
		   {
			  redirect(base_url().index_page().'UsersController/password_recovery/1'); 
		   }
   }
/* function Recover_Password($mail)
   {
   		$data = array();
		$this->db->where('user_email', $mail );
		$query = $this->db->get('users');
		 if ($query->num_rows() > 0)
		 {
		  $data = $query->row_array();
		  return $data['user_password'];
	     }	
  }*/
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
		//if(isset($_POST('user_role'))){		
		foreach($this->input->post('user_role') as $key => $val)
		{
			//$this->$db->query("INSERT INTO user_role_xref(user_id,role_id)VALUES('".$user_id."','".$val."')");
			$arrayUserRole = array('user_id' => $user_id,'role_id' => $val);
			$this->db->insert('user_role_xref', $arrayUserRole);
			
		}
		//}
		
				
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
	
	function get_user_id_by_site_id($site_id)
		{
			//$qry = 'SELECT user_id, FROM sites WHERE site_id ='.$this->db->escape($site_id);
			
			$this->db->where('site_id', $site_id); 
			$rslt = $this->db->get("sites");
			if($rslt->num_rows()>0)
			{
				$row = $rslt->row_array();
				$user_id = $row['user_id']; 
				return $user_id;   
			}
			return false;	
		}
	
	function get_user_details_by_user_id($user_id)
	{
		//Will return all data of User
		$qry = "SELECT * from users WHERE user_id = ".$user_id;
		$records = $this->db->query($qry);
		$row = $records ->result_array();
		return $row; 
		
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
	function do_signup($get_value, $newuserflag=0)
	{
		
		
		
		if(!isset($get_value['log_in']) && empty($get_value['log_in']))
		{
			
			$get_value['log_in'] = $get_value['user_email'];
			$get_value['user_fname'] = '';
			$get_value['user_lname'] = '';
		}
		else
		{
			// user From filling form
			$user_data = array(
				'user_login' => $get_value['log_in'],  
				'user_fname' => $get_value['user_fname'],
				'user_lname' => $get_value['user_lname'],
				'user_email' => $get_value['user_email'],
				'user_password' => md5($get_value['user_password']),
				'user_reg_date' => time()                       
			);
			
		}
		
		$new_user_data = array(
				'user_login' => $get_value['log_in'],  
				'user_fname' => $get_value['user_fname'],
				'user_lname' => $get_value['user_lname'],
				'user_email' => $get_value['user_email'],
				'user_password' => md5($get_value['user_password']),
				'user_reg_date' => time()                       
			);
		
		if(isset($newuserflag) && $newuserflag==1)
		{
				
					$user_email = trim($this->input->post('user_email'));
					$user_pass = trim($this->input->post('user_password'));
					if(isset($user_email) && $user_email!='')
					{
						$qry = "SELECT * from users WHERE user_email = '".$user_email."'";
						$records = $this->db->query($qry);
						$row = $records ->result_array();
						
						if(count($row)>0)
						{
							$user_array['user_id'] = $row[0]['user_id'];
							$user_array['exist']=  1;
							
							
						}
						else
						{
							$user_id = $this->db->insert('users', $new_user_data);	
						}
						
					}
					
		}
		else
		{	// user From filling form
			$user_id = $this->db->insert('users', $user_data);	
		}
		
		$user_id = $this->db->insert_id();
		if(isset($newuserflag) && $newuserflag == 1)
		{
				$package_array_data = array (
						'user_id' =>  $user_id,
						'package_id' => 3
						);
			
				$this->db->insert('user_packages_xref',$package_array_data);
		}
		else
		{
				// user From filling form
				$package_array_data = array (
						'user_id' =>  $user_id,
						'package_id' => $get_value['package']
						);
			
				$this->db->insert('user_packages_xref',$package_array_data);
		
		}
		
		
				
		/*
		 * CkEditor media management linking ! Folder Creation userwise.
		*/
		
		$path_to_main_folder = getcwd().'/media/uploads/';
		$user_folder = $path_to_main_folder.$get_value['log_in'].'_'.$user_id;
		
		
/*		if(!is_dir($user_folder))
		{
			mkdir($user_folder,0777);
			//ckedotor folders
			$ckeditor_images = $user_folder.'/images';
			mkdir($ckeditor_images,0777);
			
			$ckeditor_thumbs = $user_folder.'/_thumbs';
			mkdir($ckeditor_thumbs,0777);
			
			$ckeditor_files = $user_folder.'/files';
			mkdir($ckeditor_files,0777);
			
			
			$ckeditor_administrative = $user_folder.'/administrative';
			mkdir($ckeditor_administrative,0777);
			
			$ckeditor_contests = $user_folder.'/contests';
			mkdir($ckeditor_contests,0777);
			
			$ckeditor_flash = $user_folder.'/flash';
			mkdir($ckeditor_flash,0777);
		}*/
		
	
		if(isset($user_array) && !empty($user_array))
		{
			return $user_array;
		}
		return $user_id;
	}
	
	 function do_signup_with_trial($fname,$lname,$log_in,$pass,$email)
	 {
		 		// echo $this->isUserLoginExist();exit;
		 if( !($this->email_exists($email)) && !($this->isUserLoginExist()))
		 {
			 $trial_start_date = date('Y-m-d H:i:s');
			 $end_date = $this->calculate_trail_end_date($trial_start_date);
			 $trial_end_date = $end_date;
			 $status = "Active";
			 
			 $data = array(
						"user_login" => $log_in,
						"user_password" => $pass,
						"user_email" => $email,
						"user_fname" => $fname,
						"user_lname" => $lname,
						"user_status" => $status,
						"user_trail_start_date" => $trial_start_date,
						"user_trail_end_date" => $trial_end_date
						);
			 $r = $this->db->insert("users",$data);
			 $user_id = $this->db->insert_id();
			 
			 if($r)
			 {
				 
				 $package_array_data = array (
						'user_id' =>  $user_id,
						'package_id' => 1 	// 1 means trial package
						);
				
				 $this->db->insert('user_packages_xref',$package_array_data);
				
				 return 1;
			 }
		 }
		 else 
		 {
			 return 2;
		 }
		 return 0;
	 }
	 
	 function calculate_trail_end_date($start_date)
	 {
		 $date = strtotime(  $start_date. " +1 Month");
		 $end_date = date("Y-m-d H:i:s",$date);
		 return $end_date;
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
		//echo "<pre>"; print_r($_REQUEST);
		$user_login = $this->input->post('user_login');
		if(!isset($user_login) || empty($user_login))
		{  
			$user_login = $this->input->post('log_in');
		}
		
		$qryUserLogin = "SELECT user_id FROM users WHERE user_login=".$this->db->escape($user_login);
		$rsltUserLogin = $this->db->query($qryUserLogin);
		if($rsltUserLogin->num_rows()>0)
		{
			//echo "yes";
			return TRUE;
		}
		else
		{
			//echo 'false';
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
            
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
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
	function updateUserInfoAfterPayment($user_id)
	{
		$data = array(
               'user_status' => 'Active'            
            );
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
	
	}
	function deleteUserInfoAfterFail($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('users'); 
		return ;
	}
	function updatePassword()
	{
		$user_password          = $this->input->post('txtNewPassword');
		$user_id                = $_SESSION['user_info']['user_id'];
        $seccession             = $this->session->all_userdata();
        if( $seccession['user_info']['user_type'] == '1')
         {
             $user_id           = $this->input->post('user_id');
         }
		$qryUpdatePassword = "UPDATE users SET user_password='".md5($user_password)."' WHERE user_id=".$user_id;
		$this->db->query($qryUpdatePassword);
		return;
	}
	
	
	function updateRecoveredPassword($user_email, $user_password)
	{
		
		if(isset($user_email) && $user_email!='')
		{
			$qryUpdatePassword = "UPDATE users SET user_password='".md5($user_password)."' WHERE user_email=".$this->db->escape($user_email);
			$this->db->query($qryUpdatePassword);
		}		
		return;
	}
	
	//checks if the password provided in correct for this user, ajax call from changePassword.php(view)
	function isUserPassword($user_id)
	{
		//$user_id = $_SESSION['user_info']['user_id'];
        
		$user_password = $this->input->post('password');
		$pwd = md5($user_password);
		$qryUserPassword = "SELECT user_id FROM users WHERE user_id=".$user_id." AND user_password='".$pwd."'";  
		//echo $qryUserPassword;exit();
		$result = $this->db->query($qryUserPassword);
		if(sizeof($result)>0)
		{
			return 'TRUE';
		} 
		else
		{
			return 'FALSE';
		}
	}   
	
	function suspend_account()
	{
		$data = array(
			"user_status" => "Suspend"
		);
		
		$this->db->where("user_id",$_SESSION['user_info']['user_id']);
		$r = $this->db->update("users",$data);
		if($r)
		{
			return true;
		}
		return false;
	} 
	function get_status($user_id)
	{
		$this->db->where("user_id",$user_id);
		$r = $this->db->get('users');
		$row = $r->row_array();
		return $row['user_status'];
	}
	function set_status($user_id,$status)
	{
		$data = array(
			"user_status" =>$status	
		);
		$this->db->where("user_id",$user_id);
		$this->db->update("users",$data);
	}
    function get_affiliate_user()
    {
        $this->db->where('affiliate_id !=', '0');
        $result = $this->db->get('users');
       // echo $this->db->last_query(); exit;
        return $result->result();
    }
    
	
}
?>