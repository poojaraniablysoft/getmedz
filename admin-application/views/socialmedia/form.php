<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<div class="page">
	 <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">

            <div class="col-sm-12">  


				<section class="section"> <div id="form-div"></div>
                        <div class="sectionhead"><h4>Social Media Setup</h4>						
						
						</div>
						<div class="sectionbody">                            
                             <?php echo $frm->getFormHtml(); ?>                        
						</div>	
				</section>
			</div>
		</div>
	</div>
</div>     
