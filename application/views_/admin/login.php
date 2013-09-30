<form id="frmLogin" method="POST" action="<?=base_url().index_page()?>administrator/login/verify">
    <table align="center" width="400" border="0" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2">
                <h3>Administrator Login:</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_login">User Login:</label>
            </td>
            <td>
                <input type="text" id="user_login" name="user_login" value="<?=$user_login?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_password">Password:</label>
            </td>
            <td>
                <input type="password" id="user_password" name="user_password" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="Log In" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="color: red; font: italic; font-size: 12px;">
                    <?=$message?>
                </span>
            </td>
        </tr>
    </table>
</form>