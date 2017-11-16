<?php
if (!SYSTEM_INIT)
    die('Invalid Access'); // avoid direct access.
?>


<!--main panel start here-->
<div class="page">
<?php echo html_entity_decode($breadcrumb); ?>
	
    <div class="fixed_container">
        <div class="row">
            <div class="col-sm-12"> 
                <h1>Banners Management</h1> 
               
				<section class="section">
				<div class="sectionhead"><h4>Manage - Banners </h4>
					<?php if($canAdd):?>
						<ul class="actions">
                                <li class="droplink">
                                    <a href="javascript:void(0);"><i class="ion-android-more-vertical icon"></i></a>
                                    <div class="dropwrap">
                                        <ul class="linksvertical">
                                           <li><a href="<?php echo generateUrl('banners', 'form'); ?>">Add Banner</a></li>	
                                        </ul>
                                    </div>
                                </li>
                            </ul>
					 <?php endif;?>
				
				</div>
                
						
                        <div class="sectionbody"> 
					
                         <?php if ((count($arr_listing)>0) && (!empty($arr_listing))) :?>
                          <table class="table table-responsive" id="dtTable">
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
												
													<img src="<?php echo generateUrl('image', 'banner', array($row['banner_id'], 139, 113),CONF_WEBROOT_URL)?>" alt="" />
												<?php else :
													echo $row["banner_html"];
												endif; ?></td>
												<td class="text-center" nowrap="nowrap">
												<ul class="actions">
													<?php if ($row['banner_status']==0):?>
														<li><a href="javascript:;"  title="Enable" class="toggleswitch actives" onclick="UpdateBannerStatus('<?php echo $row['banner_id'] ?>', $(this));"><i  class="ion-checkmark icon inactive" ></i></a></li>
													<?php  else : ?>
														  <li> <a href="javascript:;" onclick="UpdateBannerStatus('<?php echo $row['banner_id'] ?>', $(this));"  title="Disable" class="toggleswitch" ><i  class="ion-checkmark icon active" ></i></a></li>
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
								
								
                            </div>
					</section>							

            </div>
        </div>
    </div>  

    <!--main panel end here-->

