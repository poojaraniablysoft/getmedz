<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        writeMetaTags();
        echo Syspage::getJsCssIncludeHtml(false);
        ?>

        <style>
            .active {
                color:green !important;
            }
            .inactive {
                color:gray !important;
            }
            .ion-android-delete{

                color:red !important;
            }
            .ion-edit{
                color:black !important;
            }
        </style>


    </head>

    <body>
        <?php echo Message::getHtml(); ?>
        <div id="msg_info"></div>
        <div class="wrapper">
            <div class="header-wrapper">
                <div class="centered">
                    <div class="logo"><a href="<?php echo generateUrl(); ?>"><img alt="" src="<?php echo CONF_WEBROOT_URL ?>images/logo.png"></a></div>
                    <div class="top-right">
                        <ul class="nav">
                            <li><a href="<?php echo generateUrl('customer'); ?>">My Questions</a></li>
                            <li><a href="<?php echo generateUrl(); ?>">Ask a New Quesiton</a></li>
                            <li><a href="<?php echo generateUrl('customer','profile'); ?>">User Profile</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="<?php echo generateUrl('members', 'logout'); ?>">Log Out</a></li>
                        </ul>
                        <div class="welcome">Welcome Back, <span><?php echo $customerName ?></span> </div>
                    </div>

                </div>

            </div>


            <?php //include getViewsPath() . 'common/customer/left-menu.php'; ?>  

            <!--right panel start here-->

            <!--right panel end here-->

            <?php //include getViewsPath() . 'common/customer/right-menu.php'; ?>  
