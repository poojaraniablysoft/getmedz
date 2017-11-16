<?php
if (!SYSTEM_INIT)
    die('Invalid Access'); // avoid direct access.
?>
<!--script type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>js/LiveEditor/scripts/innovaeditor.js"></script>
<script src="<?php echo CONF_WEBROOT_URL; ?>js/LiveEditor/scripts/common/webfont.js" type="text/javascript"></script-->

<!--main panel start here-->
<div class="page">
 <?php echo html_entity_decode($breadcrumb); ?>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  


                <div id="form-div"></div>

                <div id="listing-div"></div>

            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->

