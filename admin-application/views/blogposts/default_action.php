<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<!--main panel start here-->
	<div class="page">
		<?php echo html_entity_decode($breadcrumb); ?>
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">
					<section class="section searchform_filter">
						<div class="sectionhead">
							<h4>Search Blog Post</h4> 			
						</div>
						
						<div class="sectionbody space togglewrap" >
							<?php echo $frmPost->getFormHtml(); ?>
						</div>
					</section>
					<section class="section"> 
                        <div class="sectionhead"><h4>Manage - Blog Post</h4>
							<ul class="actions">
                                <li class="droplink">
                                    <a href="javascript:void(0);"><i class="ion-android-more-vertical icon"></i></a>
                                    <div class="dropwrap">
                                        <ul class="linksvertical">
                                           <?php if ($canview === true) { ?> <li><a href="<?php echo Utilities::generateUrl('blogposts', 'add'); ?>">Add New Post</a></li><?php } ?>	
                                        </ul>
                                    </div>
                                </li>
                            </ul>
						</div>
						<div class="sectionbody" id="post-type-list"></div>								
					</section>
				</div>
			</div>
		</div>
	</div>          
	<!--main panel end here-->
		