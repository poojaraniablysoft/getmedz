<!--Main-->
<?php //echo "<pre>"; print_r($_SESSION['question_description']); die;?>
<script>
  //var step = "<?php echo $step;   ?>";  
  var step = "<?php echo $_SESSION['step']   ?>";  

  </script>
<main class="site-main "> 
  <!--page head-->
  
  <div id="page--head" class="section section-blue" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo getLabel('L_ASK_Doctor')?></h5>
            <h6 class="sub-heading-text text--center text--white"> <?php echo getLabel('L_Help_Doctors_to_understand_your_problem_better')?> </h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        <div class="ask-category span-md-12">		
          <div class="ask-category__block"> 
		  <i class="ask-category__icon"><img src="<?php echo generateUrl('image', 'medical_category', array($cat_data['category_id'], 45, 45) ) ?>" alt=""> </i>
            <div class="ask-category__content">
              <h5><?php echo $cat_data['category_name']; ?></h5>
              <p><?php echo $question; ?> </p>
              <?php if(isset($attchment) && !empty($attchment)) { ?><a class="inline-link" href="<?php echo generateUrl('home','get_self_attachment',array($attchment),CONF_WEBROOT_URL) ?>"><?php echo getlabel(L_View_Attachment);?></a> 
			  <?php } ?>
			  </div>
			  
          </div>
        </div>
        <div class=" span-md-12">			
			<div id="ask-step" class="ask-steps">
			
			</div>
        </div>
      </div>
    </div>
  </div>
  
</main>

<script>
$(document).ready(function(){	
	getQuestionForm(step);	
});   
function submitForm(frm,v){	  
	v.validate();
	if (!v.isValid()) return;	
	var next_page =  parseInt(step)+1;	
	ask_step(next_page);	    
}
    
</script>    