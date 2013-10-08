<?php include('main_header.php');?>  

<body>
<script language="javascript" type="text/javascript">
function validatePassword()
{
    
    //var current = document.getElementById('txtCurrentPass');
    
    var newpass = document.getElementById('new_affiliate_password');
    //alert(newpass);
    
    var confirm = document.getElementById('confirm_affiliate_password');
    //alert(newpass.value.length);      return false;
    /*if(parseInt(current.value.length)<5)
    {
        alert("Password length should be greater than 5 characters");
        return false;
    }*/
    if(parseInt(newpass.value.length)<5)
    {
        alert("New Password length should be greater than 5 characters");
        return false;    
    }
    /*if(parseInt(confirm.value.length)<5)
    {
        alert(" Password length should be greater than 5 characters");
        return false;    
    } */
   else if(newpass.value!=confirm.value)
    {
        alert("New and Confirm Passwords donot match.");
        return false;        
    }
   /* if(submitFlag == false)
    {
        alert("Please enter your correct Current Password.");
        return false;
    } */
    else
    {
        return true;          
    }
    
       
}
function checkPassWord(password)
{
    var password_mesg = document.getElementById('password_mesg');
    var user_id = document.getElementById('affiliate_id').value;
    var dataString = "password="+password;
            var j = jQuery.noConflict();
        var path =  "<?=base_url().index_page()?>affiliate/affiliate_dashboard/check_password/"+user_id;
        j.ajax({
        type: "POST",
        url: path,
        data: dataString,
        success: function(data){; 
                if(data == 'correct')
                {
                    submitFlag = true;
                    password_mesg.innerHTML = '<code style="color: green">Password Correct!</code>';     
                }
                else{
                    submitFlag = false;     
                    password_mesg.innerHTML = '<code> Password Incorrect!</code>';
                }
            }
        });
    
};
</script>
<script type="application/javascript" >
    var j = jQuery.noConflict();
    j(document).ready(function(e) {
        
        j("#affiliate_password").blur(function(e) {
            var val = j(this).val();
            checkPassWord(val);
        });

        
    });
</script>

    <!-- Themer (Remove if not needed) -->  

    <!-- Themer End -->

    <!-- Header -->
     <?php include('header.php');?>    
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
        <!-- Necessary markup, do not remove -->
        <div id="mws-sidebar-stitch"></div>
        <div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <?php include('leftbar.php');?>         
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
            <!-- Inner Container Start -->
            <div class="container">
            
                <!-- Statistics Button Container -->
                <?php //include('template/menu.php');?>
                
                <!-- Panels Start -->
                
                                 
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-ok"></i>Edit Your Profile</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    <?php 
                    if($this->config->item('seo_url') == 'On')
                    {
                        echo form_open('http://'.$_SERVER['SERVER_NAME'].'/'.'affiliate/affiliate_dashboard/change_password/','class="mws-form" id="mws-validate"');
                        //redirect('http://'.$_SERVER['SERVER_NAME'].'/'.'forms');
                    }
                    else
                    {
                        echo form_open(base_url().index_page().'affiliate/affiliate_dashboard/change_password/', 'class="mws-form" id="mws-validate"');
                        //redirect(base_url().index_page().'MyAccount/login','refresh');
                    }
                    
                    ?>
                    <?php if($this->session->flashdata('password_error')!=''){?>
                 <div class="mws-form-message error" id="errorDiv"  style=""> <?php echo $this->session->flashdata('password_error'); ?> </div> 
                 <?php }?> 
                       
                            <div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                            <input type="hidden" name="affiliate_pro_id" id="affiliate_id" value="<?php echo $affiliate_info['0']->user_id; ?>">
                            <div class="mws-form-inline">
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Name</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_name" value="<?php echo $affiliate_info['0']->user_fname;?>" class="required large">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Company</label>
                                    <div class="mws-form-item">
                                        <input type="text" name="affiliate_company" value="<?php echo $affiliate_info['0']->company;?>" class="required large">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Email</label>
                                    <div class="mws-form-item">
                                        <b><?php echo $affiliate_info['0']->user_email;?>  </b>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Affiliate Login/User Login</label>
                                    <div class="mws-form-item">
                                        <b><?php echo $affiliate_info['0']->user_login;?></b>
                                        <div id="login_mesg" style=""> </div> 
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Old Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" name="affiliate_password" id="affiliate_password"  value="" class="required large">
                                        <div style="float:left;" id="password_mesg"></div>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">New Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" name="new_affiliate_password" id="new_affiliate_password"  value="" class="required large">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Confirm Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" name="confirm_affiliate_password" id="confirm_affiliate_password" value="" class="required large">
                                    </div>
                                </div>
                            </div>
                            <div class="mws-button-row">
                                <input type="submit" name="submit" value="Edit" onclick=" return validatePassword()" class="btn btn-danger">
                            </div>
                        </form>
                    </div>        
                </div>                 
                
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
<?php include('footer.php');?>