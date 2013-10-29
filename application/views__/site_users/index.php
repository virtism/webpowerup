<h1>Users</h1>

<p>
    <a href="<?=base_url().index_page()?>site_users/create">Create a User</a>
</p>

<table width="100%" border="1" cellspacing="0" cellpadding="0"> 
    <tr>
        <th>Username</th>
        <th>Fullname</th>
        <th>Email address</th>
        <th>Logged in?</th>
        <th>Enabled?</th>
    </tr>
    <?php
    if(sizeof($arrUsers)==0)
    {
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php
    }
    ?>
    <?php
    }
    ?>
    <tr>
        <td colspan="5">No records found.</td>
    </tr>
    <?php    
    }
    ?>
</table>