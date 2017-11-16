<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<div id="body">
	
	<!--main panel start here-->
	<div class="page">
	<ul class="breadcrumb arrow">
		<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

		<li ><a href="<?php echo generateUrl('blogcontributions'); ?>">Blog Contributions Management</a></li>
		
		<li >View Contribution</li>
		
	</ul>
	<div class="fixed_container">
		<div class="row">
			<div class="col-sm-12">  
			
				<h1>View Contribution </h1>
				<section class="section">
					<div class="sectionhead"><h4>Contribution Details </h4></div>
					<div class="sectionbody space">
						<table class="table_form_vertical">
							<tbody>
								<tr>
									<td><strong>First Name:</strong> <?php echo ucfirst($contribution_data['contribution_author_first_name']); ?></td>
									<td><strong>Last Name:</strong> <?php echo ucfirst($contribution_data['contribution_author_last_name']); ?></td>
									<td><strong>Email:</strong> <?php echo $contribution_data['contribution_author_email']; ?></td>
									<?php if ($canedit === true) { ?>
										<td rowspan="2" width="25%"><h2>Edit Contribution Status</h2><?php echo $frmContributionStatusUpdate->getFormHtml(); ?>
										</td>
									<?php } ?>
								</tr>

								<tr>
									<td><strong>Phone:</strong> <?php echo $contribution_data['contribution_author_phone']; ?></td>
									<td><strong>Added Date:</strong> <?php echo displayDate($contribution_data['contribution_date_time']); ?></td>
									<td><strong>Status:</strong> <?php
										if ($contribution_data['contribution_status'] == 1) {
											echo 'Approved';
										} elseif ($contribution_data['contribution_status'] == 2) {
											echo 'Posted/Published';
										} elseif ($contribution_data['contribution_status'] == 3) {
											echo 'Rejected';
										} else {
											echo 'Pending';
										}
										?>
									</td>
								</tr>
								<?php if (!empty($contribution_data['contribution_file_name'])) { ?>
									<tr>	
										<td><strong>File:</strong> <a class="a_class" href="<?php echo generateUrl('blogcontributions', 'download', array($contribution_data['contribution_file_name'], $contribution_data['contribution_file_display_name'])); ?>"><?php echo $contribution_data['contribution_file_display_name']; ?> <input type="button" class="btn_cursor" name="download" id="download" value="Download"/></a></td>
												<?php
												echo '</tr>';
											}
											?>	
							</tbody>
						</table>  
					</div>
				</section>
			</div>	
		</div>
	</div>	
</div>
