<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>
<main class="site-main ">   
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          
<div class="span-md-12 span-sm-12 span-xs-12">
    <div class="body clearfix">      
      <div class="fixed-container">
        <div class="content ">
            <?php include 'rightpanelblog.php'; ?>
            <div class="col_left" id="archives-post-list"></div>
			<?php echo $frmArchives->getFormHtml();?>
        </div>
      </div>
    </div>
  </div>
  </div>
      </div>
    </div>
  </div>
</main>