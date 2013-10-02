<?php

	/*****Showing the footer contents here*******/ 
               
	if(isset($footer_content)&&!empty($footer_content))
	{
		echo stripslashes($footer_content);
		//echo $footer_content;
	}

?> 