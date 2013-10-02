
<script language="javascript" type="text/javascript">
function save_color_scheme(site_id)
{
   var site_id = site_id;
    var font = $("#font").val();
	var msgErr = '<div class="error" id="rsp" >&nbsp;&nbsp;&nbsp; OOPS! Error in saving setting !&nbsp;&nbsp;&nbsp;</div>';
	var msgSuc = '<div class="success" id="rsp" >&nbsp;&nbsp;&nbsp;  Font setting save successfully ! &nbsp;&nbsp;&nbsp; </div>';
    
		var dataString = 'font='+font+'&site_id='+site_id;
		
		$.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>font_setting/save_font",
        data: dataString,
        success: function(response){
              	//alert(response);
                if(response == "TRUE"){                                               
                    
                    $("#responseMsg").html(msgSuc);
                }
                else{
                    
                    $("#responseMsg").html(msgErr);
                }
				return false;
            }
        });
  //  }        
}
</script>
<style>
#rsp{
	width:auto;
	padding:15px 15px 15px 15px;
	margin:15px 15px 15px 15px;
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
<div class="RightColumnHeading">
    <h1>
        <span>Set Menu Font</span>
    </h1>
</div>
<div class="clr"></div>
 
<div class="InnerMain" >
<form name="font_form" method="post" class="niceform" >
    
    <fieldset style="margin: 20px 0 20px 0; ">
    
    <legend>Please select the desire font</legend>
    <br />
    <br />
    <table width="100%" border="0">
    	<tr>
            <td colspan="2"><div id="responseMsg"></div></td>
        </tr>
        <tr>
          <td align="right" valign="middle" width="80">&nbsp;</td>
          <td >
            
            <div  style=" position:relative; margin-top:10px; float:left">
                <select size="1" name="font" id="font" style="width:360px;" >
                    <option <?php if($font == "default") { echo " selected='selected' "; } ?> value="default">Default</option>
                    <option <?php if($font == "arial") { echo " selected='selected' "; } ?> value="arial">Arial</option>
                    <option <?php if($font == "times New Roman") { echo " selected='selected' "; } ?> value="times New Roman" >Times New Roman</option>
                    <option <?php if($font == "georgia") { echo " selected='selected' "; } ?> value="georgia" >Georgia</option>
                    <option <?php if($font == "verdana") { echo " selected='selected' "; } ?> value="verdana" >Verdana</option>
                    <option <?php if($font == "vijaya") { echo " selected='selected' "; } ?> value="vijaya" >Vijaya</option>
                    
                </select>
               </div>
          </td>
        </tr>
         <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
         <tr>
            <td >&nbsp;
                
            </td>
            <td >
                <!--<input type="button" onclick="window.history.go(-1);" id="cancle" name="cancle" value="Cancle">	-->			   				<input type="button" onclick="save_color_scheme(<?=$site_id?>)" id="save" name="save" value="Save">
            </td>
        </tr>
    </table>
    
    
    <br />
    <br />
    </fieldset> 
</form>
</div>