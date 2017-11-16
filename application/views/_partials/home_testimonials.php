<div id="testimonials" class="section section--testimonials" >
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-7 span-xs-12 span--center">
          <ul class="testimonil--slider js-testimonial--slider">
		  <? foreach($testimonials as $key=>$val):?>
            <li>
              <div class="testimonial__media">
                <div class="testimonial__image"> <img src="<?php echo generateUrl('image','testimonial_image',array($val["testimonial_image"]))?>" alt=""> </div>
                <h2 class="testimonial__user"> <?php echo $val["testimonial_name"]?> </h2>
                <h5 class="testimonial__text"> <?php echo nl2br($val["testimonial_text"])?></h5>
              </div>
            </li>
		<? endforeach;?>
            
          </ul>
        </div>
        <?php echo render_block("CLIENT_SLIDER")?>
      </div>
    </div>
  </div>