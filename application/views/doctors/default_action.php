<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getlabel('L_QUALIFIED_Doctor');?> </h5>
            <h6 class="sub-heading-text text--center text--white"><?php echo getlabel('L_We_are_having_Reliable_and_Trusted_Team');?></h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  <!--Medical Divisions-->
  <?php if(!empty($categories)) { require_once(CONF_THEME_PATH.'doctors/common/medical_category_panel.php'); }?> 
  <!--End Medical Divisions-->
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="template-sidebar">
        <div class="span-row">
          <div class="span-md-4 span-sm-12 span-xs-12">
            <div class="sidebar">
              <h2 class="js-sidebarToggle sidebarHeading"><?php echo getlabel('L_Filters');?></h2>
              <div class="sidebar__content js-sidebar__content">
			  <?php echo $searchForm->getFormTag(); ?>
                <div class="sidebar__search"> <span class="filter-Title"><?php echo getlabel('L_Name_or_Keyword');?></span>
				
                  
				  <?php echo $searchForm->getFieldHTML('keyword'); ?>
                </div>
                <div class="filter-block">
                 
                    <div class="filter"><span class="filter-Title"><?php echo getlabel('L_Specialty_or_Program');?></span>
					<?php echo $searchForm->getFieldHTML('doctor_med_category'); ?>
                      <!--select>
                        <option>All Specialities</option>
                      </select--> 
                    </div>
                    <div class="filter"><span class="filter-Title"><?php echo getLabel('L_Locations'); ?></span>
					<?php echo $searchForm->getFieldHTML('doctor_state_id'); ?>
                      <!--select>
                        <option>All Locations</option>
                      </select-->
                    </div>
                    
                    <div class="filter"><span class="filter-Title"><?php echo getLabel('L_Gender'); ?></span>
					
					<?php echo $searchForm->getFieldHTML('doctor_gender'); ?>
									
					
                    </div>					
					
					<?php echo $searchForm->getFieldHTML('btn_submit'); ?>
                 <?php echo $searchForm->getExternalJS();?>
				 
                  <a class="inline-link" href="<?php echo generateUrl('doctors');?>"><?php echo getLabel('L_View_All_Doctors'); ?></a> </div>
				  </form>
                <div class="count-block">
					<div class="count__ques count"><?php echo $question_count; ?><span><?php echo getLabel('L_Questions');?></span></div>
					<div class="count__ans count"><?php echo $reply_count?><span><?php echo getLabel('L_Answers');?></span></div>
                  
                </div>
              </div>
            </div>
          </div>
		  <div id="listing-div">
		  </div>
         
        </div>
      </div>
    </div>
  </div>
  
</main>