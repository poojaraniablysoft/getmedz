 <aside class="grid_1">
	<div class="avtararea admin-doctor-avtar">
		<figure class="pic admin-doctor-pic">
			<form  enctype="multipart/form-data" id="uploadFileForm" name="uploadFileForm" action="<?php echo generateUrl('doctors','profile_pic',array($id)) ?>" method="post">
				<img id="user_profile_photo" src="<?php echo generateUrl('image','getDoctorProfilePic',array($id,100,100),CONF_WEBROOT_URL) ?>" alt="">
				<span class="uploadavtar">
					<i class="icon ion-android-camera"></i> Update Profile Picture 
					<input type="file" name="fileupload" onChange="submitImage();">
					<input type="hidden" name="user_id" value= "<?php echo $id ?>" >
				</span>
			</form>    
		</figure>                           
	</div>                      

</aside> 
<?php
// @var $frm Form
	echo $frm->getFormHtml();
?>
<script>
function uploadFile()
	{
		alert("hello");
	}

</script>
