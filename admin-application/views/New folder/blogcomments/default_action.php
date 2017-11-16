<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<div id="body">
	
	<!--main panel start here-->
	<div class="page">
		<ul class="breadcrumb arrow">
			<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

			<li ><a href="<?php echo generateUrl('blogcomments'); ?>">Blog Comments Management</a></li>
			
		</ul>
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">		
					
					<section class="section searchform_filter"> 
						<div class="sectionhead">
							<h4>Blog Comments Management</h4>						
						</div>
						<div class="tabs_nav_container responsive boxbased">

						<ul class="tabs_nav">
							<li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Blog Comments Search</a></li>
							

						</ul>

						<div class="tabs_panel_wrap">
							<span rel="tabs_01" class="togglehead active">Search</span>
							<div class="tabs_panel" id="tabs_01" >
								<?php echo $frmComment->getFormHtml(); ?>
							</div>                      

						</div>      

					</div>
											
					</section>	
					<section class="section">
						<div class="sectionhead">
							<h4>Blog Comment List</h4>
						</div>
						<div id="listing-div">

						</div>
					</section>
				</div>
			</div>
		</div>          
	<!--main panel end here-->
	</div>
<!--body end here-->
</div>			