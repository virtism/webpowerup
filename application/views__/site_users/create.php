<h1>Create a User</h1>   
 
<form id="frmCreateUser" method="post" action="<?=base_url().index_page()?>site_users/create">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <strong>Username</strong>
            <hr />
            <input type="text" id="user_login" name="user_login" />
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <strong>Create a Password</strong>
            <hr /> 
            <label>
            Password:
            <input type="password" id="user_password" name="user_password" />
            </label>
            <br />
            <label>
            Confirm:
            <input type="password" id="confirm_password" name="confirm_password" />
            </label>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <strong>Full Name</strong>
            <hr /> 
            <input type="text" id="user_fullname" name="user_fullname" />
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <strong>Email Address</strong>
            <hr /> 
            <input type="text" id="user_email" name="user_email" />
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <strong>Group(s)</strong>
            <hr /> 
            <select id="user_groups" name="user_groups">
                <option value="0">Public</option>
            </select>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <strong>Enabled?</strong>
            <hr /> 
            <label>
                <input type="radio" id="user_enabled" name="user_enabled" valu="Yes" />
                Yes
            </label>
            <br />
            <label>
                <input type="radio" id="user_enabled" name="user_enabled" valu="Yes" />
                No
            </label>
            <br /><br />
        </td>
    </tr>
    <tr>
        <td>
            <br />
            <input type="submit" value="Create User" />
        </td>
    </tr>
</table>
</form>