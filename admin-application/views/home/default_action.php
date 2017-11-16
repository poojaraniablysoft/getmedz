<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>

        <!--main panel start here-->
        <div class="page dashboard-home">
            <div class="fixed_container">
                <div class="row">
				
					 <ul class="cellgrid">
                       <li>
                            <div class="blue">
                                <div class="flipper">
                                    <div class="front">
                                        <div class="iconbox ">
                                            <figure class="icon"><img src="images/box_icon1.png" alt=""></figure>
                                            <span class="value"><span>Total Users</span><?php echo $total_users;?></span>
                                           
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="orange">
                                <div class="flipper">
                                    <div class="front">
                                        <div class="iconbox">
                                            <figure class="icon"><img src="/images/doc.png" alt=""></figure>
                                            <span class="value"><span>Total Doctors</span><?php echo $total_doctors;?></span>
                                           
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </li>
						<li>
                            <div class="purple">
                                <div class="flipper">
                                    <div class="front">
                                        <div class="iconbox">
                                            <figure class="icon"><img src="/images/question.png" alt=""></figure>
                                            <span class="value"><span>Total Questions</span><?php echo $total_questions;?></span>
                                         
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </li>
						<li>
                            <div class="darkgreen">
                                <div class="flipper">
                                    <div class="front">
                                        <div class="iconbox">
                                            <figure class="icon"><img src="images/box_icon4.png" alt=""></figure>
                                            <span class="value"><span>Total Earnings</span><?php echo $total_earnings;?></span>
                                           
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </li>
						
					</ul>
					<div class="fourcols question_stats">                     
                        
                            <div class="col-sm-3">
                                 <div class="coloredbox darkgreen whitewrap">
									<div class="top">
                                        <span class="txtsmall">Total Questions being Answeres</span>
                                      
                                    </div>
                                    <div class="body">
                                        <h3><?php echo $total_question_answered;?></h3>
                                       
                                    </div>
                                 </div>
                            </div> 
							<div class="col-sm-3">
                                 <div class="coloredbox blue whitewrap">
									<div class="top">
                                        <span class="txtsmall">Total closed questions</span>
                                      
                                    </div>
                                    <div class="body">
                                        <h3><?php echo $total_closed_question;?></h3>
                                     
                                    </div>
                                 </div>
                            </div> 
							<div class="col-sm-3">
                                 <div class="coloredbox orange whitewrap">
									<div class="top">
                                        <span class="txtsmall"> Total Unanswered Question</span>
                                      
                                    </div>
                                    <div class="body">
                                        <h3><?php echo $total_unanswered_question;?></h3>
                                     
                                    </div>
                                 </div>
                            </div> 
							<div class="col-sm-3">
                                 <div class="coloredbox  whitewrap">
									<div class="top">
                                        <span class="txtsmall">Average Doctor Rating</span>
                                       
                                    </div>
                                    <div class="body">
                                       <div class="admin_star_rating"><?php echo createStar('star_rating',ceil($average_doctor_rating)); ?> <span><?php echo number_format($average_doctor_rating,1)."/5";?></span> </div>
                                        
                                    </div>
                                 </div>
                            </div> 
                           
                    </div>	 <?php if($approval_questions){ ?>
          <div class="col-sm-12">  
                        <section class="section">
                            <div class="sectionhead">
                                <h4>Latest 5 Orders Need Approval for Reply </h4>
                                <!--<a href="" class="themebtn btn-default btn-sm">View All</a>-->
                                <ul class="actions">
                                    <li class="droplink">
                                        <a href="javascript:void(0)"><i class="ion-android-more-vertical icon"></i></a>
                                        <div class="dropwrap">
                                            <ul class="linksvertical">
                                                <li><a  onclick="redirectUser('<?php echo generateUrl('questions','');?>')"  href="javascript:void(0);">View All</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sectionbody">
                                <div class="tablewrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                              <th>Date</th>
                                              <th>Order ID</th>
                                              <th width="30%">Order Question</th>
                                              <th>Customer</th>
                                              <th>Doctor Assigned</th>
                                              <th>Action</th>
                                            </tr>
                                        </thead>  
                                        <tbody>
										<?php foreach($approval_questions as $question){ ?>
                                            <tr>
                                              <td><?php echo displayDate($question['order_date']);?></td>
                                              <td><?php echo $question['order_id'];?></td>
                                              <td><div class="scrolltext"><?php echo $question['orquestion_question']; ?></div></td>
                                              <td><?php echo $question['username'];?></td>
                                              <td><?php echo ($question['doctorname'])?$question['doctorname']:'N/A';?></td>
                                              <td><ul class="actions"><li><a href="<?php echo generateUrl('questions','view',array($question['orquestion_id']));?>">
													<i class="ion-eye icon"></i></a></li></ul>								
											</td>
                                            </tr>
                                           <?php }?>
                                        </tbody>    
                                    </table>
                                </div>    
                            </div>
                        </section>
                    </div> 
                 <?php  }?>
		<?php if($latest_questions){ ?>
          <div class="col-sm-12">  
                        <section class="section">
                            <div class="sectionhead">
                                <h4>Latest 5 Orders </h4>
                                <!--<a href="" class="themebtn btn-default btn-sm">View All</a>-->
                                <ul class="actions">
                                    <li class="droplink">
                                        <a href="javascript:void(0)"><i class="ion-android-more-vertical icon"></i></a>
                                        <div class="dropwrap">
                                            <ul class="linksvertical">
                                                <li><a onclick="redirectUser('<?php echo generateUrl('questions','');?>')" href="javascript:void(0);">View All</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sectionbody">
                                <div class="tablewrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                              <th>Date</th>
                                              <th>Order ID</th>
                                              <th width="30%">Order Question</th>
                                              <th>Customer</th>
                                              <th>Status</th>
                                            </tr>
                                        </thead>  
                                        <tbody>
										<?php 
                                                                                
                                                                                foreach($latest_questions as $val){ ?>
                                            <tr>
                                              <td><?php echo displayDate($val['order_date']);?></td>
                                              <td><?php echo $val['order_id'];?></td>
                              <td><div class="scrolltext"><?php echo $val['orquestion_question']; ?></div></td>
                                              <td><?php echo $val['username'];?></td>
                                              <td><ul class="actions"><li><a href="<?php echo generateUrl('questions','view',array($val['orquestion_id']));?>">
													<i class="ion-eye icon"></i></a>	</li>								
													</ul>
											</td>
                                            </tr>
                                           <?php }?>
                                        </tbody>    
                                    </table>
                                </div>    
                            </div>
                        </section>
                    </div> 
                 <?php  }?>
                
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
		});
		</script> 