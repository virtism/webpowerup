<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    
    
    
    <title>Testimonies Management </title>

<script language="javascript">      
<!--    
  function Check(chk)
  {
   //   alert('i am called');
    if(chk.checked==true)
    {
      var total = document.bk_manage_adm.elements.length;
      for (i = 1; i < total; i++)
      {
        if(document.bk_manage_adm.elements[i].name== 'check_list'+i)
        
        document.bk_manage_adm.elements[i].checked = true;
      }
    }
     if(chk.checked==false)
    {
      var total = document.bk_manage_adm.elements.length;
      for(i = 1; i < total; i++)
      {
        if(document.bk_manage_adm.elements[i].name== 'check_list'+i)
        
        document.bk_manage_adm.elements[i].checked = false;
      }
    }

  }
 --> 
    </script>    
</head>
<body>

<h1>Testimonies Management </h1>

<p align="center"><h2></h2></p>



<fieldset>
<legend>Testimonies Details</legend>
 <table border="0" align="left" cellpadding="2" cellspacing="3" bgcolor="#F9F9F9" width="100%">
   <tr>
    <td colspan="4"> Here All Records of Newsletters </td>
    <td colspan="2"><a href="<?php echo base_url().index_page() ?>Create_Testimonial">Create New Testimonial </a></td>
   </tr>
   <tr bgcolor="#DEDDDD">
   <th>Testimonies Publish</th>
   <th>Testimonies Menu</th>
   <th>Testimonies Parent</th>
   <th colspan="3" >Testimonies Page </th>
   <!--<th>ACTIONS / </th>  -->
   </tr>
   <?php  echo $view_all_records;?>
   <tr>
   <td colspan="6" bgcolor="#DEDDDD"> &nbsp; </td>

   </tr>
 
 
 </table> 
 <br />
 
<form  method="post" enctype="multipart/form-data" name="bk_manage_adm"  action="" id="bk_manage_adm"> 
 <table border="0" align="left" cellpadding="2" cellspacing="3" bgcolor="#F9F9F9" width="100%">
    <tr bgcolor="#005195">
    <td colspan="6" style="color: white;"> Business Reviews</td>
   </tr>
   <tr bgcolor="#DEDDDD">
   <th> <input type="checkbox" name="chk"  id="chk" onClick="Check(this)"/> </th>
   <th>Review </th>
   <th>Rating</th>
   <th > Date</th>
   <th >Submitter</th> 
   <th>ACTIONS / </th>
   </tr>
   <?php  echo $reviews;?>
   <tr>
   <td colspan="6" bgcolor="#DEDDDD"> <input type="checkbox" name="chk"  id="chk" onClick="Check(this)"/> <input type="submit" name="deleteAll" value="Delete Selected"> &nbsp; <input type="submit" name="approve" value="Approve"> </td>

   </tr>
 
 
 </table>  
</form>                                           
</fieldset>

</body>
</html>