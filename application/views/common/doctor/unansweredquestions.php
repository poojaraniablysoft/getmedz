<?php
if (count($arr_listing) > 0) {
  foreach ($arr_listing as $question) { ?> 
	<div class="dashboard_bordered-box roundedbox" id="roundedbox_<?php echo $question['orquestion_id']?>">
	  <div class="dashboard__list-box">
		<div class="question_asked">
		  <p><a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>"><?php echo subStringByWords($question['orquestion_question'],180); ?> </a>
		  <a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>"><?php echo getLabel('L_VIEW');?></a>
		  </p>
		  
		  <span class="questio_askedon"><span><?php if ($reply['reply_by'] == 0) { ?><?php echo getLabel('L_Asked_On')?> <?php } ?></span> <?php  echo date("D, dS M Y h:i T", strtotime($question['order_date'])); ?></span>  
		  <div class="question_status border-top"><?php echo getLabel('L_THIS_QUESTION_HAS_NOT_BEEN_ANSWERED_BY_YOU.');?></div>
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
			</i><span><?php echo getLabel('L_ACCEPTED');?></span></li>
			 <li class="hdisplay ion-close"> <a href="javascript:void(0);" onClick="change_question_status(<?php echo $question['orquestion_id'].",".Question::QUESTION_PENDING?>)" > <?php echo getLabel('L_REJECT_QUESTION');?></a></li>
			<li class="ion-ios-eye hdisplay" ><a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>" > <?php echo getLabel('L_VIEW_AND_REPLY');?></a></li>
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
		echo '<section class="section"><section class="sectionbody space">'. getLabel('L_You_do_not_have_any_unanswered_any_question_yet').'</section></section>';
	}
	?>
<?php include getViewsPath() . 'pagination.php'; ?>
