<?php
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.
/* @var $frm Form */
?>
<script type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>js/LiveEditor/scripts/innovaeditor.js"></script>
<script src="<?php echo CONF_WEBROOT_URL; ?>js/LiveEditor/scripts/common/webfont.js" type="text/javascript"></script>
<!--main panel start here-->
<div class="page">
 <?php echo html_entity_decode($breadcrumb); ?>
	<div class="fixed_container">
        <div class="row">
            <div class="col-sm-12">  

				<section class="section">
					<div class="sectionhead"><h4>Manage Block</h4></div>

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


