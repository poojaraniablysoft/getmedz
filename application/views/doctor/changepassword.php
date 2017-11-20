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
					<h2 class="dashboard_title"><?php echo getLabel('L_Edit_profile');?></h2>
					<?php include getViewsPath() . 'common/doctor/profile-top.php'; ?>
                <div class="profileNav">
				  <ul>
					<li><a  href="<?php echo generateUrl('doctor','profile') ?>"><?php echo getLabel('L_Edit_profile');?></a></li>
					<li><a class="active" href="<?php echo generateUrl('doctor','changepassword') ?>"><?php echo getLabel('L_Change_Password');?></a></li>
				  </ul>
				</div>
                <div class="tabContent">
				<?php echo $frm->getFormTag();?>
                  
                    <div class="form__block ">
                      <h5 class="form__title"><?php echo getLabel('L_Update_Password');?></h5>
                      <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td><label class="form__caption"><?php echo getLabel('L_Current_Password');?></label>
                              <?php echo $frm->getFieldHtml('current_password'); ?></td>
                           <td><label class="form__caption"><?php echo getLabel('L_New_Password');?></label>
                              <?php echo $frm->getFieldHtml('new_password'); ?></td>
                               <td><label class="form__caption"><?php echo getLabel('L_Confirm_New_Password');?></label>
                              <?php echo $frm->getFieldHtml('new_password1'); ?></td>
                          </tr>
                       
                        </tbody>
                      </table>
                    </div>
                    <div class="form__block ">
                      <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
						  
                            <td colspan="2">
							<?php echo $frm->getFieldHtml('btn_submit'); ?>
							<?php echo $frm->getExternalJs(); ?>
							
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
