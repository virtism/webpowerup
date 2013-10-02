<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Management </title>

</head>
<body>
<div id="header" style=" height: 100px; background-color: #96C2E8;"></div>
<div id="main" style="width: 1280px; background-color: black; height: 760;">
    <!--left Colmn    -->
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"> <?php echo $left_menu; ?> </div>
    <!--manin inner content    -->
    <div id="left" style="float: left; width: 688px; height: 760px;">
         <div  style="max-width: 688px;"> <h1> <strong>Contact Name : </strong>  <?php echo $contact_name; ?> </h1>  
           
           <fieldset style="max-width: 688px;" >
           
          <legend>Contact Details</legend>
          <strong>Contact Country :</strong> <?php echo $contact_country; ?>   <br />  
          <strong>Contact State :</strong> <?php echo $contact_state; ?>   <br />
          <strong>Contact City :</strong>  <?php echo $contact_city; ?>   <br />
          <strong>Contact Address :</strong> <?php echo $contact_address; ?>   <br />
          <strong>Contact  ZIP/Postal :</strong> <?php echo $contact_zip; ?>   <br />
          <strong>Contact Position :</strong> <?php echo $contact_position; ?>   <br />
          <strong>Contact Phone :</strong> <?php echo $contact_phone; ?>   <br />
          <strong>Contact Fax :</strong> <?php echo $contact_fax; ?>   <br />
          <strong>Contact Google Code :</strong><xmp> <?php echo $contact_google_code; ?>  </xmp> <br />
          <strong>Contact Extra Information :</strong> <?php echo $contact_extra_info; ?>  <br />
          
          </fieldset> 
          
        </div>
    </div>
    <!--Right Colmn    --> 
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"><?php echo $right_menu; ?> </div>








</div>
 <div id="footer" style=" float: left; width: 1280px; height: 100px; background-color: #96C2E8;"></div>  
</body>
</html>