<?php include('main_header.php');?> 

<body>
<script language="javascript" type="text/javascript">


function checkUserLogin(user_login)
{
    var login_mesg = document.getElementById('login_mesg');
    var dataString = 'user_login='+user_login;
    var j = jQuery.noConflict();
    if(user_login != ""){
        //alert(user_email);
        j.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>UsersController/isUserLoginExist/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'TRUE')
                {
                    submitFlag = false;
                    //login_mesg.innerHTML = '<label class="error">This user login already exist.</font>';
                    login_mesg.innerHTML = '<code>This user login is already in use.</code>';
                    return false;     
                }
                else{
                    submitFlag = true;     
                    //login_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    login_mesg.innerHTML = '<code style="color: green;">This user login is available.</code>';
                }
            }
        });
    }        
}


function checkUserEmail(user_email)
{
    
    var email_mesg = document.getElementById('email_mesg');
    var dataString = 'user_email='+user_email;
            var j = jQuery.noConflict();
        //alert(user_email);
        //console.log(user_email);
        j.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>UsersController/isUserEmailExist/",
        data: dataString,
        success: function(data){
                //alert(data);
                //console.log(data); 
                if(data == 'TRUE')
                {
                    //console.log(data);
                    submitFlag = false;
                    //email_mesg.innerHTML = '<label class="error">This user email already exist.</font>';
                    email_mesg.innerHTML = '<code>This user email is already in use.</code>';     
                }
                else{
                    submitFlag = true;     
                    //email_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    email_mesg.innerHTML = '<code style="color: green;">This user email is available.</code>';
                }
            }
        });
    
}
</script>
<script type="application/javascript" >
    var j = jQuery.noConflict();
    j(document).ready(function(e) {
        
        j("#affiliate_login").blur(function(e) {
            var val = j(this).val();
            checkUserLogin(val);
        });
        j("#affiliate_email").blur(function(e) {
            var val = j(this).val();
            checkUserEmail(val);
        });
        
    });
</script>

    <!-- Themer (Remove if not needed) -->  

    <!-- Themer End -->

    <!-- Header -->
    <?php //include('header.php');?>      
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
        <!-- Necessary markup, do not remove -->
 
        
        <!-- Sidebar Wrapper -->
         <?php //include('leftbar.php');?>         
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
            <!-- Inner Container Start -->
            <div class="container">
            
                <!-- Statistics Button Container -->
                <?php //include('template/menu.php');?>
                
                
                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-ok"></i>SignUp For Affiliate</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    <?php 
                    if($this->config->item('seo_url') == 'On')
                    {
                        echo form_open('http://'.$_SERVER['SERVER_NAME'].'/'.'wpuadmin/wpuadmin_signup/signup/','class="mws-form" id="mws-validate"');
                        //redirect('http://'.$_SERVER['SERVER_NAME'].'/'.'forms');
                    }
                    else
                    {
                        echo form_open(base_url().index_page().'wpuadmin/wpuadmin_signup/signup/', 'class="mws-form" id="mws-validate"');
                        //redirect(base_url().index_page().'MyAccount/login','refresh');
                    }
                    
                    ?>
                    <?php if( validation_errors() !="")
                    { ?>
                       <div id="mws-validate-error" class="mws-form-message error" style=""><?php echo validation_errors(); ?></div>  
                   <?php } ?>
                   <?php if( $this->session->flashdata('error') !="")
                    { ?>
                       <div id="mws-validate-error" class="mws-form-message error" style=""><?php echo $this->session->flashdata('error'); ?></div>  
                   <?php } ?>
                       
                            <div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                            <div class="mws-form-inline">
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Name</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_name" value="" class="required large">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Company</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_company" value="" class="required large">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Email</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_email" id="affiliate_email" value="" class="required email large">
                                        <div id="email_mesg" style=""> </div>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Affiliate Login/User Login</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_login" id="affiliate_login" value="" class="required large">
                                        <div id="login_mesg" style=""> </div> 
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" name="affiliate_password" value="" class="required large">
                                    </div>
                                </div>
                            </div>
                            <div class="mws-button-row">
                                <input type="submit" name="submit" value="SignUp" onclick="" class="btn btn-danger">
                            </div>
                        </form>
                    </div>        
                </div>                 
                <!-- Panels End -->

            
            <!-- Inner Container End -->
             </div>          
            <!-- Footer -->
           <?php include('footer.php');?>