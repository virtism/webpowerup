<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Autoresponder :  <?php echo $respond_name; ?> </title>
</head>
<body>
	<div id="header" style=" height: 100px; background-color: #96CE8;">
	</div>
	<div id="main" style="width: 180px; background-color: black; height: 760;">
    <!--left Colmn    -->
    <div id="left" style="float: left; width: 80px; height: 760px; background-color: #F9F9F9"> 
		<?php echo $left_menu; ?> 
    </div>
    <!--manin inner content    -->
    <div id="left" style="float: left; width: 688px; height: 760px;">
         <div  style="max-width: 688px;"> <h1> <strong><?php echo $respond_name; ?>  Newsletter </strong>   </h1>  
  
          <fieldset>
           
          <legend>Subject</legend>
                 <?php echo $respond_subject; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>Body</legend>
                 <?php echo $respond_message_body; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>Reciepient Group</legend>
                <?php echo $respond_group; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>From Address </legend>
                <?php echo $respond_from_addrress; ?> 
             
          
          </fieldset>
                    <fieldset>
           
          <legend>Reply To Address </legend>
                <?php echo $respond_to_address; ?> 
             
          
          </fieldset>
       
          
          
        </div>
    </div>
    <!--Right Colmn    --> 
    <div id="left" style="float: left; width: 80px; height: 760px; background-color: #F9F9F9"><?php echo $right_menu; ?> </div>
	</div>
 <div id="footer" style=" float: left; width: 1
80px; height: 100px; background-color: #96C
E8;"></div>  
</body>
</html>