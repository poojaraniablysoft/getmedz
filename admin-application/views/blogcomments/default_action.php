<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 

	<div class="page">
		<?php echo html_entity_decode($breadcrumb); ?>		
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">				
					<section class="section searchform_filter"> 
						<div class="sectionhead">
							<h4>Blog Comments Management</h4>						
						</div>
						
						<div class="sectionbody space togglewrap">                    
							<?php echo $frmComment->getFormHtml(); ?>                        
						</div>						
					</section>	
					<section class="section">
						<div class="sectionhead">
							<h4>Blog Comment List</h4>
						</div>
						<div id="comment-list">
						</div>
					</section>
				</div>
			</div>
		</div>          
	<!--main panel end here-->
	</div>
