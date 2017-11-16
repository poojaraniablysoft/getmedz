<!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">
            <ul class="breadcrumb arrow">
                <li><a href="<?php echo generateUrl('doctor'); ?>">Home</a></li>

                <li>Latest Questions</li>
            </ul>
            <span class="gap"></span>
        </div> 
        <h1>Your Questions</h1> 
        <div class="row" id="listing-div">
           <?php
            if (count($arr_listing) > 0) {
                foreach ($arr_listing as $question) {
                    ?><section class="roundedbox">
                        <div class="boxbody">
                            <div class="boxgrids">
                                <div class="grid_1"><?php echo $question['orquestion_question']; ?>
                                    <a href="<?php echo generateUrl('doctor', 'question', array($question['orquestion_id'])); ?>">View</a>
                                    <div class="answered_time"><?php if ($reply['reply_by'] == 0) { ?>Answered On <?php } echo date("D, dS M Y h:i T", strtotime($question['order_date'])); ?></div>                                              
                                </div>					      					      
                        
                                <div class="grid_3">
                                    <div class="avtararea padd_all user_thumb">
                                        <figure class="pic ">
                                            <form>
                                                <img alt="" src="<?php echo generateUrl('image','getCustomerProfilePic',array($question['user_id'],500,500),"/")?>">
                                            </form>    
                                        </figure>
                                        <div class="picinfo">
                                            <span class="name"><?php echo $question['user_name']; ?></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                     <?php
                }
            } else {
                echo '<section class="section"><section class="sectionbody space">You do not have any  questions</section></section>';
            }
            ?>
	<?php include getViewsPath() . 'pagination.php'; ?>

                     

        </div>
    </div>



   
</div>
</div>  

<!--main panel end here-->
</div>
<!--body end here-->
