<script type="text/javascript" src="<?php echo base_url();?>js/jscolor/jscolor.js"></script>
<script language="javascript" type="text/javascript">
function save_color_scheme()
{
	show_busy();
	
	
    var primary_color = $('#prim_color').val();
    var secondary_color = $('#sec_color').val();
    var primary_text = $('#prim_txt').val();
    var secondary_text = $('#sec_txt').val();
    var msg = $('#msg_show');
    var dataString = 'primary_color='+primary_color+'&&secondary_color='+secondary_color+'&&primary_text='+primary_text+'&&secondary_text='+secondary_text;
	
	$.ajax({
	type: "POST",
	url: "<?=base_url().index_page()?>scheme_settings/save_color_scheme/",
	data: dataString,
	success: function(data){
			if(data == 'TRUE')
			{   
				$('#msg_show2').html('<div id="rsp" class="error">OOPS! Error in saving setting! </div>');
			}
			else{
				$('#msg_show2').html('<div id="rsp" class="success"> Color scheme save successfully! </div>');
			}
		}
	});

}
function change_color_scheme(value)
{
	show_busy();
	
	
    var option = $('#def_val').val();   
    var dataString = 'option='+value;
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>scheme_settings/change_scheme/",
        data: dataString,
        success: function(data){
                if(data == 'TRUE')
                {                                               
                    $('#msg_show2').html('<div id="rsp" class="error">OOPS! Error in changing setting</div>');
                  
                }
                else{
                  
                    $('#msg_show2').html('<div id="rsp" class="success">Color scheme changed successfully !</div>');
                  
                }
            }
        });
}

function show_busy()
{
	busyImg = "<img id='busy' src='<?=base_url();?>images/webpowerup/busy1.gif'> ";
	$("#msg_show2").html(busyImg);
}


$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");

	if(id == "default")
	{
		$("#div1").fadeOut();
		var val = $("#default").val();
		change_color_scheme(val);
	}
	
	if(id == "custom")
	{
		$("#div1").fadeIn();
		var val = $("#custom").val();
		change_color_scheme(val);
	}
	
});

$(document).ready(function(e) {
    $("#save_col").click(function(){
		save_color_scheme();
	});
});

</script>

<style type="text/css">
<!--
.no-css {
    font-size: 18px;
    /*font-style: italic;
    color: #33CCFF; */
    clear: inherit;
    clear: both;   
}
.InnerMain{
	
	color:#4E4E4E;
}
.clr{
	clear:both;
}
.color_field{
	border:solid 1px #CCC;
	margin:0 0 10px 15px;
}
.color_options{
	clear:both;
}
.color_options > div{
	float:left;
	width:350px;
	margin:25px 0 25px 150px;
}

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
#busy{
	margin:15px 15px 15px 15px;
}
-->
</style>
<div class="RightColumnHeading">
    <h1>
        <span>Color Scheme Management</span>
    </h1>
</div>
<div class="clr"></div>

 <!--
<input type="text" name="prim_color" value="" style="width: 60px; height: 35px; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" class="color {pickerClosable:true}" autocomplete="off" />
Click here: <input class="color" value="66ff00"> -->

<div class="InnerMain" >
<div id="msg_show2" ></div>
<form class="niceform">

<div class="PageDetail">
<p>Note:</p>
<p>
1- Select radio button "User Define Scheme" to set your own color scheme. <br/>2- Select radio button "Default As Theme" to Restore default theme settings
</p>
</div>
   
    
<div class="color_options" align="center"> 
     
     <div>              
         <?php
                        
                         $check_default = $check_custome='';
                         (array_key_exists('default',$scheme) && $scheme['default']=='Default' ) ?   $check_default='checked="checked"' :  '';
                         (array_key_exists('default',$scheme) && $scheme['default']=='Custome' ) ?   $check_custome='checked="checked"' :  '';
                         ($check_custome == $check_default ) ?   $check_default='checked="checked"' :  '';
                          ?>
                        
                        
                        <input type="hidden" name="default" id="def_val" value="<?=(array_key_exists('default',$scheme) ) ?  $scheme['default'] : '';?>">
                       
                         <label class="check_label">Default As Theme &nbsp;</label>
                       
                        <input type="radio" name="default_settings" value="Default" <?=$check_default?>    id="default" />
                        
                       
                        <label class="check_label">User Define Scheme &nbsp;</label>
                        <input type="radio" name="default_settings" value="Custome" <?=$check_custome?>  id="custom" />
	</div>
                        
                        
                        
