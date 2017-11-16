<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?> 

	<script>    
   var catId=" <?php echo $catId ?>";
   
 /*   $(document).ready(function () {
        //Table DND call
        $('.table').tableDnD({
            onDrop: function (table, row) {
                var order = $.tableDnD.serialize('id');
                order+='&catId='+catId;                
                // $.mbsmessage('Updating display order....');
                callAjax(generateUrl('blogcategories', 'setCatDisplayOrder'), order, function (t) {

                });
            }

        });
    }); */
</script>	
	<!--main panel start here-->
	<div class="page">
			<ul class="breadcrumb arrow">
				<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>

				<li ><a href="<?php echo generateUrl('blogcategories'); ?>">Blog Management</a></li>
				<?php if($catId >0) { ?>
				<li ><a href="<?php echo generateUrl("blogcategories", 'blogchildcategories', array($catId)); ?>">List</a></li>
				<?php } ?>
			</ul>
		<div class="fixed_container">
			<div class="row">
			<div class="col-sm-12">	
					
				
                       
						<div class="tabs_nav_container responsive boxbased">

						<ul class="tabs_nav">
							<li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Blog Category Search</a></li>
							

						</ul>

						<div class="tabs_panel_wrap">
							<span rel="tabs_01" class="togglehead active">Search</span>
							<div class="tabs_panel" id="tabs_01" >
								<?php echo $frmCategory->getFormHtml(); ?>
							</div>                      

						</div>      

					</div>
											
					
				  <section class="section"> 
						<div class="sectionbody" id="listing-div"> </div>
					</section>	
			</div>
		</div>
	</div>          
	<!--main panel end here-->
</div>
<!--body end here-->

			