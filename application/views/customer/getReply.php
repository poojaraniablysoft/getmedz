         <div <?php if($reply['reply_by']==Members::DOCTOR_USER_TYPE) echo'class="grey-bg"'; ?>><?php if($reply['reply_by']==Members::DOCTOR_USER_TYPE) echo'<span class="dname">Dr. '.$reply['replier_name'].'<br/>Answer</span><br/> '; else echo '<span class="pname">'.$reply['replier_name']."'s Reply</span>";?> <?php echo html_entity_decode($reply['reply_text']); ?>
									
								<div class="answered_time"><?php if($reply['reply_by']==0){ ?>Answered On <?php } echo date("D, dS M Y h:i T", strtotime($reply['order_date'])); ?> <?php if($reply['attachments']>0){ ?><a href="<?php echo generateUrl('doctor','getAttachment',array($reply['reply_id'])) ?>">Download File</a><?php } ?></div>
								
									
									</div>