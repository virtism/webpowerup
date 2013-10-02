<? //session_start(); ?>
<html>
<head>
<meta charset="utf-8">
<title>
Create New Department
</title>
</head>
<body>
<h1>Create New Department</h1>
 <table>
 
<?=form_open('support_ticket/insert_department');?>

<?=form_hidden('d_owner',$_SESSION['user_info']['user_id']); // need to put current user ID from Session ?>
<tr><td><b>Name:</b></td>
<td><input type="text" name="d_name" size="46"/></td><td style="color: red">*</td><td><?php echo form_error('d_name'); ?></td></tr>

<tr><td><b>Groups:</b></td>
 <td>

 <?php 
    if($q->num_rows() > 0)
    {
 ?>
 <select name="d_group_id">
<?php 

    foreach ($q->result() as $row)
    {
        echo "<option value=".$row->id." > ".$row->group_name." </option>";    
    }
?>
</select>
<?php 
    }
    else 
    {
        echo "No Group found";
    }
?>
</td></tr>

<tr><td>&nbsp;</td>
<td align="right"><input type="submit" value="Insert Department" /></td>
</tr>


</form>

</table>
</body>
