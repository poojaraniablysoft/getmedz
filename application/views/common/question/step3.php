
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
<?php echo $questionFrm->getFormTag(); 


	 //$questionFrm->getField('orquestion_doctor_id')->requirements()->setRequired();
	 
	echo $questionFrm->getFieldHtml('orquestion_doctor_id');
    //echo $questionFrm->getFieldHtml('subscription_id');
	?>
    <?php
	if(!empty($related_doctor_data)) 
	{ 
    ?>
              <h5 class="ask-steps__main__title"><?php echo getlabel('L_Best_Available_Doctor') ?><span class="tooltip"> <?php echo count($related_doctor_data) .' '. getlabel('L_Doctors_Available') ?> </span></h5>
			  
              <ul class="doctors_list doctors__results">
			  <?php foreach($related_doctor_data as $doctor_data) { ?>
			  <!--input type="checkbox" name="select_doctor[]" value = <?php echo $doctor_data['doctor_id'] ;?> id="select_doctor" required-->
                <li class="team__item item__<?php echo $doctor_data['doctor_id']?>"  onclick="doctorSelection('<?php echo $doctor_data['doctor_id']?>')">
                  <div class="doctor__figure">
                    <div class="doctor__thumb"> <img src="<?php echo generateUrl('image','getDoctorProfilePic',array($doctor_data['doctor_id'],305,305)) ?>" alt=""> </div>
                  </div>
                  <div class="doctor__content">
                    <h5 class="doctor__name"><?php echo doctorDisplayName($doctor_data['doctor_first_name'].$doctor_data['doctor_last_name']); ?></h5>
                    <p class="doctor__expertise"><?php echo $doc['category_name']; ?></p>
                    <div class="reviews "> <span><?php if($doctor_data['rating'] >0) { echo createStar('star_rating'.$doctor_data['doctor_id'],ceil($doctor_data['rating'])); ?></span> <span><?php echo number_format($doctor_data['rating'],1)."/5"; }?></span> </div>
                    <span class="answers"><?php echo getlabel('L_Answers')?>: <?php echo $doctor_data['answers']?></span> <a target="_blank" href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']))?>" class="inline-link"><?php echo getlabel('L_View_Profile')?></a> </div>
                </li>
			  <?php } ?>              
                
               
                
              </ul>
              <div class="actions"><a href="javascript:;" onclick="" class="button button--non-fill button--primary fl--left prev-js"><?php echo getlabel('L_Previous')?> </a> 
				<?php echo $questionFrm->getFieldHtml('btn_login') ?>
			  <!--a href="javascript:;" class="button button--fill button--orange fl--right" ><?php echo $questionFrm->getFieldHtml('btn_login') ?></a--> </div>
	<?php } else { ?>
	<div class="no-item"> <?php echo getLabel(L_No_Doctors_Available) ; ?></div>
	<?php } ?>
			  <?php echo $questionFrm->getExternalJs();?>
			  <?php
			   $questionFrm->getField('orquestion_med_category')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_category');
				echo $questionFrm->getFieldHtml('subscription_id');
				echo $questionFrm->getFieldHtml('user_id');
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
				echo $questionFrm->getFieldHtml('step');
				echo $questionFrm->getFieldHtml('file_name');
				$questionFrm->getField('orquestion_term')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_term');				
				$questionFrm->getField('orquestion_med_history')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_history');
			?>
              </form>
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
</main>


<script>
  var step = "<?php echo $step;   ?>";
 
  </script>

<script>
<?php if($postedData['orquestion_doctor_id']){?>
doctorSelection('<?php echo $postedData['orquestion_doctor_id']?>')
<?php } ?> 
    $(document).ready(function () {

        $('input[type=radio].star').rating();
    });

</script>
		