<script type="text/javascript">

	$(document).ready(function(e) {  
		$("#grid1 ul:odd").addClass("TableData");
		$("#grid1 ul:even").addClass("TableData AlterRow");
		$("#grid1 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
		$("#grid1 ul:last").removeClass().addClass("TableData AlterRow AddFieldRow");
		
		$("#grid2 ul:odd").addClass("TableData");
		$("#grid2 ul:even").addClass("TableData AlterRow");
		$("#grid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
		$("#grid2 ul:last").removeClass().addClass("TableData AlterRow AddFieldRow");
		
		$("#chkTic").click(function(e) {
            
			var isChk = $(this).attr("checked");
			
			if(isChk == "checked")
			{
				
				$("span.ticketSelect").find("input:checkbox").attr('checked','checked');
			}
			else
			{
				$("span.ticketSelect").find("input:checkbox").removeAttr('checked')
			}
			
        });
		
		$("#chkDep").click(function(e) {
            
			var isChk = $(this).attr("checked");
			
			if(isChk == "checked")
			{
				$("span.depSelect").find("input:checkbox").attr('checked','checked');
			}
			else
			{
				$("span.depSelect").find("input:checkbox").removeAttr('checked')
			}
			
        });
		
		$("#chk_departments").submit(function(e) {
           	var n = $("span.depSelect").find("input:checked").length;
			if(n > 1)
			{
				alert("Select only one department");
				return false;
			}
			return true;
        });
		
		
		
		
		// vertical tab animation 
		$("#depTab").hide();
		$("#btnTicTab").click(function(e) {
           
		    $("#depTab").fadeOut(250,
			function(){
			$("#ticTab").fadeIn();	
			});
			
			
        });
		
		$("#btnDepTab").click(function(e) {
           
			
			$("#ticTab").fadeOut(250,
			function(){
			$("#depTab").fadeIn();	
			});
        });
		// vertical tab animation
	});
	
	
	function check(chk)
	{
		
		if(chk.checked==true)
		// alert('checked');
		{
			document.chk_support_ticket.chk.checked = true;
		  
		}
		 if(chk.checked==false)
		 //alert('un-checked');  
		{
			document.chk_support_ticket.chk.checked = false;
		}
		
	}
	function checkall(field)
	{
	for (i = 0; i < field.length; i++)
	field[i].checked = true ;
	}
	
	function uncheckall(field)
	{
	for (i = 0; i < field.length; i++)
	field[i].checked = false ;
	}


	var formSub = true;
	
	function validate_checkbox() {
	  
	
	  
		var chks = document.getElementsByName('chk[]');
		var hasChecked = false;
		for (var i = 0; i < chks.length; i++)
		{
		  if (chks[i].checked)
		  {
		  hasChecked = true;
		  break;
		  }
		}
		if(formSub == false)
		{
		formSub = true;
		  return false;
		}
		else if (hasChecked == false)
		{
		  alert("Please select any Check Box.");
		  return false;
		}
		
		
		else
		{
		  return true;
		}
	  
	} 
 
	function assign_group()
	{
	var chks = document.getElementsByName('chk[]');
	var totalCheck = 0;
	for (var i = 0; i < chks.length; i++)
	{
		 if (chks[i].checked)
		 {
			totalCheck++;
		 }
	}
	if(totalCheck > 1)
	{
	  alert("Please select only one Check Box.");
	  formSub = false;
	  return false;
	}
	
	}
 
</script>

<style>

</style> 

<div class="RightColumnHeading">
    <h1 class="createroom">
        	<img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt=" Create New Department"/>
        <span>Manage Support Tickets</span>
    </h1>
</div>

<div class="PageDetail">
<h2>Welcome to Support Tickets </h2>
</div>

<div class="RightColumnHeading">
    <div class="LeftSideButton">
        <a href="javascript: void(0)" id="btnTicTab">
            <img src="<?=base_url();?>images/webpowerup/Tickets.png" alt="Tickets"/>
        </a>
    </div>
    
    <div class="RightSideButton">
        <a href="javascript: void(0)" id="btnDepTab">
            <img src="<?=base_url();?>images/webpowerup/Departments.png" alt="Departments"/>
        </a>
    </div>
</div>

<div id="vTabContainer">
    <div id="ticTab">
    <!--	ticket 		-->
    
        <div class="RightColumnHeading">
        
        <div class="LeftSideButton">
            <a href="<?=base_url().index_page();?>support_ticket/new_ticket">
                <img src="<?=base_url();?>images/webpowerup/NewTicket.png" alt="New Ticket"/>
            </a>
        </div>
    </div>
    
    <div class="DataGrid2" id="grid1">
           <form method="post" enctype="multipart/form-data" name="chk_support_ticket" action="<?=base_url().index_page()?>support_ticket" id="chk_support_ticket" onsubmit='return validate_checkbox()'>
                
                <ul>
                    <li class="Serial">
                        <input type="checkbox" name="txtbox" id="chkTic" />  
                    </li>
                    <li>Ticket No </li>
                    <li>Date </li>
                    <li>Subject </li>
                    <li>Department </li>
                    <li>Priority </li>
                    <li class="Actions">Action</li>
                </ul>
               
                <?php if ($query->num_rows() > 0)
                { 
					$counter = 1;
				?>  
                    
                    <span class="ticketSelect">
            			
                     <?php foreach($query->result() as $row)
                     { ?>   
                    <ul>
                        <li class="Serial">
                            
                            <input type="checkbox" name="chk[]" id="chk" value="<?=$row->t_id?>" > 
                            
                        </li>
                        <li>
                            <a href="<?=site_url()?>support_ticket/ticket_detail/<?=$row->t_id?>" style="text-decoration:underline;"><?=$counter++?></a>
                        </li>
                         <li>
                           <span class="GridCalendar"> <?=convert_mysql_date_format($row->t_open_date);?> </span>
                        </li>
                         <li>
                            <?=$row->t_subject?>
                        </li>
                        <li>
                            <?=$row->d_name?>
                        </li>
                        <li>
                            <?=$row->t_priority?>
                        </li>
                        <li class="Actions">
                            <a href="<?=base_url().index_page();?>support_ticket/delete_ticket/<?=$row->t_id?>" class="DeleteAction">
                                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                            </a>
                        </li>
                    </ul>
                    <?php 
                     } ?>
                  </span>
                 <?php 
                 
                 } 
                 
                 else
                 { ?>
                    <ul class="TableData">
                    <li>
                    <span class="NoData">
                    Sorry! No Record Found.
                    </span>
                    </li>
                    </ul>
                 <?php
                 } ?>
    
                <ul>
                <li>
                 <div class="AddMoreField">
                    <div class=" LeftLinks">
                    
                    </div>
                    
                    <div>
                    <input type="hidden" name="close_ticket" value="close_ticket">
                    <input type="image" src="<?=base_url();?>images/webpowerup/Close.png" alt="Close"/>
                    Close
                    </div>
                    
                 </div>
                </li>
                </ul>
                    
            </form>
       </div> 
            
    <div class="Space">
    </div>
    
    <!--	ticket 		-->
    </div>
    <div id="depTab">
    <!--	department 	-->
    
                
    <div class="RightColumnHeading">
        
        <div class="RightSideButton">
            <a href="<?=base_url().index_page();?>support_ticket/new_department">
                <input type="image" src="<?=base_url();?>images/webpowerup/NewDepartment.png" alt="New Department"/>
            </a>
        </div>
    </div>
       
     
    <div class="DataGrid2" id="grid2">
        <form  method="post" enctype="multipart/form-data" name="chk_departments"  action="<?=base_url().index_page();?>support_ticket/assign_department_form" id="chk_departments" onsubmit='return validate_checkbox();'>   
            <ul>
                <li class="Serial">
                    <input type="checkbox" name="txtbox" id="chkDep"  />  
                </li>
                <li>Department Name </li>
                <li>Users </li>
                <li>Manager </li>
                <li class="Actions">Action</li>
            </ul>
            
     
                <?php if ($dept_query->num_rows() > 0)
                { ?>  
                <span class="depSelect">
                    <?php foreach($dept_query->result() as $row)
                    { ?>
                 
                    <ul>
                        <li class="Serial">
                        <input type="checkbox" name="chk[]" id="chk" value="<?=$row->d_id?>" onClick="check(this)"> 
                        </li>
                         <li>
                           <?=$row->d_name?>
                        </li>
                        <li>
                          <?=$row->d_users?>
                        </li>
                        <li>
                            <?=$row->user_fname?>&nbsp;<?=$row->user_lname?>
                        </li>
                        <li class="Actions">
                            <a href="<?=base_url().index_page();?>support_ticket/delete_department/<?=$row->d_id?>" class="DeleteAction">
                                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                            </a>
                        </li>
                    </ul>
                     <?php 
                    } ?>  
                    </span>
                <?php 
                } 
                else
                { ?>
                <ul class="TableData">
                <li>
                <span class="NoData">
                Sorry! No Record Found.
                </span>
                </li>
                </ul>
                <?php
                } ?>
            
            <ul>
            <li>
             <div class="AddMoreField">
                <div class=" LeftLinks">
                </div>
                
                <input type="hidden" name="group_dept" value="group_dept" >
                <input type="image" src="<?=base_url();?>images/webpowerup/5.png" alt="Assign Group"/>
                Assign Group
                </a>
             </div>
            </li>
            </ul>
        </form>
           
    </div>
    <div class="Space">
    </div>
    
    <!--	department 	-->
    </div>
</div>