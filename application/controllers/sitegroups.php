<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SiteGroups extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');  
		
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		
		//$this->load->Model('RolesModel'); 
		//$this->load->Model('PackageModel'); 
		$this->load->Model('Groups_Model'); 
		$this->load->Model('Menus_Model');  
		$this->load->library('session'); 
		$this->load->library('Paypal_Lib');
		$this->output->cache(0);  // caches 
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		
		//Check user Login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
		
		//$this->template->render($region = NULL, $buffer = FALSE, $parse = FALSE)  ;    
	}
	//checks that user has logged-in Or not
	private function checkLogin()
	{
		//checks if session user_info is set
		if(!isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id'] == NULL)
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
	//end
	function index()
	{
	
	
		$link = substr(uri_string(),1);
		$group_link = base_url().$link;
		$this->session->set_userdata("group_link", $group_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Groups'); 
	   
		$this->checkLogin();
		
		
		
		$site_id = $_SESSION["site_id"];
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$groups = $this->Groups_Model->get_all_site_gropus($site_id);
		
		//Going to fetch members count
	
		if(count($groups) > 0  )
		{
			$gp_count = 0;
			foreach($groups as $record)
			{
				//get_group_members_count('group_id')
				$groups_customer_count = $this->Groups_Model->get_group_members_count($record["id"]);
				$groups[$gp_count]["member_count"] = $groups_customer_count;
				$gp_count++;
			}
		}		
		
		if(isset($groups_customer_count))
		{
			$data['groups_customer_count'] = $groups_customer_count;
		}
		
		$data['groups_array'] = $groups;
		$this->template->write_view('content','site_groups/home',$data);
		// Render the template
		$this->template->render();
	}
	
	/*
	 This function will be used in new site/vistor sign-up group creation.
	
	*/
	function new_site_group()
	{
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Group', $this->session->userdata("group_link") ); 
		$this->breadcrumb->add_crumb('Create' );
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		$data['permissions_array'] = $permsions;
		
		/* Get all pages 3-27-2012  */
		$data['pages'] = $this->Menus_Model->getPages($_SESSION["site_id"]);  	
		$data['allpages'] = $data['pages']->result_array();	
		/* Get all pages 3-27-2012  */
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$query_upgradables = $this->Groups_Model->get_group_upgradable_options($_SESSION["site_id"]);
		$data['query_upgradables'] = $query_upgradables;
		
		$this->template->write_view('content','site_groups/site_new_group',$data);
		// Render the template
		$this->template->render();	
	}
	
	// Call to Model to perform CRUD operations for creation of new group.
	function do_creat_site_group($first_group=0)
	{
	
		$file_name = '';
	//	echo "<pre>";print_r($_REQUEST);exit;
		$site_id = $_SESSION["site_id"];
		if($_FILES["logo_image"]["tmp_name"]!="")
        {     
		      	
			/*** Start Image Upload Config******/	
			$fileName 					= $_FILES['logo_image']['name'];			
			$config['upload_path'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/';			
			$config['allowed_types'] 	= 'gif|jpg|ico|jpeg|png|GIF|JPG|JPEG|PNG';				
			$config['maintain_ratio'] 	= true;
			$config['max_width']		= '1024';
			$config['max_height']		= '768';
			$config['file_name'] 		= $fileName;
			$config['overwrite']		= true;
			$config['remove_spaces']	= true;
			$config['create_thumb'] 	= true;				
			$this->load->library('upload', $config);		
			/*** End Image Upload Config******/
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'],0777);
			} 
	   
			$this->upload->initialize($config);
			if ($this->upload->do_upload("logo_image"))
			{
				$file_name = $config['file_name'];					
				$response = "Logo have been uploaded successfully";
				$this->session->set_userdata('rsp_logo_error', 0);		
			}
		}
		
		
		$created = $this->Groups_Model->insert_site_group($site_id, $file_name);
		
		if($created)
		{
			if(isset($first_group) && !empty($first_group))
			{
				if($first_group=='m')
				{
					 redirect("menusController/createMenu/".$_SESSION["site_id"]);
				}
				else
				{
					redirect("pagesController/page_menu/".$_SESSION["site_id"]."/".$first_group);
				}
			}
			redirect("sitegroups/index");
		}
		else
		{
			echo "got error";
		}
	
	}
	
	// view - landing page for Admin Site Groups
	function creat_admin_group()
	{
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		//$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		//$data['permissions_array'] = $permsions;
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$this->template->write_view('content','site_groups/admin_new_group',$data);
		// Render the template
		$this->template->render();		
	}
	
	function status_group($group_id)
	{
		if(isset($group_id))
		{
			$status['action_text'] = $this->Groups_Model->status_group($group_id);
		}	
		redirect("/sitegroups/index");
	}
	
	function edit_group($group_id)
	{
		
	  	$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Group', $this->session->userdata("group_link") ); 
		$this->breadcrumb->add_crumb('Edit' );
		
		$this->checkLogin();
		if(isset($group_id))
		{
			$data['group_id'] = $group_id;
			$data['data'] = $this->Groups_Model->get_edit_group($group_id);	
			//echo "<pre>"; print_r($data['data']); exit;
			$permsions = $this->Groups_Model->get_all_sitegroup_permission();
			$data['permissions_array'] = $permsions;
			
			/* Get all page 3-27-2012*/
			$data['pages'] = $this->Menus_Model->getPages($_SESSION["site_id"]);  	
			$data['allpages'] = $data['pages']->result_array();	
			/* Get all page 3-27-2012*/
			
			
			$query_upgradables = $this->Groups_Model->get_group_upgradable_options_of_group($group_id,$_SESSION["site_id"]);
			$allUpgradableGroup = $query_upgradables->result_array();
			
			foreach($allUpgradableGroup as $group)
			{
				//$key['id']; die();
				if ($this->Groups_Model->if_group_is_upgradable_option_of_another_group($group_id,$group['id']) )
				{
					$group["selected"] = "selected";
					//echo "<pre>";	print_r($group);	die();	
				}
				$newUpgradableOption[] = $group;
			}
			
			
			$data['query_upgradables'] = $newUpgradableOption;
			
			$data['fields_data'] = $this->Groups_Model->get_group_fields($group_id);
			
			foreach($data['fields_data'] as $option)
			{
				/*echo "<pre>";print_r($option);
				//get_fields_options($field_id)
				$data = $this->Groups_Model->get_fields_options($option['id']);
				echo "<pre>";print_r($data);*/
				$options_value = $this->Groups_Model->get_fields_options($option['id']);
				
				$option['fields_data_options'] = $options_value;
				$data['fields_data_options'][] = $option;
				
				
			}
			/*echo "<pre>";print_r($data);
			exit;*/
			
			$group_page_id = $data['data'][0]['group_page_id'];
			
			$group_page_content = $this->Groups_Model->get_group_page_content($group_page_id); 	
			$data['group_page_content'] = $group_page_content;
			
			$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
			$data['menus_array'] = $menus;
			
			$page_id = $this->Groups_Model->get_group_button_page_by_group_id($group_id);
			$data['button_page_id'] = $page_id;
			// echo "<pre>";print_r($data	);	die();
			$this->template->write_view('content','site_groups/site_update_group',$data);
			// Render the template
			$this->template->render();	
		}
	}
	
	// check with group name
	function check_if_group_exist()
	{
		$group_name = $this->input->post("name");
		$r = $this->Groups_Model->check_if_group_exist($group_name);
		if($r)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}
	
	function do_update_site_group()
	{
		
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$site_id = $_SESSION["site_id"];
		$file_name = '';
		if($_FILES["logo_image"]["tmp_name"]!="")
        {     
		      	
			/*** Start Image Upload Config******/	
			$fileName 					= $_FILES['logo_image']['name'];			
			$config['upload_path'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/';			
			$config['allowed_types'] 	= 'gif|jpg|ico|jpeg|png|GIF|JPG|JPEG|PNG';				
			$config['maintain_ratio'] 	= true;
			$config['max_width']		= '1024';
			$config['max_height']		= '768';
			$config['file_name'] 		= $fileName;
			$config['overwrite']		= true;
			$config['remove_spaces']	= true;
			$config['create_thumb'] 	= true;				
			$this->load->library('upload', $config);		
			/*** End Image Upload Config******/
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'],0777);
			} 
	   
			$this->upload->initialize($config);
			if ($this->upload->do_upload("logo_image"))
			{
				$file_name = $this->upload->data();
				$file_name = $file_name['file_name'];					
				$response = "Logo have been uploaded successfully";
				$this->session->set_userdata('rsp_logo_error', 0);		
			}
		}
		
		
		if(isset($_REQUEST['group_id']))
		{
			$created = $this->Groups_Model->do_update_site_group($_REQUEST['group_id'], $site_id, $file_name);	
				
			if($created)
			{
				redirect("sitegroups/index");
			}
			else
			{
				echo "got error";
			}
		}
	}
	
	function delete_group($group_id)
	{ 
		
		$site_id = $_SESSION["site_id"];
		
		$r = $this->Groups_Model->delete_group($group_id,$site_id);	
		if($r)
		{
			redirect("sitegroups/index");
		}
		
	}
	
	function get_paypal_id_of_store_of_site($site_id)
	{
	 
		 $this->db->where("site_id",$site_id);
		 $r = $this->db->get('site_store_settings',1);
		 
		 if ($r->num_rows() == 1){
			 
			 $row = $r->result_array(); 
			 $paypal_id = $row['paypal_id'];
			 return $paypal_id;
			 
		 } 
		 return "";
	
	}
	
	
	
	function get_fields_options($field_id)
	{
		// echo $field_id;die();
		$this->db->where("field_id",$field_id);
		$r = $this->db->get("group_fields_options");
		$n = $r->num_rows();
		if( $n > 0 )
		{
			$options = $r->result_array();
			foreach( $options as $key => $row )
			{
				$opt[$key]['option_value'] = $row['option_value'];
				$opt[$key]['option_id'] = $row['option_id'];
			}
			
			return $opt;
		}
		return false;
	}
	
	function group_fields()
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_fields_required($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		
		//numan_1333967536_biz@virtism.com
		
		$this->load->model('Shop_model');
		$site_id = $_SESSION["site_id"];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		//echo "<pre>";
		//print_r($check_group_paid); exit;
		$fields_count = count($fields_data);
		$output = array();
		$data  = "<table>";
		for($i=0; $i<$fields_count; $i++)
		{
			if ($fields_data[$i]['field_type'] == 'Check Boxes'){
					
			 	$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='checkbox' name='".$fields_data[$i]['field_name']."'/></td></tr>";
			 
			 }else if($fields_data[$i]['field_type'] == 'Radio Buttons'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='radio' value='yes' name='".$fields_data[$i]['field_name']."' /></td></tr>";	
				   
			 }else if($fields_data[$i]['field_type'] == 'Single-Line Text' ) {
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='text' name='".$fields_data[$i]['field_name']."' /></td></tr>";   
				   
			 }else if ($fields_data[$i]['field_type'] == 'Multi-Line Text'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><textarea name='".$fields_data[$i]['field_name']."' ></textarea></td></tr>";	
			 }
		}		
		$data  .= "</table>";
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free')
		{ 
		
			if(isset($check_group_paid[0]["price"]))
			{ 
				$price = $check_group_paid[0]["price"];
			}
			else if(isset($check_group_paid[0]["fixed_price"]))
			{ 
				$price = $check_group_paid[0]["fixed_price"]; 
			}
				
			$discVal = $check_group_paid[0]['discount_value'];
			$discType = $check_group_paid[0]['discount_type'];
			if( $discType != "" )
			{
				if($discType == "Percentage")
				{
					$persontage = ( $price / 100 ) * $discVal;
					$price = $price - $persontage;
				}
				else if ($discType == "Fixed")
				{
					$price = $price - $discVal;
				}
			}
			//echo "<pre>"; print_r($check_group_paid[0]['discount_type']); echo "</pre>"; die();	
		?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>group_managment/payment/">
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>group_managment/new_group/">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="amount" value="<?=$price;?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
                        <?php 
						
							
						?>
						
						<?php 	
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$_SESSION['login_info']['customer_id'],
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	function group_fields_admin($button_type)
	{
		
		
		$group_id = $_REQUEST['group_id'];
		
		$fields_data = $this->Groups_Model->get_group_custom_fields_admin_side($group_id);
		
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		$this->load->model('Shop_model');
		$site_id = $_REQUEST['sid'];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		$extraData = array();
		$fields_count = count($fields_data);
		$output = array();
		
		// Genarate Group Custom Field HTML 
		
		$n = count($fields_data);
		if($n > 0)
		{
			echo  "<table>";
			
			if(isset($check_group_paid[0]['group_code']) && !empty($check_group_paid[0]['group_code']))
			{
					//echo  "<tr><td>Enter Group Code: </td><td><input type='text' id='input_code' name='input_code'/><td></tr>";
					//echo "<input type='hidden' id='hidden_input_code' name='hidden_input_code' value=".$check_group_paid[0]['group_code']."/>";
			}
			
			
			for($i=0; $i<$n; $i++ )
			{
				
				 echo  "<tr><td>".$fields_data[$i]['label']; 
				 echo $required = ($fields_data[$i]['required']=='Yes')? '*' : '';
				 echo " </td>";
				 echo  $fields_data[$i]['field'].' '.$fields_data[$i]['id']."</tr>";
				 
			}
			echo "</table>";
		}
		
		// Generate Paypal button 
			
		// if button is generated in registeration page
		if( $button_type == "register" )
		{
			$return = site_url()."MyAccount/payment_process/".$site_id."/paid";  
			$cancle_return = site_url()."MyAccount/register/".$site_id;
		}
		// if button is genarated in group managment while logged in 
		
		
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	
	}
	
	
	function group_fields_paypal_button($button_type)
	{
		// echo "<pre>";	print_r($_SESSION['login_info']['customer_id']);	echo "</pre>";	die();
		//$button_type = $_POST['type'];
		$group_id = $_REQUEST['group_id'];
		
		$fields_data = $this->Groups_Model->get_group_custom_fields($group_id);
		//echo "<pre>";		print_r($fields_data);	echo "</pre>";	die();
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		//numan_1333967536_biz@virtism.com
		//print_r($check_group_paid); echo "</pre>"; die();
		$this->load->model('Shop_model');
		$site_id = $_REQUEST['sid'];
		 
		
		
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		// echo "<pre>";	print_r($fields_data); echo "</pre>"; die();
		$fields_count = count($fields_data);
		$output = array();
		
		// Genarate Group Custom Field HTML 
		
		$n = count($fields_data);
		if($n > 0)
		{
			echo  "<table>";
			
			if(isset($check_group_paid[0]['group_code']) && !empty($check_group_paid[0]['group_code']))
			{
					//echo  "<tr><td>Enter Group Code: </td><td><input type='text' id='input_code' name='input_code'/><td></tr>";
					//echo "<input type='hidden' id='hidden_input_code' name='hidden_input_code' value=".$check_group_paid[0]['group_code']."/>";
			}
			
			
			for($i=0; $i<$n; $i++ )
			{
				
				 echo  "<tr><td>".$fields_data[$i]['label']; 
				 echo $required = ($fields_data[$i]['required']=='Yes')? '*' : '';
				 echo " </td><td>";
				 echo  $fields_data[$i]['field'].' '.$fields_data[$i]['id']."</td></tr>";
				 
			}
			echo "</table>";
		}
		
		// Generate Paypal button 
			
		// if button is generated in registeration page
		if( $button_type == "register" )
		{
			$return = site_url()."MyAccount/payment_process/".$site_id."/paid";  
			$cancle_return = site_url()."MyAccount/register/".$site_id;
		}
		// if button is genarated in group managment while logged in 
		else if( $button_type == "group_manage" )
		{
			$return = site_url()."group_managment/payment/";  
			$cancle_return = site_url()."group_managment/new_group/";
		}
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free' && $check_group_paid[0]['payment_method'] != 'Trial')
		{?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="payPalRegForm" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=$return?>" >
						<input type="hidden" name="cancel_return" value="<?=$cancle_return?>">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="amount" value="<?php if(isset($check_group_paid[0]["price"])){ echo $check_group_paid[0]["price"];}else if(isset($check_group_paid[0]["fixed_price"])){ echo $check_group_paid[0]["fixed_price"]; }?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
						
						<?php
						
						
						$member_id = $_REQUEST['cid'];
						
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$member_id,
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	
	
	// function to show paypal button when customer upgrades the groups
	function paypal_bottom_update($current_group_id)
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_custom_fields($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		//numan_1333967536_biz@virtism.com
		
		$this->load->model('Shop_model');
		$site_id = $_SESSION["site_id"];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		// echo "<pre>";	print_r($fields_data); echo "</pre>"; die();
		$fields_count = count($fields_data);
		$output = array();
		
		// Genarate Group Custom Field HTML 
		
		$n = count($fields_data);
		if($n > 0)
		{
			echo "<table>";
			for($i=0; $i<$n; $i++ )
			{
				
				 echo  "<tr><td>".$fields_data[$i]['label']; 
				 echo $required = ($fields_data[$i]['required']=='Yes')? '*' : '';
				 echo " </td><td>";
				 echo  $fields_data[$i]['field'].' '.$fields_data[$i]['id']."</td></tr>"; 
				 
			}
			echo "</table>";
		}
		
		// Generate Paypal button 
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free')
		{?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>group_managment/upgrade_group_payment/">
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>group_managment/edit_group/<?=$current_group_id?>">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
                        
                        
                        <?php 
						// calculate upgrade amount 
						
						//print_r();
						$group = $this->Groups_Model->get_group_by_id($current_group_id);
						
						
						$current_group_price = $group[0]['fixed_price'];
						$upgradable_group_price = $check_group_paid[0]['fixed_price'];
						
						$diffrence = $current_group_price - $upgradable_group_price;
						if($diffrence < 0)
						{
							$newPrice = $upgradable_group_price - $current_group_price;
						}
						else if($diffrence > 0)
						{
							$newPrice = $upgradable_group_price;
						}
						else
						{
							$newPrice = $upgradable_group_price;
						}
						
						
						
						//$upgradable_group_id;
						
						?>
						<input type="hidden" name="amount" value="<?=$newPrice?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
						
						<?php 	
						
						//echo "<pre>";	print_r($_SESSION);	
						
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$_SESSION['login_info']['customer_id'],
							"currentGroup_id",
							$current_group_id,
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	
	function group_field_without_paypal_setting()
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_fields_required($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		
		
		$fields_count = count($fields_data);
		$output = array();
		$data  = "<table>";
		for($i=0; $i<$fields_count; $i++)
		{
			if ($fields_data[$i]['field_type'] == 'Check Boxes'){
					
			 	$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='checkbox' name='".$fields_data[$i]['field_name']."'/></td></tr>";
			 
			 }else if($fields_data[$i]['field_type'] == 'Radio Buttons'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='radio' value='yes' name='".$fields_data[$i]['field_name']."' /> | <input type='radio' value='no' name='".$fields_data[$i]['field_name']."' /></td></tr>";	
				   
			 }else if($fields_data[$i]['field_type'] == 'Single-Line Text' ) {
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='text' name='".$fields_data[$i]['field_name']."' /></td></tr>";   
				   
			 }else if ($fields_data[$i]['field_type'] == 'Multi-Line Text'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><textarea name='".$fields_data[$i]['field_name']."' ></textarea></td></tr>";	
			 }
		}		
		$data  .= "</table>";
		
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	
	
	
	  function submits($group_id)
	  {
		$this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css');    //echo $str;exit;
		
		
        $data['submits'] = $this->Groups_Model->get_all_form_submits($group_id);
	    $data['group_id'] = $group_id;
        $this->template->write_view('content','site_groups/group_form_submit',$data);
        $this->template->render();
	  }
	  
	  function submit_detail($submit_id)
	  {
		$data['submit_id'] = $submit_id;
        $data['submit'] = $this->Groups_Model->get_form_submits_detail($submit_id);
        $this->load->view('site_groups/group_form_submit_detail',$data);
        
	  }
	  
	  function exportCVS($group_id)
	  {
		 $submits = $this->Groups_Model->get_all_form_submits_for_export($group_id);
		 $this->load->helper('csv');
		 array_to_csv($submits,"Submission.csv");
	  }
	  
	  function submit_delete($group_id,$submit_id)
	  {
		  $r = $this->Groups_Model->form_submit_delete($submit_id);
		  if($r)
		  {
			  $msg = "Group form sumbit deleted successfully";
		  }
		  else
		  {
			  $msg = "Group form sumbit not deleted successfully";
		  }
		  $this->session->set_flashdata('rspDeleteSub', $msg);
		  
		  redirect("sitegroups/submits/".$group_id);
	  }
      
	  
	
}
?>