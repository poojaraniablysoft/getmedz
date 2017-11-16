
<!--main panel start here-->
<div class="page">
    <div class="fixed_container">
        <div class="row">
            <div class="col-sm-12">  
                <!--main panel end here-->
                <div class="sectionbody space">
                    <ul class="breadcrumb arrow">
                        <li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>
                        <li>Email Templates Management</li>
                    </ul>
                    <span class="gap"></span>
                </div> 

                <h1>Email Templates Management</h1> 
                

                <div id="listing-div">
                    <?php
// @var $frm Form
                    echo $frm->getFormHtml();
                    ?></div>

            </div>
        </div>
    </div>  
    <!--main panel end here-->
</div>