<?php defined('SYSTEM_INIT') or die('Invalid Usage');  global $conf_option_types;?> 

	
	<!--main panel start here-->
	<div class="page">
		 <?php echo html_entity_decode($breadcrumb); ?>	
		<div class="fixed_container">
			<div class="row">
				<div class="col-sm-12">
								
					<section class="section"> <div id="form-div"></div>
                        <div class="sectionhead"><h4>Manage - Navigation Management</h4>						
						</div>
						
                        <div class="sectionbody">                            
                         <?php if ((count($arr_listing)>0) && (!empty($arr_listing))) :?>
                          <table class="table table-responsive" id="dtTable">
                                        <thead>
											<tr>
												<th width="40%">Title</th>
												<th width="50%">Status</th>
												<th class="text-center">Actions</th>
											</tr>
                                        </thead>  
                                        <tbody>
                                          <?php foreach ($arr_listing as $sn=>$row) { $complaint_name=trim($row["user_fname"].' '.$row["user_lname"]);	 ?>
											<tr style="color:<?php if (($row['nav_status']==0)){ ?>#AAAAAA<?php }?>">
												<td><strong><?php echo $row["nav_name"]?></strong></td>
												<td >
													<?php echo $row['nav_status']==1?"<span class='label label-success'>Enabled</span>":"<span class='label label-danger'>Disabled</span>"; ?>
												</td>
												<td class="text-center" nowrap="nowrap">
												<ul class="actions">
												<?php if ($row['nav_status']==0):?>
														<li><a href="<?php echo generateUrl('navigations', 'status', array($row['nav_id'], 'enable'))?>" title="Enable"  ><i class="ion-close-circled icon"></i></a></li>
												<?php  else : ?>
													 <li>  <a href="<?php echo generateUrl('navigations', 'status', array($row['nav_id'], 'disable'))?>"  title="Disable"  ><i class="ion-checkmark-circled icon"></i></a></li>
												<?php endif; ?>													
													<li><a href="<?php echo generateUrl('navigations', 'form', array($row['nav_id']))?>"  title="Edit"><i class="ion-edit icon"></i></a></li>
													<li><a href="<?php echo generateUrl('navigations', 'pages', array($row['nav_id']))?>"  title="Pages"><i class="ion-document-text icon"></i></a></li>
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
								<div class="gap"></div>
															
                        </section>
				</div>
			</div>
		</div>
	</div>          
