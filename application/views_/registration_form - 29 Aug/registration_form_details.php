<script>
	$(document).ready(function(e) {
        $("#regFormTbl tr:even").addClass("even");
		$("#regFormTbl tr:odd").addClass("odd");
    });
	
	
</script>

<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>

<h1>Registration Froms Details </h1>



<p align="center"><h2></h2></p>




<table width="100%">
 <tr>

    <td width="888" >&nbsp;  </td>

    <td width="181"><a href="<?php echo base_url().index_page() ?>Create_Registration_Form">Add Registration Forrm </a></td>

  </tr>
</table>

<div class="head_area">
<table width="990">
<tr>

   <th width="118">Title</th>

   <th width="115"> Permissions</th>

   <th width="10">Require Payement</th>

   <th width="14"> Action After Completion</th>

   <th width="20">Publish</th>  

   <th width="20">Email TO </th> 

   <th width="20">Make Survey</th>

   <th width="100">ACTIONS  </th> 

   </tr>
</table>

</div>
 <table id="regFormTbl" border="0"  cellpadding="0" cellspacing="0" width="990"  class="site_builder">

  

   
	<?php
	if ($forms)
	{
		
		$i = 1;
		foreach($forms as $form )
		{
			$payment_required = ($form['form_payment_required'] ==1 ? 'Yes' : 'No');
			$form_publish = ($form['form_publish'] ==1 ? 'Yes' : 'No');
			$make_survey = ($form['form_make_survey'] ==1) ? 'Yes' : 'No';
		?>
		<tr>
                  <td><?php echo $form['form_title']; ?></td> 
                  <td><?=$form['form_permissions'];?></td>
                  <td><?=$payment_required?></td>
                  <td><?=$form['form_complete_action'];?></td>
                  <td><?=$form_publish;?></td>
                  <td><?=$form['form_email_to'];?></td>
                  <td><?=$make_survey;?></td>  
                  <td>
                  <div style="color:blue;white-space:nowrap;">
                    <a href="<?=base_url().index_page()?>Registration_Froms/submits/<?=$form['form_id'];?>" > 
                        View Submissions
                    </a>
                   </div>
                  </td>
		</tr>

  
   <?php 
		$i++;
		}
	}
	else
	{
	
	?>
   <tr>  

   		<td colspan="10" >No form found.</td>

   </tr>
   <?php 
	} ?>

 </table>

