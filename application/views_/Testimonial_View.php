<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Testimonial pafe:  <?php //echo $respond_name; ?> </title>

</head>
<body>
<div id="header" style=" height: 100px; background-color: #96C2E8;"></div>
<div id="main" style="width: 1280px; background-color: black; height: 760;">
    <!--left Colmn    -->
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"> <?php echo $left_menu; ?> </div>
    <!--manin inner content    -->
    <div id="left" style="float: left; width: 688px; height: auto;">
         <div  style="max-width: 688px;"> <h1> <strong><?php // echo $respond_name; ?>  Testimonial and Reviews </strong>   </h1>  
  
          <fieldset>
           
          <legend>Testimonial</legend>
                 <?php echo $monial_page_body; ?> 

          
          </fieldset>
          
          <fieldset>
     
          <legend> Business Reviews</legend>
 <?php
    $n= count($reviews);
   // echo $n.'<pre>';
    //print_r($reviews);
    for($i=0; $i<$n;$i++){
?>         
             <fieldset>        
            <legend> <b><?php echo $reviews[$i]['review_submitter']; ?></b>   ,  <?php echo $reviews[$i]['review_date']; ?>   </legend>
                 
                 
                 <?php echo $reviews[$i]['review_reviews']; ?>
                 <br />
                 
                 <span> Rating : 
                 <?php echo $reviews[$i]['review_rating']; ?> 
                 </span>
             
          
          </fieldset>
          
          
<?php
    }
?>                
             
          
          </fieldset>

        <fieldset>
           
          <legend>Put Business Reviews</legend>
           <?php
 
    $attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
    echo form_open(base_url().index_page().'Testimonial_Management/create_reviews', $attributes); 
    echo form_hidden('monial_id',$monial_id);
        
   $name = array('name' => 'submitter','id' => 'submitter', 'size' => '40', 'value' => set_value('submitter','Submitter '));
   $rating = array('name' => 'rating','id' => 'rating', 'size' => '40', 'value' => set_value('rating','5'));       
   $review = array('name'  => 'review', 'id' => 'ck_content','value'  => set_value('review','Business Review'));       
?>

  
  <p>
  Submitter :  <?php echo form_input($name); ?>   <br />  
  Rating    :  <?php echo form_input($rating); ?> <br />
  Reviews    :   <?php echo form_textarea($review); ?>  <br />
        
</p> 
  <p>
          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
    </p>
<?php echo form_close();?>

          
          </fieldset>
       
          
          
        </div>
    </div>
    <!--Right Colmn    --> 
    <div id="left" style="float: left; width: 280px; height: 760px; background-color: #F9F9F9"><?php echo $right_menu; ?> </div>








</div>
 <div id="footer" style=" float: left; width: 1280px; height: 100px; background-color: #96C2E8;"></div>  
</body>
</html>