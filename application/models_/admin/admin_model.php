<?php

//class definition for Admin_model

class Admin_model extends CI_Model

{

    //Admin_model constructor

    function Admin_model()

    {

        parent::__construct();

        

    }

    

    //called in "Administrator" controller

    //return either TRUE Or FALSE

    //checks if user is valid Or is Admin

    function isUser() 

    {

        $boolIsUser = FALSE;

        

        $user_login = $this->input->post('user_login');

        $user_password = $this->input->post('user_password');

        

        $qryIsUser = "SELECT * FROM users usr 

                    JOIN user_role_xref urx ON urx.user_id=usr.user_id 

                    JOIN roles rol ON rol.role_id=urx.role_id 

                    WHERE usr.user_login=".$this->db->escape($user_login)." 

                    AND usr.user_password=".$this->db->escape(md5($user_password))."

                    AND rol.is_admin='1'";

        //echo $qryIsUser;exit;

        $rsltIsUser = $this->db->query($qryIsUser);

        

        if($rsltIsUser->num_rows()>0)

        {

            $boolIsUser = TRUE;    

        }

        

        return $boolIsUser;

    }

    

    //gets user_login POST data during user's login from session write

    //returns user's information in DB

    function getUserInfo()

    {

        $user_login = $this->input->post('user_login');

        

        $this->db->where('user_login', $user_login);

        $rsltUserInfo = $this->db->get('users');

        

        return $rsltUserInfo;   

    }
	
	function getAllMemberInfo()
	{
	 $query = $this->db->query('SELECT * FROM users');
	  if($query->num_rows > 0)
		{
			$userData = $query->result();
		
			return $userData;
		}
    }

}

?>

