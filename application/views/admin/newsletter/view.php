
<div id="header" style=" height: 100px; background-color: #96C2E8;"></div>
<div id="main" style="width: 1280px; background-color:; height: 760;">
    <!--left Colmn    -->
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"> <?php echo $left_menu; ?> </div>
    <!--manin inner content    -->
    <div id="left" style="float: left; width: 688px; height: 760px;">
         <div  style="max-width: 688px;"> <h1> <strong><?php //echo $box_title; ?>  Newsletter </strong>   </h1>  
  
          <fieldset>
           
          <legend>Sunject</legend>
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
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9;"><?php echo $right_menu; ?> </div>
    
    
</div>
 <div id="footer" style=" float: left; width: 1280px; height: 100px; background-color: #96C2E8;"></div>  
