<!Doctype html>
<html>
<head>
<!-- Basic Page Needs ================================================== -->
<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo CONF_WEBSITE_NAME; ?> Login</title>

<!-- Mobile Specific Metas ================================================== -->
<meta name=viewport content="width=device-width, initial-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      
 

<!-- favicon ================================================== -->
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->      
    
<!-- JS ================================================== -->



 <?php 
echo Syspage::getJsCssIncludeHtml(false);
?>
<script language="javascript">
$(document).ready(function(){document.frmLogin.username.focus();});
</script>
<script type="text/javascript" language="javascript" src="/public/includes/functions.js.php"></script>
<script type="text/javascript" language="javascript" src="/public/includes/form-validation.js.php"></script>  
</head>

<body class="enterpage">

    
<!--wrapper start here-->
<main id="wrapper">

        <div class="backlayer">
            <div class="layerLeft" style="background-image:url(<?php echo CONF_WEBROOT_URL;?>admin/images/dealsbg.jpg); background-repeat:no-repeat;">
                <figure class="logo"><img src="<?php echo CONF_WEBROOT_URL;?>admin/images/login_screen_logo.png" alt="<?php echo CONF_WEBSITE_NAME;?>" title="<?php echo CONF_WEBSITE_NAME;?>"></figure>
            </div>
            <div class="layerRight" style="background-image:url(<?php echo CONF_WEBROOT_URL;?>admin/images/dealsbg.jpg); background-repeat:no-repeat;">
                <figure class="logo"><img src="<?php echo CONF_WEBROOT_URL;?>admin/images/company_logo.png" alt="<?php echo CONF_WEBSITE_NAME;?>" title="<?php echo CONF_WEBSITE_NAME;?>"></figure>
            </div>
        </div>
        <div class="panels">
            <div class="innerpanel">
                <div class="left">
                   
                </div>
                <div class="right">
                    <div class="formcontainer">
							<?php 
						 echo Message::getHtml(); 
								echo $frm_password->getFormtag();
						?>
                            <div class="field_control fieldicon mail">
                                <label class="field_label">New Password <span class="mandatory">*</span></label>
                                <div class="field_cover">
									<?php echo $frm_password->getFieldHTML('admin_password'); ?>
                                </div>
                            </div>
                            
                            <div class="field_control fieldicon secure">
                                <label class="field_label">Confirm password <span class="mandatory">*</span></label>
                                <div class="field_cover">
                                   
                                   <?php echo $frm_password->getFieldHTML('tocken'); ?>
                                   <?php echo $frm_password->getFieldHTML('admin_password1'); ?>
								  
                                 
                                </div>
                            </div>
                            
                            <!--<button class="circlebutton"></button>-->
                            <span class="circlebutton"><?php echo $frm_password->getExternalJS(); ?><?php echo $frm_password->getFieldHTML('btn_submit'); ?></span>
                            <!--a href="javascript:void(0)" class="circlebutton">Sign In</a-->
                            <a id="moveright" href="javascript:void(0)" class="linkright linkslide">Back to Login</a>

                        </form>    


                    </div>
                </div>
            </div>
        </div>
        

 
</main>
<!--wrapper end here-->


<script language="javascript" type="text/javascript">
function submitForgotPassword(frm, v){
	v.validate();
	if (!v.isValid()) return;

var data = getFrmData(frm);
//	$.mbsmessage('Please wait...');
	//	alert(data);
	callAjax(generateUrl('admin','email_password_instructions'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans === false){
            alert(ans.msg);
            return;
        }
		
        if (ans.status == 0){
            alert(ans.msg);
            return;
        } else if (ans.status == 1) {
			$.mbsmessage( ans.msg );
			$(el).remove();			
        }		
		
	});
	return false;
}
</script>

</body>
</html>
