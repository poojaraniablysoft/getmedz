<?php
if (count($arr_listing) > 0) {
  foreach ($arr_listing as $question) { ?> 
	<div class="dashboard_bordered-box">
	  <div class="dashboard__list-box">
		<div class="question_asked">
		  <p><?php echo subStringByWords($question['orquestion_question'],180); ?> </p>
		  <span class="questio_askedon"><span><?php if ($reply['reply_by'] == 0) { ?><?php echo getLabel('L_Asked_On')?> <?php } ?></span> <?php  echo date("D, dS M Y h:i T", strtotime($question['order_date'])); ?></span> 
		   <?php if (intval($question['doctor_id']) > 0): ?>
                    <div class="bot">
                        <div class="lt"> 
                            <a href="<?php echo generateUrl('customer', 'doc_profile', array($question['orquestion_id'])) ?>"><?php echo getLabel('L_Click_Here'); ?></a>
                            <?php echo getLabel('L_To_View_Doctor_Response.'); ?> </div>
                        <div class="rt">
                            &nbsp; <div class="txt">
                                <p><?php echo getLabel('L_Rate_the_Doctor'); ?></p>
                                <p class="red2"><a href="javascript:void(0)" onclick="updateCustomQuestionStatus(<?php echo $question['orquestion_id'] . "," . Question::QUESTION_CLOSED . "," . $question['orquestion_status'] ?>)">
            <?php if (intval($question['orquestion_status']) !== Question::QUESTION_CLOSED): 
									echo getLabel('L_Close_Question_And'); 
								endif; 
									echo getLabel('L_Write_a_Review'); ?></a> </p> 
								</div>
                            <div class="star">
            <?php echo createStar('doc_rating' . $question['orquestion_id'], intval($question['doc_rating'])) ?>
                            </div>
                        </div>

                    </div>
        <?php endif; ?>
		  
		  
	   </div>
	  </div>
	  <div class="dashboard__list-box">
		<ul class="question__action">
		  <li><i>
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="34px" height="34px" viewBox="0 0 34 34" enable-background="new 0 0 34 34" xml:space="preserve">
			  <defs> </defs>
			  <g>
				<g>
				  <path fill="#C1C4C6" d="M15.146,19.143l-4.216-4.233L8.67,17.17l6.646,6.63l10.677-10.353l-2.618-2.686L15.146,19.143z M17,0
	C7.611,0,0,7.611,0,17s7.611,17,17,17s17-7.611,17-17S26.389,0,17,0z M17,30.923C9.311,30.923,3.077,24.689,3.077,17
	S9.311,3.077,17,3.077C24.686,3.086,30.913,9.314,30.923,17C30.923,24.689,24.689,30.923,17,30.923z"/>
				</g>
			  </g>
			</svg>
			</i><span><?php echo getLabel('L_Question_Status');?>:<?php echo Question::$QuestionStatus[$question['orquestion_status']]; ?></span></li>
			
			<li><i>
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="34px" height="34px" viewBox="0 0 34 34" enable-background="new 0 0 34 34" xml:space="preserve">
			  <defs> </defs>
			  <g>
				<g>
				  <path fill="#C1C4C6" d="M15.146,19.143l-4.216-4.233L8.67,17.17l6.646,6.63l10.677-10.353l-2.618-2.686L15.146,19.143z M17,0
	C7.611,0,0,7.611,0,17s7.611,17,17,17s17-7.611,17-17S26.389,0,17,0z M17,30.923C9.311,30.923,3.077,24.689,3.077,17
	S9.311,3.077,17,3.077C24.686,3.086,30.913,9.314,30.923,17C30.923,24.689,24.689,30.923,17,30.923z"/>
				</g>
			  </g>
			</svg>
						
			</i><span><?php echo getLabel('L_You_have');?><?php echo $question['count_replies'].getLabel('L_New_Answer') ?></span></li>
			
			
			
			<li><a href="<?php echo generateUrl('customer', 'doc_profile', array($question['orquestion_id'])) ?> " ><i>
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="34px" height="34px" viewBox="0 0 34 34" enable-background="new 0 0 34 34" xml:space="preserve">
			  <defs> </defs>
			  <g>
				<g>
				  <path fill="#C1C4C6" d="M15.146,19.143l-4.216-4.233L8.67,17.17l6.646,6.63l10.677-10.353l-2.618-2.686L15.146,19.143z M17,0
	C7.611,0,0,7.611,0,17s7.611,17,17,17s17-7.611,17-17S26.389,0,17,0z M17,30.923C9.311,30.923,3.077,24.689,3.077,17
	S9.311,3.077,17,3.077C24.686,3.086,30.913,9.314,30.923,17C30.923,24.689,24.689,30.923,17,30.923z"/>
				</g>
			  </g>
			</svg>
						
			</i><span><?php echo getLabel('L_Review_Full_Question/Answer ');?></span></a></li>
		</ul>
	  </div>
	  <div class="dashboard__list-box">
		<div class="dashboard--userinfo">
		  <div class="user_media"> <img src="<?php echo generateUrl('image','getCustomerProfilePic',array($question['user_id'],500,500),"/")?>" alt=""> </div>
		  <a href="javascript:;" class="dashboard__username"> <?php echo $question['user_name']; ?> </a> </div>
	  </div>
	</div>
 <?php
	}
} 
else {
		echo '<section class="section"><section class="sectionbody space">'. getLabel('L_You_Do_not_have_any_follow_up_questions').'</section></section>';
	}
	?>
<?php include getViewsPath() . 'pagination.php'; ?>




<script>
    $(document).ready(function () {

        $('input[type=radio].star').rating();
    });

</script>



