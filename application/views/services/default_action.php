<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getLabel('L_All_Medical_Services');?></h5>
            <h6 class="sub-heading-text text--center text--white"><?php echo getLabel('L_Featured_by_Department');?></h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section ">
    <div class="container">
      <div class="span-row">
       
          <div class="services">
            <div class="span-md-9 span-sm-12 span-xs-12">
			<?php if(isset($medical_service_count) && $medical_service_count>0) { ?>
			
              <h5 class="block-title"><?php echo getLabel('L_All_Medical_Services');?><span>(<?php echo $medical_service_count; ?>)</span></h5>
			  <div id="listing-div"> </div>
			<?php } 
			else
			{ ?>
				<div class="no-items"><?php echo getLabel('M_No_Medical_Services_Added');?> </div>
			<?php }
			?>
			  </div>
             
            
            <div class="span-md-3 span-sm-12 span-xs-12">
              <div class="sidebar-banner">
                <h2><?php echo getLabel('L_Best_Services_for_you');?></h2>
                <h3><?php echo getLabel('L_Getmedz,_provided_you_best_medical_services');?></h3>
                <div class="banner--thumb"> <img src="images/fixed/nurse.svg" alt=""> </div>
                <p><?php echo getLabel('L_Now_available_24X7_for_any_medical_related_queries/information');?></p>
              </div>
              <div class="count-block">
                <div class="count__ques count"><?php echo $question_count; ?><span><?php echo getLabel('L_Questions');?></span></div>
                <div class="count__ans count"><?php echo $reply_count?><span><?php echo getLabel('L_Answers');?></span></div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </div>
  
 <div class="section section-orange cta--section">
    <div class="container">
      <div class="cta--section__inner">
        <h2><?php echo getLabel('L_Ask_your')?> <span><?php echo getLabel('L_Question')?></span></h2>
        <p><?php echo getLabel('L_Ask_your_content')?>
		</p>
        <a href="<?php echo generateUrl('#ask-question') ?>" class="button button--fill button--white"><?php echo getLabel('L_Get_your_answer')?></a> </div>
    </div>
  </div>
  
</main>




