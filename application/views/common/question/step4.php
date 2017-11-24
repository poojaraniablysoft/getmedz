<script> var step = "<?php echo $step;   ?>"; </script>


<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getLabel('L_ASK_Doctor')?></h5>
            <h6 class="sub-heading-text text--center text--white"> <?php echo getLabel('L_Help_Doctors_to_understand_your_problem_better')?> </h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        <div class="ask-category span-md-12">
          <div class="ask-category__block"> <i class="ask-category__icon"><img src="<?php echo generateUrl('image', 'medical_category', array($cat_data['category_id'], 45, 45) ) ?>" alt=""> </i>
            <div class="ask-category__content">
              <h5><?php echo $cat_data['category_name']; ?></h5>
              <p><?php echo $question; ?> </p>
              <?php if(isset($attchment) && !empty($attchment)) { ?><a class="inline-link" href="<?php echo generateUrl('home','get_self_attachment',array($attchment),CONF_WEBROOT_URL) ?>"><?php echo getlabel(L_View_Attachment);?></a> 
			  <?php } ?>
			  </div>
          </div>
        </div>
        <div class=" span-md-12">
		<div class="ask-steps">
           <?php  include getViewsPath() . 'common/question/ask-step_sidebar.php';?>
<div class="ask-steps__main">

    <?php echo $questionFrm->getFormTag(); ?>
   <?php 
     $questionFrm->getField('subscription_id')->requirements()->setRequired();
    echo $questionFrm->getFieldHtml('subscription_id');
	
	
    ?> 
              <h5 class="ask-steps__main__title"><?php echo getLabel(L_Choose_Plan_from_this_list);?></h5>
              <div class="plans">
			  <?php 
			  $subscription  = Subscription::getactiveSubscription()->fetch_all();
			  if(!empty($subscription))
			  {
                    $checked=true;
                    foreach ($subscription  as $key => $value): 
                        
                        ?>
						
                <div class="plans__wrap plan__<?php echo $value['subs_id'] ?> " onclick="planSelection('<?php echo $value['subs_id'] ?>')">
                  <div class="plan__detail">
                    <h5 class="plan__title"><?php echo $value['subs_name'] ?><?php if($value['subs_popular']==1){?>
							<span class="tooltip right"><?php echo getLabel('L_Most_Popular');?></span>
							<?php }?></h5>
					<?php if($value['subs_subheading']){?>
                    <p><?php echo $value['subs_subheading'];?> </p>
					<?php } ?>
                    <ul class="plan__features">
                      <li>One Question</li>
                      <li>one Response</li>
                      <li>24-48 hrs response time</li>
                    </ul>
                  </div>
				  
                  <div class="plan__pricing"> <!--span><sup>$</sup>9<sub>.00</sub></span-->
				  <?php echo $value['subs_price_text'] ?>
				  <?php if($value['subs_price_subheading']){?>
                    <p><?php echo $value['subs_price_subheading'];?></p>
				  <?php } ?>
                  </div>
                </div>
			  <?php endforeach; } ?>
                <!--div class="plans__wrap selected">
                  <div class="plan__detail">
                    <h5 class="plan__title">Gold CARE<span class="tooltip right">Most Popular</span></h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                      industry. </p>
                    <ul class="plan__features">
                      <li>One Question</li>
                      <li>one Response</li>
                      <li>24-48 hrs response time</li>
                    </ul>
                  </div>
                  <div class="plan__pricing"> <span><sup>$</sup>19<sub>.95</sub></span>
                    <p>per consultation</p>
                  </div>
                </div-->
              </div>
              <div class="actions"><a href="javascript:;" onclick="" class="button button--non-fill button--primary fl--left prev-js"><?php echo getlabel('L_Previous')?></a>
				<?php echo $questionFrm->getFieldHtml('btn_login') ?>
			  <!--a href="javascript:;" onclick="$('#frmQuestionForm').submit();" class="button button--fill button--orange fl--right"><?php echo getlabel('L_Next_Step')?></a--> </div>
			   <?php
			  
			   $questionFrm->getField('orquestion_med_category')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_category');
				$questionFrm->getField('orquestion_question')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_question');
				$questionFrm->getField('orquestion_name')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_name');
				$questionFrm->getField('orquestion_gender')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_gender');
				$questionFrm->getField('orquestion_age')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_age');
				$questionFrm->getField('orquestion_weight')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_weight');
				$questionFrm->getField('orquestion_state')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_state');
				$questionFrm->getField('orquestion_phone')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_phone');
				$questionFrm->getField('orquestion_email')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_email');
				$questionFrm->getField('orquestion_term')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_term');
				echo $questionFrm->getFieldHtml('step');
				echo $questionFrm->getFieldHtml('file_name'); 
				$questionFrm->getField('orquestion_med_history')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_history');
				$questionFrm->getField('orquestion_doctor_id')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_doctor_id');
				echo $questionFrm->getFieldHtml('user_id');
			?>
              </form>
			  <?php echo $questionFrm->getExternalJs();?>
            </div>

 </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="container">
    <div class="getmeds-features">
        <?php  echo render_block('QUESTION_STEP_BLOCK'); ?>
 </div>
    </div>
  </div>
</main><script>
<?php if($postedData['subscription_id']){?>
planSelection('<?php echo $postedData['subscription_id']?>')
<?php } ?> 
</script>
