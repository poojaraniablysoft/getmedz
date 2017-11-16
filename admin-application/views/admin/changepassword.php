    
        <!--main panel start here-->
        <div class="page">
		<?php echo html_entity_decode($breadcrumb); ?>
            <div class="fixed_container">
                <div class="row">
                    
                   
                    
                  <div class="col-sm-12">  
                    
              
                    <div class="containerwhite">
                       
                        <aside class="grid_2">
                            <ul class="centered_nav">
                             
                               
                              
                                <li><a href="change_password.html" class="active">Change Password</a></li>
                            </ul>
                            
                          <div class="areabody">   
                              <div class="formhorizontal">
							  
							  <?php echo Message::getHTML();?>
                                <?php echo $frmPassword->getFormHtml(); ?>
                                  


                                    </form> 
                               </div>  
                            </div>   
                        </aside>  
                    </div>
                   </div> 
                   
                    
                </div>
            </div>
        </div>  
        
        <!--main panel end here-->
        
        