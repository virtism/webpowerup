<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Autoresponders Management </title>



</head>

<body>



<h1>Autoresponders Management </h1>



<p align="center"><h2></h2></p>








<legend>Autoresponders Details</legend>
<table width="990">
<tr>

    <td colspan="4"> Here All Records of Autoresponder </td>

    <td width="173" colspan="2"><a href="<?php echo base_url().index_page() ?>Create_Autoresponder">Create New Autoresponder </a></td>

  </tr>
</table>

<div class="head_area"><table width="990">
<tr>

   <th width="27%"> Name</th>

   <th width="8%"> Group</th>

   <th width="28%">When To Send</th>

   <th width="8%">Active ?</th>

   <th width="24%">ACTIONS </th> 

   </tr>
</table></div>

 <table border="0" width="990" align="left" cellpadding="0" cellspacing="0" class="site_builder">

   

   

   <?php  echo $view_all_records;?>

   <tr>

   <td colspan="6">&nbsp;  </td>



   </tr>

 

 

 </table>




</body>

</html>