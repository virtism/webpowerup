<html>
<head>
	<link rel="stylesheet" href="<?=base_url();?>/css/sidebuilder.css">   
	  
	<script type="text/javascript">
		function prefill_data()
		{
			var control_counter = $('#img_property').val();	
				//alert(control_counter);
			//	alert($("#image_url"+control_counter).val());

			 $("#img_url").val($('#image_url'+control_counter).val());
			 
			 $("#img_alt").val($('#image_alt'+control_counter).val());
			 
			 $("#url_target").val($('#image_target'+control_counter).val());
			 
			 $("#img_width").val($('#image_width'+control_counter).val());
			 
			 $("#img_hspace").val($('#image_hspace'+control_counter).val());
			 
			 
			 $("#img_vspace").val($('#image_vspace'+control_counter).val());
			 
			 $("#img_border").val($('#image_border'+control_counter).val());
			 
			 $("#img_height").val($('#image_height'+control_counter).val()); 
			 
			 $("#image_alignment").val($('#image_alignment'+control_counter).val());      
			//$('#image_url'+control_counter).val($("#img_url").val());
		}
		
		function submit_form(form)
		{
			//This function set the values in editor board hidden feilds 
			 var control_counter = $('#img_property').val();	
			 
			 $('#image_url'+control_counter).val($("#img_url").val());
			 
			 $('#image_alt'+control_counter).val($("#img_alt").val());
			 $('#image_target'+control_counter).val($("#url_target").val());
			 $('#image_width'+control_counter).val($("#img_width").val());
			 
			 $('#image_hspace'+control_counter).val($("#img_hspace").val());
			 $('#image_vspace'+control_counter).val($("#img_vspace").val());
			 $('#image_border'+control_counter).val($("#img_border").val());
			 $('#image_height'+control_counter).val($("#img_height").val()); 
			 $('#image_alignment'+control_counter).val($("#image_alignment").val());      
			
			$.fancybox.close();
			return false;
		} 
		
		function close_this()
		{
			$.fancybox.close();
		}
		
		function loadMask()
		{
			$('#img_width').setMask({mask:"999999"});
			$('#img_height').setMask({mask:"999999"});
			$('#img_border').setMask({mask:"999999"});
			$('#img_hspace').setMask({mask:"999999"});
			$('#img_vspace').setMask({mask:"999999"});
			
		}
	   loadMask();
	   prefill_data();
	</script>
</head>
<body>
<form action="javascript:void(0);" method="post" name="img_properties" onsubmit="return submit_form(this);">
<input type="hidden" name="counter" value="<?=$counter?>">
	<table cellpadding="3" cellspacing="3" border="0" width="100%">
		<tr>
			<td colspan="2"><h3>Image Properties</h3></td>
		</tr>
		
		<tr>
			<td width="100px">
				Url 
			</td>
			<td>
				<input type="text" name="url" id="img_url" size="60">
			</td>
			
		</tr>
		<tr>
			<td>Target</td>
			<td>
				<select name="url_target" id="url_target">
					<option value="">Not Set</option>
					<option value="_blank">New Window</option>
					<option value="_top">Topmost Window</option>
					<option value="_self">Same Window</option>
					<option value="_parent">Parent Window</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Alternative
			</td>
			<td>
				<input type="text" name="alt" id="img_alt" size="60">
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><b>Advance Options</b></td>
		</tr>
		<tr>
			<td colspan="2">
				<table cellpadding="2" cellspacing="2" border="0" width="100%">
					<tr>
						<td>Width</td>
						<td><input type="text" name="img_width" id="img_width" size="10"></td>
						<td>Height</td>
						<td><input type="text" name="img_height" id="img_height" size="10"></td>
						<td>Border</td>
						<td><input type="text" name="img_border" id="img_border" size="10"></td>
						
						
					</tr>
					<tr>
						<td>HSpace</td>
						<td><input type="text" name="img_hspace" id="img_hspace" size="10"></td>
						<td>VSpace</td>
						<td><input type="text" name="img_vspace" id="img_vspace" size="10"></td>
						<td>Alignment</td>
						<td>
							<select name="image_alignment" id="image_alignment">
								<option value="">Not Set</option>
								<option value="left">Left</option>
								<option value="right">Right</option>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" value="Save" > <input type="button" onclick="close_this();" value="Close" ><input type="reset" value="Reset"></td>
		</tr>
		
	</table>
</form>	
</body>
</html>