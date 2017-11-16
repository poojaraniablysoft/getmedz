<div class="medicalField_slide section">
    <div class="container">
      <div class="medicalField_list js-medicalField_list">
        <ul class="medicalField__divisions js-medicalField__divisions">
		<?php if(!empty($categories)) {
					?>
          <li>
            <div class="medicalField__content"> <a  class="cat_id <?php if(!isset($category_selected) || ($category_selected == '' ) ) { ?>selected<?php } ?>" href="<?php echo generateUrl('doctors','') ?>" id="" ><i class="med--tabs__icon"><img src="<?php echo CONF_WEBROOT_URL ?>images/fixed/categall-40h.svg" alt=""></i> <span><?php echo getLabel('L_All_Doctors')?></span> </a> </div>
          </li>
		  <?php foreach($categories as $category) { ?>
		  
          <li>
            <div class="medicalField__content"> <a class="cat_id <?php if(isset($category_selected) && ($category_selected == $category['category_id'] ) ) { ?>selected <?php } ?>" href="<?php echo generateUrl('doctors','?category='.$category['category_id']) ?>" id="<?php echo $category['category_id'];?>"> <i class="med--tabs__icon"><img src="<?php echo generateUrl('image', 'medical_category', array($category['category_id'], 45, 45) ) ?>" alt=""></i> <span><?php echo $category['category_name']?></span> </a> </div>
          </li>
		<?php }
		} ?>          
        </ul>
      </div>
    </div>
</div>