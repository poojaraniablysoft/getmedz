

<!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  


                <!--main panel end here-->
                <div class="sectionbody space">


                    <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl(''); ?>">Home</a></li>
                      
                        <li>Your Questions</li>
                    </ul>
                    <span class="gap"></span>
                </div> 

                <div id="msg_info"></div>
                <?php echo Message::getHtml();
                ?>
                             <h1>Your Questions</h1> 
					<div class="sectionbody">
						<?php echo $searchForm->getFormTag();?>
						<div class="sortbar customer_sort" >
							<aside class="grid_custom">
								<span class="sort_text">Search By </span>
								<?php echo $searchForm->getFieldHtml('orquestion_status'); ?>
							</aside>  
						  
					</div>
					</form>

                <div id="listing-div"></div>

            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->
