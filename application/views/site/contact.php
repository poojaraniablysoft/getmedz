<?php

defined('SYSTEM_INIT') or die('Invalid Usage');

?>
<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getLabel('L_Contact_US');?></h5>
            <h6 class="sub-heading-text text--center text--white"><?php echo getLabel('L_We_shall_get_in_touch_with_you_in_next_24_Hours');?></h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section contact--section">
    <div class="container">
      <div class="span-row">
        <div class="span-md-12 ">
          <div class="contact--us">
            <div class="contact--form">
			<?php// echo $frm->getFormHtml(); ?>
			<?php echo $frm->getFormtag();		?>             
                <div class="form__block ">
                  <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td><label class="form__caption"><?php echo getLabel('L_Name');?></label>
                          <?php	echo $frm->getFieldHTML('c_name');		?>
						  </td>
                        <td><label class="form__caption">Phone Number</label>
                          <?php	echo $frm->getFieldHTML('c_phone');		?>
						  </td>
                      </tr>
                      <tr>
                        <td colspan="2"><label class="form__caption">Email</label>
                          <?php	echo $frm->getFieldHTML('c_user_email');		?></td>
                      </tr>
                      <tr>
                        <td colspan="2"><label class="form__caption">Message</label>
                          <?php	echo $frm->getFieldHTML('c_message');		?></td>
                      </tr>
                     
                    </tbody>
                  </table>
                </div>
                <div class="form__block ">
                  <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                     <tr>
                        <td >
						<!--div class="g-recaptcha" data-sitekey="6LcY7hkUAAAAADTOHlEPkUgq7xX4Rd8696jCMGe2"></div-->
						<?php	echo $frm->getFieldHTML('mode');		?>
						<?php 	echo $frm->getFieldHTML('securimage');		?>
                        <!--div class="captcha">
                         <img src="images/fixed/captcha.jpg" alt=""></div--></td>
                      
                     
                        <td ><label class="form__caption">&nbsp;</label>
						<?php	echo $frm->getFieldHTML('btn_submit');		?>
						</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
				<?php echo $frm->getExternalJS();		?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php //echo render_block("Getmedz_features")?>
</main>


<script src='https://www.google.com/recaptcha/api.js'></script>















   <!--div class="cont-wrapper final-right-frm-area">

    <div class="centered ">
   
<?php echo $frm->getFormHtml(); ?>
    </div>
   </div-->
		
		
                                                    
	


