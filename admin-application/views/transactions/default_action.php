

<!--main panel start here-->
<div class="page">
<?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  

                
                
                
                <h1>Transaction Management</h1> 
              

                <div class="tabs_nav_container responsive boxbased">

                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0)" rel="tabs_01"  id="tab_a_1" class="active">Search</a></li>
                        

                    </ul>

                    <div class="tabs_panel_wrap">

                        <span rel="tabs_01" class="togglehead active">Search</span>
                        <div class="tabs_panel" id="tabs_01" >
                            <?php echo $searchForm->getFormHtml(); ?>
                        </div>

                       

                    </div>      

                </div>

              <div id="form-div"></div>
  <div id="listing-div"></div>

               

            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->
