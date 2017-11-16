<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.

/* @var $frmConf Form */

echo '';
?>

<!--main panel start here-->
<div class="page">

	<ul class="breadcrumb arrow">
		<li><a href="<?php echo generateUrl(''); ?>"><img src="<?php echo CONF_WEBROOT_URL; ?>admin/images/home.png" alt=""> </a></li>
		<li> Settings </li>
	
	</ul>
    <div class="fixed_container">
        <div class="row">



            <div class="col-sm-12">  


          
                <?php echo Message::getHtml();
                ?>
                <div id="form-div"></div>

               
				<section class="section">
					<div class="sectionhead"><h4>Home Page Settings </h4></div>

					<div class="sectionbody space"><?php 
								echo $frm->getFormHtml();
								?></div>
				</section>
            </div>
        </div>
    </div>  

    <!--main panel end here-->
</div>
<!--body end here-->
