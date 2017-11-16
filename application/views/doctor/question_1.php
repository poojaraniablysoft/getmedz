


<!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  


                <!--main panel end here-->
                <div class="sectionbody space">


                    <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl('doctor'); ?>">Home</a></li>

                        <li>Question</li>
                    </ul>
                    <span class="gap"></span>
                </div> 

                <h1><?php echo $question['orquestion_question']; ?></h1> 




                <section class="section">

                    <div class="sectionbody">
                        <table class="table table-responsive ">
                            <tr><th colspan="2">Patient profile</th></tr>
                            <tr><td >Name: <?php echo $arr_question['user_name']; ?></td><td>Visited Doctor:<?php echo ($arr_question['orquestion_seen_doctor']) ? Applicationconstants::$arr_yes_no[$arr_question['orquestion_seen_doctor']] : 'Not Available'; ?></td></tr>
                            <tr><td >Gender: <?php echo ($arr_question['orquestion_gender']) ? Applicationconstants::$arr_gender[$arr_question['orquestion_gender']] : 'Not Available'; ?></td><td>Age: <?php echo ($arr_question['orquestion_age']) ? Applicationconstants::$arr_age_year[$arr_question['orquestion_age']] : 'Not Available'; ?></td></tr>
                            <tr><td >Member Since: <?php echo displayDate($arr_question['user_added_on']); ?></td><td></td></tr>
                        </table> 
                    </div>
                </section>
                <section class="section">

                    <div class="sectionbody">
                        <table class="table table-responsive ">
                            <tr><th colspan="2">Patient Health issue</th></tr>

                            <tr><td>Question<br><?php echo $arr_question['orquestion_question']; ?></td></tr>
                            <tr><td>Asked By: <?php echo $arr_question['user_name']; ?>  on  <?php echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?></td></tr>
                            <tr><td></td></tr>
                            <tr><td> Symptoms/Medical History<br/><?php echo ($arr_question['orquestion_med_history']) ? ($arr_question['orquestion_med_history']) : 'N/A'; ?></td></tr>
                            <?php
                            if ($replies) {
                                foreach ($replies as $reply) {
                                    ?>
                                    <tr><td><?php echo html_entity_decode($reply['reply_text']); ?></td></tr>
                                <?php }
                                ?>


                            <?php } ?>
                        </table> 
                    </div>
                </section>

            </div>
        </div>
        <section class="section">
            <div class="sectionhead"><h4>Reply Query</h4></div>
            <div class="sectionbody space">
               
                    <table width="100%" style="Padding:5px" border="2" cellspacing="2" cellpadding="2">
                        <tr>
                            <td align="center"></td>
                        </tr>
                        <?php if (Members::isDoctorLogged() && $arr_question['orquestion_doctor_id'] == Members::isDoctorLogged()) { ?>
                            <tr>  
                                <td> <?php echo $replyFrm->getFormTag(); ?>
                                    <table width="100%" cellspacing="2" cellpadding="2"> <tr><td>
                                                <?php echo $replyFrm->getFieldHtml('reply_text'); ?>
                                            </td></tr>
                                        <tr>    
                                            <td>   <?php echo $replyFrm->getFieldHtml('reply_orquestion_id'); ?>
                                                <?php echo $replyFrm->getFieldHtml('uploaded_files_id'); ?>
                                                <?php echo $replyFrm->getFieldHtml('add_attachment'); ?><span style="width:0%;" class="layer pbar"></span>
                                                <?php echo $replyFrm->getFieldHtml('btn_reply'); ?>
                                    </td>
                                    </tr>
                                         

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class ="formwrapcenter uploadedFiles style='display:none'"> <ul class="uploaded_files"></ul></div>
                                                <div class="formwrapcenter uploadFormDiv "> </div>  
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" class="fileUploadTab"><?php echo $upFrm->getFormTag(); ?>Upload Assignment <small>(Upload Captured photos, videos and Assignment document)</small>
                            <div class="wrapfield fupload">
                            <?php echo $upFrm->getFieldHtml("fileupload") ?> 
                                <?php echo $upFrm->getFieldHtml("action") ?>

                                <div class="progresscounter withbg" style="display:none;">
                                    <span class="progressbar"></span>
                                    <span style="width:0%;" class="layer pbar"></span>
                                    <ul class="vlines"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
                                </div>
                                <a href="javascript:;" onclick="uploadFile(this)" class = "up-btn">UPLOAD_FILE</a>
                            </div>
                    </form>
                    </td>

                    </tr>
                <?php } elseif (Members::isDoctorLogged() && $question['orquestion_doctor_id'] == '0') { ?>

                    <tr><td> Accept Question </td></tr>
                <?php } else {
                    ?>
                    <tr><td> Doctor is reviewing your question, Please wait....</td></tr>
                <?php } ?>
                </table>
                 
            </div>
        </section>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->





<script language="javascript" type="text/javascript">
    $('textarea').tinymce({
        // Location of TinyMCE script
        script_url: '<?php echo CONF_WEBROOT_URL . 'tinymce-lnk/jscripts/tiny_mce/tiny_mce.js' ?>',
        mode: "textareas",
        theme: "advanced",
        theme_advanced_buttons1: "mybutton,bold,italic,underline",
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        plugins: 'inlinepopups',
        valid_elements: "b,em,strong,em"

    });

</script>

