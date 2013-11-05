<script type="">
$("div.NFRadio").live("click",function(){
        var id = $(this).next("input").attr("id");
        
        if(id == "group_code1")
        {
            $("#custom_code").fadeOut();
        }
        
        if(id == "group_code2")
        {
            $("#custom_code").fadeIn();
        }
});
function checkCommission()
{
    var check = document.getElementById('commission').value
    if(check ==  '')
    {
        alert('Please Fill The Commission Field');
        return false;
    }
}
</script>


<div class="RightColumnHeading">
    <h1>
        <span>Affiliate SignUp</span>
    </h1>
</div>
<div class="clr"></div>
 
<div class="InnerMain" >
<?php if($this->config->item('seo_url') == 'On')
                     {
                      echo form_open('http://'.$_SERVER['SERVER_NAME'].'/'.'wpuadmin_signup/ChangeToAffiliate', 'class="niceform"');
                    
                     }
                     else
                     {
                          echo form_open(base_url().index_page().'wpuadmin_signup/ChangeToAffiliate' , 'class="niceform"');
                      //redirect(base_url().index_page().'MyAccount/login','refresh');
                     }
            ?>
<!--<form name="font_form" method="post" class="niceform" >-->
    
    <fieldset style="margin: 20px 0 20px 0; ">
    
    <legend></legend>
    <br />
    <br />
    <table width="100%" border="0">
        <tr>
          <td align="right" valign="middle" width="80">&nbsp;</td>
          <td>
            <div  style=" position:relative; margin-top:10px; float:left">
            <b> Do You Really Want Become Affiliate</b>
            <input type="hidden" name="user_id" value="<?=$_SESSION['user_info']['user_id'];?>"> 
            <br/>
            <br/>
            <dl>
                <dt><label>Name:<label></dt>
                <dd><b><?=$_SESSION['user_info']['user_fname'];?></b></dd>
            </dl>
            <dl>
                <dt><label>Company:<label></dt>
                <dd><b><?php if($_SESSION['user_info']['company']==''){echo 'none';}else{ echo $_SESSION['user_info']['company'];}?></b></dd>
            </dl>
            <dl>
                <dt><label>Email:<label></dt>
                <dd><b><?=$_SESSION['user_info']['user_email'];?></b></dd>
            </dl>
            <dl>
                <dt><label>Commission Percentage /Month:<label></dt>
                <?php if($_SESSION['user_info']['user_role'] == ''){?>
                <dd><input type="text" id="commission" value=""></dd>
                <?php }else{?>
                <dd>20%</dd>
                <?php }?>
            </dl>
            <dl>
                <dt><label for="color" class="NewsletterLabel" style="padding-left: 0px;"> Pament Method :</label></dt>
                <dd>
                   <label class="check_label">Permanent</label>
                    <input type="radio" name="group_code" value="None" id="group_code1" checked="checked" />
                    
                    <label class="check_label">Monthly</label>
                    <input type="radio" name="group_code" value="custom" id="group_code2" />
                    
                    <div id="custom_code" style="clear:both; display:none;">
                        <input type="text" size="30" name="custome_code" />
                    </div>
                </dd>

            </dl>
            
             
            
            
            
            </table>
             <input type="button" value="Back" onClick="window.location='<?=base_url().index_page()?>SiteController/sitehome/<?=$_SESSION['site_id']?>'" />
                &nbsp;
                <?php if($_SESSION['user_info']['user_role'] == 'affiliate'){?> 
                 <input type="submit" name="bcaffilate"  value="No" />
                <?php }else{?>
                <input type="submit" name="bcaffilate" onclick=" return checkCommission()" value="Yes" /> 
                <?php }?>
             </form>   
            </div>
          </td>
        </tr>
         
        
    </table>
    
    
    <br />
    <br />
    </fieldset> 
</form>
</div>