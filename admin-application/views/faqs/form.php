<?php
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.
/* @var $frm Form */
?>
<div class="page">
	 <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">
            <div class="col-sm-12">  

				<section class="section">
					<div class="sectionhead"><h4>Faq Setup</h4></div>

					<div class="sectionbody">
					<?php
					// @var $frm Form
					echo $frm->getFormHtml();?>
					</div>      
				</section> 
			</div>
		</div>
	</div>
</div>
