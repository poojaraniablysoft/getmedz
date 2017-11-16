<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getlabel('L_Reset_Password');?> </h5>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        <div class="span-md-12 ">
          <div class="box box--white box--tabled">
            <div class="box__cell">
              <h3></h3>
			  <?php echo Message::getHtml(); ?>
							<?php echo $frm->getFormTag(); ?>
              <!--form class="form form__horizontal"-->
                <div class="form__block ">
                  <h5 class="form__title"><?php echo Utilities::getlabel('L_Forgot_Password?');?></h5>
                  <p><?php echo Utilities::getlabel('LBL_Enter_the_new_password_Associated_With_Your_Account._Click_reset_button_to_change_your_password.' );?></p>
                  <table width="100%" cellspacing="0" cellpadding="0">
                    
					  <tbody>
					  <tr>
							<td colspan="2"><label class="form__caption"><?php echo Utilities::getlabel('L_Password');?></label>
								 <?php echo $frm->getFieldHTML('user_password'); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								 <label class="form__caption"><?php echo Utilities::getlabel('LBL_Confirm_Password');?>
									<?php echo $frm->getFieldHTML('user_password1'); ?>
							</td>
						</tr>
						<tr>

						</tr>
						<tr>
							<td colspan="2">
							<?php echo $frm->getFieldHTML('token'); ?>
							 <?php echo $frm->getFieldHTML('mode'); ?>
								<?php echo $frm->getFieldHTML('user_type'); ?>
								<?php echo $frm->getFieldHTML('btn_submit'); ?>
							</td>
						</tr>
					</tbody>
				</table>
							<?php echo $frm->getExternalJS(); ?>
                </div>
              </form>
              <p class="form--link"><?php echo getlabel('L_Back_to_login');?> <a href="<?php echo generateUrl('members','login')?>" class="inline-link"><?php echo getlabel('L_Click_here');?></a></p>
            </div>
            <div class="box__cell">
              <div class="col--inner">
                <ul class="listing--icons">
                  <li> <i ><img src="<?php echo CONF_WEBROOT_URL ;?>images/fixed/secure.svg" alt=""></i>
                    <p><strong><?php echo getlabel('L_100%_Privacy_Protection');?></strong><?php echo getlabel('L_We_maintain_your_privacy_and_data_confidentiality');?></p>
                  </li>
                  <li> <i ><img src="<?php echo CONF_WEBROOT_URL ;?>images/fixed/doctors.svg" alt=""></i>
                    <p><strong><?php echo getlabel('L_Verified_Doctors');?></strong><?php echo getlabel('L_All_Doctors_go_through_a_stringent_verification_process');?></p>
                  </li>
                  <li> <i ><img src="<?php echo CONF_WEBROOT_URL ;?>images/fixed/answer.svg" alt=""></i>
                    <p><strong><?php echo getlabel('L_Quick_responses');?></strong><?php echo getlabel('L_You_will_receive_responses_to_your_health_queries_within_24_hours');?> </p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php // echo render_block("Getmedz_features")?>
</main>

<script src='https://www.google.com/recaptcha/api.js'></script>


		