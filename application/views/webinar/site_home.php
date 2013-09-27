  <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $form_title; ?> </title>

</head>
<body>
	<div id="left" style="float: left; width: 688px; height: 760px;">
		 <div  style="max-width: 688px;"> 
		 <?					
			if($this->session->flashdata('message'))
			{
				echo '<div style=" color:#009900; padding-bottom:25px;">'.$this->session->flashdata('message').'</div>';
				//echo '<pre>'; print_r($form_data); exit;
				
				
				if(!empty($form_data['is_paid']) && !empty($form_data['webinar_amount']))
				{
					
								
				?>
					<form  action="<?=$this->paypal_lib->paypal_url?>" method="post" id="paypalForm" class="niceform" >
					<input type="hidden" name="cmd" value="_xclick">
					<!--<input type="hidden" name="upload" value="1">-->
					<input type="hidden" name="business" value="<?=$payPal_id?>">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="rm" value="2">   
					<input type="hidden" name="return" value="<?=site_url()?>webinar_site/submit_webinar/<?=$form_data['site_id']?>/<?=$form_data['id']?>">
					<input type="hidden" name="cancel_return" value="<?=current_url()?>">
					<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
					<input type="hidden" name="item_name" value="<?=$form_data['title']?>">
					<input type="hidden" name="item_number" value="<?=$form_data['id']?>">
					<input type="hidden" name="quantity" value="1">
					<input type="hidden" name="amount" id="price" value="<?=$form_data['webinar_amount']?>">
					<input type="hidden" name="custom" value="<?=$this->session->flashdata('customer_id')?>">					
					<input id="btnPaypal" style="margin:10px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
							
		 <? 
		 		}
		 } if($this->session->flashdata('pay') != 1){ 
		 	echo '<div style=" color:#009900; padding-bottom:25px;">'.$this->session->flashdata('webinar_error').'</div>';
		 ?>	 
			<form action="<?=base_url().index_page().'webinar_site/submit_webinar/'.$webinar_id?>" method="post">
			
				<h1>
					<strong><?php if(isset($form_data['title'])){ echo $form_data['title']; } ?> </strong>
				</h1>  
				<?
					if(isset($form_data['form_intro']))
					{
						echo $form_data['form_intro'];
						echo "<br>";
					}
					
					
				?>
				<div style=" color:#FF0000; padding-bottom:25px;">
					<? if(isset($error)){ echo str_replace('0','',$error); }?>
				</div>
				
                <table>
				<?php				
					if($webinar_default_fields)
					{
						$n = count($webinar_default_fields); 
						
						for($i=0; $i<$n; $i++ )
						{
							 $required = ($webinar_default_fields[$i]['required']=='Yes')? '*' : '';
							 echo  "<tr><td>".$webinar_default_fields[$i]['label'].' '.$required."</td>"; 
							 ?>
							 <input type="hidden" name="required_<?=$i?>" value="<?=$webinar_default_fields[$i]['required']?>"  />
							 <?
							 echo  "<td>".$webinar_default_fields[$i]['field']."</td></tr>"; echo " \t";
							
							 echo  $webinar_default_fields[$i]['id'];  
						}
		            
					}
					
					if($form_fields)
					{
						//echo "<pre>";print_r($form_fields);
						echo form_hidden('action','done');
						if(isset($form_data['form_id']))
						{
							echo form_hidden('form_id',$form_data['form_id']);
						}

						$n = count($form_fields); 
						for($i=0; $i<$n; $i++ )
						{
							 $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
							 echo  "<tr><td>".$form_fields[$i]['label'].' '.$required."</td>"; 	
							if(isset($form_fields[$i]['options']) && !empty($form_fields[$i]['options']))
							{
								echo "<td><table><tr>";	
								for($j=0; $j<count($form_fields[$i]['options']); $j++ )
								{
								
									echo  "<td>".$form_fields[$i]['options'][$j]['label'].": ".$form_fields[$i]['options'][$j]['field'].$form_fields[$i]['options'][$j]['id']."</td>"; echo " \t";
								}
								echo "</tr></table></td></tr>";
								
							}else
							{
								if(isset($form_fields[$i]['field']))
								{
									echo  "<td>".$form_fields[$i]['field']."</td>"; echo " \t";
								 	echo  $form_fields[$i]['id']; 
								}
								echo "</tr>";
							} 
							
						}
		              
					}
					?> 
                  </table>      
			<input type="submit" value="Submit" />
		</form>	          
		
		<? } ?>
		</div>
	</div>
</body>
</html>
