<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

if(isset($renderFeatureBlock) && $renderFeatureBlock == true)
{
	echo render_block("Getmedz_features") ;
}
?>
<!--Footer-->
<footer class="footer">
  <div class="footer__top">
    <div class="container container--fixed">
      <div class="span-row">
        
		  <?php if(count($footer_nav_our_services)>0){?>
		  <div class="span-md-4 span-sm-4 span-xs-12 fl--right">
          <div class="footer__links links__services">
            <h5> <?php echo getLabel(L_Our_Services);?></h5>
            <ul>
			 <?php foreach($footer_nav_our_services as $link):?>
				<?php if($link['nl_type']==0): ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo generateUrl('page', $link['cmsc_slug']); ?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php elseif($link['nl_type']==1): ?>
				<li><?php echo $link['nl_caption']; ?></li>
				<?php elseif($link['nl_type']==2): $url=str_replace('{SITEROOT}', CONF_WEBROOT_URL, $link['nl_html']); ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo $url?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php endif; ?>
			<?php endforeach;
		  ?>
              
            </ul>
          </div>
        </div>
		 <?php }
		 if(count($footer_nav_quick_links)>0){?>
        <div class="span-md-5 span-sm-5 span-xs-12 fl--right">
          <div class="footer__links links__quick">
            <h5>Quick Links</h5>
            <ul>
			 <?php foreach($footer_nav_quick_links as $link):?>
				<?php if($link['nl_type']==0): ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo generateUrl('page', $link['cmsc_slug']); ?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php elseif($link['nl_type']==1): ?>
				<li><?php echo $link['nl_caption']; ?></li>
				<?php elseif($link['nl_type']==2): $url=str_replace('{SITEROOT}', CONF_WEBROOT_URL, $link['nl_html']); ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo $url?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php endif; ?>
			<?php endforeach;?>
             
            </ul>
          </div>
        </div>
		 <?php } ?>
        <div class="span-md-3 span-sm-3 span-xs-12">
          <div class="f__brand"> <img class="f__logo" src="<?php echo generateUrl('image','site_footer_logo'); ?>" alt=""> </div>
		  <ul class="social_links">
			<?php foreach ($social_platforms as $socialplatform):?>
				<li><a href="<?php echo $socialplatform['splatform_url']?>" target="_blank"><img src="<?php echo generateUrl('image', 'social_platform_icon', array($socialplatform["splatform_icon_file"]),CONF_WEBROOT_URL)?>" alt="<?php echo $socialplatform['splatform_title'];?>"/></a></li>
			 <?php endforeach;?>   
		  </ul>
          <!--ul class="social_links">
            <li><a href="#"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/facebook.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/twitter.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/youtube.svg" alt=""></a></li>
            <li><a href="#"><img src="<?php echo CONF_WEBSITE_URL?>images/fixed/google.svg" alt=""></a></li>
          </ul-->
        </div>
      </div>
    </div>
  </div>
  <div class="footer__bottom">
    <div class="container container--fixed">
      <div class="span-md-6 span-sm-6">
        <p class="copy-right"><?php echo render_block("FOOTER_BOTTOM_BLOCK")?></p>
      </div>
      <div class="span-md-6 span-sm-6 text--right">
        <ul class="misc--links">
		<?php foreach($footer_mobile_navigation as $link):?>
				<?php if($link['nl_type']==0): ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo generateUrl('page', $link['cmsc_slug']); ?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php elseif($link['nl_type']==1): ?>
				<li><?php echo $link['nl_caption']; ?></li>
				<?php elseif($link['nl_type']==2): $url=str_replace('{SITEROOT}', CONF_WEBROOT_URL, $link['nl_html']); ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo $url?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php endif; ?>
			<?php endforeach;?>
          <!--li><a href="#">Terms of Use </a></li>
          <li><a href="#"> Privacy Policy </a></li>
          <li><a href="#"> Careers</a></li-->
        </ul>
      </div>
    </div>
  </div>
</footer>




 <!--div class="footer-area">
    	<div class="centered">
    	<div class="lft">
        	<div class="top">
           	<a href="<?php echo generateUrl('');?>">Home</a> |     
			<a href="<?php echo generateUrl('site','contact');?>">Contact Us</a> |  			
 <?php echo trim(renderMenu("<a href='%LINK%'>%PAGE_TITLE%</a> |", CMS::CMS_MENU_LEFT), "|"); ?>
                </div>
          <?php echo render_block("FOOTER_BOTTOM_BLOCK")?>
        </div>
        
        <div class="rtg">
        	<div class="top">
        	 <?php echo trim(renderMenu("<a href='%LINK%'>%PAGE_TITLE%</a> |", CMS::CMS_MENU_RIGHT), "|"); ?>
            </div>
        </div>
        
        
    	</div>
    </div-->
<script>
		/* setTimeout(function(){
			$('.div_error').hide('slow', function() { $('.div_error').hide(); });
			$('.div_msg').hide('slow', function() { $('.div_msg').hide(); });
		}, 6000); */
                

</script>

</div>

</body>


</html>
