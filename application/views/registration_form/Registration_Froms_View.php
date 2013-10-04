<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
<script type="text/javascript">
function deleteForm()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
  else
     return false;
	
}
$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});
</script>

<div class="RightColumnHeading">
    <h1>
    	<img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="Registration Forms Management"/>
        <span>Registration Forms Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page() ?>Create_Registration_Form">
            <img src="<?=base_url();?>images/webpowerup/addRegistrationForm.png" alt="Create Boxes"/>
        </a>
    </div>
    
</div>
<div class="clr"></div>

<div class="InnerMain2">

<div class="DataGrid2">
    <ul>
        <li class="Serial">Title </li>
        <li>Permissions </li>
        <li class="managefield">Require Payment</li>
        <li>Action after completion</li>
        <li class="managefield">Publish </li>
        <li> Email to</li>
        <li class="managefield">Make Survey</li>
        <li class="Actions">Action</li>
    </ul>


  
   
    <?php 
   	
  	// echo "<pre>";	print_r($view_all_records);	echo "</pre>";
	
	if($view_all_records)
	{ 
		foreach($view_all_records as $row )
		{
			$payment_required = ($row['form_payment_required']) ==1 ? 'Yes' : 'No';
			 $form_publish = ($row['form_publish'] ==1) ? 'Yes' : 'No';
			 $make_survey = ($row['form_make_survey'] ==1) ? 'Yes' : 'No';
		?>
		<ul>
			<li class="Serial"><?=$row['form_title'];?></li>
			<li><?=$row['form_permissions'];?></li>
			<li class="managefield"><?=$payment_required;?></li>
			<li><?=$row['form_complete_action'];?></li>
			<li class="managefield"><?=$form_publish;?></li>
			<li><?=$row['form_email_to'];?></li>
			<li class="managefield"><?=$make_survey;?></li>
			<li class="Actions">
				 <a href="<?=base_url().index_page()?>Edit_Registration_Form/index/<?=$row['form_id']?>" class="EditAction">
					<img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
				</a>
				 <a href="<?=base_url().index_page()?>Registration_Froms/delete_form/<?=$row['form_id']?>" onclick="return deleteForm();" class="DeleteAction">
					<img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
				</a>
                <br />
                <a href="<?=site_url()?>Registration_Froms/submits/<?=$row['form_id']?>">Submissions</a>
			</li>
		</ul>	
		<?php 
		}
	}
	else
	{ ?>
        	<ul class="TableData">
            <li>
            <span class="NoData">
            Sorry! No Record Found.
            </span>
            </li>
            </ul>
	<?php 
	}
	?>
    
    <!--	PAGINATION	 -->
    <?php /*?><div class="pageDiv">
    <?php echo $paging;?>
    <br />
    Display # 
    <select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
    <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
    <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
    <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
    </select>
    Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
    </div><?php */?>
    <!--	PAGINATION	 -->
    
</div>

</div>