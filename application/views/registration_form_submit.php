<script>
	$(document).ready(function(e) {
		
        $("#regFormSubmits tr:even").addClass("even");
		$("#regFormSubmits tr:odd").addClass("odd");
		
		
		$(".subDetail").fancybox({
				'width'                : '70%',
				'height'            : '95%',
				'autoScale'            : false,
				'transitionIn'        : 'none',
				'transitionOut'        : 'none'
		});
	
	
	});
	
	
	
	
</script>
<style>
.heading{
	font-size:14px;
	font-weight:bold;
	height:50px;
}
</style>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>

<h1>Registration Froms Submissions</h1>
<div id="expRsp"></div>
<div style="float:right"><a href="<?=base_url().index_page()?>Registration_Froms/exportCVS/<?=$form_id?>" id="exportCVS">Export in CSV File</a></div>
<br />
 
<?php
if ($submits)
{ ?>
<div class="head_area">
<table width="100%" >
  <tr >
        <th align="left" width="20%">Submission ID</th>
        <th align="left">Details</th>
        <th align="left" width="20%">Action</th>
  </tr>
</table>
</div>


	<table width="100%" id="regFormSubmits">  
    

<?php
	$i = 1;
	
	$this->firephp->log($submits);
	
	foreach($submits as $submit )
	{ ?>
       
		<tr>
        	<td align="left" width="20%">
			<?php 
			$str = $submit['submit_id'];
			echo str_pad($str,10,"0",STR_PAD_LEFT);
			?></td>
            <td align="left">
            	<a id="subDetial_<?=$submit['submit_id'];?>" target="_blank" class="subDetail" href="<?=base_url().index_page()?>Registration_Froms/submit_detail/<?=$submit['submit_id'];?>" > [View Submission Details ] </a>
            </td>
            <td align="left" width="20%"><a href="<?=base_url().index_page()?>Registration_Froms/submit_delete/<?=$form_id?>/<?=$submit['submit_id'];?>">Delete</a></td>
        </tr>
       
		<!--	This code show submits details-->
		<?php /*?><table style="margin:0 0 15px 0; border:1px dashed; width:100%;">
        <?php
         // echo "<pre>";	print_r($submit); 	echo "</pre>";
        foreach($submit as $submitData )
        { 
        
        ?>
        
        <tr>
              <td valign="top" width="20%"><strong><?=$submitData['form_field_name']; ?></strong></td> 
              <td valign="top" width="80%"><?=$submitData['form_field_value'];?></td>		 
        </tr>
        
        
        <?php
        }
        $i++;
        ?>
        <table><?php */?>
		<!--	This code show submits details-->
	
		
	<?php
    }
	?>
    </table>
<?php 
}
else
{
	

?>
<tr>  

	<td colspan="10" >No form found.</td>

</tr>
<?php 
} ?>