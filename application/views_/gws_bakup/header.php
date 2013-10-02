        <?php

        if(isset($_SESSION['user_info']['user_id']))

        {

            $strHomehref = base_url().index_page()."SiteController/sitebuilder/";    

        }

        else

        {

            $strHomehref = base_url().index_page()."UsersController/login/sitelogin";    

        }

        

        ?>

        <div id="homebg">

                <div id="homebtn">

                        <form name="hombtn">

                        <input type="button" id="silverbtn" style="cursor:pointer;" onclick="document.location='<?=$strHomehref?>';" />

                        </form>

                </div>

            </div>

            

            <div id="nevibg">

                <div id="nevistuff">

                     <div id="notify">

                          <img src="<?=base_url()?>css/gws/images/notifications.png" />

                     </div>

                     

                     <div id="newmail">

                         <div id="newmailtxt">

                               New Mail

                         </div>

                          

                          <div id="newmailicon">

                                <form name="neviemailbtn">

                                <input type="button" id="emailicon" />

                                </form>

                          </div>

                     </div>

                     

                     <div id="confrcall">

                            <div id="confrcalltxt">

                                   Conference Call

                            </div>

                            

                            <div id="confrcallicon">

                                    <form name="ccallbtn">

                                    <input type="button" id="ccallicon" />

                                    </form>

                            </div>

                     </div>

                     

                     <div id="supporttkt">

                            <div id="supporttkttxt">

                             <a style="color: white; text-decoration: none;" href="<?=base_url().index_page()?>support_ticket/">  Support Ticket    </a>

                            </div>

                            

                            <div id="supporttkticon">

                                <form name="suprttktbtn">

                                <input type="button" id="suprttkticon" />

                                </form>

                            </div>

                     </div>

                     

                     <div id="neworder">

                         <div id="newordertxt">

                                New Order

                         </div>

                         <div id="newordericon">

                                <form name="newordrbtn">

                                <input type="button" id="newordricon" />

                                </form>

                         </div>

                     </div>

                     

                     <div id="dividernevi">

                           <img src="<?=base_url()?>css/gws/images/nevidivider.png" />

                     </div>

                     

                     <div id="refresh">

                            <form name="refreshbtn">

                            <input type="button" id="refreshicon" />

                            </form>

                     </div>

                     

                     <div id="helpbtn">

                            <form name="helpbutton">

                            <input type="button" id="helpbtnn" />

                            </form>

                     </div>

                </div>

            </div>