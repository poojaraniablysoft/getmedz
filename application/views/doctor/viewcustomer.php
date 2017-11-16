<div class="page">
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">


                <!--main panel end here-->
                <div class="sectionbody space">


                    <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl(); ?>">Home</a></li>
                        <li><a href="<?php echo generateUrl('customers'); ?>">Customers</a></li>
                        <li>Customer[<?php echo $user_data['name']?>]</li>

                    </ul>
                    <span class="gap"></span>
                </div>

                <section class="section">
                    <div class="sectionbody">                     
                        <div class="row">
                            <div class="col-md-10 col-xs-8">
                                <table class="table table-responsive ">
                                    <tbody><tr><th colspan="2">Customer profile</th></tr>
                                        <tr><td><strong>Name: </strong><?php echo $user_data['name']; ?></td>

                                        <tr><td><strong>Gender:</strong><?php echo Applicationconstants::$arr_gender[$user_data['user_gender']]; ?></td>

                                        <tr><td><strong>Member Since:</strong><?php echo displayDate($user_data['user_added_on']); ?></td><td></td></tr>
                                    </tbody></table>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <div class="avtararea padd_all">
                                    <figure class="pic">
                                        <form>
                                            <img src=" <?php echo generateUrl('image', 'getCustomerProfilePic', array(intval($user_data['user_id']), 500, 500), "/") ?>" alt="">

                                        </form>     
                                    </figure>
                                    <div class="picinfo">
                                        <span class="name"><?php echo $user_data['name']; ?></span>
                                        <span class="mailinfo"><?php echo $user_data['user_email']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section">
                    <div class="sectionhead"><h4>Customer Questions</h4></div>
                    <div class="sectionbody">
                        <table id="response_table" class="table table-responsive ">
                            <thead>
                                <tr>
                                    <th>Date </th>
                                    <th>Order ID</th>
                                    <th>Question</th>                                 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                if(count($questions)>0):
                                    foreach ($questions as $question): ?>

                                        <tr>

                                            <td><?php echo displayDate($question['order_date'])?></td>
                                            <td><?php echo $question['orquestion_order_id']?></td>
                                            <td><?php echo $question['orquestion_question']?></td>
                                            <td><a href="<?php echo generateUrl('doctor','generateChat',array($user_data['user_id'],$question['orquestion_id'])) ?>" title="Download Chat"> Pdf</a></td>


                                        </tr>
                                    <?php endforeach; 
                                else:
                                ?>
                                        <tr>

                                            <td>No Questions</td>
                                            


                                        </tr>
                                        
                                <?php endif;?>
                            </tbody>
                        </table>

                    </div>
                </section>

            </div>
        </div>

    </div>

    <!--main panel end here-->
</div>