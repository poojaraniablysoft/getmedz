<?php defined('SYSTEM_INIT') or die('Invalid Usage');

printR($postData);
exit();

?>
<div id="body">
	<div class="row gry padd logn-rg">
		<div class="fix-container">
			<div class="login-form clearfix">
				
				<div class="form-sectn">
					<div class="form-sectn-in">
						<?php echo Message::getHtml(); ?>
						<?php echo $frm->getFormTag(); ?>
							<span><?php echo 'Reset your password'; ?></span>
							<p><?php echo'Enter the new password Associated With Your Account. Click reset button to change your password.'; ?></p>
							<table width="100%" cellspacing="0" cellpadding="0" class="logn-tbl">
								<tbody><tr>
									<td colspan="2">
										 <?php echo $frm->getFieldHTML('user_password'); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<?php echo $frm->getFieldHTML('user_password1'); ?>
									</td>
								</tr>
								<tr>

								</tr>
								<tr>
									<td colspan="2">
										<?php echo $frm->getFieldHTML('btn_submit'); ?>
									</td>
								</tr>
							</tbody></table>
							 <?php echo $frm->getFieldHTML('mode'); ?>
                            <?php echo $frm->getExternalJS(); ?>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>