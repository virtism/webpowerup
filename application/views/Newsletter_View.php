<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Newsletter <?php //echo $box_title; ?> </title>

</head>
<body>
<div id="header" ></div>
<div id="main">
    <!--left Colmn    -->
    <?php /*?><div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"> <?php echo $left_menu; ?> </div><?php */?>
    <!--manin inner content    -->
    <div id="left" style="float: left; width: 688px; height: 760px;">
         <div  style="max-width: 688px;"> <h1> <strong><?php //echo $box_title; ?>  Newsletter </strong>   </h1>  
  
          <fieldset>
           
          <legend>Subject</legend>
                 <?php echo $news_subject; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>Body</legend>
                 <?php echo $news_body; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>Reciepient Group</legend>
                <?php echo $news_recipient_group; ?> 
             
          
          </fieldset>
          <fieldset>
           
          <legend>Created Date </legend>
                <?php echo $news_date_created; ?> 
             
          
          </fieldset>
                    <fieldset>
           
          <legend>Sent Date </legend>
                <?php echo $news_date_sent; ?> 
             
          
          </fieldset>
       
          
          
        </div>
    </div>
    <!--Right Colmn    --> 
    <?php /*?><div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"><?php echo $right_menu; ?> </div><?php */?>








</div>
 <div id="footer" ></div>  
</body>
</html>