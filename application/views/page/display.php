<!--Main-->
<main class="site-main "> 
  <!--page head-->
  <div id="page--head" class="section section-blue" style="background-image:url(/images/dynamic/bg-how-it-works.png);">
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup class="page-head">
            <h5 class="heading-text text--center text--white"><?php echo $pageinfo['cmsc_title']?> </h5>
            <h6 class="sub-heading-text text--center text--white"><?php echo $pageinfo['cmsc_sub_title']?></h6>
          </hgroup>
        </div>
      </div>
    </div>
  </div>
  
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="span-row">
        <div class="span-md-12">
          <?php echo html_entity_decode($pageinfo['cmsc_content']); ?>
        </div>
      </div>
    </div>
  </div>
  <?php if(isset($page_type) && $page_type == 'howitworks') 
  { ?>
  <div class="section section-orange cta--section">
    <div class="container">
      <div class="cta--section__inner">
        <h2><?php echo getLabel('L_Ask_your')?> <span><?php echo getLabel('L_Question')?></span></h2>
        <p><?php echo getLabel('L_Ask_your_content')?>
		</p>
        <a href="<?php echo generateUrl('home','questionsetup') ?>" class="button button--fill button--white"><?php echo getLabel('L_Get_your_answer')?></a> </div>
    </div>
  </div>
  <?php  } ?>
  
  <?php //echo render_block("Getmedz_features")?>
 
</main>
