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
				echo $questionFrm->getFieldHtml('step');
				echo $questionFrm->getFieldHtml('file_name'); 
				$questionFrm->getField('orquestion_med_history')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_history');
				$questionFrm->getField('orquestion_doctor_id')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_doctor_id');
				$questionFrm->getField('subscription_id')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('subscription_id');
				echo $questionFrm->getFieldHtml('user_id');
			?>
			 <?php if($plan_data['subs_price']>0){ ?>
  <h5 class="ask-steps__main__title"><?php echo getlabel('L_Choose_your_payment_method'); ?></h5>
			 <?php }?>
  <div class="payment__options">
  <?php if($plan_data['subs_price']>0){?>
	<ul class="payment__methods clearfix">
	  <li><a href="javascript:void(0);" class="selected"><img src="<?php echo CONF_WEBROOT_URL; ?>images/fixed/paypal.png" alt=""></a></li>
	  <!--li><a class="selected" href="javascript:void(0);"><img src="images/fixed/creditcard.png" alt=""></a></li-->
	</ul>
  <?php }?>
	<div class="payment__method__content" >
	<div class="form__block ">
		  <table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			  <tr>
				<td colspan="2">
			
				<input class="button button--fill button--orange" value="<?php echo Utilities::getLabel('LBL_Confirm_Your_Order');?>" type="button" onclick="$('#frmQuestionForm').submit();">
				
				
				</td>
				
			  </tr>
			</tbody>
		  </table>
		</div>
		
	</div>
	<div class="payment__method__content" style="display:none;">
	  <form class="form form__horizontal">
		<div class="form__block ">
		  <h5 class="form__title">Enter your personal information</h5>
		  <table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			  <tr>
				<td colspan="2"><label class="form__caption">Enter your card information</label>
				  <input type="text"></td>
				<td><label class="form__caption">CVV Number(3 or 4 digit code)</label>
				  <input type="text" placehoder="CVV No."></td>
			  </tr>
			  <tr>
				<td ><label class="form__caption">Cardholder's Name</label>
				  <input type="text" placeholder="Enter Cardholder's Name"></td>
				<td><label class="form__caption">Select Expiration Month</label>
				  <select>
					<option> Select Month </option>
					<option> January </option>
					<option> February </option>
				  </select></td>
				<td><label class="form__caption">Select Expiration Year</label>
				  <select>
					<option> Select Year </option>
					<option> January </option>
					<option> February </option>
				  </select></td>
			  </tr>
			  <tr>
				<td ><label class="form__caption">Zip/Billing Code</label>
				  <input type="text" placeholder="Enter Billing Code"></td>
				   <td colspan="2"><label class="checkbox leftlabel">
					<input type="checkbox">
					<i class="input-helper"></i>Zip/Postal code for your credit card's billing address.</label></td>
				  </tr>
			 
			</tbody>
		  </table>
		</div>
		<div class="form__block ">
		  <table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			  <tr>
				<td colspan="2"><input class="button button--fill button--orange" value="Submit" type="button" onclick="$('#frmQuestionForm').submit();"></td>
			  </tr>
			</tbody>
		  </table>
		</div>
	 
	</div>
  </div>
   <?php echo $questionFrm->getExternalJs();?>
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
</main><script>
  var step = "<?php echo $step;   ?>";

  </script>

