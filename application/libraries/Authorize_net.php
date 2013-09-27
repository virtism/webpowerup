<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
/**
 * Authorize.NET AIM processing class for CodeIgniter
 *
 * A class to simplify the processing of payments using Autorize.NET AIM.
 * This does not do everything but is a good start to processing payments
 * using CodeIgniter.
 *
 * Based off a class by: Micah Carrick
 * Website:	http://www.micahcarrick.com
 * 
 * @package		Authorize.NET
 * @author		Ray (Ideal Web Solutions)
 * @email		dev@idealws.net
 * @copyright	Copyright (c) 2009, Ideal Web Solutions, LLC.
 * @link		http://idealws.com
 * @since		Version 1.0
 * @filesource
 */
class Authorize_net {
	
	var $field_string;
	var $fields = array();	
	var $response_string;
	var $response = array();
	var $debuginfo;
	var $gateway_url = "https://secure.authorize.net/gateway/transact.dll";
   
	/**
	 * Constructor
	 *
	 * Loads the configuration settings for Authorize.NET
	 *
	 * @access	public
	 */
	function Authorize_net() {
		$this->CI =& get_instance();		

		if($this->CI->config->item('authorize_net_test_mode') == 'TRUE') {			
			$this->gateway_url = $this->CI->config->item('authorize_net_test_api_host');
			$this->add_x_field('x_test_request', $this->CI->config->item('authorize_net_test_mode'));
			$this->add_x_field('x_login', $this->CI->config->item('authorize_net_test_x_login'));
			$this->add_x_field('x_tran_key', $this->CI->config->item('authorize_net_test_x_tran_key'));
		}else{
			$this->gateway_url = $this->CI->config->item('authorize_net_live_api_host');
			$this->add_x_field('x_test_request', $this->CI->config->item('authorize_net_test_mode'));
			$this->add_x_field('x_login', $this->CI->config->item('authorize_net_live_x_login'));
			$this->add_x_field('x_tran_key', $this->CI->config->item('authorize_net_live_x_tran_key'));
		}
		$this->add_x_field('x_version', $this->CI->config->item('authorize_net_x_version'));
      	$this->add_x_field('x_delim_data', $this->CI->config->item('authorize_net_x_delim_data'));
      	$this->add_x_field('x_delim_char', $this->CI->config->item('authorize_net_x_delim_char'));  
      	$this->add_x_field('x_encap_char', $this->CI->config->item('authorize_net_x_encap_char')); 
      	$this->add_x_field('x_url', $this->CI->config->item('authorize_net_x_url'));
      	$this->add_x_field('x_type', $this->CI->config->item('authorize_net_x_type'));
      	$this->add_x_field('x_method', $this->CI->config->item('authorize_net_x_method'));
      	$this->add_x_field('x_relay_response', $this->CI->config->item('authorize_net_x_relay_response'));	
	}
	
	/**
	 * Add field to query for processing
	 * 
	 * Used to add a field to send to Autorize.NET for payment processing.
	 * 
	 * @param mixed $field
	 * @param mixed $value
	 * @access	public
	 */
	function add_x_field($field, $value) {
      $this->fields[$field] = $value;   
    }

   /**
    * Process payment
    * 
    * Send the payment to Authorize.NET for processing. Returns the response codes
    * 1 - Approved
    * 2 - Declined
    * 3 - Transaction Error
    * There is no need to check the MD5 Hash according to Authorize.NET documentation
	* since the process is being sent and received using SSL. 
    * 
    * @access	public
    * @return	returns response code 1,2,3
    */
   function process_payment() {
   
 //  echo "<pre>";
  // print_r($this->fields);
   //exit;
		foreach( $this->fields as $key => $value ) {
			$this->field_string .= "$key=" . urlencode( $value ) . "&";
		}
		$ch = curl_init($this->gateway_url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $this->field_string, "& " )); 
		$this->response_string = urldecode(curl_exec($ch)); 
		
