<!--Main-->
<main class="site-main "> 
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          <div class="span-md-12 span-sm-12 span-xs-12">
            <div class="dashboard">
             <?php include getViewsPath() . 'common/customer/left-menu.php'; ?>
              <div class="dashboard__content">
                <h2 class="dashboard_title"><?php echo getLabel('L_Dashboard');?></h2>
                <div class="dashboard-count">
                	<ul>
                    	<li><div class="box box--white">
                            <div class="stats stats--first">
                                <img src="/images/fixed/questions.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Asked_Questions');?> </p>
                                <h2><?php echo $all_question_count; ?></h2>
                                <a href="<?php echo generateUrl('customer', ''); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                        <li><div class="box box--white">
                            <div class="stats stats--second">
                                <img src="/images/fixed/answers.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Accepted_Questions');?> </p>
                                <h2><?php echo $accepted_question_count;?></h2>
                                <a href="<?php echo generateUrl('customer', ''); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                        <li><div class="box box--white">
                            <div class="stats stats--third">
                                <img src="/images/fixed/unanswered.svg" class="stats__icon">
                                <p> <?php echo getLabel('L_My_Pending_Questions');?></p>
                                <h2><?php echo $pending_question_count;?></h2>
                                <a href="<?php echo generateUrl('customer', ''); ?>" class="stats__link"></a>
                            </div>
                        </div></li>
                    
                    </ul>
                    
                
                </div>
                <h2 class="dashboard_subtitle"><?php echo getLabel('L_Pending_Questions');?> </h2>

				<?php include getViewsPath() . 'common/customer/pending_questions.php'; ?>
				
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

