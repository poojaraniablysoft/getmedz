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
						<li><a class="active" href="<?php echo generateUrl('doctor','profile') ?>"><?php echo getLabel('L_Edit_profile');?></a></li>
						<li><a  href="<?php echo generateUrl('doctor','changepassword') ?>"><?php echo getLabel('L_Change_Password');?></a></li>
					  </ul>
					</div>
					<div class="tabContent">
					  
					  <?php echo $frm->getFormTag(); ?>
						<div class="form__block ">
						  <h5 class="form__title"><?php echo getLabel('L_Enter_your_profile_information');?></h5>
						  <table width="100%" cellspacing="0" cellpadding="0">						  
							<tbody>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_First_Name');?></label>
								  <?php echo $frm->getFieldHtml('doctor_first_name'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Last_Name');?></label>
								  <?php echo $frm->getFieldHtml('doctor_last_name'); ?>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Category');?></label>
								  <?php echo $frm->getFieldHtml('doctor_med_category'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Phone_number');?></label>
								 <?php echo $frm->getFieldHtml('doctor_phone_no'); ?></td>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Summary_Of_Qualification');?></label>
								  <?php echo $frm->getFieldHtml('doctor_summary'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Address');?></label>
								  <?php echo $frm->getFieldHtml('doctor_address'); ?></td>
							  </tr>
							  
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_House_Number');?></label>
								  <?php echo $frm->getFieldHtml('doctor_house_no'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_City');?></label>
								  <?php echo $frm->getFieldHtml('doctor_city'); ?></td>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_State');?></label>
								  <?php echo $frm->getFieldHtml('doctor_state_id'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_PinCode');?></label>
								  <?php echo $frm->getFieldHtml('doctor_pincode'); ?></td>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Experience_In_Year');?></label>
								  <?php echo $frm->getFieldHtml('doctor_experience'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Experience_Summary');?></label>
								  <?php echo $frm->getFieldHtml('doctor_experience_summary'); ?></td>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Medical_or_Graduate_School');?></label>
								  <?php echo $frm->getFieldHtml('doctor_med_school'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Medical_degree');?></label>
								  <?php echo $frm->getFieldHtml('doctor_med_degree'); ?></td>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Medical_Year');?></label>
								  <?php echo $frm->getFieldHtml('doctor_med_year'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_License_No');?></label>
								  <?php echo $frm->getFieldHtml('doctor_licence_no'); ?></td>
							  </tr>
							  <tr>								
								<td><label class="form__caption"><?php echo getLabel('L_Medical_State');?></label>
								  <?php echo $frm->getFieldHtml('doctor_med_state_id'); ?></td>
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
								</td>
							  </tr>
							</tbody>
						  </table>
						</div>
					  <?php echo $frm->getFieldHtml('doctor_id'); ?>


					<?php echo $frm->getExternalJs(); ?>

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

