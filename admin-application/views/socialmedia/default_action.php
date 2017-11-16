<?php defined('SYSTEM_INIT') or die('Invalid Usage');  global $conf_option_types;?> 
<!--main panel start here-->
<div class="page">
  <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">

            <div class="col-sm-12">  

				<section class="section"> <div id="form-div"></div>
                        <div class="sectionhead"><h4>Manage - Social Platforms</h4>
						<a href="<?php echo generateUrl('socialmedia', 'form'); ?>" class="themebtn btn-default waves-effect">Add Social Platform</a>
						
						</div>
						
                        <div class="sectionbody">                            
                         <?php if ((count($arr_listing)>0) && (!empty($arr_listing))) :?>
                          <table class="table table-responsive" id="dtTable">
                                        <thead>
                                           <tr>
											 <th width="30%">Title</th>
											  <th width="55%">URL</th>
											  <th class="text-center">Actions</th>
										  </tr>
                                        </thead>  
                                        <tbody>
                                          <?php foreach ($arr_listing as $sn=>$row) {  ?>
											<tr class="<?php if ($row["splatform_status"]==0):?>disabledRow<?php endif;?>">
												<td><?php echo $row["splatform_title"];?></td>
												<td><?php echo $row["splatform_url"];?></td>
												<td class="text-center" nowrap="nowrap">
												<ul class="actions">
													<?php if ($row['splatform_status']==0):?>
														<li><a href="<?php echo generateUrl('socialmedia', 'status', array($row['splatform_id'], 'unblock'))?>" title="Enable" class="toggleswitch actives" ><i class="ion-checkmark icon inactive"></i></a></li>
												<?php  else : ?>
													  <li> <a href="<?php echo generateUrl('socialmedia', 'status', array($row['splatform_id'], 'block'))?>"  title="Disable" class="toggleswitch" ><i class="ion-checkmark icon active"></i></a></li>
												<?php endif; ?>
													
													<li><a href="<?php echo generateUrl('socialmedia', 'form', array($row['splatform_id']))?>"  title="Edit"><i class="ion-edit icon"></i></a></li>
													<li><a  onclick="return(confirm('Are you sure to delete this record?'));" href="<?php echo generateUrl('socialmedia', 'delete', array($row['splatform_id']))?>" title="Delete"><i class="ion-android-delete icon"></i></a></li>												
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
								<div class="footinfo">
                                <aside class="grid_1">
                                    <ul class="pagination">
										<?php unset($search_parameter["url"]); ?>
                                         <?php echo renderView(getViewsPartialPath().'pagination.php', array(
									'start_record' => $start_record,
									'end_record' => $end_record,
									'total_records' => $total_records,
									'pages' => $pages,
									'page' => $page,
									'controller' => 'socialmedia',
									'action' => 'default_action',
									'url_vars' => array(),
									'query_vars' => $search_parameter,
									)); ?>
                                    </ul>
                                </aside>  
								<?php  if ($total_records>0):?>
                                <aside class="grid_2"><span class="info">Showing <?php echo $start_record?> to  <?php echo $end_record?> of <?php echo $total_records?> entries</span></aside>
								<?php endif; ?>
                            </div>								
                        </section>

            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->

