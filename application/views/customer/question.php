<style>

</style><!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">


                <!--main panel end here-->
                <div class="sectionbody space">


                    <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl('customer'); ?>">Home</a></li>

                        <li>Question</li>
                    </ul>
                    <span class="gap"></span>
                </div>

                <section class="section">
                    <div class="sectionbody">                     
                        <div class="row">
                            <div class="col-md-10 col-xs-8">
                                <table class="table table-responsive ">
                                    <tr><th colspan="2">Patient profile</th></tr>
                                    <tr><td ><strong>Name: </strong> <?php echo $arr_question['user_name']; ?></td>
                                        <td><strong>Visited Doctor:</strong> <?php echo ($arr_question['orquestion_seen_doctor']) ? Applicationconstants::$arr_yes_no[$arr_question['orquestion_seen_doctor']] : 'Not Available'; ?></td></tr>
                                    <tr><td ><strong>Gender:</strong> <?php echo ($arr_question['orquestion_gender']) ? Applicationconstants::$arr_gender[$arr_question['orquestion_gender']] : 'Not Available'; ?></td>
                                        <td><strong>Age: </strong> <?php echo ($arr_question['orquestion_age']) ? Applicationconstants::$arr_age_year[$arr_question['orquestion_age']] : 'Not Available'; ?></td></tr>
                                    <tr><td ><strong>Member Since:</strong> <?php echo displayDate($arr_question['user_added_on']); ?></td><td></td></tr>
                                </table>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="avtararea padd_all">
                                    <figure class="pic">
                                        <form>
                                            <img alt="" src="<?php echo generateUrl('image', 'getCustomerProfilePic', array($arr_question['user_id'], 500, 500), "/") ?>">

                                        </form>     
                                    </figure>
                                    <div class="picinfo">
                                        <span class="name"><?php echo $arr_question['user_name']; ?></span>
                                        <span class="mailinfo"><?php echo $arr_question['user_email']; ?>/span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section">

                    <div class="sectionbody">
                        <table class="table table-responsive " id="response_table">
                            <tr><th colspan="2">Patient Health issue</th></tr>

                            <tr><td class="question-bg"><span class="red_title">Question</span><?php echo $arr_question['orquestion_question']; ?><div class="posted_time">Asked by <?php echo $arr_question['user_name']; ?> on <?php echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?>
                                      <?php if($arr_question['have_file']){?>
                                        <a href="<?php echo generateUrl('doctor', 'getAttachment', array($arr_question['orquestion_id'],Files::QUESTION_POST_ATTACHMENT)) ?>">Download File</a>
                                        <?php } ?>   
                                    </div></td></tr>

                            <tr><td><span class="red_title">Symptoms/Medical History</span><?php echo ($arr_question['orquestion_med_history']) ? ($arr_question['orquestion_med_history']) : 'N/A'; ?></td>
                            </tr>
                            <tr><td> <span class="red_title">Communication Thread</span>
                                    <?php
                                    if ($replies) {
                                        foreach ($replies as $reply) {
                                            ?>
                                            <div <?php if ($reply['reply_by'] == Members::DOCTOR_USER_TYPE) echo'class="grey-bg"'; ?>><?php if ($reply['reply_by'] == Members::DOCTOR_USER_TYPE) echo'<span class="dname">Dr.' . $reply['replier_name'] . '<br/>Answer</span><br/> ';
                                    else echo '<span class="pname">' . $reply['replier_name'] . "'s Reply</span>"; ?> <?php echo html_entity_decode($reply['reply_text']); ?>

                                                <div class="answered_time"><?php if ($reply['reply_by'] == 0) { ?>Answered On <?php } echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?> <?php if ($reply['attachments'] > 0) { ?><a href="<?php echo generateUrl('doctor', 'getAttachment', array($reply['reply_id'])) ?>">Download File</a><?php } ?></div>


                                            </div>
                                        <?php }
                                        ?>


								<?php } ?>
                                </td></tr>
                        </table>
                    </div>
                </section>

            </div>
		</div>
				<section class="section">

		<?php if($arr_question['orquestion_status']==4){?>

				<div id="rate_div" >
					<section class="sectionhead">Rate Your Doctor</section>
					<section class="sectionbody space">
						<?php echo $review_frm->getFormHTML(); ?>
						<?php echo $review_frm->getExternalJS(); ?>
					 </section>
				</div>
		<?php
				}else if ($arr_question['order_user_id'] == Members::getLoggedUserID() && count($replies) > 0) 
					{ ?>
						<div class="sectionhead"><h4>Reply Query</h4></div>
						<div class="sectionbody space">
							<?php echo $replyFrm->getFormTag(); ?>
							<div class="row">
								<div class="col-sm-12">
									<div class="field_control">

										<div class="field_cover">
											<?php echo $replyFrm->getFieldHtml('reply_text'); ?>

										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="wrapfield fupload" id="file_progress" style="display:none">
									<span >Uploading File...</span><span class="countvalue">0%</span>
								</div>
								<div class ="formwrapcenter uploadedFiles style='display:none'"> <ul class="uploaded_files"></ul></div>
							</div>
							<div class="row">
								<div class="col-sm-12">

									<?php echo $replyFrm->getFieldHtml('btn_reply'); ?>
									<?php echo $replyFrm->getFieldHtml('add_attachment'); ?>
									<?php echo $replyFrm->getFieldHtml('close_question'); ?><span style="width:0%;" class="layer pbar"></span>
								</div>
							</div>

							<?php echo $replyFrm->getFieldHtml('reply_orquestion_id'); ?>
							<?php echo $replyFrm->getFieldHtml('uploaded_files_id'); ?>
							 <?php echo $replyFrm->getExternalJs(); ?>
							</form>
						</div>
						<?php echo $upFrm->getFormHtml(); ?>

			<?php   } elseif ($arr_question['orquestion_doctor_id'] == '0') { ?>
						Please Wait.. A doctor will be assigned to you soon..
					<?php 
					} else 
					{
						?>
						<div class="alert alert_info" role="alert">
							<h5>  Doctor is reviewing the question, Please wait....</h5>
						</div>

		<?php 		} ?>
			</section>
			<section class="section" id="rate_div" style="display:none">
				<section class="sectionhead">Rate Your Doctor</section>
				<section class="sectionbody space">
					<?php echo $review_frm->getFormHTML(); ?>
					<?php echo $review_frm->getExternalJS(); ?>
				</section>
			</section>


            <!--main panel end here-->
	</div>
</div>
        <!--body end here-->





        <script language="javascript" type="text/javascript">
            $('#reply_text').tinymce({
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

