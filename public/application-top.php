<?php
ini_set('display_errors', 1);
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' && $donotcompress !== true)) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}

require_once dirname(__FILE__) . '/includes/conf-common.php';

require_once dirname(__FILE__) . '/includes/conf.php';


session_start();


error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

define('SYSTEM_INIT', true);

$_SESSION['WYSIWYGFileManagerRequirements'] = realpath(dirname(__FILE__) . '/includes/WYSIWYGFileManagerRequirements.php');
set_include_path(get_include_path() . PATH_SEPARATOR . CONF_INSTALLATION_PATH . 'library');

//die(get_include_path());

require_once 'includes/functions.php';
require_once dirname(__FILE__) . '/includes/site-functions.php';
require_once dirname(__FILE__) . '/includes/framework-functions.php';
require_once dirname(__FILE__) . '/includes/utilities.php';


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

$arr_page_js_common = array();
$arr_page_css_common = array();
Syspage::addJs(array('js/jquery-1.8.1.min.js', 'js/frontend/modernizr-1.7.min.js', 'js/frontend/respond.min.js', 'js/frontend/jquery-latest.js','js/frontend/modaal.js', 'js/frontend/slick.js', 'js/frontend/commonfunctions.js','js/facebox.js', 'functions.js.php','js/site-functions.js', 'js/mbsmessage.js',	
'js/calendar.js', 'js/calendar-en.js', 'js/calendar-setup.js', 'form-validation.js.php','js/jquery.form.js','js/custom_messages.js',
'js/common_functions.js'), true);

Syspage::addCss(array('css/frontend/normalize.css', 'css/frontend/bootstrap-grid.css', 'css/frontend/slick.css', 'css/frontend/base.css','css/frontend/style.css','css/frontend/inner.css','css/frontend/lib.css','css/frontend/phone.css','css/frontend/tablet.css','css/frontend/modaal.css','css/facebox.css', 'css/cal-css/calendar-win2k-cold-1.css', 'css/mbs-styles.css', 'css/system_messages.css','css/listing.css','css/ionicons.css','css/custom.css'), false);
  Syspage::addCss(array(
            "css$selected_css_folder/jquery.rating.css"
        ));
        Syspage::addJs(array(
            /*   'js/jquery.jqEasyCharCounter.min.js', /* JS for character counting */
            
            'js/jquery.rating.js'
        ));
if ((strpos($_SERVER['REQUEST_URI'], '/doctor') !== false	)) {
  // Syspage::addCss(array('css/style.css')); 
    
}
$innova_settings = array('width'=>'800', 'height'=>'400', 'groups'=>' [
        ["group1", "", [ "Bold", "Italic", "Underline", ]],
        ["group2", "", ["Bullets", "Numbering"]],
		]',
		); 


$tpl_for_js_css = ''; // used to include page js and page css

$system_alerts = array();

if (CONF_DEVELOPMENT_MODE)
    $system_alerts[] = 'System is in development mode.';

$post = getPostedData();


//Cron jobs

//$cron=new Cron();

$url = $_GET['url']!=""?$_GET['url']:$_SERVER['REQUEST_URI'];

$url=str_replace(substr(CONF_WEBROOT_URL,1,strlen(CONF_WEBROOT_URL)),"",$url);
$url=ltrim($url,"/");
list($controller, $action,$record_id) = explode('/', $url);
if ($_SERVER['REQUEST_URI']!=CONF_WEBROOT_URL)
$get = getUrlData();