		if (curl_errno($ch)) {
			$this->response['Response_Reason_Text'] = curl_error($ch);
			return 3;
		}else{
			curl_close ($ch);
		}
		$temp_values = explode($this->CI->config->item('authorize_net_x_delim_char'), $this->response_string);
		$temp_keys= array ( 
			"Response_Code", "Response_Subcode", "Response_Reason_Code", "Response_Reason_Text",
			"Approval_Code", "AVS_Result_Code", "Transaction_ID", "Invoice_Number", "Description",
			"Amount", "Method", "Transaction_Type", "Customer_ID", "Cardholder_First_Name",
			"Cardholder Last_Name", "Company", "Billing_Address", "City", "State",
			"Zip", "Country", "Phone", "Fax", "Email", "Ship_to_First_Name", "Ship_to_Last_Name",
			"Ship_to_Company", "Ship_to_Address", "Ship_to_City", "Ship_to_State",
			"Ship_to_Zip", "Ship_to_Country", "Tax_Amount", "Duty_Amount", "Freight_Amount",
			"Tax_Exempt_Flag", "PO_Number", "MD5_Hash", "Card_Code_CVV_Response Code",
			"Cardholder_Authentication_Verification_Value_CAVV_Response_Code"
		);
		for ($i=0; $i<=27; $i++) {
			array_push($temp_keys, 'Reserved_Field '.$i);
		}
		$i=0;
		while (sizeof($temp_keys) < sizeof($temp_values)) {
			array_push($temp_keys, 'Merchant_Defined_Field '.$i);
			$i++;
		}
		for ($i=0; $i<sizeof($temp_values);$i++) {
			$this->response["$temp_keys[$i]"] = $temp_values[$i];
		}
		return $this->response['Response_Code'];
   }
   
   /**
    * Get the response text.
    * 
    * Returns the response reason text for the payment processed. Must be called
    * after you have caled process_payment().
    * 
    * @access	public
    * @return	returns the response reason text
    */
   function get_response_reason_text() {
		return $this->response['Response_Reason_Text'];
   }
   
	/**
	 * Get all the codes returned
	 * 
	 * With this function you can retreive all response codes and values
	 * from your transaction. This must be called after your have called 
	 * the process_payment() function.
	 * 
	 * @access	public
	 * @return returns all codes and values in a array.
	 */
	function get_all_response_codes() {
		return $this->response;
	}

   /**
    * Dump fields sent to Authorize.NET
    * 
    * This is used for de bugging purposes. It will output the
    * field/value pairs sent to Authorize.NET to process the 
    * payment. Must be called after the process_payment() function
    * 
    * @access	public
    * @return	prints output directly to browser.
    */
   function dump_fields() {				
		echo "<h3>authorizenet_class->dump_fields() Output:</h3>";
		echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
		    <tr>
		       <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
		       <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
		    </tr>"; 
		    
		foreach ($this->fields as $key => $value) {
		 echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
		}
		
		echo "</table><br>"; 
   }

   /**
    * Dump response from Authorize.NET
    * 
    * This will return the complete output sent from Authorize.NET
    * after payment has been processed. Whether approved, declined 
    * or transaction error. Must be called after the process_payment()
    * function.
    * 
    * @access	public
    * @return	returns all the field/value pairs
    */
   function dump_response() {             
      $i = 0;
      foreach ($this->response as $key => $value) {
         $this->debuginfo .= "$key: $value\n";
         $i++;
      } 
      return $this->debuginfo;
   }
   
   function cc_feilds()
   {
   		$output  = '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
		$output .= '<tr>';
		$output .=     '<td width="19%" nowrap="nowrap">Card Holder Name<font color="#FF0000">*</font></td>';
		$output .=		'<td width="81%">';
		$output .=			'<input size="30" type="text" class="txt-field" id="card_holder" name="card_holder" maxlength="50" value="" style="width:180px;" /></td>';
		$output .=	'</tr>';
		$output .=	'<tr >';
		$output .=	'<td  nowrap="nowrap">Card Type<font color="#FF0000">*</font> </td>';
		$output .= 	'<td >';
		$output .=  '<select style="opacity:1;" name="card_type" id="card_type" onchange="load_CC_Mask(this.value)" >';
		$output .=				'<option value="Amex">American Express</option>';
		$output .=				'<option value="Visa">Visa</option>';
		$output .=				'<option value="MasterCard">Master Card</option>';
		$output .=				'<option value="Discover">Discover</option>';
		$output .=	'</select>';
		$output .=	'</td>';
		$output .= '</tr>
		<tr>
			<td nowrap="nowrap">Card No<font color="#FF0000">*</font> </td>
			<td>
				<input type="text" class="txt-field" name="credit_card" id="credit_card" maxlength="255" size="30" style="width:180px;" /></td>
		</tr>
		<tr >
			<td nowrap="nowrap">Security Code<font color="#FF0000">*</font> </td>
			<td>
				<input style="width:31%;" onkeyup="loadMask();" name="security_code" id="security_code" maxlength="4">
			</td>
		</tr>
		<tr >
<td class="col-1" nowrap="nowrap">Validity<font color="#FF0000">*</font> </td>
<td class="col-2">
<select style="opacity:1;" name="month" id="month">
<option value=""> Month </option>
<option value="01"> Jan </option>
<option value="02"> Feb </option>
<option value="03"> Mar </option>
<option value="04"> Apr </option>
<option value="05"> May </option>
<option value="06"> Jun </option>
<option value="07"> Jul </option>
<option value="08"> Aug </option>
<option value="09"> Sep </option>
<option value="10"> Oct </option>
<option value="11"> Nov </option>
<option value="12"> Dec </option>
</select>
<select style="opacity:1;" name="year" id="year">
<option value=""> Year </option>
<option value="2012"> 2012 </option>
<option value="2013"> 2013 </option>
<option value="2014"> 2014 </option>
<option value="2015"> 2015 </option>
<option value="2016"> 2016 </option>
<option value="2017"> 2017 </option>
<option value="2018"> 2018 </option>
<option value="2019"> 2019 </option>
<option value="2020"> 2020 </option>
<option value="2021"> 2021 </option>
<option value="2022"> 2022 </option>
</select>
</td>
</tr>
	</table>';
	
	return $output;			
   }
}
?>