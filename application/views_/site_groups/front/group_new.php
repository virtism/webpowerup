<script type="text/javascript">

$(document).ready(function(e) {
	function busy(divId,option)
	{
		if ( option == "hide")
		{
			$("#"+divId).html("");
		}
		else if ( option == "show")
		{
			busyImg = "<img width='25px' height='25px' id='busy' src='<?=base_url();?>images/webpowerup/busy1.gif'> ";
			$("#"+divId).html(busyImg);
		}
		
	}
	function submitBtn(option)
	{
		
		if(option == "enable")
		{
			$('#submitBtn').attr("disabled",false);
		}
		else if(option == "disable")
		{
			$('#submitBtn').attr("disabled",true);
		}
		else
		{
			return false;
		}
		
	}
	function clearAllError()
	{
		$(".error2").html("");
	}
	function check_group_payment_status(group_id)
	{
			
			if( group_id != "" && group_id != 0 ) // if select group or group code
			{
				//alert(group_id);
				var dataString = 'group_id='+group_id;	
				//alert("");
				$.ajax({
				type: "POST",
				url: "<?=base_url().index_page()?>group_managment/check_group_payment_status/",
				data: dataString,
				async: false,
				success: function(rsp){
					  // alert(rsp);
					  var rsp = $.trim(rsp);
					  if(rsp == "Free" || rsp == "Trial")
					  {
						  submitBtn("enable");
						  
					  }
					  else
					  {
						  submitBtn("disable");
						 
					  }
					}	
				});
			}
			else
			{
				submitBtn("disable");
			}
			
	}
	function get_group_fields(group_id)
	{
			//show_busy("paypal");
			var option_id = $("#group_id option:selected").attr("id");
			//alert(group_id);
			//alert(option_id);
			if( option_id != "" )
			{
				$("#group_code_field").show();
			}
			else
			{
				$("#group_code_field").hide();
			}
			if( group_id == "" ) // if select group  
			{
				$('#paypal').html("");
			}
			else if ( group_id == 0 ) // if group code 
			{
				$("#group_code_field").show();
				$('#paypal').html("");
			}
			else 
			{
				var dataString = 'group_id='+group_id;	
				var cid = $("#customer_id").val();
				var site_id = $("#site_id").val();
				var dataString = 'group_id='+group_id+"&cid="+cid+"&sid="+site_id;	
				
				$.ajax({
				type: "POST",
				url: "<?=base_url().index_page()?>sitegroups/group_fields_paypal_button/group_manage",
				data: dataString,
				async: false,
				beforeSend: function(){
					busy("paypal","show"); 
				},
				success: function(data){
					   // alert(data);
					   $('#paypal').html(data);
					   $('#paypal').show();
					}	
				});
			}
	}
	function checkGroupCode(group_code)
	{
		
		group_code = $.trim(group_code);
		var dataString = 'group_code='+group_code;
		var valid = false;
		if(group_code != ""){
		   
			$.ajax({
			type: "POST",
			async: false,
			url: "<?=base_url().index_page()?>customers/code_exist/"+group_code,
			data: dataString,
			success: function(data){
					if(data  == 'true')
					{
						$("#code_id").html('<code style="color: green;">Valid Code.</code>');
						valid = true;
					}
					else
					{
						$("#code_id").html('<code style="color: red;" >Invalid Code! Please put valid Group Code</code>');
						submitBtn("disable");
						valid = false;
					}
					
				}
				
				
				
				
			}); // ajax end 
			
			return valid;
			
		}
		//alert(valid); 
			
	}
	function group_id_by_code(group_code)
	{
		var group_id;
		$.ajax({
			type: "POST",
			async: false,
			url: "<?=base_url().index_page()?>group_managment/get_group_id_by_code/"+group_code,
			success: function(data){
					// alert(data);
					if(data != 'false')
					{
						group_id = data;	
					}
				}
			});
		return group_id;
	}
	
	//submitBtn("disable");
	$("#addGroupForm").submit(function(){
		
		var option_id = $("#group_id option:selected").attr("id");
		if( option_id != "" )
		{
			var code_value = $("#group_code").val();
			if(code_value == "")
			{
				submitBtn("disable");
				alert("Please enter group code");
				return false;	
			}
			
		}
		
		var radioChecked = 0;
		var block = 0;
			
		clearAllError();
		block = 0;
		
		var radioName = new Array();
		var checkboxName = new Array();
		var i = 0;
		var j = 0;
		var id,firstLetter,splitID;
		$(".required_custom_field").each(function() {
			
			id = $(this).attr("id");
			splitID = id.split("-");
			//alert(splitID);
			firstLetter = splitID[0];
			//alert(firstLetter);
			if(firstLetter == "check")
			{
				checkboxName[i] = $(this).attr("name");
				i++;
			}
			else if(firstLetter == "radio")
			{
				radioName[j] = $(this).attr("name");
				j++;
			}
			

		});
		//alert(radioName);alert(checkboxName);
		var unique = function(origArr) {  
			var newArr = [],  
				origLen = origArr.length,  
				found,  
				x, y;  
			for ( x = 0; x < origLen; x++ ) {  
				found = undefined;  
				for ( y = 0; y < newArr.length; y++ ) {  
					if ( origArr[x] === newArr[y] ) {  
					  found = true;  
					  break;  
					}  
				}  
				if ( !found) newArr.push( origArr[x] );  
			}  
		   return newArr;  
		};  
		
		radioName = unique(radioName);  
		checkboxName = unique(checkboxName);  
		
		chkboxName = checkboxName;
		radioName = radioName;
		// alert(chkboxName);
		//alert(radioName); 
		
		$.each(radioName, function(index, value) 
		{ 
			
			var name = "'"+value+"'";
			if( $("input[name="+name+"]").is(":checked") == false ) 
			{
				
				var radioChk = $("input[name="+value+"]").is(":checked");
				
				if(radioChk == false)
				{
					//radio.parent().css("border","solid 1px red");
					//radio.parent().css("border","green 1px red");
					$("input[name="+name+"]").parent().append("<span class='error2'> This is required</span>");
					block = 1;
					return false;
				}
				//break;
			}
			
			
		});
		$.each(chkboxName, function(index, value) 
		{ 
			
			var name = "'"+value+"'";
			if( $("input[name="+name+"]").is(":checked") == false ) 
			{
				
				var chkboxChk = $("input[name="+value+"]").is(":checked");
				
				if(chkboxChk == false)
				{
					//radio.parent().css("border","solid 1px red");
					//radio.parent().css("border","green 1px red");
					$("input[name="+name+"]").parent().append("<span class='error2'> This is required</span>");
					block = 1;
					return false;
				}
				//break;
			}
			
			
		});
		
		
		$(".required_custom_field").each(function(index) {
			// alert(index + ': ' + $(this).val());
			
			
			if ( $(this).is(":text") ) // if it is a text field
			{
				if($(this).val() == "")
				{
					// $(this).css("border","solid 1px red");
					$(this).parent().append("<span class='error2'> This is required</span>");
					block = 1;
					return false;
				}
			}
			
			else if( $(this).is("textarea") )
			{
				if($(this).val() == "")
				{
					// $(this).css("border","solid 1px red");
					$(this).parent().append("<span class='error2'> This is required</span>");
					block = 1;
					return false;
				}
			}
			
			
		});
		
		group_code_field = $("#input_code").val();
		/*if(group_code_field!='')
		{
			$status_code = checkGroupCode(group_code_field);
			if($status_code==false)
			{
				//$("#response").html("Please enter correct group code");
				alert("Please enter correct group code");
				block = 1;
			}
		}
		else
		{
			alert("Please enter group code");
			block = 1;
		}*/
		
		var v = $("#group_id").val();
		if(v == "")
		{
			$("#response").html("Please Select a group");
			block = 1;
		}
		
		
		if(block == 1)
		{
			return false;
		}
		else
		{
			return true;
		}
	
	});
	
	
	$("#group_id").change(function() {
        
		var group_id = $(this).val();
		get_group_fields(group_id); 
		check_group_payment_status(group_id);
    });
	
	$("#group_code").blur(function(e) {
        var group_code = $(this).val();
		var valid = checkGroupCode(group_code);
		//alert(valid);
		if(valid)
		{
			group_id = $.trim(group_id_by_code(group_code));
			get_group_fields(group_id);
			check_group_payment_status(group_id);
			$("#group_id_by_code").val(group_id);
		}
    });
	
}); // ready end 


