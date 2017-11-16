<?php if(count($answeredQuest)>0){?>
<div class="section section--answers" style="background-image:url(images/dynamic/bg-answers.jpg);" >
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-6 span-sm-12 span-xs-12 fl--right">
          <div class="fixed-image text--center"> <img src="<?php echo CONF_WEBSITE_URL?>images/dynamic/doc.png" alt=""> </div>
          <hgroup>
            <h5 class="heading-text text--left "><?php echo getLabel('L_Recent_Answered');?></h5>
          </hgroup>
          <div class="answers-accord">
            <div class="accordion js-accordion">
			<?php foreach ($answeredQuest as $value): ?>
              <h4 ><?php echo subStringByWords($value['orquestion_question'], 70) ?> </h4>
              <div class="ans fade">
                <div class="ans__description">
                  
                  <p><?php  echo $value['reply_text'] ?></p>
                <div class="ans__post">
                  <div class="ans__posted-in"><?php echo getLabel('L_Realte_To');?>:<span> <?php echo $value['category_name'] ?></span></div>
                  <div class="ans__posted-by"><?php echo getLabel('L_Posted_By');?>:<span> <?php echo $value['doctor_username'] ?></span></div>
                </div>
              </div>
			 
             
            </div>
			<?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
<?php }?>