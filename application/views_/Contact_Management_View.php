<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Management </title>
<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h1>Contact Management </h1>

<p align="center"><h2></h2></p>



<fieldset>
<legend>Contact Details</legend>
 <table border="0" align="left" cellpadding="2" cellspacing="3" bgcolor="#F9F9F9">
   <tr>
    <td colspan="7"> Here All Records of Contact pages </td>
    <td colspan="2"><a href="<?php echo base_url().index_page() ?>Add_Contact">Add Contact </a></td>
   </tr>
   <tr bgcolor="#DEDDDD">
   <th> Contact Name</th>
   <th> Contact Country</th>
   <th>Contact State</th>
   <th> Contact City</th>
   <th>ZIP/Postal</th>
   <th> Phone</th>
   <th>Fax</th>
   <th>Publish</th>
   <th>ACTIONS / </th> 
   </tr>
   <?php  echo $view_all_records;?>
   <tr>
   <td colspan="9" bgcolor="#DEDDDD"> &nbsp; </td>

   </tr>
 
 
 </table>
</fieldset>

</body>
</html>