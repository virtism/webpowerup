<!--

<? //echo $msg;?>

<?php

    $attributes = array('method' => 'post', 'id' => 'user' , 'name' => 'user');

    echo form_open(base_url().index_page().'UsersController/signup_step2', $attributes); 

    echo form_hidden('action','step2');

?>

<fieldset>

<legend><b> Signup Process </b> </legend>

 

 <h2>Step 1 : </h2> 



<fieldset>

<legend>Please Select A Pakage </legend>

    <div style="width:auto; vertical-align:top;">

    <?php

    $total_pakage = count($packges);

    

    for($i=0;$i<$total_pakage;$i++)

    {

?> 

        <div style="width:200px; float:left; height:auto;">

                <h3 align="center"> <?=$packges[$i]['package_name'] ?> </h3>

                <div align="center"> <img src = "<?=base_url();?>images/package.png" width="128" height="128" border="0"  /></div>

                <div align="center"><b>Description : </b><?=$packges[$i]['package_description'] ?></div>

                <div align="center"><b>Price : </b><?=$packges[$i]['package_fixed_price'] ?></div>

                <div align="center"><input type="radio" name="package_select" value="<?=$packges[$i]['package_id'] ?>" <?php if($i== 0){echo 'CHECKED';} ?>  >

                </div>

        </div>

    <?php

    }

?>

</div>        

</fieldset>



<p>

          <input type="button" value="Back" onclick="javascript: history.go(-1);" />

          <?php echo form_submit(array('name' => 'next'),'NEXT'); ?> 

          <?php //echo form_button(array('name' => 'cancel'),'Cancel'); ?>

          

</p>

 </fieldset>  

</form>

-->



<form id="user" name="user" action="<?=base_url().index_page()?>UsersController/signup_step2" method="post">

    <fieldset>

        <input type="hidden" name="action" value="step2" />

        <label>Sign up - Step 1</label>

        

        <div class="section">

            <label>Packages <span class="required">&nbsp;</span></label>

            <div>

                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                    <?php

                    $total_pakage = count($packges);

                    $count = 1;

                    ?>

                    <tr>

                        <?php

                        for($i=0;$i<$total_pakage;$i++)

                        {

                        ?> 

                        <td align="center">

                            <table id="signup_1" width="33%" border="0" cellpadding="0" cellspacing="0">

                                <tr>

                                    <td align="center">

                                        <h3 align="center"><?=$packges[$i]['package_name'] ?></h3>

                                    </td>

                                </tr>

                                <tr>

                                    <td align="center">

                                        <img src = "<?=base_url();?>images/package.png" width="128" height="128" border="0"  />

                                    </td>

                                </tr>

                                <tr>

                                    <td align="center">

                                        <div class="radio">

                                            <?php

                                            $strChecked='';

                                            if($count==1)

                                            {

                                                $strChecked = 'class="checked"';    

                                            }

                                            ?>

                                            <span <?=$strChecked?>>

                                            <input type="radio" value="<?=$packges[$i]['package_id'] ?>" name="package_select" <?php if($i== 0){echo 'CHECKED';} ?> />

                                            </span>                                                    

                                        </div>    

                                    </td>

                                </tr>

                                <tr>

                                    <td align="center">

                                        <b>Description : </b><?=$packges[$i]['package_description'] ?>

                                        <br />

                                        <b>Price : </b><?=$packges[$i]['package_fixed_price'] ?>

                                    </td>

                                </tr>

                            </table>

                        </td>

                        <?php

                            if($count%3 == 0)

                            {

                                echo '</tr><tr>';

                            }  

                            $count++;                  

                        }

                        ?> 

                    </tr>

                </table>

            </div>   

        </div>

        

        <div class="section">

            <div>

                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="NEXT" />

            </div>

        </div>

    </fieldset>

</form>



<script type="text/javascript">

    //jquery for radio button control

    $('div.radio span input:radio').click(function() {

        $(this).parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span').removeClass('checked')

        var className = $(this).attr('class');

        if(className == "")

        {

            $(this).parent().addClass("checked"); 

            $(this).attr('checked', true);       

        }

        else

        {

            $(this).parent().removeClass('checked');   

            $(this).attr('checked', false);       

        }

    });

</script>

