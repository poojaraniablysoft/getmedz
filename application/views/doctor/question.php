<script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
	<script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>

	<!--Main-->
<main class="site-main "> 
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
		<div class="container">
			<div class="dashboard--box">
				<div class="span-row">
					<div class="span-md-12 span-sm-12 span-xs-12">
						<div class="dashboard">
							<?php include getViewsPath() . 'common/doctor/left-menu.php'; ?>
							<div class="dashboard__content">
								<h2 class="dashboard_title">Question</h2>
								<h2 class="dashboard_subtitle nopadding--top">Patient Profile</h2>
								<div class="dashboard_bordered-box">
									 <?php //if ($question['orquestion_status'] != Question::QUESTION_PENDING): ?>
										<?php include getViewsPath() . 'common/doctor/customer_block.php'; ?>  
									<?php //endif; ?>
									 
								</div>
								<h2 class="dashboard_subtitle nopadding--top"><?php echo Utilities::getLabel('LBL_Patient_Health_issue');?></h2>
								<div class="dashboard_bordered-box">
									<table class="table table-responsive " >
										<tbody>

											<tr>
												<td class="question"><span class="table-title"><?php echo Utilities::getLabel('LBL_Question');?></span>
												<h3><?php echo $arr_question['orquestion_question']; ?></h3>
												<span class="questio_askedon"><span><?php echo Utilities::getLabel('LBL_Asked_By');?></span> <?php echo $arr_question['user_name']; ?> <?php echo Utilities::getLabel('LBL_On');?> <?php echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?> </span>
												<?php if($arr_question['have_file']){?>
													<a href="<?php echo generateUrl('doctor', 'getAttachment', array($arr_question['orquestion_id'],Files::QUESTION_POST_ATTACHMENT)) ?>"><?php echo Utilities::getLabel('LBL_Download Attachment');?></a>
												<?php } ?>
												</td>
											</tr>
											<tr><td><span class="table-title"><?php echo Utilities::getLabel('LBL_Medical_History');?></span><?php echo ($arr_question['orquestion_med_history']) ? (nl2br($arr_question['orquestion_med_history'])) : 'N/A'; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="dashboard_bordered" >
									<span class="table-title"><?php echo Utilities::getLabel('LBL_Communication_Thread');?></span>
									<div class="replies-js replies ">
									 <?php foreach ($replies as $reply): ?>
										<div class="dashboard_bordered-box  <?php echo ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR)?'chat-left doc':'chat-right patient';?>">
										  <?php if ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR){ ?>
											<div class="dashboard__list-box">
												<div class="doc-profile">
													<div class="doc--pic">
														<img alt = "" src ="<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($reply['doctor_id']), 139, 113), "/") ?>">
													   </div>
													   <div class="doc--content">
														<h3><?php echo $reply['replier_name'] ?></h3>
														   <h4><?php echo $reply['degrees'];?>, <?php echo $reply['doctor_city'];?>,<?php echo $reply['state_name'];?></h4>
														   <p><?php echo $reply['category_name'];?></p>
												   </div>

												</div>
												
											</div>
												<?php 
												  } ?>
											<div class="dashboard__list-box">
												<?php echo html_entity_decode($reply['reply_text']) ?>

												<?php if ($reply['attachments']): ?>
													<a href="<?php echo generateUrl('doctor','getAttachment',array($reply['reply_id'])) ?>"><img align = "absbottom" alt = "Attachment" src = "<?php echo CONF_WEBROOT_URL ?>images/attchment.png"></a>
												<?php endif; ?>
												 <?php if ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR){
												 $askedOnTxt = Utilities::getLabel('LBL_Answered_on');}
												 else{
													  $askedOnTxt = Utilities::getLabel('LBL_Asked_on');
												 }
												 ?>
												 
												<span class="questio_askedon"><span><?php echo $askedOnTxt;?> </span><?php echo date("D, dS M Y h:i T", strtotime($reply['reply_date'])); ?></span>
											</div>
										</div>
									<?php endforeach; ?> 
									</div>					
									

								
							
								<?php if ($arr_question['orquestion_status'] == Question::QUESTION_CLOSED ){?>
									<div class="note question-close"><?php echo Utilities::getLabel('LBL_QUESTION_CLOSED');?></div>

								<?php }else if ($arr_question['orquestion_status'] == Question::QUESTION_ESCLATED_TO_ADMIN ){?>
								  <div class="note question-esclated"> <?php echo Utilities::getLabel('LBL_Esclated_to_Admin');?></div>

								<?php } elseif ($arr_question['orquestion_doctor_id'] != Members::getLoggedUserID() ) {
									?>
									 <div class="note question-esclated"><?php echo Utilities::getLabel('LBL_QUESTION_HAS_BEEN_REASSIGNED_TO_SOME_OTHER_DOCTOR');?></div>

								<?php } elseif ($arr_question['orquestion_doctor_id'] == Members::getLoggedUserID() && $arr_question['orquestion_status'] == Question::QUESTION_ASSIGNED) {
									?>
									<a class="button button--fill button--secondary" href="<?php echo generateUrl('doctor', 'acceptquestion', array($arr_question['orquestion_id'])); ?>">Accept This Question</a>

								<?php } else if ($arr_question['orquestion_doctor_id'] == Members::getLoggedUserID()){
									?>
								   <div class="sectionbody reply-status-js">
										<div class="sectionhead" ><span class="table-title">Reply Query</span></div>
										<div class="sectionbody space">
											
											<?php echo $replyFrm->getFormTag(); ?>
											<div class="row">
											<?php echo $replyFrm->getFieldHtml('reply_text'); ?>

											</div>           


											<div class="row">
												<div class="wrapfield fupload file_progress-js" id="file_progress" style="display:none">
													<span >Uploading File...</span><span style="width:0%;" class="layer progress-bar-js"></span><span class="countvalue-js">0%</span>
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
	</div>
</main>



<script language="javascript" type="text/javascript">
    

</script>

