<script type="text/javascript">
/*$.validator.setDefaults({
    submitHandler: function() { alert("submitted!"); }
});  */

$().ready(function() {
    // validate the comment form when it is submitted
    $("#addressbook").validate();
    
    // validate signup form on keyup and submit
    $("#addressbook").validate({
        rules: {
            firstname: "required",
            lastname: "required",
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
        }
    });
    
    // propose username by combining first- and lastname
    $("#username").focus(function() {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        if(firstname && lastname && !this.value) {
            this.value = firstname + "." + lastname;
        }
    });
    
    //code to hide topic selection, disable for demo
    var newsletter = $("#newsletter");
    // newsletter topics are optional, hide at first
    var inital = newsletter.is(":checked");
    var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
    var topicInputs = topics.find("input").attr("disabled", !inital);
    // show when newsletter is checked
    newsletter.click(function() {
        topics[this.checked ? "removeClass" : "addClass"]("gray");
        topicInputs.attr("disabled", !this.checked);
    });
});
</script>

<style type="text/css">
/*#registerform { width: 500px; }
#registerform label { width: 250px; }  */
#addressbook label.error, #commentForm input.submit { margin-left: 0px; color:red; }
#signupForm { width: 670px; }
#signupForm label.error {
    margin-left: 10px;
    width: auto;
    display: inline;
}
#newsletter_topics label.error {
    display: none;
    margin-left: 103px;
}
</style>

<h2><?php echo $title;?></h2>  
<!-- Address Book -->
<?php
 
    $attributes = array('class' => 'contact', 'id' => 'addressbook' ,  'name' => 'addressbook',  'onsubmit'=>'javascript: return checkRegFormFields(this);' );
    echo form_open(base_url().'index.php/MyAccount/AddressBook_new',$attributes);
    echo form_hidden('action','address_book_add');
   // echo form_hidden('customer_id',$customer_id);
    //echo form_hidden('step',$step);
   // echo form_hidden('tag_tab',$tag_tab);
    
    $f_name = array('name'=>'f_name','id'=>'f_name','size'=>'32' , 'maxlength' => '32', 'class'=>'required' , 'value' => set_value('f_name','')); 
    $last_name = array('name'=>'last_name','id'=>'last_name','size'=>'32' , 'maxlength' => '32' , 'class'=>'required' , 'value' => set_value('last_name',''));
     
    $address = array('name'=>'address','id'=>'address', 'rows'=>'3' , 'cols'=>'25' , 'class'=>'required' ,'value' => set_value('address',''));
    $city = array('name' => 'city', 'id' => 'city','size'=>'32' , 'maxlength' => '64' ,'class'=>'required' , 'value' => set_value('city',''));  
    $state = array('name' => 'state', 'id' => 'state','size'=>'32' , 'maxlength' => '64' ,'class'=>'required' , 'value' => set_value('state',''));  
    $post_code = array('name' => 'post_code', 'id' => 'post_code', 'size'=>'32' , 'maxlength' => '32' ,'class'=>'required' , 'value' => set_value('post_code',''));    
    $phone = array('name' => 'phone', 'id' => 'phone', 'size'=>'32' , 'maxlength' => '32' , 'value' => set_value('phone',''));    
    $fax = array('name' => 'fax', 'id' => 'fax', 'size'=>'32' , 'maxlength' => '32' , 'value' => set_value('fax',''));    
