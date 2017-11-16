
                   <?php
            if (count($arr_listing) > 0) {
                foreach ($arr_listing as $question) {
                    ?><section class="roundedbox">
                        <div class="boxbody">
                            <div class="boxgrids">
                                <div class="grid_1"><?php echo subStringByWords($question['orquestion_question'],180); ?>
                                    <a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>">View and Reply</a>
                                    <div class="answered_time"><?php if ($reply['reply_by'] == 0) { ?>Answered On <?php } echo date("D, dS M Y h:i T", strtotime($question['order_date'])); ?></div>
                                    <div class="question_status border-top">Patient has sent a followup Qyestion</div>                                      
                                </div>					      					      
                                <div class="grid_2">
                                    <ul class="verticalNav ques-act">
                                        <li class="ion-ios-eye " ><a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>">View Answer</a></li>
                                       
                                    </ul>
                                </div>
                                <div class="grid_3">
                                    <div class="avtararea padd_all user_thumb">
                                        <figure class="pic ">
                                            <form>
                                                <img alt="" src="<?php echo generateUrl('image','getCustomerProfilePic',array($question['user_id'],500,500),"/")?>">
                                            </form>    
                                        </figure>
                                        <div class="picinfo">
                                            <span class="name"><?php echo $question['user_name']; ?></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                     <?php
                }
            } else {
                echo '<section class="section"><section class="sectionbody space">You do not have any follow up questions</section></section>';
            }
            ?>
	<?php include getViewsPath() . 'pagination.php'; ?>