<div class="h__user fl--right"> <!--a href="login.html" class="button button--fill button--blue">Login</a-->
	<div class="h__usersignedin"> <a href="javascript:void(0);" class="h__userprofile js-h__userprofile"> <span class="user__pic"> <img src="<?php echo generateUrl('image','getCustomerProfilePic',array(Members::getLoggedUserAttribute('user_id'),'35','35')) ?>" alt=""> </span> <span class="user__name"><?php echo $customerName=  Members::getLoggedUserAttribute('user_first_name')." ".Members::getLoggedUserAttribute('user_last_name');	?></span> </a>
		  <div class="user__dropsection">
			<div class="user__profile-large"> <span class="user__pic"> <img src="<?php echo generateUrl('image','getCustomerProfilePic',array(Members::getLoggedUserAttribute('user_id'),'35','35')) ?>" alt=""> </span> <span class="user__name"><?php echo $customerName=  Members::getLoggedUserAttribute('user_first_name')." ".Members::getLoggedUserAttribute('user_last_name');	?></span> 
			</div>
			<ul class="user__options">
				<li><a href="<?php echo generateUrl('customer'); ?>"><i class="dropdown_icon"><img src="/images/fixed/doctor.svg" alt=""></i><span><?php echo getLabel('L_My_Questions');?></span></a></li>
				<li><a href="<?php echo generateUrl(); ?>#orquestion_question"><i class="dropdown_icon"><img src="/images/fixed/doctor.svg" alt=""></i><span>
				<?php echo getLabel('L_Ask_a_New_Quesiton');?></span>
				</a></li>
				<li><a href="<?php echo generateUrl('customer', 'profile'); ?>"><i class="dropdown_icon"><img src="/images/fixed/avatar.svg" alt=""></i><span><?php echo getLabel('L_User_Profile');?></span></a></li>				
				<li><a href="<?php echo generateUrl('members', 'logout'); ?>"><i class="dropdown_icon"><img src="/images/fixed/shutdown.svg" alt=""></i><span><?php echo getLabel('L_Log_Out');?> </span></a></li>
			 
			</ul>
		  </div>
	</div>
</div>

<?php
$customerName=  Members::getLoggedUserAttribute('user_first_name')." ".Members::getLoggedUserAttribute('user_last_name');
?>
<!--ul class="nav">
    <li><a href="<?php echo generateUrl('customer'); ?>">My Questions</a></li>
    <li><a href="<?php echo generateUrl(); ?>">Ask a New Quesiton</a></li>
    <li><a href="<?php echo generateUrl('customer', 'profile'); ?>">User Profile</a></li>
    <li><a href="#">Support</a></li>
    <li><a href="<?php echo generateUrl('members', 'logout'); ?>">Log Out</a></li>
</ul>
<div class="welcome">Welcome Back, <span><?php echo $customerName ?></span> </div-->
