<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login form</title>
<?
//echo base_url();exit;
?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/buttons.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/gallery.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/shadows.css">
</head>
<body>
<? echo $msg;?>
<form name="user", method="post" action="<?=base_url().index_page()?>UserController/login/">
<h5>Email</h5>
<input type="text" name="email" value="" size="50" />

<h5>Password</h5>
<input type="password" name="password" value="" size="50" />
<div><input type="submit" value="Login" /><a href="<?=base_url().index_page()?>UserController/signup/"> Sign Up</a></div>
</form>

</body>
</html>