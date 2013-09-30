<table width="100%" border="0" cellspacing="0" cellpaddding="0">
<?php
  $this->load->view('services/services_menu_common');
?>
<tr>
    <td align="top">
        <h3>My Services</h3>
        
        <p>
        <a href="<?=base_url().index_page()?>services/add_service">Add a Service</a>
        </p>
        
        <table border="1" width="100%" cellpadding="2" cellspacing="0">
            <tr>
                <td width="20%"><b>Service</b></td>
                <td><b>Title</b></td>
                <td width="15%"><b>Action</b></td>
            </tr>
            <tr>
                <td>sample</td>
                <td>sample</td>
                <td><a href="javascript: void(0);">Edit </a>| <a href="javascript: void(0);">Remove</a></td>
            </tr>
        </table> 
        
        <p>
            There're no service added to show here.
        </p>   
        
    </td>
</tr>
</table>
