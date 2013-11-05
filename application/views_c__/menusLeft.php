<?php 
$resultMenu = $this->Menus_Model->getMenu("Left", "EveryOne");
foreach($resultMenu->result_array() as $rowMenu):
    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);
    $boolDisplay=false;
    if($rowMenu['menu_published']=='Yes'){
        $boolDisplay = true;
    }
    else{          
        $dateStart = strtotime($rowMenu['menu_start']);
        $dateEnd = strtotime($rowMenu['menu_end']);
        $dateToday = strtotime(date("Y-m-d h:i:s"));          
        if($dateStart<$dateToday && $dateEnd>$dateToday){
            $boolDisplay = true;
        }
    }
    if($boolDisplay == true){?>
<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px black;margin-top:8px;">
    <tr>
        <td align="center"><div style="background-color:black;color:white;font-weight:bold"><?=$rowMenu['menu_name'];?></div></td>
    </tr>
    <tr>
        <td>
        <?php if($resultMenuItem->num_rows()>0){?>
        <ul>
            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):
            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);
            $rowPage = $resultPage->row_array();?>
            <li><a href="<?=base_url().index_page()?>site/page/<?=$rowPage["page_seo_url"];?>"><?=$rowMenuItem["item_name"];?></a></li>
            <?php endforeach;?>            
        </ul></td>
        <?php
        }
        else{?>&nbsp;<?php
        }?>
    </tr>
</table>
    <?php
    }
endforeach;?>
<?php 
$resultMenu = $this->Menus_Model->getMenu("Left", "Registered");
foreach($resultMenu->result_array() as $rowMenu):
    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);
    $boolDisplay=false;
    if($rowMenu['menu_published']=='Yes'){
        $boolDisplay = true;
    }
    else{          
        $dateStart = strtotime($rowMenu['menu_start']);
        $dateEnd = strtotime($rowMenu['menu_end']);
        $dateToday = strtotime(date("Y-m-d h:i:s"));          
        if($dateStart<$dateToday && $dateEnd>$dateToday){
            $boolDisplay = true;
        }
    }
    if($boolDisplay == true){?>
<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px black;margin-top:8px;">
    <tr>
        <td align="center"><div style="background-color:black;color:white;font-weight:bold"><?=$rowMenu['menu_name'];?></div></td>
    </tr>
    <tr>
        <td>
        <?php if($resultMenuItem->num_rows()>0){?>
        <ul>
            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):
            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);
            $rowPage = $resultPage->row_array();?>             
            <li><a href="<?=base_url().index_page()?>site/page/<?=$rowPage["page_seo_url"];?>"><?=$rowMenuItem["item_name"]?></a></li>
            <?php endforeach;?>            
        </ul></td>
        <?php
        }
        else{?>&nbsp;<?php
        }?>
    </tr>
</table>
<?php
    }
endforeach;?>
<?php 
$resultMenu = $this->Menus_Model->getMenu("Left", "Other");
foreach($resultMenu->result_array() as $rowMenu):
    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);
    $boolDisplay=false;
    if($rowMenu['menu_published']=='Yes'){
        $boolDisplay = true;
    }
    else{          
        $dateStart = strtotime($rowMenu['menu_start']);
        $dateEnd = strtotime($rowMenu['menu_end']);
        $dateToday = strtotime(date("Y-m-d h:i:s"));          
        if($dateStart<$dateToday && $dateEnd>$dateToday){
            $boolDisplay = true;
        }
    }
    if($boolDisplay == true){?>
<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px black;margin-top:8px;">
    <tr>
        <td align="center"><div style="background-color:black;color:white;font-weight:bold"><?=$rowMenu['menu_name'];?></div></td>
    </tr>
    <tr>
        <td>
        <?php if($resultMenuItem->num_rows()>0){?>
        <ul>
            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):
            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);
            $rowPage = $resultPage->row_array();?>            
            <li><a href="<?=base_url().index_page()?>site/page/<?=$rowPage["page_seo_url"];?>"><?=$rowMenuItem["item_name"]?></a></li>
            <?php endforeach;?>            
        </ul></td>
        <?php
        }
        else{?>&nbsp;<?php
        }?>
    </tr>
</table>
<?php
    }
endforeach;?>