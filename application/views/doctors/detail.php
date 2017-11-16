<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue fixed--height" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        
        <div class="span-md-12">
          	<div class="doctors--detail">
             <div class="span-row">
            	<div class="doctors--detail__profile span-md-3 span-sm-5 span-xs-12">
                
                	<div class="detail__profileBox">
                    <div class="profile__detail">
                        	<h5><?php echo doctorDisplayName($doctor_data['doctor_first_name'] . $doctor_data['doctor_last_name']); ?></h5>
                            <h3><?php echo $doctor_data['category_name'] ?></h3>
							<?php if($doctor_data['doctor_experience'] >0) { ?>
                            <p><span><?php echo $doctor_data['doctor_experience'] ?> <?php echo getLabel('L_Years of Experience');?></span><i><img src="<?php echo CONF_WEBROOT_URL ?>images/fixed/certification.svg" alt=""></i></p>
							<?php } ?>
                        
                        </div>
                    <div class="profile__doctor">
                    	<div class="profile__image">
                        	<img src="<?php echo generateUrl('image','getDoctorProfilePic',array($doctor_data['doctor_id'],305,305)) ?>" alt="">
                        </div>
                        
                        <div class="profile__specifications">
                        <div class="specialization_category"><span class="item_category"><span class="item_categoryIcon"> <a class="item_category__link" href="javascript:void(0);"><img src="<?php echo generateUrl('image', 'medical_category', array($doctor_data['category_id'], 50, 50) ) ?>" alt=""></a> </span></span></div>
                        <div class="profile__description">
                        <div class="gender"><span><?php echo getLabel('L_Gender')?>: </span><?php if($doctor_data['doctor_gender'] == 1) {echo " Male";} else if($doctor_data['doctor_gender'] == 2) { echo "Female"; }?> </div>
						
                        	<div class="location"><span><?php echo getLabel('L_Location')?>: </span> <?php echo doctorDisplayLocation($doctor_data['doctor_address'],$doctor_data['doctor_city'],$doctor_data['state_name'],$doctor_data['doctor_pincode']); ?></div>
                            <div class="qualification"><span><?php echo getLabel('L_Eductaion')?>: </span><?php echo $doctor_data['degree_name'] ?></div>
                            <div class="speciality"><span><?php echo getLabel('L_Specialty')?>: </span> <?php echo $doctor_data['category_name'] ?></div>
                        	</div>
                        </div>
                    
                    </div>
                    	
                    
                    </div>
                
                
                </div>
                <div class="doctors--detail__description span-md-9 span-sm-7 span-xs-12">
                
                <div class="cms--content">
                <p><?php echo getLabel('L_I_enjoy_being_an')?> </p>
                <h2><?php echo getLabel('L_Biography')?></h2>
                <p><?php echo html_entity_decode($doctor_data['doctor_summary']);?></p>
                <h2><?php echo getLabel('L_Work_Experience')?></h2>
               
                <p><?php echo html_entity_decode($doctor_data['doctor_experience_summary']);?></p>
                </div>
                
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
<?php if(!empty($related_doctor_data)) {  ?>
  <div class="section related--doctors">
    <div class="container">    
		<div class="span-md-12">
		  <hgroup >
			<h5 class="heading-text text--center "><?php echo getLabel('L_Related_Doctors')?></h5>
			<h6 class="sub-heading-text text--center "><?php echo getLabel('L_Having same functionality')?></h6>
		  </hgroup>
		</div>
		<div class="listing__items">
			<?php foreach($related_doctor_data as $doctor_data ) { ?>
			  <div class="span-md-3 span-sm-4 span-xs-6">
				<div class="item">
				  <div class="item__head"><a href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>"> <img class="item__pic " src="<?php echo generateUrl('image','getDoctorProfilePic',array($doctor_data['doctor_id'],305,305)) ?>" alt=""> </a> </div>
				  <div class="item__body">
					<div class="item__summary"> <span class="item_category"><span class="item_categoryIcon"> <a class="item_category__link" href="javascript:void(0);"><img src="<?php echo generateUrl('image', 'medical_category', array($doctor_data['category_id'], 50, 50) ) ?>" alt=""></a> </span></span><span class="item__title"><a href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>"><?php echo $doctor_data['doctor_first_name'] . $doctor_data['doctor_last_name']; ?> </a></span> <span class="item__subtitle"><?php echo $doctor_data['category_name'] ?> </span>
					  <div class="item__description">
						<p><?php echo subStringByWords(html_entity_decode($doctor_data['doctor_summary']), 100);?></p>
						<a class="button button--fill button--primary" href="<?php echo generateUrl('doctors','detail',array($doctor_data['doctor_id']));?>" ><?php echo getLabel('L_Read_More')?></a></div>
					</div>
				  </div>
				</div>
			  </div>
			<?php }  ?>
				 
				  
		  <div class="span-md-3 span-sm-12 span-xs-6">
			<div class="vieall--realted">
				<h2><?php echo getLabel('L_Best_Doctors_for_you')?></h2>
				<p><?php echo getLabel('L_Checkout_the_list_of_all_our_exprienced_doctors_team_with_different_specialty')?></p>
			<i class="med--ico"><img src="<?php echo CONF_WEBROOT_URL ?>images/fixed/medical.svg" alt=""></i>
			<a href="<?php echo generateUrl('doctors','lists');?>"><?php echo getLabel('L_View_All_Doctors')?></a>
			</div>
		  </div>
	  </div>       
  </div>
</div>
<?php } ?>

</main>