<?php if(!empty($paypal_frm)){ ?>
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
                 
                        <h2><?php echo Utilities::getLabel("LBL_Payment_Processing")?></h2>
                        
                    </div>
               </div>
			   <div class="form-cover form-cover--even">
			    <h2><?php echo getlabel('L_WE_ARE_REDIRECTING_YOU!!')?></h2>
                        <h6><?php echo getlabel("L_PLEASE_WAIT")?>...</h6>
                   	<?php echo $paypal_frm->getFormHtml();?>
               </div>
              </h5>

</div>
        </div>
      </div>
    </div>
  </div>
 
</main>




  <!--body end here-->  
<script>
 $(document).ready(function(){
	
	$("#frmPay").submit();
}); 
</script>
<?php } ?>

