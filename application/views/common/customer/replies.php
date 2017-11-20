
<?php foreach ($replies as $reply):  ?>
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

