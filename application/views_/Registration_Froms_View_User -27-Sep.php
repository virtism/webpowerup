<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.min.js"></script>
<?php 
if( !isset($form_number) ) // if there are multiple forms then 
{
	 $form_number = "";
}
?>
<script type="text/javascript">
$(document).ready(function() {
   	
	
    var chkboxName = new Array();
	var radioName = new Array();
	radioChecked = 0;
	var block = 0;
	$("#regFormFields<?=$form_number?>").submit(function(){
		
			chkboxName = get_checkbox_name();
			radioName = get_all_radio();
			alert(chkboxName);
			alert(radioName); 
			
			
			return false;
			clearAllError();
			block = 0;
			
			// var allFields = $(this).find(".required_custom_field").css("border","solid 1px red");
			
			// var v = $(".required_custom_field").val() || [];
			
			$("#regFormFields<?=$form_number?> .required_custom_field").each(function(index) {
				// alert(index + ': ' + $(this).val());
				
				
				if ( $(this).is(":text") ) // if it is a text field
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
				}
				/*
				else if( $(this).is(":radio")  )
				{
					
					if (radioChecked == 0)
					{
						if( $(this).is(":checked") == false) // if it checked
						{
							$(this).parent().append("<span class='error'> This is required</span>");
							block = 1;
							return false;
						}
						else 
						{
							radioChecked = 1;
						}
					}
					
				}
				else if( $(this).is(":checkbox") ) // if it is a checkbox
				{
					if( $(this).is(":checked") == false) // if it checked
					{
						$(this).parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
				}
				*/
				else if( $(this).is("textarea") )
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error'> This is required</span>");
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
			
			
			return false; // for dev 
	});
	/*
	$("#regFormFields<?=$form_number?>").find(":radio").click(function(){
		radioChecked = 1;
	});
	*/
	
	
	
});


function get_checkbox_name()
{
	var allCheckBoxName = new Array();
	var i = 0;
	<?php
	if ( isset($form_fields) && count($form_fields) > 0) 
	{
		
		foreach($form_fields as $row)
		{
			if ( $row['type'] == "Check Boxes")
			{
			?>
			allCheckBoxName[i]='<?=$row['name']?>';
			i++;
			<?php
			}
			
		}
	}
	?>
	
	return allCheckBoxName;
}

function get_all_radio()
{
	var allRadioName = new Array();
	var i = 0;
	<?php
	if ( isset($form_fields) && count($form_fields) > 0) 
	{
		
		foreach($form_fields as $row)
		{
			if ( $row['type'] == "Radio Buttons")
			{
			?>
			allRadioName[i]='<?=$row['name']?>';
			i++;
			<?php
			}
			
		}
	}
	?>
	
	return allRadioName;
}


function clearAllError()
{
	$(".error").html("");
}
</script>
<style>
.error 
{
color: #D8000C;
}
.formTbl
{
	padding-left:10px; 
}
.formTbl tr td{
	padding:3px 3px 3px 10px;
	
}

</style>
<?php 
if( ( !isset($thml_fixer)) )	// this fix the height problem for the view in specific page
{
?>		
	<div id="left" style="float: left; width: 688px; height: 760px;">
	<div  style="max-width: 688px;"> 
<?php
} 
?>
<?php
if($form_data['form_complete_action'] == "Redirect URL")
{
	$site_id = $form_data['site_id']; // site id
	$page_id = $form_data['form_redirect_to']; // page id
	$action = site_url()."site_preview/page/".$site_id."/".$page_id;
} 
else
{ 
	$action = site_url()."Froms/index/";
?>
    
<?php
} ?>
	<form action="<?=$action?>" method="post" id="regFormFields<?=$form_number?>" >
	
			<? //echo "<pre>";print_r($form_data); echo $form_data['form_title']; ?>
				<h1><strong><?php if(isset($form_data['form_title'])){ echo $form_data['form_title']; } ?> </strong>   </h1>  
				<fieldset>           
					<?php if(isset($form_data['form_intro'])){ echo $form_data['form_intro']; }?>      
				</fieldset>
				<?php if($form_fields)
						{
							echo form_hidden('action','done');
							if(isset($form_data['form_id']))
							{
								echo form_hidden('form_id',$form_data['form_id']);
							}
		
				?>       
			   <fieldset>
					<legend>Form Field</legend>
		<table class="formTbl">
		
				<?php
				
			
					
					$n = count($form_fields);
					
					$this->firephp->log($form_fields);
					
					for($i=0; $i<$n; $i++ )
					{
						
						 echo  "<tr><td>".$form_fields[$i]['label']; 
						 echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
						 echo " </td><td>";
						 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>"; 
						 
					}
				?>
				<?php echo "<tr><td>".form_submit(array('name' => 'Submit'),'Submit')."</td></tr>"; ?>   
			</table>
				</fieldset> 
			<?php } 
			
			?>           
</form>
<?php 
	if( ( !isset($thml_fixer)) )
	{
?>	
</div>
</div>
<?php
	} 
?>
