<!--Banner-->
<?php if($home_page_elements["banners"][0] != ''){
	$val = $home_page_elements["banners"][0];?>
	<div class="banner page-banner">
	  <div class="banner__content" >
		<div class="banner__img"><img src="<?php echo generateUrl('image','homebanner',array($val["banner_image_path"],'NORMAL'))?>" alt=""></div>
		<!--div class="banner__img"><img src="<?php echo CONF_WEBROOT_URL;?>images/banners/home-banner.jpg" alt=""></div-->
		<div class="container container--fixed">
		  <div class="banner__content__title">
			<!--h2>Get Answers For Your Health Queries<span>From our Top Doctors</span></h2-->
			<h2><?php echo $val["banner_text"] ;?></h2>
			<a class="button button--fill button--orange ask_question"><?php echo getLabel('L_Ask_Question');?></a> </div>
		</div>
	  </div>
	</div>
<?php } ?>
<!--Main-->

<main class="site-main "> 
  <!--How it works-->
  <?php if($howItWorkContent = render_block("Home_page_How_does_it_work")){
	?>
	<div id="how-it-works" class="section section-blue" style="background-image:url(<?php echo CONF_WEBROOT_URL;?>images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
	  <?php echo $howItWorkContent;?>
        
      </div>
    </div>
  </div>
	<?php
}?>
  
  <!--Ask Doctor-->
	<?php  include getViewsPath() . '_partials/home_ask_doctor.php'; ?>
  <!--Experienced Team-->
	<?php  include getViewsPath() . '_partials/home_experienced_team.php'; ?>
  <!--Testimonials-->
    <?php  include getViewsPath() . '_partials/home_testimonials.php'; ?>
  <!--Answers Section-->
	<?php  include getViewsPath() . '_partials/home_answers_section.php'; ?>
  <!--Blog Posts Section-->
	<?php  include getViewsPath() . '_partials/home_blog_posts.php'; ?>
  <!--CTA Section-->
	<?php  include getViewsPath() . '_partials/home_CTA.php'; ?>
</main>

<!-- Icons -->
<!--<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" style="display:none">
  <defs>
    <symbol id="generalmed" viewBox=""></symbol>
  </defs>
</svg> -->
<!--Scripts-home--> 
<?php if(isset($_GET['ask_question'])) { ?>
<script>
 getAnswer();
 </script>
<?php } ?>
<script>
$(".ask_question").click(function() {
<?php unset($_SESSION['step']);
		 unset($_SESSION['step_1']);
		 unset($_SESSION['step_2']);
		 unset($_SESSION['step_3']);
		 unset($_SESSION['step_4']);
		 unset($_SESSION['step_5']);?>	
    $('html,body').animate({
        scrollTop: $("#ask-doc").offset().top},
        'slow');
});

function getAnswer()
{
	<?php unset($_SESSION['step']);
		 unset($_SESSION['step_1']);
		 unset($_SESSION['step_2']);
		 unset($_SESSION['step_3']);
		 unset($_SESSION['step_4']);
		 unset($_SESSION['step_5']);?>	
    $('html,body').animate({
        scrollTop: $("#how-it-works").offset().top},
        'slow');
}	
</script>
</body>
</html>
