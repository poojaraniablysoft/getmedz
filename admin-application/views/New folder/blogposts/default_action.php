<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<div id="body">
	
	<!--main panel start here-->
	<div class="page">
		
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">
					<div class="sectionbody space">
						<ul class="breadcrumb arrow">
							<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

							<li ><a href="<?php echo generateUrl('blogposts'); ?>">Blog Posts Management</a></li>
							
						</ul>
						<span class="gap"></span>
					</div>
					<div class="tabs_nav_container responsive boxbased">

						<ul class="tabs_nav">
							<li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search Blog Post</a></li>
							

						</ul>

						<div class="tabs_panel_wrap">
							<span rel="tabs_01" class="togglehead active">Search</span>
							<div class="tabs_panel" id="tabs_01" >
								<?php echo $frmPost->getFormHtml(); ?>
							</div>                      

						</div>      

					</div>
					<!--section class="section searchform_filter">
						<div class="sectionhead">
							<h4>Search Blog Post</h4> 			
						</div>
						
						<div class="sectionbody space togglewrap" style="display:none;">
							<?php echo $frmPost->getFormHtml(); ?>
						</div>
					</section-->
					<section class="section"> 
                        <div class="sectionhead"><h4>Manage - Blog Post</h4>
							<?php if($canadd === true):?>
								<a href="<?php echo generateUrl('blogposts', 'add'); ?>"  class="themebtn btn-default waves-effect">Add New Post</a>
							<?php endif;?>							
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