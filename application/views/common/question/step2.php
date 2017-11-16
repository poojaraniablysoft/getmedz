<?php

	?>
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
				echo $questionFrm->getFieldHtml('step');
				echo $questionFrm->getField('orquestion_term')->requirements()->setRequired();
				echo $questionFrm->getField('orquestion_med_history')->requirements()->setRequired();
				echo $questionFrm->getField('orquestion_name')->requirements()->setRequired();
				echo $questionFrm->getField('orquestion_gender')->requirements()->setRequired();
				echo $questionFrm->getField('orquestion_age')->requirements()->setRequired();
				echo $questionFrm->getField('orquestion_weight')->requirements()->setRequired();
				if(!Members::getLoggedUserID()){
					$required = true;
				}else{
					$required = false;
				}
				$questionFrm->getField('orquestion_email')->requirements()->setRequired($required);
			
				echo $questionFrm->getField('orquestion_state')->requirements()->setRequired();
			?>
    <?php //echo $questionFrm->getFieldHtml('btn_login'); ?>
                <div class="form__block ">
                  <h5 class="form__title"><?php echo Utilities::getLabel('LBL_Explain_your_medical_history_and_symptoms');?></h5>
                  <table  width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="2"><label class="form__caption"><?php echo Utilities::getLabel('LBL_Medical History');?></label>
                        <?php echo $questionFrm->getFieldHtml('orquestion_med_history'); ?></td>
                    </tr>
                  </table>
                </div>
                <div class="form__block ">
                  <h5 class="form__title"><?php echo Utilities::getLabel('LBL_Enter_your_personal_information');?></h5>
                  <table  width="100%" cellpadding="0" cellspacing="0">
                    <tr>
					<?php $user_id=Members::getLoggedUserID();		
				if(!$user_id ){
                      $questionFrm->getField('orquestion_name')->requirements()->setRequired();
				 } ?>
						<td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Name');?></label>
					  
                        <?php echo $questionFrm->getFieldHtml('orquestion_name'); ?></td>
                      <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Select_Gender');?></label>
					  <?php echo $questionFrm->getFieldHtml('orquestion_gender'); ?>
                       </td>
                    </tr>
                    <tr>
                      <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Select_Age');?></label>
					  <?php echo $questionFrm->getFieldHtml('orquestion_age'); ?>
                        </td>
                      <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Weight_(in_Kgs)');?> </label>
                       <?php echo $questionFrm->getFieldHtml('orquestion_weight'); ?>
					   </td>
                    </tr>
                    <tr>
                      <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Select_Location');?></label>
					  <?php echo $questionFrm->getFieldHtml('orquestion_state'); ?>
                        </td>
                      <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Phone_Number');?></label>
                        <?php echo $questionFrm->getFieldHtml('orquestion_phone'); ?>
					   </td>
                    </tr>
					<?php $user_id=Members::getLoggedUserID();		
					if(!$user_id ){?>
                    <tr>
						<td colspan="2"><label class="form__caption"><?php echo Utilities::getLabel('LBL_Email');?></label>
							<?php $questionFrm->getField('orquestion_email')->requirements()->setRequired(); echo $questionFrm->getFieldHtml('orquestion_email'); ?>
						</td>
                    </tr>
					<?php } ?>
                    <tr>
                      <td colspan="2"><label class="checkbox leftlabel">
                          <?php echo $questionFrm->getFieldHtml('orquestion_term');
						
							$pageSlug = Cms::getPageSlugById(CONF_TERMS_PAGE);
						  ?>
                          <i class="input-helper"></i><?php echo Utilities::getLabel('LBL_I_agree_to_Getmedz');?><a  target="_blank" class="inline-link" href="<?php echo Utilities::generateUrl('page', $pageSlug);?>"> <?php echo Utilities::getLabel('L_Terms_&_Conditions');?></a></label></td>
                  </table>
                </div>
                <div class="actions">
				<a href="javascript:void(0)"  class="button button--non-fill button--primary fl--left prev-js"><?php echo Utilities::getlabel('LBL_Previous')?> </a>
				<?php echo $questionFrm->getFieldHtml('btn_login') ?>
				</div>
                  <!--table  width="100%" cellpadding="0" cellspacing="0">
					<tr>
					
                      <td colspan="2"><?php echo $questionFrm->getFieldHtml('btn_previous') ?></td>
                    </tr>
                    <tr>
					
                      <td colspan="2"><?php echo $questionFrm->getFieldHtml('btn_login') ?></td>
                    </tr>
                  </table-->
                 	<?php
					$questionFrm->getField('orquestion_med_category')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_category');
				echo $questionFrm->getFieldHtml('user_id');
				echo $questionFrm->getFieldHtml('orquestion_doctor_id');
				echo $questionFrm->getFieldHtml('subscription_id');
				$questionFrm->getField('orquestion_question')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_question');
				 $emailFld = $questionFrm->getField('user_email');
				  echo $questionFrm->getFieldHtml('file_name');		?>
				<?php echo $questionFrm->getFieldHtml('orquestion_med_category') ?>
				<?php echo $questionFrm->getFieldHtml('orquestion_question') ?>
				<?php echo $questionFrm->getExternalJs();?>
              </form>
          </form></div>
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
  var step = "<?php echo $step;   ?>";
 
  </script>
