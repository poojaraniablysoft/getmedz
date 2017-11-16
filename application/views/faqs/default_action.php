<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getLabel('L_Frequently_Asked_Questions');?></h5>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        <div class="span-md-4 span-sm-12 span-xs-12">
         <div class="fixed__panel">
          <div id="fixed__panel">
            <div class="box box--white">
              <ul class="nav--vertical nav--vertical-js">
			  
			  <?php 
			  if(!empty($faq_categories)){
				  $i=1;
				  foreach($faq_categories as $categories) { 
				  
			  ?>
				
				<li <?php if($i==1){ ?>class="is-active" <?php } ?> ><a href="#<?php echo $categories['faqcat_id'];?>" class="scroll"><?php echo $categories['faqcat_name'];?></a></li>
				<!--li <?php if($i==1){ ?>class="is-active" <?php } ?> ><a href="#trendingquestions" class="scroll"><?php echo $categories['faqcat_name'];?></a></li-->
			  <?php $i = $i+1; }  } ?>
				
               
              </ul>
            </div>
          </div>
        </div>
        </div>
        <div class="span-md-8 span-sm-12 span-xs-12">
         
            <h2 class="faq--title"><?php echo getLabel('L_Frequently_Asked_Questions');?></h2>
            
            <div class="container--faqs">
			
			<?php  if(!empty($faq_categories) ){ 
			 $i=1;
			foreach($faq_categories as $categories)
			{
			?> 
              <div id="<?php echo $categories['faqcat_id'];?>" class="listing--accordians">
                <h4><?php echo $categories['faqcat_name'];?></h4>
                <div class="box box--white">
				
					<?php if(!empty($categories['faqs'])) { 
					
						foreach($categories['faqs'] as $faqs)
							{
								
					?>
								  <div class="accordians">
									<div class="accordians__head accordians__trigger-js<?php if($i==1){ ?> is-active<?php } ?>  ">
									  <h6><?php echo $faqs['faq_question'] ?></h6>
									</div>
									<div class="accordians__body accordians__target-js" <?php if($i!=1){ ?> style="display:none"<?php } ?>>
									  <div class="description">
										<div class="description__body faq-content" >	
										  <?php echo html_entity_decode($faqs['faq_answer']); ?> 
										</div>
										
									  </div>
									</div>
								  </div>
					<?php $i++; } }?>
				</div>
                  
			</div>
			<?php }}?>
		  </div>             
             
		 </div>
         
        </div>
      </div>
    </div>
  </div>
  
</main>
<script>
 /******** for faq accordians  ****************/ 
$( document).ready(function(){
	$('.nav--vertical-js li').removeClass('is-active');
	$('.nav--vertical-js li:first').addClass('is-active');
});
$('.accordians__trigger-js').click(function(){
	
	
  if($(this).hasClass('is-active')){
      $(this).removeClass('is-active');
      $(this).siblings('.accordians__target-js').slideUp();
      return false;
  }
 $('.accordians__trigger-js').removeClass('is-active');
 $(this).addClass("is-active");
 $('.accordians__target-js').slideUp();
 $(this).siblings('.accordians__target-js').slideDown();
});
    
    /* for click scroll function */
$(".scroll").click(function(event){
event.preventDefault();
var full_url = this.href;
var parts = full_url.split("#");
var trgt = parts[1];
/* var target_offset = $("#"+trgt).offset();
var target_top = target_offset.top;
    
$('html, body').animate({scrollTop:target_top}, 1000); */
var nav = $("#"+trgt);


if (nav.length) {
  var contentNav = nav.offset().top;

}
 $("html, body").animate({ scrollTop: $("#"+trgt).offset().top }, 1000);
});  
    
$('.nav--vertical-js li').click(function(){    
	$('.nav--vertical-js li').removeClass('is-active');
	$(this).addClass('is-active');
});       

    
    
/* for sticky left panel */
  
    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var div_top = $('.fixed__panel').offset().top -30;
        var sticky_left = $('#fixed__panel');
        if((window_top + sticky_left.height()) >= ($('footer').offset().top - 60)){
            var to_reduce = ((window_top + sticky_left.height()) - ($('footer').offset().top - 60));
            var set_stick_top = -60 - to_reduce;
            sticky_left.css('top', set_stick_top+'px');
        }else{
            sticky_left.css('top', '75px');
            if (window_top > div_top) {
                $('#fixed__panel').addClass('stick');
            } else {
                $('#fixed__panel').removeClass('stick');
            }
        }
    }

    $(function () {
        $(window).scroll(sticky_relocate);
        sticky_relocate();
    });
          


</script>