</div>
               
<?php       
if($check_default == 'checked="checked"')
{
	$div1Style = 'style="display:none;"';
}
else
{
	$div1Style = "";
}
?>    

<div id="div1" <?=$div1Style?> >
  
    
              
     <div class="no-css" id="color_a" style="margin:0 0 0 30px;"> 
     <table width="590" border="0" cellpadding="3" cellspacing="3">       
              <tr>
                <td width="141" align="right" >Primary Color : </td>
                <td width="111">
                <input type="text" name="prime_view_color" id="prime_view_color" onmousemove="document.getElementById('prime_view_color').color.showPicker()" onmouseover="document.getElementById('prime_view_color').color.hidePicker()" style="width: 60px; height: 35px; background-color: <?=(array_key_exists('primary_color',$scheme)) ?  $scheme['primary_color'] : 'FFFFFF';?>;" class="color {valueElement:'prim_color' } none color_field" autocomplete="off" />
                <input type="hidden"  name="prim_color" id="prim_color" value="<?=(array_key_exists('primary_color',$scheme)) ?  $scheme['primary_color'] : 'FFFFFF';?>"  >
                
                </td>
                <td width="10" rowspan="3">&nbsp;</td>
                <td width="141" align="right">Primary Text : </td>
                <td width="139"><input type="text" name="prim_view_txt" id="prim_view_txt"  onmousemove="document.getElementById('prim_view_txt').color.showPicker()" onmouseover="document.getElementById('prim_view_txt').color.hidePicker()" style="width: 60px; height: 35px; background-color: <?=(array_key_exists('primary_txt',$scheme)) ?  $scheme['primary_txt'] : 'FFFFFF';?>;" class="color {valueElement:'prim_txt' } none color_field" autocomplete="off" />
                 <input type="hidden" name="prim_txt" id="prim_txt"  value="<?=(array_key_exists('primary_txt',$scheme)) ?  $scheme['primary_txt'] : 'FFFFFF';?>"  >
                </td>
              </tr>
              <tr>
                <td align="right">Secondary Color : </td>
                <td><input type="text" name="sec_view_color" id="sec_view_color"   onmousemove="document.getElementById('sec_view_color').color.showPicker()" onmouseover="document.getElementById('sec_view_color').color.hidePicker()" style="width: 60px; height: 35px; background-color: <?=(array_key_exists('secondary_color',$scheme)) ?  $scheme['secondary_color'] : 'FFFFFF';?>;" class="color {valueElement:'sec_color' } none color_field" autocomplete="off" />
                   <input type="hidden" name="sec_color" id="sec_color"  value="<?=(array_key_exists('secondary_color',$scheme)) ?  $scheme['secondary_color'] : 'FFFFFF';?>"  >
                
                </td> 
                <td align="right">Secondary Text :</td>
                <td><input type="text" name="sec_view_txt" id="sec_view_txt"   onmousemove="document.getElementById('sec_view_txt').color.showPicker()" onmouseover="document.getElementById('sec_view_txt').color.hidePicker()" style="width: 60px; height: 35px; background-color:<?=(array_key_exists('secondary_txt',$scheme)) ?  $scheme['secondary_txt'] : 'FFFFFF';?>;" class="color {valueElement:'sec_txt' } none color_field" autocomplete="off" />
                 <input type="hidden"  name="sec_txt" id="sec_txt"  value="<?=(array_key_exists('secondary_txt',$scheme)) ?  $scheme['secondary_txt'] : 'FFFFFF';?>"  >
                
                </td>
              </tr>
                
                <tr>
                <td colspan="5" align="center"> <div id="msg_show" > &nbsp;</div></td>
              </tr>
              <tr>
                <td colspan="5" align="center"> <input type="button" value="Save Changes" name="save_col" id="save_col" />
                
                </td>
              </tr>
            </table>
      </div>
     
          
    
    </div>
    
	
</form>
</div>


