<h2>Support Ticket</h2>
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
<br />
</div>
<form action="<?php echo 'http://'.$_SERVER['SERVER_NAME']."/ticket/new_ticket/".$site_id ?>" method="post" >
<input type="hidden" name="t_uid" value="<?=$_SESSION['login_info']['customer_id'];?>" >
<div>
<table border="0">
    <tr>
      <td align="right">Email: </td>
      <td>
      	<?php echo (isset($_SESSION['login_info']['customer_email'])) ? $_SESSION['login_info']['customer_email'] : "" ; ?>
        <input type="hidden" name="t_email" value="<?=(isset($_SESSION['login_info']['customer_email'])) ? $_SESSION['login_info']['customer_email'] : "" ;?>" >
      </td>
    </tr>
    <tr>
        <td align="right">Subject: </td> <td><input type="text" name="t_subject"> </td>
    </tr> 
    
    <tr>
    <td>Department:</td>
    <td>
    <?php 
        if ($query->num_rows() > 0)
		{ 
			$arr = array('' => 'Select One');
			foreach($query->result() as $row): 
			$arr[$row->d_id] = $row->d_name; 
			endforeach;
			//  print_r($arr); exit;
			echo form_dropdown('t_department_id', $arr, set_value('t_department_id'));
		}
		else
		{
			echo "No department Found.";
		}
    ?>    
    </td>
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
