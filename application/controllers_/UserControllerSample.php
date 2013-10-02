<?php
@session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {
	function UserController(){
		$value = array(
			'userId'=>'','username' => '','password' => '','phone' => '','email' => '');
		$result='';
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UserModel');
		$this->output->cache(0);  // caches
		}
		function index(){
			$data['msg'] = '';
		$data['status'] ='';
		//$term = $this->input->post('email');echo $term;
		$this->load->view('index',$data);
		}
		function signup(){
			$this->load->view('UserView');
			}
		function AddUserSubmit()
		{
			$data['msg'] = 'Please Login';
			$value = array(
			'userId'=>'','username' => $_POST['username'], 'password' => $_POST['password'], 'phone' => $_POST['phone'], 'email' => $_POST['email']);
			$data['status']=$this->UserModel->AddUserSubmit($_POST);
			 //$data['status']='';
			$this->load->view('index',$data);
		}
	function login()
	{
	$value = array(
		'userId'=>'','email' => '', 'password' => '');
		$result=$this->UserModel->login($_POST);
		if($result == 'yes'){
			$data['msg']='Successfully login';
			$data['status']=$result;
		 $this->load->view('index',$data);
		}
		else if ($result == 'no'){
			$data['status']=$result;
						$data['msg']='Invalid Username/password ';
			$this->load->view('index',$data);
		}
		else if ($result == ''){
			$data['msg'] =  'invalid Access';
			$data['status']=$result;
			$this->load->view('index',$data);
		}
	}
	function logout(){
					$data['msg'] = 'You have logout successfully';
					$data['status']= 1;
									//unset($_SESSION['admName']);
					$this->load->view('index',$data);	
	}//end logout function
	function Myaccount(){
							$data['msg'] = 'you can upadte your profile';
									$data['status']= 1;
					$this->load->view('index',$data);
	}//end logout function
}
?>
