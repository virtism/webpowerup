<?php if(isset($msgResponse))
{
  echo "<div>".$msgResponse."</div>";  
}

?>
<div style="color:red">
<?php 
	if($formError != "")
	{
	  echo "<div>".$formError."</div>";  
	}
?>
</div>

<form action="<?php echo base_url().index_page()."ticket/new_ticket" ?>" method="post" >
<div>

<table border="0">
    <tr>
      <td align="right">Email: </td>
      <td><input type="text" name="t_email"> </td>
    </tr>
    <tr>
        <td align="right">Subject: </td> <td><input type="text" name="t_subject"> </td>
    </tr> 
    
    <tr>
    <td>Department:</td>
    <td>
    <?php 
        if ($query->num_rows() > 0): 
        $arr = array('' => 'Select One');
        foreach($query->result() as $row): 
        $arr[$row->d_id] = $row->d_name; 
        endforeach;
        //  print_r($arr); exit;
        echo form_dropdown('t_department_id', $arr, set_value('t_department_id'));
        endif;
    ?>    </td>
    </tr>
    <tr>
   <td align="right">Priority:</td>
    <td><!--<input type="" name="t_priority" size="66"/>-->
    <select name="t_priority">
      <option>Normal</option>
      <option>High</option>
    </select></td>
	</tr>

    <tr>
        <td align="right" valign="top">Detail</td> <td><textarea name="t_detail" cols="50" rows="20"></textarea></td>
    </tr>
    <tr>
        <td>&nbsp;</td> <td><input type="submit" value="Submit" name="t_submit"></td>
    </tr>
</table>

</div>
