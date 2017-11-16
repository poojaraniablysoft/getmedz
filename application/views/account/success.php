 <!--body start here-->  
 
 <main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo Utilities::getLabel('LBL_Congratulations')?></h5>
            
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
       
        <div class=" span-md-12">
          <div class="ask-steps">
         
           <div class="ask-steps__main">

  
  <h5 class="ask-steps__main__title">  
  <div class="form-cover">
                   <div class="block--empty -align-center">
                        <img width="80" alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/tick.svg" class="block__img">
                        <h2><?php echo Utilities::getLabel("L_YOUR_ORDER_HAS_BEEN_PLACED_SUCCESSFULLY.")?></h2>
                        
                    </div>
               </div>
			   <div class="form-cover form-cover--even">
                   <a class="btn btn--secondary" href="<?php echo Utilities::generateUrl('#ask-question')?>"><?php echo getLabel("L_Post_Another_Question")?></a>
               </div>
              </h5>

</div>
        </div>
      </div>
    </div>
  </div>
 
</main>


