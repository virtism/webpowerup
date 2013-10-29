



<div>



    <h2>Thank You for subscribing to this group</h2>

    

    <div>
		<?
		if($this->config->item('seo_url') == 'On')
 		{		
		?>       		
			<a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/group_managment/" ?>"> Click here to see your groups </a>
		<?
		}
		else
		{ ?>
		
		 <a href="<?php echo base_url().index_page()."group_managment/" ?>"> Click here to see your groups </a>
		<? 
		}	
		?>
    </div>

    <br />

	<br />



    <div>

    <?php echo $this->session->flashdata('response'); ?>

    </div>



</div>