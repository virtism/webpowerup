

<div>

    <h2>Thank You your group was upgraded successfully</h2>
    
    <div>
        <a href="<?php echo base_url().index_page()."group_managment/" ?>"> Click here to see your groups </a>
    </div>
    <br />
	<br />

    <div>
    <?php echo $this->session->flashdata('response'); ?>
    </div>

</div>