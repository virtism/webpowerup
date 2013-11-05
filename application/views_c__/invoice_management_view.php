<script type="text/javascript">
function popUp(invoice_id) 
{
	var url = "<?=base_url().index_page()?>invoice/create_view_invoice/"+invoice_id;
    var  popupWindow = window.open(url,'','height=600,width=600,left=0,top=0,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function deleteForm()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
  else
     return false;
	
}
$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});
</script>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Invoice"/>
        <span>Invoice Management</span>
    </h1>
    <div class="RightSideButton">        
        <a href="<?=base_url().index_page();?>invoice/index">
        	<img src="<?=base_url()?>images/webpowerup/create-invoice.png" />
        </a>
    </div>
    
</div>
<div class="form">

    	<div class="DoubleColumn">
        <span style="padding:0 0 0 10px;" ></span>
        <form class="niceform" id="" name="" method="post" action="<?=site_url();?>invoice/invoice_managment_view/">
        <input type="hidden" name="action" value="search" />
        <div class="ColumnA">        
            <ul>
                <li> 
                    <div style=" float:left; width:100%; position:relative;">
                    <select size="1" style="width:300px" id="page_id_home" name="page_id_home" >  
                        <option value="">Select Option</option>
                        <option value="customer_fname">First Name</option>
                        <option value="customer_lname">Last Name</option>
                        <option value="customer_email">Mail ID</option>
                    </select>
                    </div>
                    
                 </li>
            </ul>
        </div>
        
        <div class="ColumnB">
            <ul>
            <li>
             <input type="text" id="search_value" name="search_value"  value="" size="35"  placeholder="Search Value"/>
             </li>
            </ul>
        </div>
        
        <div class="ButtonRow">
         <?
         
		 	if($this->session->flashdata('search_error'))
			{
				?>
				<p style="font-weight:bold; color:#000099;"><?=$this->session->flashdata('search_error')?></p>
				
				<?
			}
		 
		 ?>       
        <button type="submit" class="SearchButton">
            <img src="<?=base_url()?>images/webpowerup/SearchGreen.png" title="Search Invoice" alt="SearchGreen"/>
        </button>
        
        </div>
        </form>
     
    </div>

</div>

<!--Search Result-->
<? //echo "<pre>";print_r($search_array_result);exit;?>

<? if(!empty($search_array_result) && count($search_array_result)>0)
{ 

?>
    <div class="RightColumnHeading">
        <h1>
            <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Invoice"/>
            <span>Search Results</span>
        </h1>
	</div>
    <div class="DataGrid2">
    
            <ul>
                <li class="Serial">ID </li>
                <li> Biller </li>
                <li>Customer Name</li>
                <li>Customer Email</li>
                <li>Date </li>
                <li class="Serial">Total </li>
                <li class="Actions">Actions</li>
            </ul>
            
            <?php 
            $i=1;
            foreach($search_array_result as $invoice)
            {
			
				//echo "<pre>";print_r($invoice);exit;
            ?>
            <ul>
                <li class="Serial">
                <? //if($invoice['quote']=='yes'){ echo "Quote ".$invoice['invoice_id']; } else { echo "Invoice ".$invoice['invoice_id']; }
                    if($invoice['quote']=='yes'){ echo "Quote ".$i; } else { echo "Invoice ".$i; }
                    $i++;
                ?>
                </li>
                <li> 
                <? if(isset($invoice['username'])&&!empty($invoice['username']) ){ echo $invoice['username']; } ?>
                </li>
                <li> <? if(isset($invoice['customer_name'])&&!empty($invoice['customer_name']) ){ echo $invoice['customer_name'];}else{ echo $invoice['customer_fname']." ".$invoice['customer_lname']; }?></li>
                <li><? if(isset($invoice['customer_email'])&&!empty($invoice['customer_email']) ){ echo $invoice['customer_email'];}?></li>
                 <li>
                    <span class="GridCalendar"><? if(isset($invoice['invoice_date'])&&!empty($invoice['invoice_date']) ){ echo $invoice['invoice_date'];}?></span>
                </li>
                <li class="Serial"><?  if(isset($invoice['total'])&&!empty($invoice['total'])){ echo "$".number_format($invoice['total'],2);}?></li>
                <li class="Actions">
                     <a onClick="popUp(<?=$invoice['invoice_id']?>)" href="javascript:void(0)" class="Invoice">
                        <img src="<?=base_url();?>images/webpowerup/InvoiceAction.png" alt="button"/>
                    </a>
                     <a href="<?php echo base_url().index_page(); ?>invoice/edit_invoice/<?=$invoice['invoice_id']?>" class="EditAction">
                        <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                    </a>
                     <a onClick="return deleteForm()" href="<?php echo base_url().index_page(); ?>invoice/delete_invoice/<?=$invoice['invoice_id']?>" class="DeleteAction">
                        <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                    </a>
                    <a  href="<?php echo base_url().index_page(); ?>invoice/create_email_invoice/<?=$invoice['invoice_id']?>">Email</a> | 
                    <a href="<?=base_url().index_page()?>invoice/create_view_invoice/<?=$invoice['invoice_id']?>">Print</a> | 
                    <a target="_blank" href="<?php echo base_url().index_page(); ?>invoice/create_pdf_invoice/<?=$site_id.'/'.$invoice['invoice_id']?> ">PDF</a> | 
                    <a href="<?=base_url().index_page()?>invoice/customer_new_invoice/<?=$invoice['invoice_id']?>/<?=$invoice['customer_id']?>" >New</a>
                    <b><?=$invoice['status']?></b>
                </li>
            </ul>
            <?php
            } ?>
    </div>
	<br />
<? }
	else if(isset($title))
	{
		?>
    <div class="RightColumnHeading">
        <h1>
            <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Invoice"/>
            <span>Search Results</span>
        </h1>
	</div>
    <div class="DataGrid2">
    
            <ul>
                <li class="Serial">ID </li>
                <li> Biller </li>
                <li>Customer Name</li>
                <li>Customer Email</li>
                <li>Date </li>
                <li class="Serial">Total </li>
                <li class="Actions">Actions</li>
            </ul>
            No result found.
	</div>	
    
		<?
	}
	

