<!--div class="your-doc-block">
    <h2>Your <span>Doctor </span> </h2>
    <div class="left">
        <p class="img"><img alt="" src="<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($question['doctor_id']), 139, 113), "/") ?>"></p>
        <p> 
            <?php if ($question['doctor_online']): ?>
                <img alt="" src="<?php echo CONF_WEBROOT_URL ?>images/green-ball1.png"> <span class="green">Online</span>
            <?php endif; ?>
            Dr <?php echo $question['doctor_name'] ?><br> Professional </p>
    </div>
    <div class="right">
        <p class="head1"><?php echo intval($question['doc_rating']) ?> Rating <?php echo createStar('doc_rating2', intval($question['doc_rating'])) ?></br></p>
        <div class="clear"></div>
          
        <p class="blue1"><a href="javascript:void(0)" onclick="updateCustomQuestionStatus(<?php echo $question['orquestion_id'].",".Question::QUESTION_CLOSED.",".$question['orquestion_status'] ?>)">Write a Review</a> </p>
   
    </div>
</div-->

<?php //print_r($question); die;?>

                  <div class="dashboard__list-box">
                    <div class="patient--details">
                      <table class="table nopadding table-responsive ">
                        <tr>
                          <td><strong>Name: </strong> <?php echo doctorDisplayName($question['doctor_name']); ?></td>
                          <td><strong>Email: </strong><?php echo doctorDisplayName($question['doctor_email']); ?></td>
                        </tr>
                        <tr>
                          <td><?php echo intval($question['doc_rating']) ?> Rating <?php echo createStar('doc_rating2', intval($question['doc_rating'])) ?></td>
                          <td><a href="javascript:void(0)" onclick="updateCustomQuestionStatus(<?php echo $question['orquestion_id'].",".Question::QUESTION_CLOSED.",".$question['orquestion_status'] ?>)">Write a Review</a></td>
                        </tr>
                        <!--tr>
                          <td><strong>Age: </strong> 10-17</td>
                          <td><strong>Member Since:</strong> 2015-11-09</td>
                        </tr-->
                      </table>
                    </div>
                  </div>
                  <div class="dashboard__list-box">
                    <div class="dashboard--userinfo">
                      <div class="user_media"> <img src="<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($question['doctor_id']), 139, 113), "/") ?>" alt=""> </div>
                      <a href="<?php echo generateUrl('doctors','detail',array($question['doctor_id']));?>" class="dashboard__username"> <?php echo doctorDisplayName($question['doctor_name']); ?> </a> </div>
                  </div>
                </div>
