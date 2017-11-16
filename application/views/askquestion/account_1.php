<div class="cont-wrapper inner-main">

    <div class="centered">

        <div class="bot-table-area">
            <div class="row">
                <div class="cell1" style="border-right: 1px solid #eee">
                    
                    <span><center><h3>Select a Payment Mode.</h3></center></span>
                    <?php echo $checkOutBtnFrm->getFormTag(); ?>
                    
                    <?php foreach(Subscription::getactiveSubscription()->fetch_all() as $key=>$value):?>
                    <label class="radio">
                        <input type="radio" checked name="payment_plan" value=<?php echo $value['subs_id'] ?>><i class="input-helper"></i>
                        <?php echo $value['subs_name']."@".$value['subs_price'] ?>
                    </label>
                      <br> <br> <br>
                    <?php endforeach;?>
                 
                    <?php echo $checkOutBtnFrm->getFormHTML('getCheckoutBtnForm'); ?>
                    </form>
                </div>




                <div class="cell1">
                    <span><center><h3>Already Have an account! Please Login.</h3></center></span>
                    <?php echo $checkOutLoginFrm->getFormTag(); ?>
                    <?php echo $checkOutLoginFrm->getFormHTML('checkOutLoginFrm'); ?>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>