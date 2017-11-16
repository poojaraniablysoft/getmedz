<?php $step_array = explode("-",$step);
$step_no = $step_array[1];
?>
<div class="ask-steps__sidebar">
  <div class="steps__wrap">
	<ul class="steps__count">
	  <li><a <?php if($step=='1'){?>class="current" <?php } ?> href="<?php echo generateUrl('home')?>" >1</a></li>
	  <li><a <?php if($step-1=='2'){?>class="current" <?php } ?> href="javascript:;" onclick = "getQuestionForm(2);">2</a></li>
	  <li><a <?php if($step-1=='3'){?>class="current" <?php } ?> href="javascript:;" <?php if($step >3 ) { ?> onclick = " getQuestionForm(3);" <?php } ?>>3</a></li>
	  <li><a <?php if($step-1=='4'){?>class="current" <?php } ?> href="javascript:;" <?php if($step >4 ) { ?> onclick = "getQuestionForm(4);" <?php } ?> >4</a></li>
	  <li><a <?php if($step-1=='5'){?>class="current" <?php } ?> href="javascript:;" <?php if($step_no >5 ) { ?> onclick = "getQuestionForm(5);" <?php } ?> >5</a></li>
	</ul>
  </div>
  <?php echo render_block($right_block) ; ?>
 
</div>