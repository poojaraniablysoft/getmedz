<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 

<!--main panel start here-->
<div class="page">
  <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  



                <h1>Testimonial Management</h1> 
				<div class="tabs_nav_container responsive boxbased">

                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search</a></li>
                        

                    </ul>

                    <div class="tabs_panel_wrap">

                        <span rel="tabs_01" class="togglehead active">Search</span>
                        <div class="tabs_panel" id="tabs_01" >
                            <?php echo $frmPost->getFormHtml(); ?>
                        </div>

                       

                    </div>      

                </div>
				
				<section class="section"> 
					<div class="sectionhead"><h4>Manage - Testimonials </h4>
							<?php if($canAdd):?>
						<a href="<?php echo generateUrl('testimonials', 'form'); ?>"   class="themebtn btn-default waves-effect">Add Testimonial</a>
							 <?php endif;?>
					
					</div>
					<!--div class="sectionhead"><h4>Manage - Testimonials</h4>
						<ul class="actions">
							<li class="droplink">
								<a href="javascript:void(0);"><i class="ion-android-more-vertical icon"></i></a>
								<div class="dropwrap">
									<ul class="linksvertical">
									   <li><a href="<?php echo generateUrl('testimonials', 'form'); ?>">Add Testimonial</a></li>	
									</ul>
								</div>
							</li>
						</ul>
					</div-->
					<div class="sectionbody" id="listing-div"></div>								
				</section>
                

            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->
		