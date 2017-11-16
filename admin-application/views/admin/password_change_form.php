<div class="tblheading">Change Password</div>
<ul class="breadCrumb">
   <li><a href="<?php echo generateUrl(''); ?>"><img src="/images/home.png" alt=""></a></li>
   <li><a href="javascript:void(0);">Change Password</a></li>
</ul>


<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.

/* @var $frmPassword Form */
 
?>

<div id="form-div"><?php global $msg; echo $msg->display();?></div>

<div class="form"><?php echo $frmPassword->getFormHtml(); ?></div>