?>    
  
  <table width="100%" cellspacing="1" cellpadding="3" summary="Address book">
    <tbody>
      <tr>
          <td class="data-name" width="10%"><label for="firstname">First name</label></td>
          <td class="data-required" width="2%">*</td>
          <td>
             <?php echo form_input($f_name) ?> 
          </td>
        </tr>
  
      <tr>
          <td class="data-name"><label for="lastname">Last name</label></td>
          <td class="data-required">*</td>
          <td>
              <?php echo form_input($last_name) ?> 
          </td>
    </tr>
  
      <tr>
          <td class="data-name"><label for="address">Address</label></td>
          <td class="data-required">*</td>
          <td>
              <?php echo form_textarea($address) ?>
          </td>
    </tr>
      <tr>
          <td class="data-name"><label for="city">City</label></td>
          <td class="data-required">*</td>
          <td>
            <?php echo form_input($city) ?>
          </td>
    </tr>
  
  
      <tr>
          <td class="data-name"><label for="state">State</label></td>
          <td class="data-required">*</td>
          <td>
            <?php echo form_input($state) ?> 
            
          </td>
    </tr>
  
      <tr>
          <td class="data-name"><label for="country">Country</label></td>
          <td class="data-required">*</td>
          <td>
            <select onchange="check_zip_code_field(this, $('#zipcode').get(0))" id="country" name="country" class="required" style="width: 219px;">
                          <option value="AF">Afghanistan</option>
                          <option value="AX">Aland Islands</option>
                          <option value="AL">Albania</option>
                          <option value="DZ">Algeria</option>
                          <option value="AS">American Samoa</option>
                          <option value="AD">Andorra</option>
                          <option value="AO">Angola</option>
                          <option value="AI">Anguilla</option>
                          <option value="AQ">Antarctica</option>
                          <option value="AG">Antigua and Barbuda</option>
                          <option value="AR">Argentina</option>
                          <option value="AM">Armenia</option>
                          <option value="AW">Aruba</option>
                          <option value="AU">Australia</option>
                          <option value="AT">Austria</option>
                          <option value="AZ">Azerbaijan</option>
                          <option value="BS">Bahamas</option>
                          <option value="BH">Bahrain</option>
                          <option value="BD">Bangladesh</option>
                          <option value="BB">Barbados</option>
                          <option value="BY">Belarus</option>
                          <option value="BE">Belgium</option>
                          <option value="BZ">Belize</option>
                          <option value="BJ">Benin</option>
                          <option value="BM">Bermuda</option>
                          <option value="BT">Bhutan</option>
                          <option value="BO">Bolivia</option>
                          <option value="BA">Bosnia and Herzegovina</option>
                          <option value="BW">Botswana</option>
                          <option value="BV">Bouvet Island</option>
                          <option value="BR">Brazil</option>
                          <option value="IO">British Indian Ocean Territory</option>
                          <option value="VG">British Virgin Islands</option>
                          <option value="BN">Brunei Darussalam</option>
                          <option value="BG">Bulgaria</option>
                          <option value="BF">Burkina Faso</option>
                          <option value="BI">Burundi</option>
                          <option value="KH">Cambodia</option>
                          <option value="CM">Cameroon</option>
                          <option value="CA">Canada</option>
                          <option value="CV">Cape Verde</option>
                          <option value="KY">Cayman Islands</option>
                          <option value="CF">Central African Republic</option>
                          <option value="TD">Chad</option>
                          <option value="CL">Chile</option>
                          <option value="CN">China</option>
                          <option value="CX">Christmas Island</option>
                          <option value="CC">Cocos (Keeling) Islands</option>
                          <option value="CO">Colombia</option>
                          <option value="KM">Comoros</option>
                          <option value="CG">Congo</option>
                          <option value="CK">Cook Islands</option>
                          <option value="CR">Costa Rica</option>
                          <option value="CI">Cote D'ivoire</option>
                          <option value="HR">Croatia</option>
                          <option value="CU">Cuba</option>
                          <option value="CY">Cyprus</option>
                          <option value="CZ">Czech Republic</option>
                          <option value="CD">Democratic Republic of the Congo</option>
                          <option value="DK">Denmark</option>
                          <option value="DJ">Djibouti</option>
                          <option value="DM">Dominica</option>
                          <option value="DO">Dominican Republic</option>
                          <option value="EC">Ecuador</option>
                          <option value="EG">Egypt</option>
                          <option value="SV">El Salvador</option>
                          <option value="GQ">Equatorial Guinea</option>
                          <option value="ER">Eritrea</option>
                          <option value="EE">Estonia</option>
                          <option value="ET">Ethiopia</option>
                          <option value="FK">Falkland Islands (Malvinas)</option>
                          <option value="FO">Faroe Islands</option>
                          <option value="FJ">Fiji</option>
                          <option value="FI">Finland</option>
                          <option value="FR">France</option>
                          <option value="GF">French Guiana</option>
                          <option value="PF">French Polynesia</option>
                          <option value="TF">French Southern Territories</option>
                          <option value="GA">Gabon</option>
                          <option value="GM">Gambia</option>
                          <option value="GE">Georgia</option>
                          <option value="DE">Germany</option>
                          <option value="GH">Ghana</option>
                          <option value="GI">Gibraltar</option>
                          <option value="GR">Greece</option>
                          <option value="GL">Greenland</option>
                          <option value="GD">Grenada</option>
                          <option value="GP">Guadeloupe</option>
                          <option value="GU">Guam</option>
                          <option value="GT">Guatemala</option>
                          <option value="GG">Guernsey</option>
                          <option value="GN">Guinea</option>
                          <option value="GW">Guinea-Bissau</option>
                          <option value="GY">Guyana</option>
                          <option value="HT">Haiti</option>
                          <option value="HM">Heard and McDonald Islands</option>
                          <option value="HN">Honduras</option>
                          <option value="HK">Hong Kong</option>
                          <option value="HU">Hungary</option>
                          <option value="IS">Iceland</option>
                          <option value="IN">India</option>
                          <option value="ID">Indonesia</option>
                          <option value="IQ">Iraq</option>
                          <option value="IE">Ireland</option>
                          <option value="IR">Islamic Republic of Iran</option>
                          <option value="IM">Isle of Man</option>
                          <option value="IL">Israel</option>
                          <option value="IT">Italy</option>
                          <option value="JM">Jamaica</option>
                          <option value="JP">Japan</option>
                          <option value="JE">Jersey</option>
                          <option value="JO">Jordan</option>
                          <option value="KZ">Kazakhstan</option>
                          <option value="KE">Kenya</option>
                          <option value="KI">Kiribati</option>
                          <option value="KP">Korea</option>
                          <option value="KR">Korea, Republic of</option>
                          <option value="KW">Kuwait</option>
                          <option value="KG">Kyrgyzstan</option>
                          <option value="LA">Laos</option>
                          <option value="LV">Latvia</option>
                          <option value="LB">Lebanon</option>
                          <option value="LS">Lesotho</option>
                          <option value="LR">Liberia</option>
                          <option value="LY">Libyan Arab Jamahiriya</option>
                          <option value="LI">Liechtenstein</option>
                          <option value="LT">Lithuania</option>
                          <option value="LU">Luxembourg</option>
                          <option value="MO">Macau</option>
                          <option value="MK">Macedonia</option>
                          <option value="MG">Madagascar</option>
                          <option value="MW">Malawi</option>
                          <option value="MY">Malaysia</option>
                          <option value="MV">Maldives</option>
                          <option value="ML">Mali</option>
                          <option value="MT">Malta</option>
                          <option value="MH">Marshall Islands</option>
                          <option value="MQ">Martinique</option>
                          <option value="MR">Mauritania</option>
                          <option value="MU">Mauritius</option>
                          <option value="YT">Mayotte</option>
                          <option value="MX">Mexico</option>
                          <option value="FM">Micronesia</option>
                          <option value="MD">Moldova, Republic of</option>
                          <option value="MC">Monaco</option>
                          <option value="MN">Mongolia</option>
                          <option value="ME">Montenegro</option>
                          <option value="MS">Montserrat</option>
                          <option value="MA">Morocco</option>
                          <option value="MZ">Mozambique</option>
                          <option value="MM">Myanmar</option>
                          <option value="NA">Namibia</option>
                          <option value="NR">Nauru</option>
                          <option value="NP">Nepal</option>
                          <option value="NL">Netherlands</option>
                          <option value="AN">Netherlands Antilles</option>
                          <option value="NC">New Caledonia</option>
                          <option value="NZ">New Zealand</option>
                          <option value="NI">Nicaragua</option>
                          <option value="NE">Niger</option>
                          <option value="NG">Nigeria</option>
                          <option value="NU">Niue</option>
                          <option value="NF">Norfolk Island</option>
                          <option value="MP">Northern Mariana Islands</option>
                          <option value="NO">Norway</option>
                          <option value="OM">Oman</option>
                          <option value="PK">Pakistan</option>
                          <option value="PW">Palau</option>
                          <option value="PS">Palestinian Territory</option>
                          <option value="PA">Panama</option>
                          <option value="PG">Papua New Guinea</option>
                          <option value="PY">Paraguay</option>
                          <option value="PE">Peru</option>
                          <option value="PH">Philippines</option>
                          <option value="PN">Pitcairn</option>
                          <option value="PL">Poland</option>
                          <option value="PT">Portugal</option>
                          <option value="PR">Puerto Rico</option>
                          <option value="QA">Qatar</option>
                          <option value="RE">Reunion</option>
                          <option value="RO">Romania</option>
                          <option value="RU">Russian Federation</option>
                          <option value="RW">Rwanda</option>
                          <option value="WS">Samoa</option>
                          <option value="SM">San Marino</option>
                          <option value="ST">Sao Tome and Principe</option>
                          <option value="SA">Saudi Arabia</option>
                          <option value="SN">Senegal</option>
                          <option value="RS">Serbia</option>
                          <option value="SC">Seychelles</option>
                          <option value="SL">Sierra Leone</option>
                          <option value="SG">Singapore</option>
                          <option value="SK">Slovakia</option>
                          <option value="SI">Slovenia</option>
                          <option value="SB">Solomon Islands</option>
                          <option value="SO">Somalia</option>
                          <option value="ZA">South Africa</option>
                          <option value="GS">South Georgia and the South Sandwich Islands</option>
                          <option value="ES">Spain</option>
                          <option value="LK">Sri Lanka</option>
                          <option value="BL">St. Barthelemy</option>
                          <option value="SH">St. Helena</option>
                          <option value="KN">St. Kitts and Nevis</option>
                          <option value="LC">St. Lucia</option>
                          <option value="MF">St. Martin</option>
                          <option value="PM">St. Pierre and Miquelon</option>
                          <option value="VC">St. Vincent and the Grenadines</option>
                          <option value="SD">Sudan</option>
                          <option value="SR">Suriname</option>
                          <option value="SJ">Svalbard and Jan Mayen Islands</option>
                          <option value="SZ">Swaziland</option>
                          <option value="SE">Sweden</option>
                          <option value="CH">Switzerland</option>
                          <option value="SY">Syrian Arab Republic</option>
                          <option value="TW">Taiwan</option>
                          <option value="TJ">Tajikistan</option>
                          <option value="TZ">Tanzania, United Republic of</option>
                          <option value="TH">Thailand</option>
                          <option value="TL">Timor-Leste</option>
                          <option value="TG">Togo</option>
                          <option value="TK">Tokelau</option>
                          <option value="TO">Tonga</option>
                          <option value="TT">Trinidad and Tobago</option>
                          <option value="TN">Tunisia</option>
                          <option value="TR">Turkey</option>
                          <option value="TM">Turkmenistan</option>
                          <option value="TC">Turks and Caicos Islands</option>
                          <option value="TV">Tuvalu</option>
                          <option value="UG">Uganda</option>
                          <option value="UA">Ukraine</option>
                          <option value="AE">United Arab Emirates</option>
                          <option value="GB">United Kingdom (Great Britain)</option>
                          <option selected="selected" value="US">United States</option>
                          <option value="UM">United States Minor Outlying Islands</option>
                          <option value="VI">United States Virgin Islands</option>
                          <option value="UY">Uruguay</option>
                          <option value="UZ">Uzbekistan</option>
                          <option value="VU">Vanuatu</option>
                          <option value="VA">Vatican City State</option>
                          <option value="VE">Venezuela</option>
                          <option value="VN">Vietnam</option>
                          <option value="WF">Wallis And Futuna Islands</option>
                          <option value="EH">Western Sahara</option>
                          <option value="YE">Yemen</option>
                          <option value="ZM">Zambia</option>
                          <option value="ZW">Zimbabwe</option>
                      </select>
          </td>
    </tr>
    <tr>
          <td class="data-name"><label for="zipcode">Zip/Postal code</label></td>
          <td class="data-required">*</td>
          <td>
              <?php echo form_input($post_code) ?> 
              
          </td>
    </tr>
  
      <tr>
          <td class="data-name"><label for="phone">Phone</label></td>
          <td>&nbsp;</td>
          <td>
             <?php echo form_input($phone) ?> 
              
          </td>
    </tr>
  
      <tr>
          <td class="data-name"><label for="fax">Fax</label></td>
          <td>&nbsp;</td>
          <td>
            <?php echo form_input($fax) ?>
          </td>
    </tr>  
  </tbody>
 </table>

    <div class="center" style="margin: 20px 40px 20px 40px;">
                <!--<button title="Submit" type="submit" class="button main-button">
              <span class="button-right"><span class="button-left">Submit</span></span>
              </button> -->
              <?php   echo form_submit('submit','Continue'); ?> 
    </div>
  
  </form>
  
<?php  echo form_close();  ?>  

<!-- Address Book -->