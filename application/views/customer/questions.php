<!--Main-->
<main class="site-main ">   
  <!--main section--sidebar template-->
  <div class="section section-gray">
    <div class="container">
      <div class="dashboard--box">
        <div class="span-row">
          <div class="span-md-12 span-sm-12 span-xs-12">
            <div class="dashboard">
              <?php include getViewsPath() . 'common/customer/left-menu.php'; ?>
              <div class="dashboard__content">
                <h2 class="dashboard_title"><?php if(isset($question_title) && $question_title!='' ) { echo $question_title; } else { echo getLabel('L_My_Questions'); }?></h2>
					<?php echo $searchForm->getFormTag(); ?>
							<div class="sortbar customer_sort">
								<aside class="grid_custom ">
									<span class="sort_text"><?php echo getLabel('L_Search_By'); ?> </span>
									<?php echo $searchForm->getFieldHtml('orquestion_status'); ?>		
								</aside>
					
							</div>			
					</form>
					
					<div class="row" id="listing-div">
					<?php  //include getViewsPath() . 'common/doctor/myansweredquestions.php'; ?>
				</div>               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>





<!--main panel start here-->
<!--div class="custm-wrapper inner-main">

    <div class="centered">


        <h2>My <span>Questions</span> </h2>


        <div class="admin-cont-area" id="listing-div"> 

                    
        </div>

		  
		<div class="qst-btn1-area">
			<input name="" type="button" value="Ask Another Medical Question" class="ask click-btn">
		</div>
		
		  <?php echo $questionFrm->getFormTag(); ?>
		<div class="hidden-qst " style="display:none;">
		  <ul class="nav-area">
            <?php
            $array_first = current($categories);
            foreach ($categories as $key => $category):
                ?>
                <li><a href="javascript:void(0)" class="<?php echo ($array_first == $category) ? 'active' : '' ?>">
                        <input style="display:none;" type="radio" <?php echo ($array_first == $category) ? 'checked' : '' ?> title="<?php echo $category ?>" value="<?php echo $key ?>" name="orquestion_med_category">

                        <?php echo $category
                        ?></a></li>
            <?php endforeach; ?>
        </ul>
		<div class="qst-block">
		<h3>Please Enter Your Medical <span>Question Below </span> </h3>
		<?php echo $questionFrm->getFieldHtml('orquestion_question'); ?>	  <?php
            echo $questionFrm->getFieldHtml('step');



            echo $questionFrm->getFieldHtml('btn_login');
            ?>
  <div class="file_upload">
                 <?php echo $questionFrm->getFieldHtml('fileupload'); ?>
           
                <div class="VisibleField"><input type="text" value="No file chosen" class="textbox" id="textfield"></div>
            </div>
          
			<?php echo $questionFrm->getExternalJs(); ?>
		</div>
			</form>
		</div>
        
		</div>


    </div>




</div>

</div>
<!--body end here-->
