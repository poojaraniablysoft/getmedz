<!--Main-->
<script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
	<script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>
<main class="site-main "> 
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          <div class="span-md-12 span-sm-12 span-xs-12">
            <div class="dashboard">
               <?php include getViewsPath() . 'common/customer/left-menu.php'; ?>
              <div class="dashboard__content">
                <h2 class="dashboard_title">Question</h2>
               
                <div class="dashboard_bordered-box">
				 <?php //if ($question['orquestion_status'] != Question::QUESTION_PENDING): ?>
					<?php include getViewsPath() . 'common/customer/doctor_block.php'; ?>  
				<?php //endif; ?>
				 
				
                <div class="dashboard_bordered-box">
					<div class="dashboard__list-box">
					<table class="table table-responsive " id="response_table">
                            <tbody>

                            <tr><td class="question"><span class="table-title"><?php echo Utilities::getLabel('LBL_Question');?></span>
								<h3><?php echo $question['orquestion_question'] ?></h3>
								<span class="questio_askedon"><span><?php echo Utilities::getLabel('LBL_Asked_on');?></span> <?php echo $question['order_date'] ?> </span>
								<?php if($question['attachments']){?>
									<a class="asklink" href="<?php echo generateUrl('doctor', 'getAttachment', array($question['orquestion_id'],Files::QUESTION_POST_ATTACHMENT)) ?>"><img align = "absbottom" alt = "" src = "<?php echo CONF_WEBROOT_URL ?>images/attchment.png"></a>
								<?php } ?>
								</td>
							</tr>
							
                        </tbody></table>
					</div>
					</div>
					<div id="question_reply" class=" replies replies-js"></div>
					<?php  if ($question['orquestion_status'] == Question::QUESTION_CLOSED ){?>
								<div class="note question-close"> <?php echo Utilities::getLabel('LBL_Question_CLOSED');?></div>

								<?php }elseif ($question['orquestion_status'] == Question::QUESTION_ASSIGNED ){?>
							

								<?php } else {
									?>
								   <div class="sectionbody reply-status-js">
										<div class="sectionhead" ><span class="table-title"><?php echo Utilities::getLabel('LBL_Reply_Query');?></span></div>
										<div class="sectionbody space">
											
											<?php echo $replyFrm->getFormTag(); ?>
											<div class="row">
											<?php echo $replyFrm->getFieldHtml('reply_text'); ?>

											</div>           


											<div class="row">
												<div class="wrapfield fupload file_progress-js" id="file_progress" style="display:none">
													<span ><?php echo Utilities::getLabel('LBL_Uploading_File');?>...</span><span style="width:0%;" class="layer progress-bar-js"></span><span class="countvalue-js">0%</span>
												</div>
												<div class="formwrapcenter uploadedFiles style='display:none'"> <ul class="uploaded_files"></ul></div>
											</div>
											<div class="actions text--right">      
													<?php echo $replyFrm->getFieldHtml('btn_reply'); ?>
													<?php echo $replyFrm->getFieldHtml('add_attachment'); ?>
											 
											</div>

											<?php echo $replyFrm->getFieldHtml('reply_id'); ?>
											<?php echo $replyFrm->getFieldHtml('reply_orquestion_id'); ?>
											<?php echo $replyFrm->getFieldHtml('uploaded_files_id'); ?>
											</form>



											<?php echo $replyFrm->getExternalJs(); ?>
										</div>
											<?php echo $upFrm->getFormHtml(); ?>
									</div>
									<?php }
									?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
</main>

<script>
    var RepliesObj = {};
    $(document).ready(function () {

        RepliesObj = Reply(<?php echo $question['orquestion_id'] ?>);
        RepliesObj.fetch_replies();

    });


</script>