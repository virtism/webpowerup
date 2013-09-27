  <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $form_title; ?> </title>

</head>
<body>
	<div id="left" style="float: left; width: 688px; height: 760px;">
		 <div  style="max-width: 688px;"> 
		 
		
			
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
				
				<?php
					if($webinar_default_fields)
					{
						
						$n = count($webinar_default_fields); 
						for($i=0; $i<$n; $i++ )
						{
							 echo  $webinar_default_fields[$i]['label']; echo $required = ($webinar_default_fields[$i]['required']=='Yes')? '*' : '';  echo " \t";
							 echo  $webinar_default_fields[$i]['field'];    echo " \t";
							 echo "<br/>"; 
							 echo  $webinar_default_fields[$i]['id'];  echo "<br/>";
						}
		
					}
					
					if($form_fields)
					{
						echo form_hidden('action','done');
						if(isset($form_data['form_id']))
						{
							echo form_hidden('form_id',$form_data['form_id']);
						}

						$n = count($form_fields); 
						for($i=0; $i<$n; $i++ )
						{
							 echo  $form_fields[$i]['label']; echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';  echo " \t";
							 echo  $form_fields[$i]['field'];    echo " \t";
							 echo "<br/>"; 
							 echo  $form_fields[$i]['id'];  echo "<br/>";
						}
		
					}
					?> 
			<input type="submit" value="Submit" />
		</form>	          
		</div>
	</div>
</body>
</html>
