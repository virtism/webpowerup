<html>
<head>
<title>Web Builder - Preview</title>
</head>
<body>
<table align="center" width="960" height="500" border="1" cellspacing="0" cellpadding="0">
<tr height="100">
    <td colspan="3"><h3>Header will ge here.</h3></td>
</tr>
<tr>
    <td width="18%" valign="top">
    <!--LEFT MENUS AREA START -->
    <?php $this->load->view("menusLeft");?>    
    &nbsp;<!--LEFT MENUS AREA END-->
    </td>
    <td valign="top"><p>Page body will go here.</p></td>
    <td valign="top" width="18%">
    <!--RIGHT MENUS AREA START-->
    <?php $this->load->view("menusRight");?>    
    &nbsp;<!--RIGHT MENUS AREA END-->
    </td>
</tr>
<tr height="60">
    <td colspan="3">Footer will go here.</td>
</tr>
</table>
</body>
</html>

