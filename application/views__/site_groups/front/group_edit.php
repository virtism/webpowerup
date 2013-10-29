<script type="text/javascript">
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
function check_group_payment_status(group_id)
{
	
	    submitBtn("disable");
		var dataString = 'group_id='+group_id;	
		$.ajax({
		type: "POST",
		url: "<?=base_url().index_page()?>group_managment/check_group_payment_status/",
		data: dataString,
		success: function(data){
			  //alert("asd");
			  data = $.trim(data);
			  if(data == "Free")
			  {
				  submitBtn("enable");
			  }
			  else
			  {
				  submitBtn("disable");
			  }
			}	
		});
		
		$("#response").html("");
}

function show_busy(divId)
{
	busyImg = "<img width='25px' height='25px' id='busy' src='<?=base_url();?>images/webpowerup/busy1.gif'> ";
	$("#"+divId).html(busyImg);
}
function payPal_bottom(group_id)
{
		show_busy("paypal");
		
		
		var dataString = 'group_id='+group_id;	
		if( group_id == "" ) 
		{
			$('#paypal').html("");
		}
		else
		{
			// alert(user_mail);
			$.ajax({
			type: "POST",
			url: "<?=base_url().index_page()?>sitegroups/paypal_bottom_update/<?php echo $group['id']; ?>",
			data: dataString,
			success: function(data){
				   
				   $('#paypal').html(data);
				   $('#paypal').show();
				   
				}	
			});
		}
		
}
function clearAllError()
{
	$(".error2").html("");
}

$(document).ready(function(){
	
	/* 	custom field validation */
	
	
	
	//submitBtn("disable");
	$("#addGroupForm").submit(function(){
		var v = $("#group_id").val();
		if(v == "")
		{
			$("#response").html("Please Select a group");
			block = 1;
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
		
		if(block == 1)
		{
			return false;
		}
		else
		{
			return true;
		}
		

		
		
		
	});
	
	$("#group_id").change(function(e) {
        
		var group_id = $(this).val();
		
		payPal_bottom(group_id);
		check_group_payment_status(group_id);
		
    });
});
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
<h2>Upgrade your group</h2>
<div>
	<a href="<?php echo base_url().index_page()."group_managment/" ?>"> Back </a>
</div>
<div id="response">
	
</div>
<?php if($this->config->item('seo_url') == 'On')
 {
  echo form_open('http://'.$_SERVER['SERVER_NAME'].'/'.'group_managment/update_group');
 }
 else
 {
     echo form_open(base_url().index_page()."group_managment/update_group");
 }?>




<!--<form id="addGroupForm" method="post" action="<?php echo base_url().index_page()."group_managment/update_group" ?>">-->
<table border="0">
  <tr>
    <th  scope="col">&nbsp;</th>
    <th  scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td><span style="display:block;width:137px;">Your current Group:</span></td>
    <td>
    <?php 
	if ( count($group) > 0 )
	{ 
		echo $group['group_name'];?>
        <!--<input type="hidden" name="degrate_group" value="<?php echo $group['id']?>">-->
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Upgrade to Group:</td>
    <td>
    <?php 
	if ( $upgradableGroups->num_rows() > 0 )
	{ ?>
    
    <select name="upgrade_group_id" id="group_id">
    	<option value="" >Select Group</option>
		<?php foreach($upgradableGroups->result_array() as $row)
		{ ?>
        	<option value="<?php echo $row['id']; ?>"><?php echo $row['group_name']; ?></option>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    	<div id="paypal">
    	</div>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <?php 
	if ( $upgradableGroups->num_rows() > 0 )
	{ ?>
    	<input type="submit" name="submit" value="Upgrade Group" id="submitBtn" >
    <?php 
	} ?>
    </td>
  </tr>
</table>
<input type="hidden" name="current_group_id" value="<?php echo $group['id']; ?>"  />
</form>
</div>