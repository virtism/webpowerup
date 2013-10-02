<style>
.main{
	width:800px;
	height:500px;
	overflow:visible;
	overflow-x:hidden;
}
#subDetailTbl{
	padding:2px;
}
#subDetailTbl tr td{
	padding:10px;
}

h2{
	color:#C74934;
	font-size:24px;
	font-weight:bold;
}

</style>

<div class="main">

<table width="100%" border="0" id="subDetailTbl">
  <tr>
    <th align="left" height="25" scope="col" colspan="2">
    <h2>
    View Submission
    <?php 
			$str = $submit_id;
			echo "#".str_pad($str,10,"0",STR_PAD_LEFT);
	?>
    </h2>
    </th>
  </tr>
 
 <?php 

if($submit)
{
	foreach($submit as $row)
	{ ?>
  <tr height="25">
    <td width="26%" align="right"><strong><?php echo $row['form_field_name']; ?></strong></td>
    <td width="74%"><?php echo $row['form_field_value']; ?></td>
  </tr>
  <?php
  }
}
else 
{ ?>
	<tr>
    	<td colspan="2">No record found</td>
	</tr>
<?php
}
?>
</table>

</div>