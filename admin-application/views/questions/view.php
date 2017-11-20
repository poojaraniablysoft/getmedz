<style>

</style><!--main panel start here-->
<div class="page">
<?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">


             
                <h1><?php echo $question['orquestion_question']; ?></h1>

                <section class="section">
                    <div class="sectionbody">                     
                        <div class="row">
                                      <div class="col-md-10 col-xs-8">
                                      	    <table class="table table-responsive nowraptable ">
												<tr><th colspan="2">Patient profile</th></tr>
												<tr><td ><strong>Name: </strong> <?php echo ($arr_question['orquestion_name'])?$arr_question['orquestion_name']:$arr_question['user_name']; ?></td>
													<td><strong>Weight:</strong> <?php echo  $arr_question['orquestion_weight']?></td></tr>
												<tr><td ><strong>Gender:</strong> <?php echo ($arr_question['orquestion_gender']) ? Applicationconstants::$arr_gender[$arr_question['orquestion_gender']] : 'Not Available'; ?></td>
													<td><strong>Age: </strong> <?php echo ($arr_question['orquestion_age']) ? Applicationconstants::$arr_age_year[$arr_question['orquestion_age']] : 'Not Available'; ?></td></tr>
												<tr><td ><strong>Member Since:</strong> <?php echo displayDate($arr_question['user_added_on']); ?></td><td></td></tr>
											</table>
                                      </div>
                                      <div class="col-md-2 col-xs-4">
                                      	 	 <div class="avtararea padd_all">
													<figure class="pic">
														<form>
															<img alt="" src="<?php echo generateUrl('image','getCustomerProfilePic',array($arr_question['user_id'],500,500),"/")?>">
															
														</form>    
													</figure>
													<div class="picinfo">
														<span class="name"> <?php echo $arr_question['user_name']; ?></span>
														<span class="mailinfo"> <?php echo $arr_question['user_email']; ?></span>
													</div>
                           					 </div>
                                      </div>
                         </div>
                    </div>
                </section>
                <section class="section">

                    <div class="sectionbody">
                        <table class="table table-responsive nowraptable" id="response_table">
                            <tr><th  >Patient Health issue</th>
							<th> <?php
                            /* if ($replies) {  ?><span class="ques_reply_status" id="update_reply_<?php echo $arr_question['orquestion_id'];?>"><span >Status:</span><select name="ques_status" id="" class="ques_status" onchange="updateReply(<?php echo $arr_question['orquestion_id'];?>,this.value)">
													<?php  foreach(Applicationconstants::$arr_reply_status as $key=> $val){?>
													<option <?php if($key==$arr_question['orquestion_reply_status']){ echo"selected=selected"; } ?>  value="<?php echo $key;?>"><?php echo $val;?></option>
													<?php } ?>
												</select></span>
									<?php } */?>			
												</th></tr>

                            <tr><td colspan="2" class="question-bg"><span class="red_title">Question</span><?php echo $arr_question['orquestion_question']; ?><div class="posted_time">Asked by <?php echo $arr_question['user_name'];?> on <?php echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?>
                                         <?php if($arr_question['have_file']){?>
                                        <a href="<?php echo generateUrl('doctor', 'getAttachment', array($arr_question['orquestion_id'],Files::QUESTION_POST_ATTACHMENT)) ?>">Download File</a>
                                        <?php } ?>  
                                    </div></td></tr>
                           
                            <tr><td  colspan="2"><span class="red_title">Symptoms/Medical History</span><?php echo ($arr_question['orquestion_med_history']) ? ($arr_question['orquestion_med_history']) : 'N/A'; ?></td>
                            </tr>
							<tr><td colspan="2"> <span class="red_title">Communication Thread</span>
                            <?php
                            if ($replies) { 
                                foreach ($replies as $reply) {
                                    ?>
                                                                <div <?php if($reply['reply_by']==Members::DOCTOR_USER_TYPE) echo'class="grey-bg"'; ?>><?php if($reply['reply_by']==Members::DOCTOR_USER_TYPE) echo'<span class="dname">Dr.'.$reply['replier_name'].'<br/>Answer</span><br/> '; else echo '<span class="pname">'.  $reply['replier_name'] ."'s Reply</span>";?> <?php echo html_entity_decode($reply['reply_text']); ?>
									
                                                                    <div class="answered_time"><?php if($reply['reply_by']==0){ ?>Answered On <?php } echo date("D, dS M Y h:i T", strtotime($arr_question['order_date'])); ?> <?php if($reply['attachments']>0){ ?><a href="<?php echo generateUrl('doctor','getAttachment',array($reply['reply_id']),"/") ?>">Download File</a><?php } ?></div>
								
									
									</div>
                                <?php }
                                ?>


                            <?php } ?>
							</td></tr>
                        </table>
                    </div>
					 <div class="sectionbody">
                        <table class="table table-responsive nowraptable" id="response_table">
                            <tr><th   >Assignment History</th>
							</tr>
							<?php foreach($assignmentHistory as $history){?>
							<tr>
								<td>Question Assigned to <?php echo $history['doctor_name'];?></td>
							</tr>
							<?php } ?>

                          </table>
                    </div>
                </section>

            </div>
        </div>
  
    </div>

    <!--main panel end here-->
</div>
<!--body end here-->

<script type="text/javascript">
		$(function () {
		setTimeout(function(){
			$(".ques_status").selectbox();},500);
		
		
	setTimeout(function(){
<?php 
	
			if($arr_question['orquestion_reply_status']==0){
				$add_class='pending';
			 }
			 elseif($arr_question['orquestion_reply_status']==1){
				$add_class='approved';
			 }
			 else{
			 $add_class='disapproved';
			 }
						
						 ?>
		$add_class='<?php echo $add_class;?>';
	$("#update_reply_"+<?php echo $arr_question['orquestion_id'];?>).children().next().addClass($add_class);
		

},2000); 
 });
 </script>   

