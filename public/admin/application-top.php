<?php
	
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' && $donotcompress !== true)) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}

require_once dirname(dirname(__FILE__)) . '/includes/conf-common.php';

require_once dirname(__FILE__) . '/includes/conf.php';

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

define('SYSTEM_INIT', true);

$_SESSION['WYSIWYGFileManagerRequirements'] = realpath(dirname(__FILE__) . '/../includes/WYSIWYGFileManagerRequirements.php');

set_include_path(get_include_path() . PATH_SEPARATOR . CONF_INSTALLATION_PATH . 'library');

require_once 'includes/functions.php';
require_once dirname(dirname(__FILE__)) . '/includes/site-functions.php';
require_once dirname(dirname(__FILE__)) . '/includes/framework-functions.php';
require_once dirname(dirname(__FILE__)) . '/includes/breadcrumbs.php';
require_once dirname(dirname(__FILE__)) . '/includes/utilities.php';

$db_config = array(
    'server' => CONF_DB_SERVER,
    'user' => CONF_DB_USER,
    'pass' => CONF_DB_PASS,
    'db' => CONF_DB_NAME);
$db = new Database(CONF_DB_SERVER, CONF_DB_USER, CONF_DB_PASS, CONF_DB_NAME);

/* define configuration variables */
$rs = $db->query("select * from tbl_configurations");
while ($row = $db->fetch($rs)) {
    define(strtoupper($row['conf_name']), $row['conf_val']);
}
/* end configuration variables */

$arr_page_js = array();
$arr_page_css = array();

$arr_page_js_common = array(
);
$arr_page_css_common = array();



$tpl_for_js_css = ''; // used to include page js and page css


$admin = new Admin();
Syspage::addJs(array('js/jquery-latest.js',
    'form-validation.js',
    '../js/custom_messages.js',
    '../js/common_functions.js',
    'form-validation.js.php',
    //'../tinymce-lnk/jscripts/tiny_mce/jquery.tinymce.js',
    'functions.js.php',
    '../js/mbsmessage.js',
    '../js/jquery.selectbox-0.2.js',
    '../js/jquery.form.js',
    '../js/site-functions.js',
    '../js/facebox.js',
    '../js/calendar.js',
    '../js/calendar-en.js',
    '../js/calendar-setup.js',
    
	'/js/jquery-ui.js'), true);
if (!$admin->isLogged()) {
    Syspage::addJs(array('js/login_functions.js'), true);
}

Syspage::addCss(
        array(
    /* '../css/mbs-styles.css',
    '../css/mbsmessage.css', */
    //	'css/login.css',
    '../css/ionicons.css',
    'css/style.css',
    '../css/admin.css',
    '../css/jquery.selectbox.css', '../css/facebox.css', '../css/cal-css/calendar-win2k-cold-1.css','css/system_messages.css'
        ), true);

$system_alerts = array();
;
$innova_settings = array('width'=>'1000', 'height'=>'400', 'groups'=>' [
        ["group1", "", [ "Bold", "Italic", "Underline", "Strikethrough", "TextDialog", "Styles", "RemoveFormat"]],
        ["group2", "", ["JustifyLeft", "JustifyCenter", "JustifyRight", "Bullets", "Numbering"]],
        ["group3", "", [ "BRK", "LinkDialog", "ImageDialog","TableDialog", "Undo", "Redo" ,"SourceDialog"]],        
		]',
		'fileBrowser'=> '"'.CONF_WEBROOT_URL.'js/LiveEditor/assetmanager/asset.php"');  
if (CONF_DEVELOPMENT_MODE)
    $system_alerts[] = 'System is in development mode.';

$post = getPostedData();
$url = $_GET['url'];

list($controller, $action) = explode('/', $url);

if (!$admin->isLogged()) {

    $actions_not_required_login = array(
        'admin' => array(
            'loginform',
            'login',
            'forgot_password',
            'email_password_instructions',
            'reset_password',
            'password_reset',
        ),
        'jscss' => array(
            'js',
            'css'
    ));
    if (!in_array($action, $actions_not_required_login[$controller])) {
        if (isAjaxRequest()) {
            dieJsonError('Your Session seems to have expired. Please try refreshing the page to login again.');
        }
        redirectUser(generateUrl('admin', 'loginform'));
    }
}