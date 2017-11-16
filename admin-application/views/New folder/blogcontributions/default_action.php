<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 

<div id="body">
	
	<!--main panel start here-->
	<div class="page">
		 <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

                        <li ><a href="<?php echo generateUrl('blogcontributions'); ?>">Blog Contributions Management</a></li>
						
                    </ul>
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">
				
				
					<h1>Blog Contributions</h1> 
					<div class="tabs_nav_container responsive boxbased">

						<ul class="tabs_nav">
							<li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Blog Contributions Search</a></li>
							

						</ul>

						<div class="tabs_panel_wrap">
							<span rel="tabs_01" class="togglehead active">Search</span>
							<div class="tabs_panel" id="tabs_01" >
								<?php echo $frmContributions->getFormHtml(); ?>
							</div>                      

						</div>      

					</div>					
					
					<section class="section"><div id="form-div"></div>
                        <div class="sectionhead"><h4>Blog Contributions List</h4>						
						</div>
						<div class="sectionbody" id="listing-div"></div>								
					</section>
				</div>
			</div>
		</div>
	</div>          
	<!--main panel end here-->
</div>
<!--body end here-->
</div>				