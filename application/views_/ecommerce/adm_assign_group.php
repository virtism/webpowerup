<script type="text/javascript">
$(document).ready(function() {

	$("#adm_assign_group").submit(function(){
		var val = $("#group_id").val();
		if( val == "" ) 
		{
			$("#response").html("Please Select the Group!");

			$("#response").show();

			return false;
		}
		else
		{
			return true;
		}
	});

});
function get_group_fields()
{
		var group_id = document.getElementById('group_id').value;
		//alert(group_id);
		var dataString = 'group_id='+group_id;
		$.ajax({
			type: "POST",
			url: "<?=base_url().index_page()?>sitegroups/group_fields_admin/register",
			data: dataString,
			success: function(data){
			
				$('#fields').html(data);
				$('#fields').show();
				
				NFFix();
				}
		});
}
</script>

<div >

	<?php echo($this->breadcrumb->output()); ?>

</div>



<h1 style="color:#000000; padding-left:28px;">Assign Group to member</h1>



<?php 

	$style = " style=\" display:none; \" ";

	if ( $this->session->flashdata('response') != "" )

	{

		

		if($this->session->flashdata("error") == 0)

		{ 

			$style = " style=\"display:block; border:green 1px solid; padding:5px; color:green; \" ";

		}

		else if ($this->session->flashdata("error") == 1)

		{

		 	$style = " style=\"display:block; border:red 1px solid; padding:5px; color:red; \" ";

		}

	}

	

	

?>

<div id="response"  <?=$style?> >

    <?php echo $this->session->flashdata('response'); ?>

</div>





<form id="adm_assign_group" action="<?=base_url().index_page()?>customers/group_process" method="post" class="niceform" >



<input type="hidden" name="customer_id" value="<?php echo $this->uri->segment(3) ?>" >


 <fieldset>
        <dl>
            <dt><label for="email" class="NewsletterLabel">Email: </label></dt>
            <dd ><span style="color:#000000;"><? echo $customer['customer_email'];?></span></dd>
        </dl>
        
         <dl>
            <dt><label for="email" class="NewsletterLabel">Name: </label></dt>
            <dd><span style="color:#000000;"><? echo $customer['customer_fname']." ".$customer['customer_lname']; ?></span></dd>
        </dl>
        
         <dl>
            <dt><label for="gender" class="NewsletterLabel">Group:</label></dt>
            <dd>
              <?php
				
				if ( $groups->num_rows() > 0 )
				{ ?>
				<select name="group_id" onchange="get_group_fields();" id="group_id">
		
					<option value="" >Select Group</option>
		
					<?php foreach($groups->result_array() as $row)
					{ ?>
						<option value="<?php echo $row['group_id']; ?>"><?php echo $row['group_name']; ?></option>
					<?php 
					} ?>
				</select>
				<?php } 
				else 
				{
					echo "No group found";
				}
				?>

            </dd>
        </dl>
         
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
                <div id="fields" style="display:none; color:#333333; "></div>
            </dd>
        </dl>
        
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
                <input type="button" value="Go Back" onClick="history.go(-1)" >
    			<input type="submit" value="Add Group" >
            </dd>
        </dl>
        
  </fieldset>
</form>
</div>