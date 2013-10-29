<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
   
    
	radioChecked = 0;
	var block = 0;
	$("#regFormFields").submit(function(){
		
		
			clearAllError();
			block = 0;
			
			// var allFields = $(this).find(".required_custom_field").css("border","solid 1px red");
			
			// var v = $(".required_custom_field").val() || [];
			
			$(".required_custom_field").each(function(index) {
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
			
	});
	
	$("#regFormFields").find(":radio").click(function(){
		radioChecked = 1;
	});
	
});

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
</style>

    <div id="left" style="float: left; width: 688px; height: 760px;">

         <div  style="max-width: 688px;"> 

	
<form action="<?=base_url().index_page()?>Froms/index/" method="post" id="regFormFields" >

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
		<table style="padding-left:10px; ">
		
				<?php
				
				

					$n = count($form_fields); 
					
					for($i=0; $i<$n; $i++ )

					{

						 echo  "<tr><td>".$form_fields[$i]['label']; echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';  echo " </td><td>";

						 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>";  

					}

				?>

				<?php echo "<tr><td>".form_submit(array('name' => 'Submit'),'Submit')."</td></tr>"; ?>   
			</table>
				</fieldset> 

			<?php } 
			
			?>           
</form>
        </div>

    </div>
