<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div>
    <div class="body clearfix">
      <div class="sectionsearch">
        <!--<div class="container">
          <h3><?php echo getLabel('L_How_can_help_you')?></h3>
          <form class="siteForm">
            <input type="text" onBlur="if(this.value=='') this.value='<?php echo getLabel('L_Have_Question_Enter')?>';" onFocus="if(this.value=='<?php echo getLabel('L_Have_Question_Enter')?>') this.value='';" value="<?php echo getLabel('L_Have_Question_Enter')?>" name="q">
            <input type="submit" value="<?php echo getLabel('L_Search')?>">
          </form>
        </div>-->
      </div>
      <div class="fixed-container"><br>
        <br>
        <h1 class="pageTitle"><?php echo getLabel('L_Frequently_Asked_Questions')?><br>
<br>
</h1>
        <div class="faqcontainer">
          <div class="partLeft">
            <div class="sectiontoggle">
                <span class="spantxt"><?php echo getLabel('L_FAQ_Categories') ?> </span><a href="javascript:void(0)" class="togglelink"></a>
            </div>
            <ul class="leftLinks">
                <?php foreach($faq_categories as $key=>$val):?>
                <li><a href="<?php echo generateUrl('faqs', 'category',array($val["category_id"]))?>" <?php if($val["category_id"]==$faq_category["category_id"]):?> class="selectedlink" <?php endif; ?>><?php echo $val["category_name"]?></a></li>
                <?php endforeach;?>
            </ul>
           </div>
          <div class="partRight">
                    		<h2><?php echo $faq_category["category_name"]?></h2>
                            <div class="cmsContainer">
								<?php foreach($faq_category["faqs"] as $fcat=>$fval):?>
                                <div class="contentrow">
                                    <span class="contentTitle tileicon accordianhead"><?php echo $fval["faq_question_title"]?></span>
                                    <div class="contentwrap accordiancontent">
                                        <p><?php echo nl2br($fval["faq_answer_brief"],true)?></p>
                                    </div>
                                </div>
                                <?php endforeach;?>
                         </div>   
                    </div>
        </div>
      </div>
    </div>
    
  </div>
  

