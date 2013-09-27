
<form id="frmAddService" action="<?=base_url().index_page()?>services/add" method="post">
    <input type="hidden" name="site_id" value="" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <?php
        $this->load->view('services/services_menu_common');
        ?>
        <tr>
            <td>
                 <h2>Add a Service</h2>
                 
                 <table width="100%" border="0" cellpadding="0" cellspacing="3">
                    <tr>
                        <td width="20%" align="right">
                            Service
                        </td>
                        <td>
                            <select id="lstService" name="lstService">
                                <option>Select a Service</option>
                                <option>Tutorworks</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            Title
                        </td>
                        <td>
                            <input type="text" id="service_title" name="service_title" />    
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">Description</td>
                        <td>
                            <textarea id="service_desc" name="service_desc" cols="40" rows="15"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td>
                            <input type="submit" value="Submit" />
                        </td>
                    </tr>
                    </table>
                 
            </td>
        </tr>

    </table>
</form>