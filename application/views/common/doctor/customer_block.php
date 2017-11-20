
  <div class="dashboard__list-box">
	<div class="patient--details">
	  <table class="table nopadding table-responsive ">
		<tr>
		  <td><strong><?php echo Utilities::getLabel('LBL_Name');?>: </strong> <?php echo ($arr_question['orquestion_name'])?$arr_question['orquestion_name']:$arr_question['user_name']; ?></td>
		  <td><strong><?php echo Utilities::getLabel('LBL_Email');?>: </strong> <?php echo $arr_question['user_email']; ?></td>
		   
		</tr>
		<tr>
		<td><strong><?php echo Utilities::getLabel('LBL_Weight');?>:</strong> <?php echo ($arr_question['orquestion_weight']) ?Applicationconstants::$arr_weight_kgs[$arr_question['orquestion_weight']] : 'Not Available'; ?></td></td>
		 <td ><strong><?php echo Utilities::getLabel('LBL_Gender');?>:</strong> <?php echo ($arr_question['orquestion_gender']) ? Applicationconstants::$arr_gender[$arr_question['orquestion_gender']] : 'Not Available'; ?></td>
		
		</tr>
		<tr>
		<td><strong><?php echo Utilities::getLabel('LBL_Age');?>: </strong> <?php echo ($arr_question['orquestion_age']) ? Applicationconstants::$arr_age_year[$arr_question['orquestion_age']] : 'Not Available'; ?></td>
		<td ><strong><?php echo Utilities::getLabel('LBL_Member_Since');?>:</strong> <?php echo displayDate($arr_question['user_added_on']); ?></td><td></td></tr>
	  </table>
	</div>
  </div>
  <div class="dashboard__list-box">
	<div class="dashboard--userinfo">
	  <div class="user_media"> <img src="<?php echo generateUrl('image', 'getCustomerProfilePic', array($arr_question['user_id'], 500, 500), "/") ?>" alt=""> </div>
	  <a class="dashboard__username" href="javascript:;"><?php echo $arr_question['user_name']; ?></a> 
	</div>	  
  </div>

