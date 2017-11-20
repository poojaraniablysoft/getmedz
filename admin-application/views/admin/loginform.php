
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
<!--<script type="text/javascript" language="javascript" src="/public/includes/functions.js.php"></script>
<script type="text/javascript" language="javascript" src="/public/includes/form-validation.js.php"></script>  -->
</head>

<body class="enterpage">

    
<!--wrapper start here-->
<main id="wrapper">
<div class="system_message"><?php echo Message::getHtml(); ?></div>
        <div class="backlayer">
            <div class="layerLeft" style="background-image:url(<?php echo CONF_WEBROOT_URL;?>admin/images/Doctor.jpg); background-repeat:no-repeat;">
                <figure class="logo" style="color:#fff"><img alt="<?php echo CONF_WEBSITE_NAME;?>" src="<?php echo generateUrl('image', 'site_admin_logo',array(CONF_ADMIN_LOGO), CONF_WEBROOT_URL)?>"></figure>
            </div>
            <div class="layerRight" style="background-image:url(<?php echo CONF_WEBROOT_URL;?>admin/images/Doctor.jpg); background-repeat:no-repeat;">
                <figure class="logo" style="color:#fff"><img alt="<?php echo CONF_WEBSITE_NAME;?>" src="<?php echo generateUrl('image', 'site_admin_logo',array(CONF_ADMIN_LOGO), CONF_WEBROOT_URL)?>"></figure>
            </div>
        </div>
        <div class="panels">
            <div class="innerpanel">
                <div class="left">
                    <div class="formcontainer">
                        <h5>Forgot your password? </h5>
                        <h6>Enter The E-mail Address Associated With Your Account.</h6>
					
						<div id="adderror"></div>
						<?php 
							//echo Message::getHtml(); 
								echo $frm_password->getFormtag();
						?>
                            <div class="field_control fieldicon mail">
                                <label class="field_label">Email <span class="mandatory">*</span></label>
                                <div class="field_cover">
									<?php echo $frm_password->getFieldHTML('admin_email'); ?>
                                </div>
                            </div>
                            
                            <div class="field_control fieldicon secure">
                                <label class="field_label">Security Code <span class="mandatory">*</span></label>
                                <div class="field_cover">
                                   
                                   <?php echo $frm_password->getFieldHTML('security_code'); ?>
								   <?php echo $frm_password->getFieldHTML('secureimage'); ?>
                                 
                                </div>
                            </div>
                            
                            <!--<button class="circlebutton"></button>-->
                            <span class="circlebutton"><?php echo $frm_password->getExternalJS(); ?><?php echo $frm_password->getFieldHTML('btn_submit'); ?></span>
                            <!--a href="javascript:void(0)" class="circlebutton">Sign In</a-->
                            <a id="moveright" href="javascript:void(0)" class="linkright linkslide">Back to Login</a>
                        </form>    
                    </div>
                </div>
                <div class="right">
                    <div class="formcontainer">
						<?php
								
								
								echo $frm->getFormtag();
							
							?>
                        
                            <div class="field_control login fieldicon user active">
                                <label class="field_label">Username <span class="mandatory">*</span></label>
                                <div class="field_cover">
                                   <?php echo $frm->getFieldHTML('username'); ?>
                                </div>
                            </div>

                            <div class="field_control login fieldicon key active">
                                <label class="field_label">Password <span class="mandatory">*</span></label>
                                <div class="field_cover">
                                   <?php echo $frm->getFieldHTML('admin_password'); ?>
								   <?php echo $frm->getExternalJS(); ?>
                                </div>
                            </div>

                            <div class="field_control">
                                <label class="checkbox leftlabel"> <?php echo $frm->getFieldHTML('chk_remember'); ?><i class="input-helper"></i>Remember me</label>
                                <a id="moveleft" href="javascript:void(0)" class="linkright linkslide">Forgot Password?</a>
                            </div>

                           <span class="circlebutton"><?php echo $frm->getFieldHTML('btn_submit'); ?> </span>
                            <!--a href="javascript:void(0)" class="circlebutton">Sign In</a-->

                        </form>    


                    </div>
                </div>
            </div>
        </div>
        
<div class="login_message" id="div_error"></div>
 
</main>
<!--wrapper end here-->


<script language="javascript" type="text/javascript">
function submitForgotPassword(frm, v){
	v.validate();
	if (!v.isValid()) return;

var data = getFrmData(frm);
//	$.mbsmessage('Please wait...');
		//alert(generateUrl('admin','email_password_instructions')+ data);
	callAjax(generateUrl('admin','email_password_instructions'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans.status==0){
			document.getElementById('image').src = '<?php echo CONF_WEBROOT_URL ;?>securimage/securimage_show.php?sid= Math.random()';
			 $(".system_message").html(ans.msg).show();
			 hide_msg();
			$("#security_code").val('').focus();
            return;
        }
		
        if (ans.status == 0){
            $(".system_message").html(ans.msg).show();
			$("#security_code").val('').focus();
			hide_msg();
            return;
        } else if (ans.status == 1) {
			 $(".system_message").html(ans.msg).show();
			 hide_msg();
				
        }		
		
	});
	return false;
}
$(document).ready(function(){
	$(".closeMsg").click(function(){$(".system_messagea").hide();});
	  setTimeout(function(){ $(".system_message").fadeOut(500);$(".system_message").html('');},3000); 
    
    //  floatLabel(".web_form input[type='text'], .web_form input[type='password'], .web_form input[type='email'], .web_form select, .web_form textarea, .web_form input[type='file']");
    setTimeout(function(){
//  $("#admin_password").val('');

 floatLabel(".web_form input[type='text'], .web_form input[type='password'], .web_form input[type='email'], .web_form select, .web_form textarea, .web_form input[type='file']"); 
 },2000); 
     
    
});
// setTimeout(function(){floatLabel(".web_form input[type='text'], .web_form input[type='password'], .web_form input[type='email']")},500); 

</script>


</body>
</html>

