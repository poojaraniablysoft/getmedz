<!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">
            <ul class="breadcrumb arrow">
                <li><a href="<?php echo generateUrl('doctor'); ?>">Home</a></li>

                <li>Customers</li>
            </ul>
            <span class="gap"></span>
        </div> 
        <h1>My Customers</h1> 
          <?php echo $searchForm->getFormTag();?>
            <div class="sortbar customer_sort" >
               
                <aside class="grid_custom">
                  
                                 <?php echo $searchForm->getFieldHtml('search_keyword'); ?>
            </aside>  
			<aside class="grid_custom srch-btn">
                  
                                 <?php echo $searchForm->getFieldHtml('btn_submit'); ?>
                             
            </aside> 
                      
        </div>
        </form>
        <div class="row" id="listing-div" id="mainQuestionContainer">
               <?php  include getViewsPath() . 'common/doctor/customer.php'; ?>

        </div>
    </div>



</div>
</div>  

<!--main panel end here-->
</div>
<!--body end here-->
