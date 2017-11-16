<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>

<!-- Basic Page Needs
  ================================================== -->
<meta charset="utf-8">

<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php
	writeMetaTags();
	echo Syspage::getJsCssIncludeHtml(false);
?>

<!-- Typography
  ================================================== -->
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">

<!-- Favicons	================================================== -->
<link rel="shortcut icon" href="<?php echo CONF_WEBROOT_URL; ?>images/dynamic/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo CONF_WEBROOT_URL; ?>images/dynamic/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo CONF_WEBROOT_URL; ?>images/dynamic/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo CONF_WEBROOT_URL; ?>images/dynamic/apple-touch-icon-114x114.png">

</head>

<body>
<!--Header-->
<header id="Header" class="site-header js-site-header">
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
  <div class="container container--fixed"> <a title="Menu" class="toggleMenu js-toggleMenu hide-on-desktop" href="javascript:void(0);"><span></span><span></span><span></span></a>
    <div class="h_brand-main">
      <div class="h_brand fl--left"> <a href="<?php echo generateUrl(''); ?>" class="h_logo"><img src="<?php echo generateUrl('image','site_logo'); ?>" alt=""></a> </div>
      <span class="leftoverlay"></span>
	  
	  <?php
                    if (Members::isUserLogged() || $session_arr['logged_user']['user_id']>0) {
						if($session_arr['logged_user']['user_id']>0){
							$_SESSION=$session_arr;
						}
                        if (Members::isCustomerLogged())
                            include getViewsPath() . 'common/customer/top_bar.php';
						if (Members::isDoctorLogged())							
                            include getViewsPath() . 'common/doctor/top_bar.php';                        
                    } ?>
      <div class="h__navigation fl--right">
        <div class="h_navigationHeading"><?php echo getLabel('L_Menu');?></div>
        <nav class="menu main-menu small--menu js-main-menu">
          <ul class="list list--horizontal">
		  
		  <?php foreach($top_header_mobile_navigation as $link):?>
				<?php if($link['nl_type']==0): ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo generateUrl('cms', 'view', array($link['nl_cms_page_id'])); ?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php elseif($link['nl_type']==1): ?>
				<li><?php echo $link['nl_caption']; ?></li>
				<?php elseif($link['nl_type']==2): $url=str_replace('{SITEROOT}', CONF_WEBROOT_URL, $link['nl_html']); ?>
				<li><a target="<?php echo $link['nl_target']?>" href="<?php echo $url?>"><?php echo $link['nl_caption']; ?></a></li>
				<?php endif; ?>
			<?php endforeach;?>            
			<?php if (!Members::isUserLogged()) {						
                        ?>
				
				<li><a href="<?php echo generateUrl('members', 'login'); ?>" class="button button--fill button--blue">Login</a></li>
				
				
			<?php } ?>
            
          </ul>
          <a class="link__close toggle--close-js" href="javascript:void(0)"></a> </nav>
      </div>
    </div>
  </div>
</header>
<!--Banner-->



