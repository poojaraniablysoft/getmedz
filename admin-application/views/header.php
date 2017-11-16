<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>
<!Doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
        <?php
        writeMetaTags();
        echo Syspage::getJsCssIncludeHtml(false);
		 
        ?>
<script>var CONF_AUTO_CLOSE_SYSTEM_MESSAGES = true; var CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES =6000;</script>
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
	<script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
	<script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>

    </head>

    <body>
        
		<?php $haveMsg = false; 
		$alertClass='';
	if( Message::getMessageCount() || Message::getErrorCount() ){
		$alertClass= 'alert--success';
		$haveMsg = true;
	}
	if( Message::getErrorCount()){
		$alertClass= 'alert--danger';
	}
	
	?>
<div  class="alert alert--positioned-bottom alert--positioned <?php echo $alertClass;?>" <?php if($haveMsg) echo 'style="display:block"';?>>
			<div class="close"></div>
			<div class="sysmsgcontent content ">
				<?php 
				
				if( $haveMsg ){ 
					
					echo html_entity_decode( Message::getHtml() );
				} ?>
			</div>
		</div>


        <!--wrapper start here-->
        <main id="wrapper">



            <!--header start here-->
            <header id="header">
                <div class="headerwrap">
                    <div class="one_third_grid"><a href="javascript:void(0);" class="menutrigger"></a></div>
                    <div class="one_third_grid logo"><a style="color:#fff" href="<?php echo generateUrl(); ?>"><img src="/images/logo.png" alt="<?php echo CONF_WEBSITE_NAME; ?>"></a></div>
                    <div class="one_third_grid">
                        <a href="<?php echo generateUrl('admin', 'logout'); ?>" title="Logout" class="logout"></a>
                    </div>
                </div>  


            </header>    
            <!--header end here-->
            <!--body start here-->
            <div id="body">


                <?php include getViewsPath() . 'left-menu.php'; ?>  


                <?php include getViewsPath() . 'right-menu.php'; ?>  
