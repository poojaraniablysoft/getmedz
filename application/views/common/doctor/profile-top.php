<div class="profileEdit">
  <div class="editprofileImg">
	<figure class="pic">
		<form  enctype="multipart/form-data" id="uploadFileForm" name="uploadFileForm" action="<?php echo generateUrl('doctor','profile_pic') ?>" method="post">
			<img src="<?php echo generateUrl('image','getDoctorProfilePic',array(0,500,500)) ?>" alt="">
			<span class="uploadavtar">
				<i class="icon ion-android-camera"></i> <?php echo getLabel('L_Update_profile_picture');?> 
				<input type="file" name="fileupload" onChange="$('#uploadFileForm').submit();">
			</span>
		</form>    
	  
	</figure>
  </div>
  <div class="editprofileInfo">
	<h2><?php  echo doctorDisplayName($doctor_data['doctor_first_name'],$doctor_data['doctor_last_name']); ?></h2>
	<a class="mail" href="" target="_top"><?php echo $doctor_data['doctor_email']; ?></a> <span class="contact"><?php echo $doctor_data['doctor_phone_no']; ?></span> <span class="location"><?php echo doctorDisplayLocation($doctor_data['doctor_address'],$doctor_data['doctor_city'],$doctor_data['state_name'],$doctor_data['doctor_pincode']); ?></span> 
</div>
</div>
