<div id="ask-question" class="section " >
    <div class="container container--fixed">
      <div class="span-row">
        <div class="span-md-12">
          <hgroup>
            <h5 class="heading-text text--center "><?php echo getLabel('L_Ask_Doctor');?></h5>
            <h6 class="sub-heading-text text--center "><?php echo getLabel('L_Online_Any_Question');?></h6>
          </hgroup>
        </div>
		<?php echo $questionFrm->getFormTag(); ?>
		<div class="span-md-12">
          <div class="questions--tabs">
            <div class="question--tab__trigger js-question--tab__trigger"><span><?php echo getLabel('L_Select_Category');?></span></div>
            <div class="med--tabs ">
              <nav>
                <ul class="med-tabs-navigation">
				<?php
					
					
					$categori = array_slice($categories, 0, 5);
					$read_more = array_slice($categories, 5);
					
				$array_first = current($categories);
				
				foreach ($categori as $key => $category):			
				
				
					?>
					<li><a href="javascript:void(0)" class="<?php echo ($array_first['category_name'] == $category['category_name']) ? 'selected' : '' ?>">
							<?php //echo $questionFrm->getFieldHtml('orquestion_med_category'); ?>
							<div class="categories__custom_content">
							<input style="display:none;" type="radio" <?php echo ($array_first['category_name'] == $category['category_name']) ? 'checked' : '' ?> title="<?php echo $category['category_name'] ?>" value="<?php echo $category['category_id'] ?>" name="orquestion_med_category">
							<i class="med--tabs__icon"><img src="<?php echo generateUrl('image', 'medical_category', array($category['category_id'], 45, 45) ) ?>" alt=""></i>
							 <span><?php echo $category['category_name']
							?></span></div></a></li>
				<?php   endforeach; ?>
				<?php if(count($categories)>5)
				{?>
					<li><a class="modaal-inline-content" href="#more_categories"> <i class="med--tabs__icon"><img src="<?php echo CONF_WEBROOT_URL ?>images/fixed/categmore-40h.svg" alt=""></i> <span><?php echo getLabel('L_More');?></span> </a> </li>
				<?php } ?>
			</ul>
		 </nav>
		</div>
		<div id="more_categories" class="hidden more__categories" >
		  <div class="categories__wrapper">
			<div class="categories__box">
			  <ul class="medical-categry-js ">
			  <?php 
				foreach ($read_more as $key => $category):			
				
					?>
					<li><a href="javascript:void(0)" class="<?php echo ($array_first['category_name'] == $category['category_name']) ? '' : '' ?>" >
					<div class="categories__custom_content">
							<?php //echo $questionFrm->getFieldHtml('orquestion_med_category'); ?>
							<input style="display:none;" type="radio" <?php echo ($array_first == $category['category_name']) ? 'checked' : '' ?> title="<?php echo $category['category_name'] ?>" value="<?php echo $category['category_id'] ?>" name="orquestion_med_category" >
							<i class="med--tabs__icon"><img src="<?php echo generateUrl('image', 'medical_category', array($category['category_id'], 45, 45) ) ?>" alt=""></i>
							 <span><?php echo $category['category_name']
							?></span></div></a></li>
				<?php   endforeach; ?>
				
			  </ul>
			</div>
		  </div>
		</div>
		
		<div class="med--tabs__content">		 
			<div class="span-row">
			  <div class="span-md-12">
				<div class="field-set">
				  <div class="field-wraper">
					<div class="field_cover">
						
					  <?php echo $questionFrm->getFieldHtml('orquestion_question'); ?>
					  <?php
						echo $questionFrm->getFieldHtml('step'); ?>
					</div>
				  </div>
				</div>
			  </div>
		
			
			<div class="span-md-6 span-sm-6">
                    <div class="field-set">
                      <div class="field-wraper">
                        <div class="field_cover">
                          <div class="box">
						   <!--div class="VisibleField"><input type="text" value="" class="textbox" id="textfield"></div-->
						   <!--input type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple /-->
						   <?php echo $questionFrm->getFieldHtml('fileupload'); ?>
           
							 <label for="file-1">
                              <svg version="1.1"
	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
	 x="0px" y="0px" width="12px" height="27px" viewBox="0 0 12 27" enable-background="new 0 0 12 27" xml:space="preserve">
                                <defs> </defs>
                                <path fill="#737474" d="M11.191,7.811c-0.455,0-0.822,0.362-0.822,0.828v12.236c0,1.249-0.44,2.272-1.292,3.146
	c-0.853,0.873-1.866,1.324-3.099,1.324c-1.205,0-2.233-0.436-3.084-1.31c-0.852-0.873-1.278-1.926-1.278-3.16v-4.62v-2.469v-6.08
	v-2.92v-0.03v-0.03c0-0.828,0.297-1.546,0.867-2.137C3.059,1.991,3.76,1.67,4.597,1.67s1.539,0.32,2.115,0.918
	c0.569,0.591,0.866,1.31,0.866,2.137v0.03v0.06v13.65c0,0.857-0.646,1.521-1.482,1.521c-0.808,0-1.469-0.692-1.469-1.521v-7.149
	c0-0.466-0.353-0.828-0.808-0.828c-0.455,0-0.808,0.361-0.808,0.828v7.149c0,0.888,0.294,1.641,0.896,2.258s1.322,0.918,2.189,0.918
	c0.866,0,1.594-0.309,2.203-0.918c0.595-0.595,0.896-1.34,0.896-2.258V4.756v-0.03c0-1.294-0.459-2.404-1.351-3.326
	C6.943,0.47,5.86,0,4.597,0S2.25,0.47,1.351,1.399C0.459,2.321,0,3.431,0,4.726v0.03v2.95v6.08v2.469v4.62
	c0,1.7,0.587,3.146,1.748,4.334C2.908,26.398,4.318,27,5.978,27c1.66,0,3.099-0.572,4.274-1.775C11.427,24.02,12,22.545,12,20.875
	V8.639C12,8.172,11.647,7.811,11.191,7.811z"/>
                              </svg>
                              <span>Choose a file</span></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
  
			<div class="span-md-6 span-sm-6">
                    <div class="field-set">
                      <div class="field-wraper text--right">
                        <div class="field_cover">
							<?php
								echo $questionFrm->getFieldHtml('btn_login');
								$questionFrm->getField('orquestion_name')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_name');
				$questionFrm->getField('orquestion_gender')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_gender');
				$questionFrm->getField('orquestion_age')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_age');
				$questionFrm->getField('orquestion_weight')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_weight');
				$questionFrm->getField('orquestion_state')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_state');
				$questionFrm->getField('orquestion_phone')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_phone');
				$questionFrm->getField('orquestion_email')->fldType = 'hidden';
				echo $questionFrm->getField('orquestion_email')->requirements()->setRequired(false);
				echo $questionFrm->getFieldHtml('orquestion_email');
				echo $questionFrm->getFieldHtml('orquestion_email');
				echo $questionFrm->getFieldHtml('step');
				echo $questionFrm->getFieldHtml('file_name'); 
				$questionFrm->getField('orquestion_med_history')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_med_history');
				/* $questionFrm->getField('orquestion_doctor_id')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('orquestion_doctor_id');
				$questionFrm->getField('subscription_id')->fldType = 'hidden';
				echo $questionFrm->getFieldHtml('subscription_id'); */
				$questionFrm->setJsErrorDisplay('afterfield');
							?>
                        </div>
                      </div>
                    </div>
                  </div>
           
			
		</div>
		
		</div>
		
		
        
        </div>
      </div>
	 
	  <?php echo $questionFrm->getExternalJs(); ?>
	</form>
    </div>
  </div>
  </div>