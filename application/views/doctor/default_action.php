<!--Main-->
<main class="site-main "> 
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          <div class="span-md-12 span-sm-12 span-xs-12">
            <div class="dashboard">
             <?php include getViewsPath() . 'common/doctor/left-menu.php'; ?>
              <div class="dashboard__content">
                <h2 class="dashboard_title"><?php echo getLabel('L_Dashboard');?></h2>
                <div class="dashboard-count">
                	<ul>
                    	<li><div class="box box--white">
                            <div class="stats stats--first">
                                <img src="/images/fixed/questions.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Total_Questions');?> </p>
                                <h2><?php echo $menu_count['all_question']?></h2>
                                <a href="<?php echo generateUrl('doctor', 'questions'); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                        <li><div class="box box--white">
                            <div class="stats stats--second">
                                <img src="/images/fixed/answers.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Answered_Questions');?> </p>
                                <h2><?php echo $menu_count['answered_question']?></h2>
                                <a href="<?php echo generateUrl('doctor', 'myansweredquestions'); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                        <li><div class="box box--white">
                            <div class="stats stats--third">
                                <img src="/images/fixed/unanswered.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Unanswered_Questions');?></p>
                                <h2><?php echo $menu_count['unanswered_question']?></h2>
                                <a href="<?php echo generateUrl('doctor', 'unansweredquestions'); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                    
                    </ul>
                    
                
                </div>
                <h2 class="dashboard_subtitle"><?php echo getLabel('L_Patient_Follow_Up_Questions');?> </h2>
				<?php  include getViewsPath() . 'common/doctor/latest_questions.php'; ?>
               
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>





<!--main panel start here-->
<!--div class="page">
    <div class="fixed_container">
        <div class="row">
            <ul class="breadcrumb arrow">
                <li><a href="<?php echo generateUrl('doctor'); ?>">Home</a></li>

                <li>Patient Follow-up Questions</li>
            </ul>
            <span class="gap"></span>
        </div> 
        <h1>Patient Follow-up Questions</h1> 
		<div class="col-sm-12">  
       
        <div id="msg_info"></div>
        <?php echo Message::getHtml(); ?>
    </div>

        <div class="row" id="listing-div">
                <?php  include getViewsPath() . 'common/doctor/followupquestions.php'; ?>

        </div>
    </div>



    
</div>
</div>  


</div-->
<!--body end here-->
