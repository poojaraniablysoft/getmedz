


<!--main panel start here-->
<div class="page">
<?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  
			<div id="adderror"></div>				
                        <div class="tabs_nav_container responsive flat">
                            
                            <ul class="tabs_nav">
                                <li><a class="active" rel="tabs_01" href="javascript:void(0)"> Website Settings </a></li>
                                <li><a rel="tabs_02" href="javascript:void(0)">Home Page Settings</a></li>
                                <li><a rel="tabs_03" href="javascript:void(0)">Pdf Settings</a></li>
								<li><a rel="tabs_04" href="javascript:void(0)">Third Party Api Keys</a></li>
                               
                            </ul>
                            
                             <div class="tabs_panel_wrap">
                                        
                                        <!--tab1 start here-->
                                        <span class="togglehead active" rel="tabs_01">Website Settings </span>
                                        <div id="tabs_01" class="tabs_panel">
                                            <div class="wrapcenter">
                                                <?php echo $frmConf->getFormHtml(); ?>
                                            </div>    
                                        </div>
                                        <!--tab1 end here-->
                                     
                                      
                                       <!--tab2 start here-->
                                        <span class="togglehead" rel="tabs_02">HomePage Settings </span>
                                        <div id="tabs_02" class="tabs_panel">
                                            <div class="wrapcenter">
											  <?php echo $frmHome->getFormHtml(); ?>
                                                
                                            </div>    
                                        </div>
                                     <!--tab2 end here-->  
                                 
                                   <!--tab3 start here-->
                                        <span class="togglehead" rel="tabs_03">Pdf Settings </span>
                                        <div id="tabs_03" class="tabs_panel">
                                            <div class="wrapcenter">
											  <?php echo $frmPdf->getFormHtml(); ?>
                                                
                                            </div>    
                                        </div>
                                     <!--tab3 end here-->  
                                 
                                 
									<!--tab4 start here-->
                                        <span class="togglehead active" rel="tabs_04">Third Party Api Keys </span>
                                        <div id="tabs_04" class="tabs_panel">
                                            <div class="wrapcenter">
                                                <?php echo $frmThirdparty->getFormHtml(); ?>
                                            </div>    
                                        </div>
                                        <!--tab4 end here-->
                                 
                                 
                                 
                                 
                                     
                                      
                                  </div>      
                        
                        </div> 
                    
                    </div>
            </div>
        </div>  
        
	
	<!---------------------------------------------------------------------------------------->
				
				
				
				
				
				
				
			</div></div>
			