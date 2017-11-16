<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<!--main panel start here-->
	<div class="page">
		<?php echo html_entity_decode($breadcrumb); ?>
		<div class="fixed_container">
			<div class="row">				
				<div class="col-sm-12">	
					<h1>Manage Blog Category</h1>
					<section class="section">
                        <div class="sectionhead"><h4>Blog Category Form</h4></div>										
                        <div class="sectionbody space">                            
                            <?php echo $frmAdd->getFormHtml(); ?>                         
						</div>	
					</section>
				</div>
			</div>
		</div>
	</div>          
	<!--main panel end here-->
