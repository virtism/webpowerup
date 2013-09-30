<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Success Payment</title>
</head>

<body>
<h1>Payment Submitted Successfully.</h1>
<br />
<?php
	
	if(!empty($product_download_url) && count($product_download_url))
	{
		for($i = 0; $i<1; $i++)
		{
		 
			
		?>
			<!--<a target="_blank" href="<?=$product_download_url[$i]?>" title="Download Link" >Click Here To Download</a><br /><br />-->
			<p style="color:#003300;"><b>Thank you order has submitted successfully please check your email for download product.If you do not receive an email in the next 15 minutes, please check your Junk Mail Folder.</b></p>
		<? 
			//exit;
		} 
		
	}
	?>
	
</body>
</html>