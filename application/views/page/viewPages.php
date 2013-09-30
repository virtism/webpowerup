<style type="text/css">
    div#actionMenu li {
        display: inline;
        list-style-type: none;
        padding-right: 20px;
    }
    div#actionMenu {
        margin-top:10px;
        margin-bottom:10px; 
    }

</style>
<script language="javascript" type="text/javascript">
    function isChecked(){
        for(i=1;i<='<?=$numRecords?>';i++){
            if(document.getElementById('chkPage'+i).checked==true){
                return true;            
            }
        }
        return false;
    }
    function publishPage(){    
        if(isChecked() == true){

            form = document.getElementById('frmPages');
            form.action = "<?=base_url().index_page()?>pagesController/publishPage/<?=$site_id?>";
            form.submit();
        }
        else{
            window.alert("No page(s) selected. Please select page(s) first to continue.");
            return;
        }    
    }
    function unpublishPage(){    
        if(isChecked() == true){
            form = document.getElementById('frmPages');
            form.action = "<?=base_url().index_page()?>pagesController/unpublishPage/<?=$site_id?>";
            form.submit();
        }
        else{
            window.alert("No page(s) selected. Please select page(s) first to continue.");
            return;
        }    
    }
    function deletePage(){    
        if(isChecked() == true){

            var msg = confirm("Are you sure you want to Delete?");
            if(msg)
                {
                form = document.getElementById('frmPages');
                form.action = "<?=base_url().index_page()?>pagesController/trashPage/<?=$site_id?>";
                form.submit();    
            }
            return false;
        }
        else{
            // Define changes to default configuration here. For example:
            // l = window.location;
            // var base_url = l.host + "/" ;
            // window.alert(base_url);
            window.alert("No page(s) selected. Please select page(s) first to continue.");
            return;
        }    
    }
    function selectAllPage(){
        state = document.getElementById('chkPageAll').checked;    
        for(i=1;i<='<?=$numRecords?>';i++){        
            document.getElementById('chkPage'+i).checked=state;        
        }       
    }


    $(document).ready(function(e) {  
        $(".DataGrid2 ul:odd").addClass("TableData");
        $(".DataGrid2 ul:even").addClass("TableData AlterRow");
        $(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
    });



    $("NFSelectRight").live("click",function(){
        var id = $(this).next("input").attr("id");
        alert(id);


    });
</script>

<div class="RightColumnHeading">
    <h1>
        <span>Manage My Pages</span>
    </h1>
    <div class="RightSideButton">
        <a href="javascript: void(0)" onClick="return deletePage()">
            <img src="<?=base_url()?>images/webpowerup/Trash.png" alt="Trash"/>
        </a>
        <a href="javascript: void(0)" onClick="unpublishPage()">
            <img src="<?=base_url()?>images/webpowerup/Unpublish.png" alt="Unpublish"/>
        </a>
        <a href="javascript: void(0)" onClick="publishPage()">
            <img src="<?=base_url()?>images/webpowerup/Publish.png" alt="Publish"/>
        </a>
        <a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$site_id?>">
            <img src="<?=base_url()?>images/webpowerup/New.png" alt="New"/>
        </a>
    </div>
</div>
<div class="clr"></div>

<div class="InnerMain2">

    <div class="form">

        <div class="DoubleColumn">
            <span style="padding:0 0 0 10px;" >Your current homepage is</span>
            <form class="niceform" id="frmSetAsHomepage" name="frmSetAsHomepage" method="post" action="<?=base_url().index_page()?>pagesController/setAsHomepage/<?=$site_id?>">

                <div class="ColumnA">

                    <ul>
                        <li> 
                            <div style=" float:left; width:100%; position:relative;">

                                <select size="1" style="width:300px" id="page_id_home" name="page_id_home" onChange="this.form.submit()" >  
                                    <?php 
                                        foreach($pages_list->result_array() as $row_pages_list)
                                        {
                                            if($this->Pages_Model->isHomepage($row_pages_list["page_id"]))
                                            {
                                                $strSelected = 'selected="selected"';
                                            }
                                            else
                                            {
                                                $strSelected = ""; 
                                            }    
                                        ?>
                                        <option value="<?=$row_pages_list['page_id'];?>" <?=$strSelected;?>><?=$row_pages_list['page_title'];?></option>
                                        <?php    
                                        }
                                    ?>
                                </select>
                            </div>

                        </li>
                    </ul>
                </div>
            </form>
            <form  id="frmSearchPage" name="frmSearchPage" method="post" action="<?=base_url().index_page()?>pagesController/searchPage/<?=$site_id?>/0"> 
                <div class="ColumnB">
                    <ul>
                        <li>
                            <input type="text" id="page_title" name="page_title"  value="<?=$search_page_title;?>" size="35" />
                        </li>
                    </ul>
                </div>

                <div class="ButtonRow">

                    <button type="submit" class="SearchButton">
                        <img src="<?=base_url()?>images/webpowerup/SearchGreen.png" alt="SearchGreen"/>
                    </button>

                </div>
            </form>

        </div>

    </div>

    <form  id="frmPages" name="frmPages" method="post" action="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0" >
        <div class="DataGrid2">

            <ul>
                <li class="Serial">
                    <input type="checkbox" value="0" name="chkPageAll" id="chkPageAll" onClick="selectAllPage()"  />  
                </li>
                <li>Title</li>
                <li>Page Templates</li>
                <li>Access Level</li>
                <li>Status</li>
                <li>Last Modified</li>
            </ul>


            <?php 
               // echo "<pre>";print_r($pages_templates);
                $intCount = 0;
                foreach($records->result_array() as $row)
                {
                    $intCount++;
                ?>
                <ul >
                    <li class="Serial" style="height:42px;">
                        <?php
                            $strDisabled = '';
                            if($this->Pages_Model->isHomepage($row["page_id"]))
                            {
                                $strDisabled = 'disabled="disabled"';
                            }
                        ?>
                        <input type="checkbox" value="<?php echo $row['page_id'];?>" name="chkPage[]" id="chkPage<?php echo $intCount;?>" <?=$strDisabled?>  />  
                    </li>
                    <li>
                        <a target="_blank" href="<?=base_url().index_page()?>page_editor/index/<?=$site_id?>/<?php echo $row['page_id'];?>" class="activelink"><?php echo $row['page_title'];?></a>
                    </li>
                    <? 
                    $isexists = 0;
                        for($i = 0;$i<count($pages_templates);$i++)
                        {
                            if($pages_templates[$i]['page_id'] == $row['page_id'])
                            {
                                $isexists = 1;
                            ?>
                            <li>
                                <a target="_blank" href="<?=base_url().index_page()?>pagesController/layout_desc_edit/<?=$site_id?>/<?php echo $row['page_id'];?>/<?php echo $pages_templates[$i]['id'];?>" class="activelink"><?php echo $pages_templates[$i]['temp_option_name_field'];?></a>
                            </li>
                            <?
                                break;
                            }
                    } if($isexists ==0){
                        $isexists = 0;
                        ?>
                    
                       <li></li> 
                 <?   }   ?>            
                    <li>
                        <?php 

                            if($row['page_access'] == "Other")
                            {
                                //echo $this->Pages_Model->get_page_access_title($row['page_id']);    
                                echo $row['page_access'];
                            }
                            else
                            {
                                echo $row['page_access'];
                            }

                        ?>
                    </li>
                    <li>
                        <?php echo $row['page_status'];?>
                    </li>
                    <li>
                        <?php
                            $page_modified_date = strtotime($row['page_modified_date']);
                            $page_modified_date = date('M. d, Y (h:i a)', $page_modified_date);        
                            echo $page_modified_date;
                        ?>
                    </li>
                </ul>

                <?php
            } ?>



        </div>
        <div class="pageDiv">
            <?php echo $paging;?>
            <br />
            Display # 
            <select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
                <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
                <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
                <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
            </select>
            Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
        </div>
    </form>    
</div>