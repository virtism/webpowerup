<h2><?php echo $form_detail['form_title']; ?></h2>  

<div id="left" style="float: left; width: 688px; height: 760px;">
         <div  style="max-width: 688px; display:inline;">  
         
             <?php echo $form_detail['form_thank_u'];?>
			 <div style="color:#006600"> 
			 <?
			 	if($this->session->flashdata('payment_request'))
				{
					echo $this->session->flashdata('payment_request');				
				}
			 ?>
			 </div>
          
        </div>
    </div> 

