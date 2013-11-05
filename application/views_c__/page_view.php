<html>
<head>
<title><?=$site_name?> - <?=$page_title?></title>
<meta name="description" content="<?=$page_desc?>" />
<meta name="keywords" content="<?=$page_keywords?>" />
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.slideshow').cycle({
        fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    });
});
</script>
</head>
<body>
<?php
    $flagShowPage = false;
        
    if($page_status == "Published")
    {
        $flagShowPage = true;        
    }
    else if($page_status == "Schedule")
    {
        $page_start_date = strtotime($page_start_date); 
        $page_end_date = strtotime($page_end_date);
        $date_today = strtotime(date("Y-m-d h:i:s"));
        if($page_start_date < $date_today && $page_end_date > $date_today)
        {
            $flagShowPage = true;        
        }               
    }
    
    if($flagShowPage == false)
    {
        echo "<h1>This page is ".$page_status."</h1>";
        echo "<p>So, your access to this page is restricted.</p>";    
        exit();        
    }
    
    if($page_access == "Registered")
    {
        if($this->session->userdata("user_id") != "")
        {
            $flagShowPage = true;            
        }
        else
        {
            $flagShowPage = false;               
        }
    }
    else if($page_access == "Other")
    {
        $role_id = $this->session->userdata("role_id");
        if($this->Pages_Model->isPageRole($page_id, $role_id) == true)
        {
            $flagShowPage = true;        
        }  
        else
        {
            $flagShowPage = false;                  
        }      
    }
    else//Everyone case
    {
        $flagShowPage = true;            
    }
    
    if($flagShowPage == false)
    {
        echo "<h1>Access Is Restricted </h1>";
        echo "<p>Your access to this page has been restricted.</p>";    
    }
    else
    {
?>
<table align="center" width="960" height="500" border="1" cellspacing="0" cellpadding="0">
<tr height="100" valign="top">
    <td colspan="3">
        <?php
        if($page_header != "Slideshow")
        {?>
            <div style="height: 100px; background-image: url('<?=$header_image;?>'); background-repeat:no-repeat; background-size:960px 100px;">
            </div>    
        <?php
        }
        else
        {?>
            <div class="slideshow">
                <?php
                foreach($header_image->result_array() as $rowImage)
                {   
                ?>
                    <img src="<?=base_url();?>headers/<?=$rowImage["header_image"]?>" width="960" height="100" />
                <?php
                }
                ?>
            </div>    
        <?php
        }
        ?>
        
    </td>
</tr>
<tr style="background-image: url('<?=$background_image?>'); background-repeat: no-repeat; background-size:100% 100%">
    <td width="18%" valign="top">
        
        <!--LEFT MENUS AREA START -->
        
        <?php 
        $data["page_id"] = $page_id;
        $this->load->view("pageMenusLeft", $data);?>    
        &nbsp;<!--LEFT MENUS AREA END-->
        
    </td>
    
    <td valign="top">
    
        <?=$page_content?>
    
    </td>
    
    <td valign="top" width="18%">
    
        <!--RIGHT MENUS AREA START-->
        <?php $this->load->view("pageMenusRight", $data);?>    
        &nbsp;<!--RIGHT MENUS AREA END-->
        
    </td>
    
</tr>

<tr height="60">

    <td colspan="3">Footer will go here.</td>
    
</tr>
</table>
<?php
    }
?>
</body>
</html>

