<style>

</style><!--main panel start here-->
<div class="page">
<?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">





                <section class="section">
                    <div class="sectionbody">                     
                        <div class="row">
                            <div class="col-md-10 col-xs-8">
                                <table class="table table-responsive ">
                                    <tr><th colspan="2">Review</th></tr>
                                    <tr><td ><strong>Order id: </strong> <?php echo $review['order_id']; ?></td>
                                        <td><strong>Order Date:</strong> <?php echo displayDate($review['order_date'])?></td></tr><tr><td ><strong>Name: </strong> <?php echo $review['user_name']; ?></td>
                                        <td><strong>Email:</strong> <?php echo $review['user_email']?></td></tr>
                                    <tr><td ><strong>Doctor:</strong> <?php echo $review['doctor_name']; ?></td>
                                        <td><strong>Rating: </strong> <?php echo createStar('review_rating',$review['review_rating']); ?></td></tr>
                                    <tr><td ><strong>Review:</strong> <?php echo $review['review_text']; ?></td><td></td></tr>
                                </table>
                            </div>
                          
                        </div>
                    </div>
                </section>
            </div>
        </div>
      

        </section>
    </div>

    <!--main panel end here-->
</div>
<!--body end here-->



