<!--Main-->
<main class="site-main ">   
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          <div class="span-md-12 span-sm-12 span-xs-12">
            <div class="dashboard">
              <?php include getViewsPath() . 'common/customer/left-menu.php'; ?>
              <div class="dashboard__content">
					<h2 class="dashboard_title"><?php echo getLabel('L_Edit_profile');?></h2>
					<?php include getViewsPath() . 'common/customer/profile-top.php'; ?>
					<div class="profileNav">
					  <ul>
						<li><a class="active" href="<?php echo generateUrl('customer','profile') ?>"><?php echo getLabel('L_Edit_profile');?></a></li>
						<li><a  href="<?php echo generateUrl('customer','changepassword') ?>"><?php echo getLabel('L_Change_Password');?></a></li>
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
								  <?php echo $frm->getFieldHtml('user_first_name'); ?></td>
								<td><label class="form__caption"><?php echo getLabel('L_Last_Name');?></label>
								  <?php echo $frm->getFieldHtml('user_last_name'); ?>
							  </tr>
							  <tr>
								<td><label class="form__caption"><?php echo getLabel('L_Email');?></label>
								  <?php echo $frm->getFieldHtml('user_email'); ?></td>
								
							  </tr>
							 <?php echo $frm->getFieldHtml('user_id'); ?>
							<?php echo $frm->getExternalJs(); ?>
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













<div class="cont-wrapper inner-main">

    <div class="centered">


        <h2>My <span>Profile</span> </h2>


        <div class="admin-cont-area"> 

            <div class="my-prof-block">
                <?php echo $frm->getFormTag(); ?>
                <div class="left">
                    <div class="row">
                        <label>First Name </label>
                        <?php echo $frm->getFieldHtml('user_first_name'); ?>
                    </div>
                    <div class="row">
                        <label>Last Name </label>
                        <?php echo $frm->getFieldHtml('user_last_name'); ?>
                    </div>
                    <div class="row">
                        <label>Email Address </label>
                        <?php echo $frm->getFieldHtml('user_email'); ?>
                    </div>
                    <div class="row">
                        <label>Mobile </label>
                        <input name="" type="text" value="7025773782">
                    </div>

                    <?php echo $frm->getFieldHtml('user_id'); ?>
                    <?php echo $frm->getExternalJs(); ?>
                    <?php echo $frm->getFieldHtml('btn_submit'); ?>
                </div>



                </form>
                <div class="right">				
				   <?php echo $password->getFormTag(); ?>
				
                    <div class="row">
                        <label>Old Password  </label>
                        <?php echo $password->getFieldHtml('current_password'); ?>
                    </div>
                    <div class="row">
                        <label>New Password  </label>
                        <?php echo $password->getFieldHtml('new_password'); ?>
                    </div>
                    <div class="row">
                        <label>Confirm Password </label>
                        <?php echo $password->getFieldHtml('new_password1'); ?>
                    </div>
        
                    <?php echo $password->getExternalJs(); ?>
                    <?php echo $password->getFieldHtml('btn_submit'); ?>
					</form>
                </div>


                </form>
            </div>

            <div class="my-prof-block">
                <div class="img-block"><img src="<?php echo generateUrl('image','getCustomerProfilePic',array(0,78,90)) ?>" alt="" id="userImage" width="79" height="90" ></div>
                <div class="choose-txt-block">
                    <p>To change your profile image: press the Choose Image button then press Update Image . For best results use an image with a width of 125 pixels and 125 pixels. 
                    </p>
                    <p>&nbsp;</p>
                    <p>
                        <?php echo $profilePic->getFormTag();?>
                        
                        <?php echo $profilePic->getFieldHtml('fileupload');  ?>
                        <?php echo $profilePic->getFieldHtml('btn_submit');  ?>
                        <?php echo $profilePic->getExternalJs();  ?>
                    </p>
                </div>
            </div>

        </div>




    </div>

</div>




