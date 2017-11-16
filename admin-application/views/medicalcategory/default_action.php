

<!--main panel start here-->
<div class="page">
	<?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  

                <div class="tabs_nav_container responsive boxbased">

                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search</a></li>
                        <li><a href="javascript:void(0)" rel="tabs_02" id="tab_a_2">Manage Category</a></li>

                    </ul>

                    <div class="tabs_panel_wrap">

                        <span rel="tabs_01" class="togglehead active">Search</span>
                        <div class="tabs_panel" id="tabs_01" >
                            <?php echo $searchForm->getFormHtml(); ?>
                        </div>

                        <span rel="tabs_02" class="togglehead">Manage Category</span>
                        <div class="tabs_panel" id="tabs_02" style="display: none;">
                            <div id="form-div">
                                
                                 <?php echo $addform->getFormHtml(); ?>
                            </div>
                           
                        </div>

                    </div>      

                </div>
                <div id="listing-div"></div>






            </div>
        </div>
    </div>  

    <!--main panel end here-->



</div>
<!--body end here-->
<script>
 $('.filefield :input').change(function(){			
			$(this).prev('.filename').html(this.value);
		});
</script>
