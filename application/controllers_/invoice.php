<?php

if(!session_start()){
    session_start();
}
  class Invoice extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('Template');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('cezpdf');
		$this->load->library('mpdf/mpdf');
		//Check user Login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
		$this->load->helper('pdf');
		$this->load->helper('date');
		$this->load->Model('UsersModel');
		$this->load->model('Groups_Model');
		$this->load->model("Invoice_Model");	
		$this->load->model('product_model');			
		$this->load->model('customers_model');
		$this->load->model('Access_Model');
		$this->load->model('shop_model');
		$this->load->model('Categories_model');
		
		 
		if(isset($_SESSION['current_site_info']['site_id']))
		{
			$this->site_id = $_SESSION['current_site_info']['site_id']; 
		}
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
      }
      
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        if($user_info=='' && $user_role=='')
        {
            redirect('/UsersController/login/sitelogin');
        }
        else
        {
            return;
        }   
         
    }
    //end
	
	function invoice_managment_view()
	{
		$link = substr(uri_string(),1);
		$invoice_link = base_url().$link;
		$this->session->set_userdata("invoice_link", $invoice_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Invoice Management' );
		

		if($this->session->userdata("ses_showMenuLimit"))
        {
            //applies paging limit if stored in session
            $data["pageLimit"] = $this->session->userdata("ses_showMenuLimit");
        }
        else
        {
            //applies pre-defined/fixed/constant paging limit below:
            $data["pageLimit"] = 10;
        }
        
        //save paging limit in seesion, prepare $data for pagination
        if($this->input->post("numRecords"))
        {            
            $this->session->set_userdata("ses_showMenuLimit", $this->input->post("numRecords"));
            $data["pageLimit"] = $this->session->userdata("ses_showMenuLimit");
        }        
        
        //prepares $data 
        $data['invoices'] = $this->Invoice_Model->get_all_invoices_by_site($this->site_id);	
		
		$data['site_id'] = $this->site_id; 
        
		$data["numRecords"] =  count($data['invoices']);
             
        
        // parameters for pagination applied  
        $config = array(
            'uri_segment' => 4,
            'base_url' => base_url().index_page().'invoice/invoice_managment_view/',
            'per_page' => $data["pageLimit"],
            'first_link' => 'First',
            'next_link' => 'Next',
            'last_link' => 'Last',
            'next_link' => 'Next',
            'prev_link' => 'Previous',
            'display_pages' => TRUE,
            'num_links' => 2,
            'total_rows' => $data["numRecords"]
        ); 
        
        
        //apply pagination parameters set earlier     
        $this->pagination->initialize($config);

        //prepare pagination $data for display
        $data["paging"] = $this->pagination->create_links();
		
		
		//search invoice by customer
		if($this->input->post('action')== 'search')
		{
			
			 $search_by = trim($this->input->post('page_id_home'));
			 $search_value = trim($this->input->post('search_value'));
			 $search_param = array('search_by'=> $search_by, 'search_value'=>$search_value);		 
			if(empty($search_by) || empty($search_value))
			{
				$this->session->set_flashdata('search_error', 'Please select option and enter search value.');
				
			}
			else
			{
				$data['title'] = "Search Results";
				$data['search_param'] = $search_param;
				$data['search_array_result'] = $this->Invoice_Model->getAllCustomers($this->site_id,$search_param);
			}
			
		}
		
		$this->template->write_view('content','invoice_management_view',$data);
		$this->template->render();
	}
      
	  function index()
      { 
         
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Invoice Management', $this->session->userdata("invoice_link") ); 
		$this->breadcrumb->add_crumb('Create');
		 
		if(isset($_SESSION['user_info']['user_login']))
		{
			$data['user_name'] = $_SESSION['user_info']['user_login'];        
			$data['products'] = $this->product_model->getDigitalProductsDropdown_invoice($this->site_id);
			$data['categories'] = $this->categories_model->getAllCategories($this->site_id);		
			//echo "<pre>";print_r($data['categories']);
		}
		else
		{
			redirect('/UsersController/login/sitelogin');
		}
		
		$data['countries'] = $this->Invoice_Model->get_country();
		$data['states'] = $this->Invoice_Model->get_states();
		
		//$data['count'] = $this->customers_model->getAllCustomersCountBySiteID($this->site_id);
		$this->template->write_view('content','ecommerce/invoice',$data);
		$this->template->render();
 
      }
      
	  //ajex call for groups and customers
	  function ajax_call_customers($data = 0)
	  {
	  	 
		 $count = $this->customers_model->getAllCustomersCountBySiteID($this->site_id);
		 if($count>0)
		 {
		 	echo $data = $this->Invoice_Model->get_site_gropus_customer_by_site_id($this->site_id, 'single');	  	
		 }
		 else
		 {
		 	echo "<a style='padding-left:16px;' href=".base_url().index_page()."customers/customer_registration/1>Create Customer</a>";
		 }
		 
	  }
	  
	  //ajex call for customer detail
	  function ajax_call_customers_detail($customer_id=0)
	  {
	 	$customer_id = $_POST['customer_id_'];
		$detail = $this->customers_model->getCustomer($customer_id);
		$address_detail = $this->customers_model->getAllAddress('0',$customer_id);
		$countries = $this->Invoice_Model->get_country();
		$states = $this->Invoice_Model->get_states();
		//echo "<pre>";print_r($address_detail); print_r($detail);
		//$states = $this->Invoice_Model->getstates_by_country_id($country_id);
		//echo "<pre>";print_r($address_detail);exit;
		
		//HTML starts 
	?>
		
        
        <div class="ColumnA">
                    <ul>
                    	<li> 
                        	<label class="NewsletterLabel">First Name:</label>
                     		<input id="fname" name="fname" type="text" value="<? if(isset($detail['customer_fname'])){ echo $detail['customer_fname']; }?>" size="20" />
                     	</li>
                     	<li>
                     		<label class="NewsletterLabel">Last Name:</label>                     
                     		<input id="customer_lname" name="lname" type="text"  value="<? if(isset($detail['customer_lname'])){ echo $detail['customer_lname']; }?>" size="20"/>
                     	<li>
                        	<label class="NewsletterLabel">Company:</label>
                            <input id="customer_company" name="company" type="text"  value="<? if(isset($detail['customer_company'])){ echo $detail['customer_company'];}?>" size="20" />
                     	<li>
                        	<label class="NewsletterLabel">Email:</label>
                            <input id="email" name="email" type="text" value="<? if(isset($detail['customer_email'])){ echo $detail['customer_email']; }?>"  size="20"/>
                     	</li>
                     	<li>
                        	<label class="NewsletterLabel">Phone Number:</label>
                            <input id="pnumber" name="pnumber" type="text" value="<? if(isset($address_detail[0]['address_book_phone'])){ echo $address_detail[0]['address_book_phone']; } ?>" size="20"/>
                     	</li>
                    </ul>
         </div>                 
         <div class="ColumnB">
            <ul>
                <li>
                    <label class="NewsletterLabel">Street address: </label>
                    <input id="saddress" name="saddress" type="text" value="<? if(isset($address_detail[0]['address_book_address'])){ echo $address_detail[0]['address_book_address']; } ?>" size="20"/>
                </li>
                <li>
                    <label class="NewsletterLabel">Country:</label>                     
                    <div  style="position:relative; float:left; height:40px !important;">
                        <select id="country" name="country" onchange="get_ajax_states()" style= "width:150px;" size="1" >
                            <? foreach($countries as $country) 
                            {
                                //echo "<option value=".$country["countries_id"].">".$country["countries_name"]."</option>";
							?>	
								<option <? if(isset($address_detail[0]["address_book_country"]) && $address_detail[0]["address_book_country"]==$country["countries_id"]){ echo 'selected="selected"';}?>  value="<?=$country["countries_id"]?>"><?=$country["countries_name"]?></option>
                            <? }
                            ?>		
                                												
                        </select>
                    </div>                     
                </li>
                <li>
                    <label class="NewsletterLabel">State/Province:</label>                     
                     <div id="state_option" style="position:relative; float:left; height:40px !important; ">
                     <select id="state" name="state" style="width:150px;" size="1">
							<? foreach($states as $state) 
                            {
                               ?>                               
                               <option <? if(isset($address_detail[0]["address_book_state"]) && $address_detail[0]["address_book_state"]==$state["zone_code"]){ echo 'selected="selected"';}?>  value="<?=$state["zone_code"]?>"><?=$state["zone_name"]?></option>
                               
							   <?
                            }
                            ?>	
                            												
                    </select>
                    </div>
                </li>
                <li>
                    <label class="NewsletterLabel">City:</label>
                    <input id="city" name="city" type="text" value="<? if(isset($address_detail[0]['address_book_city'])){ echo $address_detail[0]['address_book_city']; }?>"  />
                </li>
                <li>
                    <label class="NewsletterLabel">ZIP/Postal Code:</label>
                    <input id="zip" name="zip" type="text" value="<? if(isset($address_detail[0]['address_book_zipcode'])){ echo $address_detail[0]['address_book_zipcode']; }?>" size="20"/>
                </li>
            </ul>
      </div>
     
	<? }
	  
	  //create 
	  function ajax_call_states($country_id=0)
	  {
			$country_id = $_REQUEST['country_id'];
			$states = $this->Invoice_Model->getstates_by_country_id($country_id);
			if(empty($states))
			{
				// echo '<input type="text" id="state1" name="state" size="20" />';
				echo "";
			}
			else
			{
				
				//echo '<div  style="position:relative;">';
                echo   '<select class="none" id="state2" name="state" style="width:150px;" size="1">';
					foreach($states as $state) 
					{
						echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
					}
																		
				 echo '</select>';
        		 //echo '</div>';	
				
				
			}
			
			
			/*else
			{
				//print_r($states);
				//echo '<div  style="position:relative;">';
                
				echo '<div class="NFSelect" style="width: 150px; left: 959px; top: 724px; z-index: 998;"><img src="http://23.23.227.152/images/webpowerup/img/0.png" class="NFSelectLeft"><div class="NFSelectRight">'.$states[0]['zone_name'].'</div><div class="NFSelectTarget" style="display: none;"><ul class="NFSelectOptions">'; 
        foreach($states as $state) 
		{
			//echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
			echo '<li><a href="javascript:;">'.$state['zone_name'].'</a></li>';
		}
		
        echo '</ul></div></div><select size="1" style="width:150px;" name="state" id="state" class="NFhidden">';
	    foreach($states as $state) 
		{
			echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
		}
  		echo '</select>';
				
		}*/
			
		}
	
	function get_ajax_product_type()
	{
		$product_type = trim($_POST['product_id_']);
		$row_type = $_POST['row_id'];
		
		if($product_type=='Meeting')
		{
			$products = $this->Invoice_Model->getMeetingsDropdown_invoice($this->site_id);	
			
		}
		else if($product_type=='Webinar')
		{
			$products = $this->Invoice_Model->getWebinarsDropdown_invoice($this->site_id);	
		}
		else
		{
			$products = $this->product_model->getProductsDropdown_invoice($this->site_id, $product_type);	
		}
		
		//echo "<pre>";print_r($products);exit;
			if(count($products)>=1)
				{
			?>
					<select id="product<?=$row_type?>" name="product<?=$row_type?>" onchange="get_ajax_product_data(<?=$row_type?>)" title="<?=$product_type?>" size="1" style="width:155px">
						<? foreach($products as $key => $product) 
							{
								echo "<option value=".$key.">".$product."</option>";
							}
						?>						
					</select>			
			<?  }
				else
				{
			?>
					<a href="<?=base_url().index_page()?>Products_Management/create/1">Create Product</a>		
			<?
				} 
	}
	
	
	
	
	function get_ajax_category_products()
	{
		$category = trim($_POST['category_id_']);
		$row_type = $_POST['row_id'];
		$category_products = $this->product_model->getProductsByCategory($category);
		//print_r($category_products);exit;
		//echo '------'.count($category_products);
			if(count($category_products)>=1 && $category!=0)
				{
				
			?>
					<select id="product<?=$row_type?>" name="product<?=$row_type?>" onchange="get_ajax_product_data(<?=$row_type?>)" size="1" title="product_type<?=$row_type?>" style="width:155px">
								<option value="0">Select Product</option>
						<? foreach($category_products as $key => $product) 
							{
								echo "<option value=".$product['product_id'].">".$product['product']."</option>";
							}
						?>						
					</select>			
			<?  }
				else
				{
			?>
					<a href="<?=base_url().index_page()?>Products_Management/create/1">Create Product</a>		
			<?
				} 
	}
	
	
		
	function get_ajax_product_data()
	{
		$product_id = $_POST['product_id_'];
		$products = $this->product_model->getProduct($product_id);
		echo trim($products['list_price']);
		
	}
	
	function get_ajax_product_tax()
	{
		$product_id = $_POST['product_id_'];
		$products = $this->product_model->getProduct($product_id);
		echo trim($products['tax']);
		
	}
	
	function get_ajax_product_desc()
	{
		$product_id = $_POST['product_id_'];
		$products = $this->product_model->getProduct($product_id);
		echo trim($products['short_desc']);
		
	}
	
	  function create_invoice()
      { 
       
      	/*echo "<pre>";
		//echo $_POST['customer'];
		print_r($_POST);
		exit;*/
		$inovice_data['customer_type'] = $this->input->post('customer_type');
		if(isset($inovice_data['customer_type']) && trim($inovice_data['customer_type'])=='new_customer')
		{
			// Add new customer data
			$customer_data['site_id'] = $this->site_id;
			$customer_data['customer_login'] = $this->input->post('email');
			$customer_data['customer_name'] = $this->input->post('fname')." ".$this->input->post('lname');
			//$this->input->post('username');
			//$customer_data['customer_password'] = md5(mt_rand(10000000, 99999999));
			$customer_data['customer_fname'] = $this->input->post('fname');
			$customer_data['customer_lname'] = $this->input->post('lname');
			$customer_data['customer_company'] = $this->input->post('company');
			$customer_data['customer_email'] = $this->input->post('email');
			$customer_data['registered_date'] =  date('Y-m-d h-i-s');
			$customer_id = $this->Invoice_Model->addCustomer($customer_data);
			
						
			//Address book data
			if(isset($customer_id) && !empty($customer_id))
			{
				$customer_book_data['customer_id'] = $customer_id;		
			}	
			else
			{
				$customer_book_data['customer_id'] = $_POST['customer'];
				$customer_id = $_POST['customer'];		
			}
			
			$customer_book_data['address_book_fname'] = $this->input->post('fname');
			$customer_book_data['address_book_lname'] = $this->input->post('lname');
			$customer_book_data['address_book_phone'] = $this->input->post('pnumber');
			$customer_book_data['address_book_address'] = $this->input->post('saddress');
			$customer_book_data['address_book_country'] = $this->input->post('country');
			$customer_book_data['address_book_state'] = $this->input->post('state');
			$customer_book_data['address_book_city'] = $this->input->post('city');
			$customer_book_data['address_book_zipcode'] = $this->input->post('zcode');
			
			$this->Invoice_Model->address_book_data($customer_book_data);
		}
		else
		{
			// Add new customer data
			$customer_data['customer_id'] = $_POST['customer'];	
			if(isset($customer_id) && !empty($customer_id))
			{
				$customer_book_data['customer_id'] = $customer_id;		
			}	
			else
			{
				$customer_book_data['customer_id'] = $_POST['customer'];
				$customer_id = $_POST['customer'];		
			}
				
			$customer_data['site_id'] = $this->site_id;
			$customer_data['customer_login'] = $this->input->post('fname')." ".$this->input->post('lname');
			//$this->input->post('username');;
			//$customer_data['customer_password'] = md5(mt_rand(10000000, 99999999));
			$customer_data['customer_fname'] = $this->input->post('fname');
			$customer_data['customer_lname'] = $this->input->post('lname');
			$customer_data['customer_company'] = $this->input->post('company');
			$customer_data['customer_email'] = $this->input->post('email');
			$customer_result = $this->Invoice_Model->aditCustomer($customer_data);
			
			//Address book data
			$customer_book_data['customer_id'] = $customer_id;					
			$customer_book_data['address_book_phone'] = $this->input->post('pnumber');
			$customer_book_data['address_book_address'] = $this->input->post('saddress');
			$customer_book_data['address_book_country'] = $this->input->post('country');
			$customer_book_data['address_book_state'] = $this->input->post('state');
			$customer_book_data['address_book_city'] = $this->input->post('city');
			$this->Invoice_Model->adit_book_data($customer_book_data);	
			//print_r($customer_book_data);
		}
		
		$numInvoice = $this->input->post('numInvoice');
		$inovice_data['site_id'] = $this->site_id;
		$inovice_data['username'] = $this->input->post('main_username');
		$inovice_data['customer_type'] = $this->input->post('customer_type');
		$inovice_data['invoice_date'] = $this->input->post('inovice_date');
		$inovice_data['due_date'] = $this->input->post('due_date');
		$inovice_data['payment_term'] = $this->input->post('payment_ters');
		$inovice_data['subtotal'] = $this->input->post('subtotal');
		$inovice_data['total_tax'] = $this->input->post('total_tax');
		$inovice_data['total'] = round($this->input->post('total'),2);
		$inovice_data['total_discount'] = $this->input->post('total_discount');
		
		$inovice_data['net_total'] = $this->input->post('net_total');
		$inovice_data['partial_payment'] = $this->input->post('partial_payment');
		$inovice_data['recurring'] = $this->input->post('recurring');
    
		$inovice_data['terms_conditions'] = $this->input->post('termsconditions');
		$inovice_data['invoice_notes'] = $this->input->post('invoicenotes');
		
		$inovice_data['draft'] = $this->input->post('draft');
		$inovice_data['quote'] = $this->input->post('quote');
		$inovice_data['status'] = $this->input->post('status');
		if($inovice_data['status']=='yes')
		{
			$inovice_data['status'] = 'Paid';
		}
		else
		{
			$inovice_data['status'] = 'Due';
		}
		if(isset($_POST['customer']) && !empty($_POST['customer']))
		{
			$inovice_data['customer_id'] = $_POST['customer'];
		}
		else
		{
			$inovice_data['customer_id'] = $customer_id;
		}
		//echo $customer_id.''.$_POST['customer'];
		//echo $inovice_data['customer_id'];exit;
		//Recurring data save
		$recuring = $this->input->post('recuring');
		if(isset($recuring) && $recuring=='yes')
		{
			$inovice_data['recurring'] = $this->input->post('recuring');
			$inovice_data['recurring_username'] = $this->input->post('recurring_username');
			$inovice_data['recurring_order_number'] = $this->input->post('recurring_order_number');
			$inovice_data['recurring_occurrences'] = $this->input->post('recurring_occurrences');
			if($inovice_data['recurring_occurrences'] == 'bi-month')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '15');
			}
			else if($inovice_data['recurring_occurrences'] == 'weekly')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '7');
			}
			else if($inovice_data['recurring_occurrences'] == 'monthly')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '30');
			}
			
			$inovice_data['recurring_start_date'] = $this->input->post('recurring_start_date');
			$inovice_data['recurring_end_date'] = $this->input->post('recurring_end_date');
			$inovice_data['rec_end_date_type'] = $this->input->post('rec_end_date_type');
			$inovice_data['recurring_biller_email'] = $this->input->post('recurring_biller_email');
			$inovice_data['recurring_customer_email'] = $this->input->post('recurring_customer_email');
		}
		
		//save slideshow info
		$invoice_id = $this->Invoice_Model->save_invoice_info($inovice_data);
		
		
		//save each invoice  info
		for($i=1; $i<= intval($numInvoice); $i++)
		{
		   $product_id = $_POST['product'.$i];
		   $description = $_POST['description'.$i];
		   $unit_cost = trim($_POST['ucost'.$i]);
		   $discount = $_POST['discount'.$i];		   
		   $quantity = $_POST['quantity'.$i];
		   $taxone = $_POST['taxone'.$i];
		   $taxtwo = $_POST['taxtwo'.$i];
		   $price = $_POST['price'.$i];
		   $product_type = $_POST['product_type'.$i];
		   $this->Invoice_Model->save_each_invoice_product_info($invoice_id, $product_id, $description, $unit_cost, $quantity, $discount, $taxone, $taxtwo, $price,  $product_type);
		}
		 redirect('/invoice/invoice_managment_view/');
	}     
	
	// Delete Invoice
	function delete_invoice($invoice_id)
	{
		$this->Invoice_Model->delete_invoice($invoice_id);
		 redirect('/invoice/invoice_managment_view/');
	}
	
	// Invoice View
	function create_view_invoice($invoice_id)
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Invoice Management', $this->session->userdata("invoice_link") ); 
		$this->breadcrumb->add_crumb('View');
		
		$invoice_data['invoice_info'] = $this->Invoice_Model->get_invoice($invoice_id);
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		
		$invoice_data['admin_details'] = $this->UsersModel->get_user_details_by_user_id($_SESSION['current_site_info']['user_id']);
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
		}		
		/*echo "<pre>";
		print_r($invoice_data);
		exit;*/
		$this->template->write_view('content','ecommerce/invoice_view',$invoice_data);
		$this->template->render();
	}
	
	// PDF View
	function create_pdf_invoice($site_id, $invoice_id)
	{
		prep_pdf(); // creates the footer for the document we are creating.
		$invoice_data['invoice_info'] = $this->Invoice_Model->get_invoice($invoice_id);
		$store_logo = $this->shop_model->get_store_settings($site_id);
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($customer_id);
		$user_data = $this->UsersModel->get_user_details_by_user_id($_SESSION['user_info']['user_id']);
		//echo "<pre>";print_r($user_data);exit;
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
		}	
		if($store_logo['publish'] =='Yes' && !empty($store_logo['store_logo']))
		{
			$image_name_array = explode('.',$store_logo['store_logo']);
			$thumbnail_name = $image_name_array[0]."_thumb.".$image_name_array[1];
			$upload_path  = realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/logo/'.$thumbnail_name; 
		}
		
		
		//Invoice detail
		if(isset($invoice_data['invoice_info'][0]['quote']) && $invoice_data['invoice_info'][0]['quote'] == 'yes')
		{ 
			$type = "Quote";
		}
		else
		{ 
			$type = "Invoice";
		}
		$all_products_html = '';
		$sub_tax = 0;
		$total_price = 0;
		 for($i = 0; $i<$invoice_data['count']; $i++)
		  {
			$all_products_html .='<tr align="center">
				<td>'.$invoice_data['product_detail'][$i]['product'].'</td>
				<td>'.$invoice_data['invoice_info'][$i]['description'].'</td>
				<td>$'.number_format($invoice_data['product_detail'][$i]['list_price'],2,'.','').'</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['quantity'],2,'.','').'</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['discount'],2,'.','').'%</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['taxone'],2,'.','').'%</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['taxtwo'],2,'.','').'%</td>
				<td>$'.number_format($invoice_data['invoice_info'][$i]['price'],2,'.','').'</td>
		  		</tr>';
				
				$total_tax = $invoice_data['invoice_info'][$i]['taxone'] + $invoice_data['invoice_info'][$i]['taxtwo'];
				$tax1      = $invoice_data['invoice_info'][$i]['taxone'] * (0.01) * $invoice_data['invoice_info'][$i]['price'];
				$tax2      = $invoice_data['invoice_info'][$i]['taxtwo'] * (0.01) * $invoice_data['invoice_info'][$i]['price'];
				$tax = $tax1 + $tax2;
				$sub_tax = $sub_tax + $tax; 
				$total_price += $invoice_data['invoice_info'][$i]['price'];
				
		  }
		
		 $this->mpdf->SetHeader('{DATE d-m-Y}|{PAGENO}|Customer Invoice');
		
		$html_output = '<table width="100%" border="0" >
							 <tr>
								<td colspan="2">
									<table width="100%">
										<tr>
											<td align="left" width="60%"><img  style="vertical-align:top; width:100px; height:100; margin-right:200px;  float:left;" src="'.$upload_path.'" /></td>
											<td><h1 >Invoice View</h1></td>
										</tr>
									</table>
								</td>
    						</tr>
            				<tr>
								<td>
									<table width="350" border="1">
										<tr>
											<td colspan="2"><b>Biller Detail</b></td>  
										</tr>
										<tr>
											<td>Name</td><td>'.$user_data[0]['user_fname'].' '.$user_data[0]['user_lname'].'</td>  
										</tr>
										<tr>
											<td>Company</td><td>'.$invoice_data[0]['company'].'</td>  
										</tr>
										<tr>
											<td>Address</td><td>'.$user_data[0]['street_address'].' ,'.$user_data[0]['city'].' '.$user_data[0]['country'].' ,'.$user_data[0]['state'].'<br>'.$user_data[0]['pnumber'].'</td>  
										</tr>
										<tr>
											<td>Create Date</td><td>'.$invoice_data['invoice_info'][0]['invoice_date'].'</td>  
										</tr>
										<tr>
											<td>Due Date </td><td>'.$invoice_data['invoice_info'][0]['due_date'].'</td>  
										</tr>
										
									</table>	
								</td>
								<td align="right">
									<table  width="300" border="1" style="border:1px solid #666666;">
										<tr>
											<td colspan="2"><b>Customer Detail</b></td>  
										</tr>				
										<tr>
											<td colspan="2">Bill To: </td>  
										</tr>				
										<tr>
											<td>Name </td><td>'.$invoice_data['customer_detail']['customer_fname'].'</td>
										</tr>
										<tr>
											<td>Company</td><td>'.$invoice_data['customer_detail']['customer_company'].'</td>  
										</tr>
										<tr>
											<td>Address</td><td>'.$user_data[0]['street_address'].' ,'.$user_data[0]['city'].' '.$user_data[0]['country'].' ,'.$user_data[0]['state'].'<br>'.$user_data[0]['pnumber'].'</td>  
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-top:25px;"   colspan="2">
									<table  width="100%" cellspacing="1" cellpadding="20" border="0">
										  <tr style="background-color:#CCCCCC;" >
											<th scope="col"><h6>Product/Service</h6></th>
											<th scope="col"><h6>Description</h6></th>
											<th scope="col"><h6>Unit&nbsp;Cost</h6></th>
											<th scope="col"><h6>Quantity</h6></th>
											<th scope="col"><h6>Discount</h6></th>
											<th scope="col"><h6>Tax&nbsp;1</h6></th>
											<th scope="col"><h6>Tax&nbsp;2</h6></th>
											<th scope="col"><h6>Price</h6></th>
										  </tr>'.$all_products_html.'
									</table>
								</td>	
							</tr>
							<tr>
								<td style="padding-top:20px; padding-right:10px;" colspan="2">
									<table align="right"> 
									  <tr>
										<td ><label>Subtotal: </label></td>
										<td ><div id="subtotal">$'.number_format($total_price,2,'.','').'</div></td>
									  </tr>
									  <tr>
										<td  style="font-weight:bold;"><label>Net Total: </label></td>
										<td  style="font-weight:bold;"><div id="total">$'.number_format($total_price,2,'.','').'</div></td>
									  </tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="left" >
									<strong>Terms & Conditions</strong>
									<br>
									'.$invoice_data['invoice_info'][0]['terms_conditions'].'
									<br>
								</td>			
							</tr>
							<tr>
								<td align="left" >
									<br>		
									<strong>Invoice Notes</strong>
									<br>
									'.$invoice_data['invoice_info'][0]['invoice_notes'].'
								</td>
							</tr>
					</table>' ;
		//echo $html_output;exit;
		$this->mpdf->WriteHTML($html_output);
		$this->mpdf->Output();
		exit;
	} 
	
	//Invoice Edit View
	function edit_invoice($invoice_id)
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Invoice Management', $this->session->userdata("invoice_link") ); 
		$this->breadcrumb->add_crumb('Edit');
		
		$invoice_data['invoice_info'] = $this->Invoice_Model->get_invoice($invoice_id);
		/*echo "<pre>";
		echo $invoice_data['invoice_info'][0]['customer_type'];
		print_r($invoice_data['invoice_info']);
		exit;*/
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($this->site_id, $customer_id);
		$invoice_data['countries'] = $this->Invoice_Model->get_country();
		$invoice_data['states'] = $this->Invoice_Model->get_states();
		$invoice_data['products'] = $this->product_model->getProductsDropdown($this->site_id);
		$invoice_data['categories'] = $this->categories_model->getAllCategories($this->site_id);
		/*echo "<pre>";
		echo $customer_id;
		print_r($invoice_data);
		exit;*/
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
			
		}		
		
		$this->template->write_view('content','ecommerce/invoice_edit',$invoice_data);
		$this->template->render();
	}
	
	//Save After Edit Invoice
	function edit_invoice_data()
	{
		//echo $_POST['customers'][0];
      	/*echo "<pre>";
		print_r($_POST);
		exit();*/
		$inovice_data['customer_type'] = $this->input->post('customer_type');
		$numInvoice = $this->input->post('numInvoice');
		if(isset($_POST['customers'][0]) && !empty($_POST['customers'][0]))
		{
			$customer_id = $_POST['customers'][0];
		}
		else
		{
			$customer_id = $this->input->post('hidden_customer');			
		}
		if(isset($inovice_data['customer_type']) && $inovice_data['customer_type']=='new_customer')
		{
			// Add new customer data
			$customer_data['site_id'] = $this->site_id;
			$customer_data['customer_login'] = $this->input->post('fname')." ".$this->input->post('lname');
			//$this->input->post('username');;
			$customer_data['customer_password'] = md5(mt_rand(10000000, 99999999));
			$customer_data['customer_fname'] = $this->input->post('fname');
			$customer_data['customer_lname'] = $this->input->post('lname');
			$customer_data['customer_company'] = $this->input->post('company');
			$customer_data['customer_email'] = $this->input->post('email');
			$customer_data['customer_id'] = $customer_id;
			$customer_result = $this->Invoice_Model->aditCustomer($customer_data);
			
			//Address book data
			$customer_book_data['customer_id'] = $customer_id;		
			$customer_book_data['address_book_phone'] = $this->input->post('pnumber');
			$customer_book_data['address_book_address'] = $this->input->post('saddress');
			$customer_book_data['address_book_country'] = $this->input->post('country');
			$customer_book_data['address_book_state'] = $this->input->post('state');
			$customer_book_data['address_book_city'] = $this->input->post('city');
			$this->Invoice_Model->adit_book_data($customer_book_data);
		}
		else
		{
			// Add new customer data
			$customer_data['customer_id'] = $customer_id;		
			$customer_data['site_id'] = $this->site_id;
			$customer_data['customer_login'] = $this->input->post('fname')." ".$this->input->post('lname');
			//$this->input->post('username');;
			//$customer_data['customer_password'] = md5(mt_rand(10000000, 99999999));
			$customer_data['customer_fname'] = $this->input->post('fname');
			$customer_data['customer_lname'] = $this->input->post('lname');
			$customer_data['customer_company'] = $this->input->post('company');
			$customer_data['customer_email'] = $this->input->post('email');
			$customer_result = $this->Invoice_Model->aditCustomer($customer_data);
			
			//Address book data
			$customer_book_data['customer_id'] = $customer_id;					
			$customer_book_data['address_book_phone'] = $this->input->post('pnumber');
			$customer_book_data['address_book_address'] = $this->input->post('saddress');
			$customer_book_data['address_book_country'] = $this->input->post('country');
			$customer_book_data['address_book_state'] = $this->input->post('state');
			$customer_book_data['address_book_city'] = $this->input->post('city');
			$this->Invoice_Model->adit_book_data($customer_book_data);	
		}
		
		
		$inovice_data['site_id'] = $this->site_id;
		$inovice_data['username'] = $this->input->post('main_username');
		$inovice_data['customer_type'] = $this->input->post('customer_type');
		$inovice_data['invoice_date'] = $this->input->post('inovice_date');
		$inovice_data['due_date'] = $this->input->post('due_date');
		$inovice_data['payment_term'] = $this->input->post('payment_ters');
		$inovice_data['subtotal'] = $this->input->post('hidden_subtotal');
		$inovice_data['total_tax'] = $this->input->post('total_tax');
		$inovice_data['total_discount'] = $this->input->post('total_discount');
    	$inovice_data['total'] = round($this->input->post('total'),2);
		
		$inovice_data['net_total'] = $this->input->post('net_total');
		$inovice_data['partial_payment'] = $this->input->post('partial_payment');
		$inovice_data['recurring'] = $this->input->post('recurring');
    
		$inovice_data['terms_conditions'] = $this->input->post('termsconditions');
		$inovice_data['invoice_notes'] = $this->input->post('invoicenotes');
		
		$inovice_data['draft'] = $this->input->post('draft');
		$inovice_data['quote'] = $this->input->post('quote');
		$inovice_data['status'] = $this->input->post('status');
		if($inovice_data['status']=='yes')
		{
			$inovice_data['status'] = 'Paid';
		}
		else
		{
			$inovice_data['status'] = 'Due';
		}
		
		$inovice_data['invoice_id'] = $this->input->post('invoice_id');
		
		//Recurring data save
		$recuring = $this->input->post('recuring');
		if(isset($recuring) && $recuring=='yes')
		{
			$inovice_data['recurring'] = $this->input->post('recuring');
			$inovice_data['recurring_username'] = $this->input->post('recurring_username');
			$inovice_data['recurring_order_number'] = $this->input->post('recurring_order_number');
			$inovice_data['recurring_occurrences'] = $this->input->post('recurring_occurrences');
			if($inovice_data['recurring_occurrences'] == 'bi-month')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '15');
			}
			else if($inovice_data['recurring_occurrences'] == 'weekly')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '7');
			}
			else if($inovice_data['recurring_occurrences'] == 'monthly')
			{
				$inovice_data['inc_invoice_date'] = add_days_to_date(date("m/d/Y"), '30');
			}
			$inovice_data['recurring_start_date'] = $this->input->post('recurring_start_date');
			$inovice_data['recurring_end_date'] = $this->input->post('recurring_end_date');
			$inovice_data['rec_end_date_type'] = $this->input->post('rec_end_date_type');
			$inovice_data['recurring_biller_email'] = $this->input->post('recurring_biller_email');
			$inovice_data['recurring_customer_email'] = $this->input->post('recurring_customer_email');
		}
		
		if(isset($_POST['customers'][0]) && !empty($_POST['customers'][0]))
		{
			$inovice_data['customer_id'] = $_POST['customers'][0];
		}
		else
		{
			$inovice_data['customer_id'] = $customer_id;
		}
		
		//save slideshow info
		$invoice_id = $this->Invoice_Model->edit_invoice_info($inovice_data);
		
		//save each invoice  info
	
		for($i=1; $i<= intval($numInvoice); $i++)
		{
		   $product_data['product_id'] = $_POST['product'.$i];
		   $product_data['description'] = $_POST['description'.$i];
		   $product_data['unit_cost'] = $_POST['ucost'.$i];
		   $product_data['discount'] = $_POST['discount'.$i];		   
		   $product_data['quantity'] = $_POST['quantity'.$i];
		   $product_data['taxone'] = $_POST['taxone'.$i];
		   $product_data['taxtwo'] = $_POST['taxtwo'.$i];
		   $product_data['price'] = $_POST['price'.$i];
		   $product_data['product_type'] = $_POST['product_type'.$i];
		   $product_data['invoice_id'] = $this->input->post('invoice_id');
		   $this->Invoice_Model->edit_each_invoice_product_info($product_data);
		}
		 redirect('/invoice/invoice_managment_view/');
	}
	
	function customer_new_invoice($invoice_id, $customer_id)
	{
		
		if(isset($_SESSION['user_info']['user_login']))
		{
			$invoice_data['user_name'] = $_SESSION['user_info']['user_login'];        
			
			//echo "<pre>";print_r($data['categories']);
		}
		else
		{
			redirect('/UsersController/login/sitelogin');
		}
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($this->site_id, $customer_id);
		$invoice_data['countries'] = $this->Invoice_Model->get_country();
		$invoice_data['states'] = $this->Invoice_Model->get_states();
		$invoice_data['products'] = $this->product_model->getProductsDropdown($this->site_id);
		$invoice_data['categories'] = $this->categories_model->getAllCategories($this->site_id);
		/*echo "<pre>";
		echo $customer_id;
		print_r($invoice_data);
		exit;*/
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		
		
		
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
			
		}		
		$this->template->write_view('content','ecommerce/customer_new_invoice',$invoice_data);
		$this->template->render();
	
	}
	
	function create_email_invoice($invoice_id)
	{
		$email_html ='';
		$invoice_data = $this->Invoice_Model->get_invoice($invoice_id);
		$customer_id = $invoice_data[0]['customer_id'];
		$customer_data = $this->customers_model->getCustomer($customer_id);
		$address_data = $this->customers_model->getAllAddress($customer_id);
		$invoice_count = count($invoice_data);		
		
		for($i = 0; $i<$invoice_count; $i++)
		{
			$products_data[] = $this->product_model->getProduct($invoice_data[$i]['product_id']);
		}
		
		/*echo "<pre>";
		print_r($invoice_data);
		exit;*/
		$type = '';
		if($invoice_data[0]['quote']=='yes')
		{ 
			$type .='Quote';
		}
		else
		{ 
			$type .='Invoice';
		}
		
		$email_html .= "<h1>Invoice Details</h1><table width='100%' border='0'><tr><td><table width='200' style='border:1px solid #666666;'><tr><td>Invoice ID </td><td>".$invoice_data[0]['invoice_id']."</td></tr><tr><td>Username</td><td>".$invoice_data[0]['username']."</td></tr><tr><td>Invoice Date</td><td>".$invoice_data[0]['invoice_date']."</td></tr><tr><td>Due Date </td><td>".$invoice_data[0]['due_date']."</td></tr><tr><tr><td>Type</td><td>".$type;
		
		
		$email_html .="</td></tr><tr></table></td><td align='right'><table  width='200' style='border:1px solid #666666;'><tr><td colspan='2'><b>Customer Detail</b></td></tr><tr><td colspan='2'>Bill To: </td></tr><tr><td>Name </td><td>".$customer_data['customer_fname'].' '.$customer_data['customer_lname']."</td></tr><tr><td>Company</td><td>".$customer_data['customer_company']."</td></tr><tr><td>Email</td><td>".$customer_data['customer_email']."</td></tr></table></td></tr><tr><td style='padding-top:25px;' colspan='2'><table  id='invoice_table' width='100%' border='0'><tr><th scope='col'>Product/Service</th><th scope='col'>Description</th><th scope='col'>Unit Cost</th><th scope='col'>Quantity</th><th scope='col'>Discount</th><th scope='col'>Tax 1</th><th scope='col'>Tax 2</th><th scope='col'>Price</th></tr>";
			
		  for($i = 0; $i<$invoice_count; $i++)
		  {
			 
			$email_html .= "<tr align='center'><td>";
			if(isset($products_data[$i]['product']))
			{ 
				$email_html.= $products_data[$i]['product']; 
			
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['description']))
			{ 
				$email_html.= $invoice_data[$i]['description'];
			} 
			$email_html .="</td><td>";
			
			if(isset($products_data[$i]['list_price']))
			{ 
				$email_html .= '$'.$products_data[$i]['list_price'];
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['quantity']))
			{ 
				$email_html .=$invoice_data[$i]['quantity'];
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['discount']))
			{ 
				$email_html .= '$'.$invoice_data[$i]['discount'].'%';
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['taxone']))
			{ 
				$email_html .= '$'.$invoice_data[$i]['taxone'].'%'; 
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['taxtwo']))
			{ 
				$email_html .= '$'.$invoice_data[$i]['taxtwo'].'%';
			}
			$email_html .="</td><td>";
			
			if(isset($invoice_data[$i]['price']))
			{ 
				$email_html .= '$'.$invoice_data[$i]['price'];
			} 
			$email_html .="</td></tr>";
		  }
		  
		$email_html .="</table></td></tr><tr><td style='padding-top:20px; padding-right:10px;' colspan='2'><table align='right'><tr><td ><label>Subtotal: </label></td><td ><div id='subtotal'>$".$invoice_data[0]['subtotal']."</div></td></tr><tr><td  style='font-weight:bold;'><label>Net Total: </label></td><td  style='font-weight:bold;'><div id='total'>$".$invoice_data[0]['total']."</div></td></tr></table></td></tr><tr><td align='left' ><strong>Terms & Conditions</strong><br>".$invoice_data[0]['terms_conditions']."<br></td></tr><tr><td align='left' ><br><strong>Invoice Notes</strong><br>".$invoice_data[0]['invoice_notes']."</td></tr></table>";
		
		$this->load->library('email');	
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		//$send = $this->email->send();
		$this->email->from("no-reply@webpowerup.ca", "Webpowerup");
		$this->email->subject("Invoice");
		$this->email->message($email_html);
		$this->email->to($customer_data['customer_email']);
		$send = $this->email->send();
		//echo $email_html;
		redirect('/invoice/invoice_managment_view/');
	}	
	

}
?>