?>
<div class="RightColumnHeading">
        <h1>
            <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Invoice"/>
            <span>Invoice List</span>
        </h1>
	</div>
<div class="DataGrid2">

        <ul>
            <li class="Serial">ID </li>
            <li> Biller </li>
            <li>Customer Name</li>
            <li>Customer Email</li>
            <li>Date </li>
            <li class="Serial">Total </li>
            <li class="Actions">Actions</li>
        </ul>
        
        <?php 
		$i=1;
		foreach($invoices as $invoice)
		{
		?>
        <ul>
            <li class="Serial">
            <? //if($invoice['quote']=='yes'){ echo "Quote ".$invoice['invoice_id']; } else { echo "Invoice ".$invoice['invoice_id']; }
				if($invoice['quote']=='yes'){ echo "Quote ".$i; } else { echo "Invoice ".$i; }
				$i++;
			?>
            </li>
            <li> 
            <? if(isset($invoice['username'])&&!empty($invoice['username']) ){ echo $invoice['username']; } ?>
            </li>
            <li> <? if(isset($invoice['customer_name'])&&!empty($invoice['customer_name']) ){ echo $invoice['customer_name'];}else{ echo $invoice['customer_fname']." ".$invoice['customer_lname']; }?></li>
            <li><? if(isset($invoice['customer_email'])&&!empty($invoice['customer_email']) ){ echo $invoice['customer_email'];}?></li>
             <li>
                <span class="GridCalendar"><? if(isset($invoice['invoice_date'])&&!empty($invoice['invoice_date']) ){ echo $invoice['invoice_date'];}?></span>
            </li>
            <li class="Serial"><?  if(isset($invoice['total'])&&!empty($invoice['total'])){ echo "$".number_format($invoice['total'],2);}?></li>
            <li class="Actions">
                 <a onClick="popUp(<?=$invoice['invoice_id']?>)" href="javascript:void(0)" class="Invoice">
                    <img src="<?=base_url();?>images/webpowerup/InvoiceAction.png" alt="button"/>
                </a>
                 <a href="<?php echo base_url().index_page(); ?>invoice/edit_invoice/<?=$invoice['invoice_id']?>" class="EditAction">
                    <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                </a>
                 <a onClick="return deleteForm()" href="<?php echo base_url().index_page(); ?>invoice/delete_invoice/<?=$invoice['invoice_id']?>" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                </a>
                <a  href="<?php echo base_url().index_page(); ?>invoice/create_email_invoice/<?=$invoice['invoice_id']?>">Email</a> | 
                <a href="<?=base_url().index_page()?>invoice/create_view_invoice/<?=$invoice['invoice_id']?>">Print</a> | 
                <a target="_blank" href="<?php echo base_url().index_page(); ?>invoice/create_pdf_invoice/<?=$site_id.'/'.$invoice['invoice_id']?> ">PDF</a> | 
                <b><?=$invoice['status']?></b>
            </li>
        </ul>
        <?php
		} ?>
</div>

<div  class="pageDiv">
	<?php echo $paging;?>
</div>   
  	
 