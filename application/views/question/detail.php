<?php echo Message::getHtml(); ?>
<table width="100%" cellspacing="2" cellpadding="2">
    <tr><td colspan="2">Patient profile</td></tr>
    <tr><td >Name: <?php echo $question['user_name']; ?></td><td>Visited Doctor:<?php echo ($question['orquestion_seen_doctor']) ? Applicationconstants::$arr_yes_no[$question['orquestion_seen_doctor']] : 'Not Available'; ?></td></tr>
    <tr><td >Gender: <?php echo ($question['orquestion_gender']) ? Applicationconstants::$arr_gender[$question['orquestion_gender']] : 'Not Available'; ?></td><td>Age: <?php echo ($question['orquestion_age']) ? Applicationconstants::$arr_age_year[$question['orquestion_age']] : 'Not Available'; ?></td></tr>
    <tr><td >Member Since: <?php echo displayDate($question['user_added_on']); ?></td><td></td></tr>
</table> 
<table width="100%" style="Padding:5px" border="2" cellspacing="2" cellpadding="2">
    <tr><td align="center">Patient Health issue</td></tr>
    <tr><td>Question</td></tr>
    <tr><td><?php echo $question['orquestion_question']; ?></td></tr>
    <tr><td>Asked By: <?php echo $question['user_name']; ?>  on  <?php echo date("D, dS M Y h:i T", strtotime($question['order_date'])); ?></td></tr>
    <tr><td>Symptoms/Medical History</td></tr>
    <tr><td> <?php echo ($question['orquestion_med_history']) ? $question['orquestion_med_history'] : 'N/A'; ?></td></tr>
    <?php if ($replies) {
        foreach ($replies as $reply) {
            ?>
            <tr><td><?php echo $reply['reply_text']; ?></td></tr>
        <?php }
        ?>


    <?php } ?>
                        <?php if (Members::isDoctorLogged() && $arr_question['orquestion_doctor_id'] == Members::isDoctorLogged()) { ?>
        <tr><td> <?php echo $replyFrm->getFormTag(); ?> <table width="100%" cellspacing="2" cellpadding="2"> <tr><td>
                            <?php echo $replyFrm->getFieldHtml('reply_text'); ?>
                            <?php echo $replyFrm->getFieldHtml('reply_orquestion_id'); ?>
                            <?php echo $replyFrm->getFieldHtml('uploaded_files_id'); ?>
                            <?php echo $replyFrm->getFieldHtml('add_attachment'); ?><span style="width:0%;" class="layer pbar"></span>
    <?php echo $replyFrm->getFieldHtml('btn_reply'); ?>

                        </td></tr>
                    <tr><td> <div class = " formwrapcenter uploadedFiles style='display:none'"> <ul class="uploaded_files"></ul>

                            </div>

                            <div class="formwrapcenter uploadFormDiv ">



                            </div>  </td></tr></table></form></td></tr>

        <tr>
            <td valign="top" class="fileUploadTab"><?php echo $upFrm->getFormTag(); ?>Upload Assignment <small>(Upload Captured photos, videos and Assignment document)</small></td>


        <div class="wrapfield fupload"><?php echo $upFrm->getFieldHtml("fileupload") ?> 
    <?php echo $upFrm->getFieldHtml("action") ?>

            <div class="progresscounter withbg" style="display:none;">
                <span class="progressbar"></span>
                <span style="width:0%;" class="layer pbar"></span>
                <ul class="vlines"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
            </div>





            <a href="javascript:;" onclick="uploadFile(this)" class = "up-btn">UPLOAD_FILE</a></div>
    </form>
    </td>

    </tr>
<?php } elseif (Members::isDoctorLogged() && $arr_question['orquestion_doctor_id'] == '0') { ?>

    <tr><td> Accept Question </td></tr>
    <?php } else {
    ?>
    <tr><td> Doctor is reviewing your question, Please wait....</td></tr>
<?php } ?>
</table>