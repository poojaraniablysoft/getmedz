
<?php foreach ($replies as $reply): ?>
	<div class="dashboard_bordered-box">
              	<div class="dashboard__list-box">
   
       
        <?php echo html_entity_decode($reply['reply_text']) ?>

  <?php if ($reply['attachments']): ?>
            <a href="<?php echo generateUrl('customer','getAttachment',array($reply['reply_id'])) ?>"><img align = "absbottom" alt = "" src = "<?php echo CONF_WEBROOT_URL ?>images/attchment.png"></a>
        <?php endif; ?>

        <span class="red2">Answered on <?php echo date("D, dS M Y h:i T", strtotime($reply['reply_date'])); ?></span>


 
</div>

  <div class="dashboard__list-box">


        
            <div class = "user_media">
                <?php if ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR): ?>
                    <img alt = "" src = "<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($reply['doctor_id']), 139, 113), "/") ?>">
                <?php else: ?>  
                    <img alt = "" src ="<?php echo generateUrl('image', 'getCustomerProfilePic', array(intval($reply['user_id']), 139, 113), "/") ?>">
                <?php endif; ?>
		</div>
				 <?php if ($reply['reply_by'] == Question::QUESTION_REPLIED_BY_DOCTOR):
            ?>

            <div class="dashboard__username">
                <?php if ($reply['doctor_online']): ?>
                    <img alt="" src="<?php echo CONF_WEBROOT_URL ?>images/green-ball1.png"> &nbsp;&nbsp;<span class="green">Online</span>
                <?php endif; ?>
                Dr <?php echo $reply['doctor_name'] ?>  Medical <br>Professional </div>

        <?php else: ?>

            <div class="dashboard__username"><?php echo $reply['customer_name'] ?> </div>



        <?php endif; ?>
            </p>
            
           
        <p>
           
          </p>
    </div>

</div>
<?php endforeach; ?>

