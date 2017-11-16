<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo CONF_WEBSITE_NAME; ?> Forgot Password</title>
<?php 
echo Syspage::getJsCssIncludeHtml(false);
?>
<script language="javascript">
$(document).ready(function(){document.frmForgotPassword.admin_email.focus();});
</script>
<script type="text/javascript" language="javascript" src="/public/includes/functions.js.php"></script>
<script type="text/javascript" language="javascript" src="/public/includes/form-validation.js.php"></script>
</head>

<body>

	<section class="frontForms">
    	<figure class="frontLogo"><img src="<?php echo CONF_WEBROOT_URL;?>manager/images/logo.png" alt="<?php echo CONF_WEBSITE_NAME;?>" title="<?php echo CONF_WEBSITE_NAME;?>"></figure>
        <div class="whitesection">
		<?php 
			global $msg;
			echo $msg->display();
			echo $frm_password->getFormtag(); 
			$frm_password->setJsErrorDisplay('afterfield');
		?>
        	<table width="100%" border="0" class="formTable" cellpadding="0" cellspacing="0">
              <tr>
                <td><?php echo $frm_password->getFieldHTML('admin_email'); ?></td>
              </tr>
              <tr>
                <td><?php echo $frm_password->getFieldHTML('security_code'); ?></td>
              </tr>
              <tr>
                <td><?php echo $frm_password->getFieldHTML('secureimage'); ?></td>
              </tr>
              <tr>
                <td><?php echo $frm_password->getFieldHTML('btn_submit'); ?></td>
              </tr>
           </table>
           </form><?php echo $frm_password->getExternalJS(); ?>
           <p class="ptext">Go to Login Page? <a href="<?php echo generateUrl('admin', 'loginform');?>">Click here</a></p>

        </div>
    </section>
</body>
</html>