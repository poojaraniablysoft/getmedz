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
                <h2 class="dashboard_title"><?php if(isset($question_title) && $question_title!='' ) { echo $question_title; } else { echo getLabel('L_My_Questions'); }?></h2>
				<div class="row" id="listing-div">
					<?php  //include getViewsPath() . 'common/doctor/latest_questions.php'; ?>
				</div>               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
