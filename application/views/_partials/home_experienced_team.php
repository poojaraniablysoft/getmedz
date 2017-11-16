<div id="our-docs" class="section section--our--docs" style="background-image:url(images/dynamic/bg-team.jpg);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup>
            <h5 class="heading-text text--center "><?php echo getLabel('L_Experienced_Team');?> </h5>
            <h6 class="sub-heading-text text--center "><?php echo getLabel('L_Our_Doctors');?></h6>
          </hgroup>
        </div>
        <div class="span-md-12">
          <div class="team__list ">
            <div class="team__media ">
              <ul class="doctors_list ">
			  <?php if(!empty($activedocs)){ 
			  $activedocs = array_slice($activedocs, 0, 4);
			  $i=0;
			  
			  foreach($activedocs as $doc)
			  {
				 
				  $rel = 'doc_'.$doc['doctor_id'];
				  
			  ?>
                <li class='team__item <?php if($i==0) { ?> selected <?php } ?>' rel='<?php echo $rel ?>'> <a  href="javascript:void(0);">
                  <div class="doctor__figure">
                    <div class="doctor__thumb"> <img src="<?php echo generateUrl('image','getDoctorProfilePic',array($doc['doctor_id'],100,100))?>" alt=""> </div>
                  </div>
                  <div class="doctor__content">
                    <h5 class="doctor__name"><?php echo doctorDisplayName($doc['doctor_first_name'],$doc['doctor_last_name']); ?></h5>
                    <p class="doctor__expertise"><?php echo $doc['category_name']; ?></p>
                  </div>
                  </a> </li>
			  <?php $i++;}  } ?>
                <!--li class="team__item" rel="second"> <a href="javascript:void(0);">
                  <div class="doctor__figure">
                    <div class="doctor__thumb"> <img src="images/users/team-thumb2.jpg" alt=""> </div>
                  </div>
                  <div class="doctor__content">
                    <h5 class="doctor__name">dr.jonathen Doe</h5>
                    <p class="doctor__expertise">Orthopedic surgen</p>
                  </div>
                  </a> </li-->
               
                <li class="team__item last-child"> <a href="<?php echo generateUrl('doctors')?>"><?php echo getLabel('L_View_All_Doctors');?>  </a> </li>
              </ul>
            </div>
			<?php if(!empty($activedocs)){ 
			$i=0;
			  foreach($activedocs as $doc)
			  {
				  $rel = 'doc_'.$doc['doctor_id'];
				  
			  ?>
            <div class='team__doctors-intro <?php echo $rel ?> <?php if($i==0) { ?> active <?php } ?>'>
              <div class="intro__image"> <img src="<?php echo generateUrl('image','getDoctorProfilePic',array($doc['doctor_id'],370,370))?>" alt=""> </div>
              <div class="intro_text">
                <h5 class="doctor__name"><?php echo doctorDisplayName($doc['doctor_first_name'],$doc['doctor_last_name']); ?></h5>
                <p class="doctor__expertise"><?php echo $doc['category_name']; ?></p>
                <div class="doctors__bio">
                  <div class="bio__speciality bio__list"> <i class="bio_icon"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/stethoscope.svg" alt=""></i> <span class="bio_description">
                    <h5 class="bio__title"><?php echo getLabel('L_Specialty');?></h5>
                    <h6 class="bio__text"><?php echo $doc['category_name']; ?></h6>
                    </span> </div>
                  <div class="bio__degree bio__list"> <i class="bio_icon"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/degree.svg" alt=""></i> <span class="bio_description">
                    <h5 class="bio__title"><?php echo getLabel('L_Degree');?></h5>
                    <h6 class="bio__text"><?php echo $doc['degree_name']; ?></h6>
                    </span> </div>
                  <div class="bio__location bio__list"> <i class="bio_icon"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/location.svg" alt=""></i> <span class="bio_description">
                    <h5 class="bio__title"><?php echo getLabel('L_Location');?></h5>
                    <h6 class="bio__text"><?php echo doctorDisplayLocation($doc['doctor_address'],$doc['doctor_city'],$doc['state_name'],$doc['doctor_pincode']); ?></h6>
                    </span> </div>
					<?php if($doc['doctor_experience'] > 0 )
				  { ?> 
                  <div class="bio__experience bio__list noBorder"> <i class="bio_icon"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/certification.svg" alt=""></i> <span class="bio_description">
                    <h5 class="bio__title"><?php echo getLabel('L_Experience');?></h5>
                    <h6 class="bio__text"><?php   echo $doc['doctor_experience'] ?> <?php echo getLabel('L_Years of Experience');?> </h6>
                    </span> </div>
				<?php } ?>
                </div>
              </div>
            </div>
			<?php $i++; }  } ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>