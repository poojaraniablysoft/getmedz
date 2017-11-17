
<div class="dashboard_bordered-box  <?php echo ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR)?'chat-left doc':'chat-right patient';?>">
	<div class="dashboard__list-box">
		<div class="doc-profile">
			<div class="doc--pic">
				<img alt = "" src ="<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($reply['orquestion_doctor_id']), 139, 113), "/") ?>">
			   </div>
			   <div class="doc--content">
				<h3><?php echo $reply['replier_name'] ?></h3>
				   <h4>MBBS, MS Neurology, Berghingam,United Kingdom</h4>
				   <p>MD,Medicine</p>
		   </div>

		</div>
		
	</div>
	<div class="dashboard__list-box">
		<?php echo html_entity_decode($reply['reply_text']) ?>

		<?php if ($reply['attachments']): ?>
			<a href="<?php echo generateUrl('doctor','getAttachment',array($reply['reply_id'])) ?>"><img align = "absbottom" alt = "Attachment" src = "<?php echo CONF_WEBROOT_URL ?>images/attchment.png"></a>
		<?php endif; ?>

		<span class="questio_askedon"><span><?php echo Utilities::getLabel('LBL_Answered_on');?> </span><?php echo date("D, dS M Y h:i T", strtotime($reply['reply_date'])); ?></span>
	</div>
</div>
