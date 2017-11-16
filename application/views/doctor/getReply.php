
<div class="dashboard_bordered-box">
	<div class="dashboard__list-box">
		<?php echo html_entity_decode($reply['reply_text']) ?>

		<?php if ($reply['attachments']): ?>
			<a href="<?php echo generateUrl('doctor','getAttachment',array($reply['reply_id'])) ?>"><img align = "absbottom" alt = "Attachment" src = "<?php echo CONF_WEBROOT_URL ?>images/attchment.png"></a>
		<?php endif; ?>

		<span class="questio_askedon"><span>Answered on </span><?php echo date("D, dS M Y h:i T", strtotime($reply['reply_date'])); ?></span>
	</div>
</div>
