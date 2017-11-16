<div class="profileEdit">
  <div class="editprofileImg">
	<figure class="pic">
		<form  enctype="multipart/form-data" id="uploadFileForm" name="uploadFileForm" action="<?php echo generateUrl('customer','profile_pic') ?>" method="post">
			<img src="<?php echo generateUrl('image','getCustomerProfilePic',array(0,500,500)) ?>" alt="">
			<span class="uploadavtar">
				<i class="icon ion-android-camera"></i> <?php echo getLabel('L_Update_profile_picture');?> 
				<input type="file" name="fileupload" onChange="$('#uploadFileForm').submit();">
			</span>
		</form>    
	  
	</figure>
  </div>
  <div class="editprofileInfo">
	<h2><?php  echo $user_data['user_first_name'].' '.$user_data['user_last_name'] ?></h2>
	<a class="mail" href="" target="_top"><?php echo $user_data['user_email']; ?></a> 
</div>
</div>