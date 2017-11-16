<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 

	<!--main panel start here-->
	<div class="page">
		<ul class="breadcrumb arrow">
						<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

						<li ><a href="<?php echo generateUrl('blogcategories'); ?>">Blog Management</a></li>
						
					</ul>
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
	