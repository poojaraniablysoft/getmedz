<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php global $nav_page_type; ?> 

	
	<!--main panel start here-->
	<div class="page">
		 <?php echo html_entity_decode($breadcrumb); ?>	
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">
				
					<section class="section">
					 <div id="form-div"></div>
                        <div class="sectionhead"><h4>Manage - Navigation Pages</h4>
						<a href="<?php echo generateUrl('navigations', 'addeditnavigationPage',array($navigation)); ?>"  class="themebtn btn-default waves-effect">Add Navigation Page</a>
						<!--ul class="actions">
                                <li class="droplink">
                                    <a href="javascript:void(0);"><i class="ion-android-more-vertical icon"></i></a>
                                    <div class="dropwrap">
                                        <ul class="linksvertical">
                                            <li><a href="<?php echo generateUrl('navigations'); ?>">Back to Navigations</a></li>
                                            <li><a href="<?php echo generateUrl('navigations', 'addeditnavigationPage',array($navigation)); ?>">Add Navigation Page</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul-->
						</div>
						
                        <div class="sectionbody">                            
                         <?php if ((count($arr_listing)>0) && (!empty($arr_listing))) :?>
                          <table class="table table-responsive" id="dtTable">
                                        <thead>
                                           <tr>
											  <th width="40%">Title</th>
											  <th width="40%">Type</th>
											  <th class="text-center">Actions</th>
										  </tr>
                                        </thead>  
                                        <tbody>
                                          <?php foreach ($arr_listing as $sn=>$row) {  ?>
											<tr>
												<td><?php echo $row["nl_caption"]?></td>
												<td >
													<?php echo $nav_page_type[$row['nl_type']] ?>
												</td>
												<td class="text-center" nowrap="nowrap">
												<ul class="actions">
													<li><a  href="<?php echo generateUrl('navigations', 'addEditNavigationPage', array($row['nl_nav_id'],$row['nl_id']))?>" title="Edit"><i class="ion-edit icon"></i></a></li>
													<li><a onclick="return(confirm('Are you sure to delete this record?'));" href="<?php echo generateUrl('navigations', 'deletepage', array($row['nl_id']))?>" title="Delete"><i class="ion-android-delete icon"></i></a></li>													
													</ul>
												
												</td>
											</tr>
											<?php }?>
											<?php else: ?>
											 <p>We are unable to find any record corresponding to your selection in this section.</p>
											<?php endif;?>                                      
                                        </tbody>    
                                    </table>                                
                                </div>																	
                        </section>
				</div>
			</div>
		</div>
	</div>          
	<!--main panel end here-->
			