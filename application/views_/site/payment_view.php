<script>
  $(document).ready(function(){
	  
	  
	  $("#btnPaypal").click(function(){
			
			var submit_flag = 0
			
			$("#rsp").html("");
			$("#rsp").slideUp("fast");
			
			
			var gCode = $("#code").val();
			
			if(gCode == "")		// if field is empty
			{
				
				$("#price").val(120);
				$('#paypalForm').submit();
			}
			else		// if proper code is enter
			{
				$.ajax({
				type: 'POST',
				url: "<?=base_url().index_page()?>PackageController/get_group_code_price",
				data: "code="+gCode,
				success: function(data){
					// alert(data);
					
					if(data == 0)
					{
						
						$("#price").val(data);
						$('#paypalForm').attr("action","<?=base_url().index_page()?>SiteController/site_payment_success_free");
						$('#paypalForm').submit();
						
					}
					else if(data != "error")
					{
						$("#price").val(data);
						$('#paypalForm').submit();
					}
					else
					{
						
						$("#rsp").addClass("error");
						$("#rsp").html("The code you entered was incorrect. Please enter the proper code");
						$("#rsp").slideDown("fast");
					}
				}
				
				});
			}
			return false;
		  
	  });
	  
		
	  	
  });
  
</script>
<style>
/***********/
/*	RESPONSE CSS	*/
#rsp{
	
	display:none;
	width:auto;
	padding:15px 15px 15px 15px;
	margin:15px 15px 15px 15px;
}
#rsp2{
	width:auto;
	padding:15px 15px 15px 15px;
	margin:15px 0px 0px 0px;
}
#code{
	height:25px;
	width:230px !important;
}
.info 
{
color: #00529B;
background-color: #BDE5F8;
}
.success 
{
color: #4F8A10;
background-color: #DFF2BF;
}
.warning 
{
color: #9F6000;
background-color: #FEEFB3;
}
.error 
{
color: #D8000C;
background-color: #FFBABA;
}
/***********/

.mainContentDiv{
	clear: both;
    color: #4E4E4E;
    margin: 50px auto;
    width: 50%;
}

#content_container_subpages{
	background: url(<?=base_url();?>images/webpowerup/content_bg.jpg) no-repeat center top #FEFEFE;
	width:1000px !important;
	height:888px !important;
	position:relative;
	z-index:5;
	padding:40px 0 0 0;
}
#contents h2 
{
display: block;
text-align: center;
font-family: Myriad Pro;
font-size: 24px;
color: white;
font-weight: bold;
padding: 0 0 20px 0;

}
.content_details_subpage 
{
background: url(<?=base_url();?>images/webpowerup/iner.gif) repeat-x #FEFEFE;
padding: 10px;
}

.expire_banner
{
	background: url(<?=base_url();?>images/webpowerup/members_banner.jpg) no-repeat center top;
	height: 262px;
}
.data {
	padding: 207px 0 0 201px;
}
.webcomes {
	color: #0068BB;
	display: block;
	float: left;
	font-family: Verdana,Arial,Helvetica,sans-serif;
	font-size: 15px ;
	margin: 0 0 0 51px;
	text-align: left;
	font-weight:normal ;
}
.about_label {
color: #363636;
font-size: 25px;
font-family: Verdana, Arial, Helvetica, sans-serif;
display: block;
padding: 0 0 10px 0;
border-bottom: #CCC 1px solid;
font-weight:normal;
}
.about_table p {
padding: 0 0 25px 10px;
}
p {
line-height: 22px;
color: #515151;
}
</style>

<div id="content_container_subpages">
      <div id="contents">
            <div class="content_details_subpage">
            <div class="expire_banner">
            <div class="data">
              <label class="webcomes">WebPowerUp comes with a series of tools to help <br /> you with getting your messages across.</label>
            <div class="clear"></div>
    		</div>
        
			</div>
            
            
                
         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="about_table">
                  <tr>
                    <td valign="top">
                    
                    <img src="<?=base_url();?>images/webpowerup/paypal.jpg" alt="" style="padding:0 0 0 0; float:left; "><label class="about_label"><br>
    </label>
	<br> 
	<p><strong><?php //echo $_SESSION['user_info']['user_fname']." ".$_SESSION['user_info']['user_lname'] ?></strong> Pay for your site</p>
                
                    <br />
                    <form class="niceform">
                        <input type="text"  name="code" id="code" />
                        <br /><br />
                    </form>
                    <br />
                    <div id="rsp">
                    </div>
                    <br />
                    <?php
                    
                    ?>
                    <form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="paypalForm" >
                    <input type="hidden" name="cmd" value="_xclick">
                    <!--<input type="hidden" name="upload" value="1">-->
                    <input type="hidden" name="business" value="numan_1333967536_biz@virtism.com">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="rm" value="2">   
                    <input type="hidden" name="return" value="<?=base_url().index_page()?>SiteController/site_payment_success">
                    <input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>SiteController/creatnewsite_step3">
                    <input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
                    <input type="hidden" name="item_name" value="Charged Amount for Plan">
                    <input type="hidden" name="item_number" value="<?=$site_id?>">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="amount" id="price" value="">
                    <input type="hidden" name="custom" value="<?=$customer?>">
                    <!--<input type="hidden" name="on0" value="usman">
                    <input type="hidden" name="os0" value="999999">-->
                    
                    <input id="btnPaypal" style="width:220px;" type="image" src="<?=base_url();?>images/webpowerup/activate.jpg" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
                    
                    </form>
                    <br />
                    
                    </td>
                   
                  </tr>
                </table>
            
            
	</div>
</div>
</div>

<div class="RightColumnHeading">
    <h1>
        <span>Pay for your site</span>
    </h1>
</div>


    
   