</script>
<style>
.error, .error2 
{
	color: #D8000C;
	background-color: #FFBABA;
}
.error2 
{
	background:none;
}
/***********/
</style>
<div>
<?php 
// echo "<pre>";	print_r($_SESSION['login_info']['customer_id']);		echo "</pre>";
?>
<h2>Sign up for a new group</h2>
<div>
	<a href="<?php echo base_url().index_page()."group_managment/" ?>"> Back </a>
</div>
<div id="response">
<?php echo $this->session->flashdata('response'); ?>
</div>
<form id="addGroupForm" method="post" action="<?php echo base_url().index_page()."group_managment/add_group" ?>" >
<input type="hidden" id="customer_id" name="customer_id" value="<?=$_SESSION['login_info']['customer_id'];?>" />
<input type="hidden" name="site_id"  id="site_id" value="<?=$site_id?>" />
<input type="hidden" name="group_id_by_code"  id="group_id_by_code" value="" />
<table width="500" border="1">
  <tr>
    <th width="96" scope="col">&nbsp;</th>
    <th width="388" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td><div style="width:100px; " >Group</div></td>
    <td>
    <?php 
	if ( $groups->num_rows() > 0 )
	{ 
		$i = 0;
		//echo "<pre>";print_r($groups->result_array());exit;
	
	?>
    <select name="group_id" id="group_id">
		<option value=""  selected="selected" >Select Group</option>
        <option value="0">Group Code</option>
    	<?php foreach($groups->result_array() as $row)
		{ ?>
        	<option id="<? if(isset($row['group_code']) && $row['group_code'] != 'None'){ echo 'code_exist'.$i++; } ?>"   value="<?php echo $row['group_id']; ?>"><?php echo $row['group_name']; ?></option>
        <?php 
		} ?>
    </select>
    <?php } 
    else 
	{
		echo "No group found";
	}
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
     	<div id="group_code_field" style="display:none;">
   	    	<input type="text" name="group_code" id="group_code" />
            <div  id="code_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Use your Code </div>
        	</div>
        
    	<div id="paypal">
    	</div>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <?php 
	if ( $groups->num_rows() > 0 )
	{ ?>
	    <input type="submit" name="submit" value="Join Group" id="submitBtn"  >
    <?php 
	} ?>
    </td>
  </tr>
</table>
</form>
</div>