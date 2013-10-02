<!--
<h1>Newsletter</h1>

<h3>Newsletters</h3>
<ul>
    <li>
        <a href="<?=base_url().index_page()?>Newsletter_Management/">Create a Newsletter</a>
    </li>
    <li>
        <a href="javascript: void(0);">Manage Newsletters</a>
    </li>
</ul>
-->
<h1>Newsletter Management </h1>

<p align="center"><h2></h2></p>

<fieldset>
<legend>Newsletter Details</legend>
    <table border="0" align="left" cellpadding="2" cellspacing="3" bgcolor="#F9F9F9">
        
        <tr>
            <td colspan="5"> Here All Records of Newsletters </td>
            <td colspan="2"><a href="<?php echo base_url().index_page() ?>administrator/newsletter/create">Create New Newsletter </a></td>
        </tr>
        <tr bgcolor="#DEDDDD">
            <th> Newsletter Subject</th>
            <th> Newsletter Body</th>
            <th>Recipients Group</th>
            <th>Newsletter Created</th>
            <th>Newsletter Send</th>
            <th>ACTIONS / </th> 
        </tr>
            <?php  echo $view_all_records;?>
        <tr>
            <td colspan="7" bgcolor="#DEDDDD"> &nbsp; </td>
        </tr>
    
    </table>
</fieldset>


