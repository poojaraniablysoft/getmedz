<?php defined('SYSTEM_INIT') or die('Invalid Usage');  global $conf_option_types;?> 

	<!--main panel start here-->

	<div class="page">
		 <?php echo html_entity_decode($breadcrumb); ?>

		<div class="fixed_container">

			<div class="row">

				<div class="col-sm-12">
				

					<!--section class="section searchform_filter">

						<div class="sectionhead">

							<h4>Search Language Labels</h4>

										

						</div>

						<div class="sectionbody space togglewrap" style="display:none;">

							<?php echo $search_form->getFormHtml(); ?>		

						</div>

					</section-->
					<div class="tabs_nav_container responsive boxbased">

                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search</a></li>
                        <li><a href="javascript:void(0)" rel="tabs_02"  id="tab_a_2" >Manage Label</a></li>
                        

                    </ul>

                    <div class="tabs_panel_wrap">

                        <span rel="tabs_01" class="togglehead active">Search</span>
                        <div class="tabs_panel" id="tabs_01" >
                            <?php echo $search_form->getFormHtml(); ?>
                        </div> 
						<span rel="tabs_02" class="togglehead ">Search</span>
                        <div class="tabs_panel" id="tabs_02" >
                           <div id="form-div">Please select any label to edit</div>
                        </div>

                       

                    </div>      

                </div>

					<section class="section"> <div id="form-div"></div>
                        <div class="sectionhead"><h4>Manage -  Language Labels</h4>
						<!--<ul class="actions">
                                <li class="droplink">
                                    <a href="javascript:void(0);"><i class="ion-android-more-vertical icon"></i></a>
                                    <div class="dropwrap">
                                        <ul class="linksvertical">
                                            <li><a href="<?php echo generateUrl('labels', 'form'); ?>">Add Language Label</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>-->
						</div>

						

                        <div class="sectionbody" id="listing-div"> 
						</div>
                        </section>

				</div>

			</div>

		</div>

	</div>          

	<!--main panel end here-->
