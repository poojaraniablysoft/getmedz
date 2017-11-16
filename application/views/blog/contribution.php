<?php defined('SYSTEM_INIT') or die('Invalid Usage');?>

<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"> <?php echo getLabel('L_Contribution_Form'); ?></h5>
           
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="userLogin">
   
		  <?php echo $frmContribute->getFormTag(); ?>   
          <div class="form__block ">
            <h5 class="form__title"><?php echo getLabel('L_Enter_your_information');?></h5>
              <table class="loggin_form">
                            <tbody>
                                <tr>
                                    <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_First_Name');?></label><?php echo $frmContribute->getFieldHtml('contribution_author_first_name'); ?></td>
                                </tr>
                                <tr>
                                    <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Last_Name');?></label><?php echo $frmContribute->getFieldHtml('contribution_author_last_name'); ?></td>
                                </tr>
                                <tr>
                                    <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Email');?></label><?php echo $frmContribute->getFieldHtml('contribution_author_email'); ?></td>
                                </tr>
                                <tr>
                                    <td><label class="form__caption"><?php echo Utilities::getLabel('LBL_Phone_No.');?></label><?php echo $frmContribute->getFieldHtml('contribution_author_phone'); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $frmContribute->getFieldHtml('contribution_file_name'); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $frmContribute->getFieldHtml('htmlNote'); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $frmContribute->getFieldHtml('contribution_user_id'); ?>
                                        <?php echo $frmContribute->getFieldHtml('btn_submit'); ?>
                                    </td>
                                </tr>


                            </tbody></table>
							<?php echo $frmContribute->getExternalJs(); ?>
							</form>
                    <?php

	
		
		?>
		
		 </div>
	
  </div>

  
</main>
 

  <script src='https://www.google.com/recaptcha/api.js'></script>