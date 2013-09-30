<style type="text/css">
.grey_table{
}
.grey_table tr td{
border-left: 1px solid #535353;
    color: #2a3445;
	font-size:12px;
    text-align: center;}
.grey td {
    background: none repeat scroll 0 0 #E1E2E3;
    border-bottom: 1px solid #D9DADC;
    height: 28px;
}
.no_border{
border:none!IMPORTANT;
}
.choose {
    color: #CCCCCC;
    display: inline-block;
    font-size: 25px;
    font-weight: bold;
    padding: 19px 15px;
    text-align: center;
}
.greyy td {
    background: none repeat scroll 0 0 #373737 !important;
    color: #FFFFFF !important;
    padding: 9px 0;
	 border-bottom: 1px solid #505050!important;
}
.light_grey td {
    background: none repeat scroll 0 0 #E1E2E3;
    border-bottom: 1px solid #D9DADC;
    height: 28px;
}
.white td {
    background: none  #fff;
    height: 28px;
}
.message{
	height:45px;
	padding:10px;
	line-height:45px;
	font-size:14px;
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


</style>
<!--
<?php

    $attributes = array('method' => 'post', 'id' => 'user' , 'name' => 'user');

    echo form_open(base_url().index_page().'UsersController/signup_step2', $attributes); 

    echo form_hidden('action','step2');

?>

<fieldset>

<legend><b> Signup Process </b> </legend>

 

 <h2>Step 1 : </h2> 



<fieldset>

<legend>Please Select A Pakage </legend>

    <div style="width:auto; vertical-align:top;">

    <?php

    $total_pakage = count($packges);

    

    for($i=0;$i<$total_pakage;$i++)

    {

?> 

        <div style="width:200px; float:left; height:auto;">

                <h3 align="center"> <?=$packges[$i]['package_name'] ?> </h3>

                <div align="center"> <img src = "<?=base_url();?>images/package.png" width="128" height="128" border="0"  /></div>

                <div align="center"><b>Description : </b><?=$packges[$i]['package_description'] ?></div>

                <div align="center"><b>Price : </b><?=$packges[$i]['package_fixed_price'] ?></div>

                <div align="center"><input type="radio" name="package_select" value="<?=$packges[$i]['package_id'] ?>" <?php if($i== 0){echo 'CHECKED';} ?>  >

                </div>

        </div>

    <?php

    }

?>

</div>        

</fieldset>



<p>

          <input type="button" value="Back" onclick="javascript: history.go(-1);" />

          <?php echo form_submit(array('name' => 'next'),'NEXT'); ?> 

          <?php //echo form_button(array('name' => 'cancel'),'Cancel'); ?>

          

</p>

 </fieldset>  

</form>

-->

<div class="message warning">
	Your 30 days trial has expired. Please update
</div>

<form id="user" name="user" action="<?=base_url().index_page()?>UsersController/upgrade_package_payment" method="post">
<fieldset>

<input type="hidden" value="<?=$customer?>" name="customer" style="height:0px;"  />

<label>Upgrade Your Package</label>

 <?php
                    $total_pakage = count($packges);
					//echo "<pre>";
					//print_r($packges);
                    $count = 1;
                    ?>
	<div  style="background:url(<?=base_url()?>images/gbg.png) no-repeat left top; width:990px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grey_table" >
		<tr>
		  <td  class="no_border" width="31%"><label class="choose">Chose your package</label></td>
			  <td class="no_border">
			  <table width="100%" cellpadding="0" cellspacing="0">
				<tr class="greyy">
					<td width="47%"><?=$packges[0]['package_name'] ?></td>
					<td width="22%"><?=$packges[1]['package_name'] ?></td>
					<td width="31%"><?=$packges[2]['package_name'] ?></td>
			  </tr>
			  <tr>
					<td ><label class="choose"><?=$packges[0]['package_fixed_price'] ?>$</label></td>
					<td ><label class="choose"><?=$packges[1]['package_fixed_price'] ?>$</label></td>
					<td ><label class="choose"><?=$packges[2]['package_fixed_price'] ?>$</label></td>
			  </tr>
</table></td>
		</tr>
		
		<tr class="light_grey">
		  <td  class="no_border" width="31%"><?=$packges[0]['package_description'] ?></td>
			  <td class="no_border" width="69%">
			  <table width="100%" cellpadding="0" cellspacing="0">
<tr>
					<td width="47%">10GB </td>
					<td width="22%">20GB </td>
					<td width="31%">45GB</td>
			  </tr>
			  
</table></td>
		</tr>
		
		<tr class="white">
		  <td  class="no_border" width="31%"><?=$packges[1]['package_description'] ?></td>
			  <td class="no_border" width="69%">
			  <table width="100%" cellpadding="0" cellspacing="0">
<tr>
					<td width="47%">10GB </td>
					<td width="22%">20GB </td>
					<td width="31%">45GB</td>
			  </tr>
              
			  
</table></td>
		</tr>
        <tr class="light_grey">
		  <td  class="no_border" width="31%"><?=$packges[2]['package_description'] ?></td>
			  <td class="no_border" width="69%">
			  <table width="100%" cellpadding="0" cellspacing="0">
<tr>
					<td width="47%">10GB </td>
					<td width="22%">20GB </td>
					<td width="31%">45GB</td>
			  </tr>
			  
</table></td>
		</tr>
        <tr class="white">
		  <td  class="no_border" width="31%">Select</td>
			  <td class="no_border" width="69%">
              
			  <table width="100%" cellpadding="0" cellspacing="0">
<tr>
					 <?php
                                            $strChecked='';
                                            if($count==1)
                                            {
                                                $strChecked = 'class="checked"';    
                                            }
                                            ?>
                               
                    <td width="47%"> <input style="opacity:1;" type="radio" value="<?=$packges[0]['package_id'] ?>" checked="checked" name="package_select"  /></td>
					<td width="22%"> <input style="opacity:1;"  type="radio" value="<?=$packges[1]['package_id'] ?>" name="package_select"  /></td>
					<td width="31%"> <input style="opacity:1;"  type="radio" value="<?=$packges[2]['package_id'] ?>" name="package_select" /></td>
			  </tr>
              
			  
</table></td>
		</tr>
		
		<tr class="light_grey">
		  <td  class="no_border" width="31%">&nbsp;</td>
			  <td class="no_border" width="69%">
			  <table width="100%" cellpadding="0" cellspacing="0">
<tr>
					<td colspan="3"><div class="section">
            <div>
                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="NEXT" />
            </div>
        </div> </td>
					
			  </tr>
			  
</table></td>
		</tr>
		</table>
        </div>

    </fieldset>

</form>



<script type="text/javascript">

    //jquery for radio button control

    $('div.radio span input:radio').click(function() {

        $(this).parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span').removeClass('checked')

        var className = $(this).attr('class');

        if(className == "")

        {

            $(this).parent().addClass("checked"); 

            $(this).attr('checked', true);       

        }

        else

        {

            $(this).parent().removeClass('checked');   

            $(this).attr('checked', false);       

        }

    });

</script>