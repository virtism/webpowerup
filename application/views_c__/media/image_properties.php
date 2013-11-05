<html>
<head>
	<link rel="stylesheet" href="<?=base_url();?>/css/sidebuilder.css">   
	  <style>
	  .main-property
	  {
			text-align:left; 
	  }
		
	 .main-property tr td 
	  {
			color:#000000;
			vertical-align: middle !important;
	  }
	.img_options
	{
			display: block;
			float: left;
			margin: 2px 5px 0;	
	}
	.align-options
	{
			float:left;
			text-align:left;			
	}
	#fancybox-content{
	
	width:700px !important;
	background:#fff !important;
		}
	#fancybox-close{
		right:0px !important; 
			}
		
	  </style>
	<script type="text/javascript">
	
	function removejscssfile(filename, filetype){
			 var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
			 var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
			 var allsuspects=document.getElementsByTagName(targetelement)
			 for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
			  if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
			   allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
			 }
		}
	$(document).ready(function() {
			//removejscssfile('style.css', 'css');
			//removejscssfile('niceforms.js', 'js');
			<?php
				$niceform = explode("/",$_SERVER['HTTP_REFERER']);
				if($niceform[3]!='page_editor'){

			?>

			 NFFix() ;
			 
			 <? } ?>
});
	
		function prefill_data(id)
		{
			var control_counter = $('#img_property').val();	
				//alert(control_counter);
			//	alert($("#img_url").val());

			// $("#img_url").val($('#image_url'+control_counter).val());
			 
			 $("#img_alt").val($('#image_alt'+control_counter).val());
			 
			 if($("#img_size_type1").val()==$('#image_size_type'+control_counter).val())
			 {
				$("#img_size_type1").attr("checked", true); 
			 }
			 if($("#img_size_type2").val()==$('#image_size_type'+control_counter).val())
			 {
				$("#img_size_type2").attr("checked", true); 
			 }
			 
			 if($("#image_alignment_bottom").val()==$('#image_alignment'+control_counter).val())
			 {
				$("#image_alignment_bottom").attr("checked", true); 
			 }
			 else  if($("#image_alignment_left").val()==$('#image_alignment'+control_counter).val())
			 {
				$("#image_alignment_left").attr("checked", true);
			 }
			 else 
			 {
				$("#image_alignment_right").attr("checked", true);
			 }
			 
			 //if((document.getElementById('img_cons_opt').checked))
			 
			if($('#image_cons_opt'+control_counter).val()=='ratio')
			{ 
					document.getElementById('img_cons_opt').checked =true;					
			} 
			
			 $("#img_selected_size").val($('#image_selected_size'+control_counter).val());			 
			 
			 $("#url_target").val($('#image_target'+control_counter).val());
			 
			 if($('#image_width'+control_counter).val() == "" )
			 {
				$("#img_width").val("200");				 
			 }
			 else
			 {
				$("#img_width").val($('#image_width'+control_counter).val());	 
			 }
			 //alert($('#img_height'+control_counter).val());
			 if($('#image_height'+control_counter).val() == "" )         
			 {
				 $("#img_height").val("150"); 
			 }
			 else
			 {
				$("#img_height").val($('#image_height'+control_counter).val()); 				 
			 }     
			 
			 
			 $("#img_hspace").val($('#image_hspace'+control_counter).val());
			 
			 
			 $("#img_vspace").val($('#image_vspace'+control_counter).val());
			 
			 $("#img_border").val($('#image_border'+control_counter).val());
			 
			 
			 
			 $("#image_alignment").val($('#image_alignment'+control_counter).val());      
			//$('#image_url'+control_counter).val($("#img_url").val());
		}
		
		function submit_form(form)
		{
			//This function set the values in editor board hidden feilds 
			 var control_counter = $('#img_property').val();	
			 
			 
			 $('#image_url'+control_counter).val($("#img_url").val());
			 
			 $('#image_alt'+control_counter).val($("#img_alt").val());
			
			 if ( $('#img_size_type1').is(':checked') )
			 {
				
				$('#image_size_type'+control_counter).val($("#img_size_type1").val());				
			 }
			 else if ( $('#img_size_type2').is(':checked') )
			 {
				$('#image_size_type'+control_counter).val($("#img_size_type2").val());
			 }
			 else
			 {
				$('#image_size_type'+control_counter).val($("#img_size_type3").val());
			 }
			 $('#image_selected_size'+control_counter).val($("#img_selected_size").val());			 
			 $('#image_target'+control_counter).val($("#url_target").val());
			 $('#image_width'+control_counter).val($("#img_width").val());
			 
			 $('#image_hspace'+control_counter).val($("#img_hspace").val());
			 $('#image_vspace'+control_counter).val($("#img_vspace").val());
			 $('#image_border'+control_counter).val($("#img_border").val());
			 $('#image_height'+control_counter).val($("#img_height").val()); 
			if ( $('#image_cons_opt').is(':checked') )
			{ 
					$('#image_cons_opt'+control_counter).val($("#img_cons_opt").val());
					<? $_SESSION['img_cons'] = "true"; ?>
				//alert($("#img_cons_opt").val());
			} 
			else 
			{ 
					$('#image_cons_opt'+control_counter).val();
					<? $_SESSION['img_cons'] = "false"; ?>
			}	 
			 if ( $('#image_alignment_bottom').is(':checked') )
			 {
				$('#image_alignment'+control_counter).val($("#image_alignment_bottom").val());
			 }
			 else if ( $('#image_alignment_left').is(':checked') )
			 {
				$('#image_alignment'+control_counter).val($("#image_alignment_left").val());
			 }
			 else 
			 {
				$('#image_alignment'+control_counter).val($("#image_alignment_right").val());
			 }
			 
			
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
	   prefill_data(<?=$counter?>);
	   
	   
	</script>
</head>
<body>
<form action="javascript:void(0);" method="post" name="img_properties"  onSubmit="return submit_form(this);">
<input type="hidden" name="counter" value="<?=$counter?>">
	<table class="main-property" cellpadding="3" cellspacing="3" border="1" width="100%" style="text-align:left;">
		<tr>
			<td colspan="2" align="left"><h2>Image Properties</h2></td>
		</tr>
		<tr>
			<td colspan="2" align="left" ><h1 style="color:#4d73b8;">LINK IMAGE TO A WEBSITE</h1></td>
		</tr>		
		<tr>
			<td width="100px">
				Make this Image Linkable to another webpage
			</td>
			<td>
				<input type="text" name="url" id="img_url" value="http://" onfocus=" if(this.value.split(' ').join('')=='http://'){ this.value=''; this.style.color='black'; }"  onblur=" if(this.value.split(' ').join('')==''){ this.value='http://'; this.style.color='grey'; }else{ this.style.color='black'; }"  size="30">
			</td>			
		</tr>
		<tr>
			<td >
				Open Link In
			</td>
			<td align="left">
				<select  name="url_target" id="url_target">
					<option value="">This Website</option>
					<option value="_blank">Another Website</option>
					<option value="_top">Topmost Window</option>
					<option value="_self">Same Window</option>
					<option value="_parent">Parent Window</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="100px">
				Image Title & Description
			</td>
			<td>
				<input  type="text" name="des" id="img_alt" value="" size="30">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="left"><h1 style="color:#4d73b8;">IMAGE SIZE</h1></td>
		</tr>
		<tr>
			<td  align="left" width="50%">
				<table align="left" cellpadding="0" cellspacing="0" width="100%" >
					<tr>
						<td style="white-space:nowrap;"  ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio"  checked="checked" value="default_size"  id="img_size_type1" name="img_size_type" /> 
						Default Size
						</td>
					</tr>
					<tr>
						<td style="white-space:nowrap;"  ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio"   value="custom_size"  id="img_size_type2" name="img_size_type" /> Customize Your Image size
						</td>
					</tr>
					<tr>
						<td>Width</td>
						<td><input type="text" name="img_width" id="img_width" size="5" value="200"></td>
					</tr>
					<tr>
						<td>Height</td>
						<td><input type="text" name="img_height" id="img_height" size="5" value="150"></td>			
					</tr>											
				</table>
			</td>
			<td  align="left">
				<table  align="left" cellpadding="0" cellspacing="0" >
					<tr>
						<td ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio" value="selected_size"  id="img_size_type3" name="img_size_type"/> Select A Standard Web size</td>
					</tr>
					<tr>
						<td align="left">
							<select name="img_selected_size" id="img_selected_size">
								<option value="80_80">80 X 80  (Thumbnail Size)</option>
								<option value="100_67">100 X 67 (Thumbnail Size)</option>
								<option value="100_75">100 X 75 (Thumbnail Size)</option>
								<option value="220_148">220 X 148(Small Size)</option>
								<option value="240_160">240 X 160(Small Size)</option>
								<option value="320_200">320 X 200(Average Size)</option>
								<option value="320_240">320 x 240(Average Size)</option>
								<option value="400_300">400 X 300(Large Size )</option>
								<option value="460_55">460 X 55 (Large Size )</option>
								<option value="640_200">640 x 200 (Large Size )</option>
								<option value="640_350">640 x 350 (Large Size )</option>
								<option value="640_480">640 x 480 (Large Size )</option>						
							</select>
						</td>					
					</tr>
					<tr>
						<td >&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<!--<tr>
			<td>
				Alternative
			</td>
			<td>
				<input type="text" name="alt" id="img_alt" size="60">
			</td>
		</tr>-->
		<tr>

			<td colspan="2" align="left"><input  style=" display: block; float: left; margin: 2px 5px 0;" type="checkbox"  value="ratio" id="img_cons_opt" name="img_cons_opt"/>Constrain Proportions</td>
		</tr>
		<tr>
			<td colspan="2" align="left"><h1 style="color:#4d73b8;">IMAGE ALIGNMENT</h1></td>
		</tr>
		<tr>
			<td colspan="2" >
				<table class="align-options" cellpadding="2" cellspacing="2" border="0" width="100%">
					<tr>
						<td ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio" value="center" id="image_alignment_bottom" name="image_alignment"/> Center</td>
						<td ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio" value="left"  id="image_alignment_left" name="image_alignment"/> Left</td>
						<td ><input  style=" display: block; float: left; margin: 2px 5px 0;" type="radio" value="right"  id="image_alignment_right" name="image_alignment"/> Right</td>	
					</tr>
					<tr>
						<td><img src="<?=base_url()?>images/bottomimage.jpg" /></td>
						<td><img src="<?=base_url()?>images/leftimage.png" /></td>
						<td><img src="<?=base_url()?>images/rightimage.png" /></td>	
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="48%">
					<tr>
						<td>Border</td>
						<td><input type="text" name="img_border" id="img_border" size="10"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h2 style="color:#4d73b8;">Space Between Image and Text</h2></td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="60%">
					<tr>
						<td>HSpace</td>
						<td><input type="text" name="img_hspace" id="img_hspace" size="10"></td>
						<td>VSpace</td>
						<td><input type="text" name="img_vspace" id="img_vspace" size="10"></td>
					</tr>
				</table>			
			</td>			
		</tr>		
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" value="Save" > <input type="button" onClick="close_this();" value="Close" ><input type="reset" value="Reset">
			</td>
		</tr>		
	</table>
</form>	
</body>
</html>