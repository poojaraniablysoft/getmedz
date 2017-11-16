<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 
<div id="body">
	
	<!--main panel start here-->
	<div class="page">
		<ul class="breadcrumb arrow">
					<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

					<li ><a href="<?php echo generateUrl('blogcomments'); ?>">Blog Comments Management</a></li>
					<li >View Detail</li>
					
				</ul>
		<div class="fixed_container">
    <div class="row">
        <div class="col-sm-12">  
			
            <h1>Manage Comment </h1>
            <section class="section">
                <div class="sectionhead"><h4>Comment Details </h4></div>
                <div class="sectionbody space">
                    <table class="table_form_vertical">
                        <tbody>
                            <tr>
                                <td><strong>Name:</strong> <?php echo ucfirst($comment_data['comment_author_name']); ?></td>
                                <td><strong>Email:</strong> <?php echo $comment_data['comment_author_email']; ?></td>
                                <td><strong>IP Address:</strong> <?php echo $comment_data['comment_ip']; ?>
                                </td>
                                <?php if ($canedit === true) { ?>
                                    <td rowspan="2" width="25%"><h2>Edit Comment Status</h2><?php echo $frmComment->getFormHtml(); ?>
                                    </td>
                                <?php } ?>
                            </tr>

                            <tr>
                                <td><strong>Status:</strong> <?php
                                if ($comment_data['comment_status'] == 1) {
                                    echo 'Approved';
                                } elseif ($comment_data['comment_status'] == 2) {
                                    echo 'Cancelled';
                                } else {
                                    echo 'Pending';
                                }
                                ?> </td>

                                <td><strong>Date:</strong> <?php echo displayDate($comment_data['comment_date_time']); ?></td>

                                <td ><strong>User Agent:</strong> <?php echo $comment_data['comment_user_agent']; ?></td>
                            </tr>
                            <tr>	
                                <td><strong>Comment:</strong></td>
                                <td  colspan=3 style="text-align:justify"><?php echo nl2br($comment_data['comment_content']); ?></td>
                            </tr>	
                        </tbody>
                    </table>  
                </div>
            </section>
        </div>	
    </div>			
	<!--main panel end here-->
</div>
<!--body end here-->
</div>			