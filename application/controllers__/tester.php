<?php

class Tester extends CI_Controller{
	
	
	function index()
	{ 
			$path = "media/ckeditor_uploads/numan@virtism.com_109/test"; 
			if( mkdir($path) )
			{
		
				echo "ok";
			}
			else
			{
				echo "nope";
			}
			chmod($path,0777);
	}
	
	function changeP() 
	{
		$path = "media/ckeditor_uploads/numan@virtism.com_109/test"; 
		chmod($path,0777);
	}
}

?>