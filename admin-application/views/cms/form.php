<?php
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.
/* @var $frm Form */
?>

<!--main panel start here-->
<div class="page">
 <?php echo html_entity_decode($breadcrumb); ?>
	 <div class="fixed_container">
        <div class="row">
            <div class="col-sm-12">  

				<section class="section">
					<div class="sectionhead"><h4>Manage Cms Page</h4></div>

					<div class="sectionbody">
					   <?php echo $frm->getFormHtml();?>
					</div>      
				</section> 
			</div>
		</div>
	</div>
   
    <!--main panel end here-->
</div>
<!--body end here-->

 
