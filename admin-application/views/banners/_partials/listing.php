<section class="section">
				<div class="sectionhead"><h4>Manage - Banners </h4>
							<?php if($canAdd):?>
						<a href="<?php echo generateUrl('banners', 'form'); ?>"  class="themebtn btn-default waves-effect">Add New Banner</a>
							 <?php endif;?>
					
					</div>
                
						
                        <div class="sectionbody"> 
					
                         <?php if ((count($arr_listing)>0) && (!empty($arr_listing))) :?>
                          <table class="table table-responsive id="dtTable">
                                        <thead>
                                           <tr>
											 <th width="30%">Title</th>
											  <th width="55%">Banner</th>
											  <th class="text-center">Actions</th>
										  </tr>
                                        </thead>  
                                        <tbody>
                                          <?php foreach ($arr_listing as $sn=>$row) {  ?>
											<tr class="<?php if ($row["banner_status"]==0):?>disabledRow<?php endif;?>">
												<td><?php echo $row["banner_title"];?></td>
												<td>
												<?php if ($row["banner_type"]==0):?>
													<img src="<?php echo generateUrl('image', 'banner', array($row['banner_image_path'],'THUMB'),CONF_WEBROOT_URL)?>" alt="" />
												<?php else :
													echo $row["banner_html"];
												endif; ?></td>
												<td class="text-center" nowrap="nowrap">
												<ul class="actions">
													<?php if ($row['banner_status']==0):?>
														<li><a href="#"  title="Enable" class="toggleswitch actives" ><i onclick="UpdateBannerStatus('<?php echo $row['banner_id'] ?>', $(this));" class="ion-close-circled icon"></i></a></li>
													<?php  else : ?>
														  <li> <a href="#"   title="Disable" class="toggleswitch" ><i onclick="UpdateBannerStatus('<?php echo $row['banner_id'] ?>', $(this));" class="ion-checkmark-circled icon"></i></a></li>
													<?php endif; ?>
													<li><a href="<?php echo generateUrl('banners', 'form', array($row['banner_id']))?>" title="Edit"><i class="ion-edit icon"></i></a></li>
													<li><a  href="javascript:void(0);" onclick="ConfirmBannerDelete('<?php echo $row['banner_id'] ?>', $(this));" title="Delete"><i class="ion-android-delete icon"></i></a></li>													
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
                                         <?php  include getViewsPath() . 'backend-pagination.php'; ?>
                                    </ul>
                                </aside>  
								
                            </div>
					</section>							
