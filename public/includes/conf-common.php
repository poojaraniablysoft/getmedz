<?php
/**
 * 
 * General configurations
 */

define('CONF_DEVELOPMENT_MODE', true);
define('CONF_LIB_HALDLE_ERROR_IN_PRODUCTION', true);

define ('CONF_URL_REWRITING_ENABLED', true);
define('CONF_WEBSITE_URL','/');
if($_SERVER['SERVER_NAME']=='getmedz.4demo.biz'){
    define('CONF_WEBROOT_URL', '/');

    define('CONF_DB_SERVER', 'localhost');
    define('CONF_DB_USER', 'developer');
    define('CONF_DB_PASS', 'developer');
    define('CONF_DB_NAME', 'dev_get_medz');
}
else{
    define('CONF_WEBROOT_URL', '/');
    define('CONF_DB_SERVER', 'localhost');
    define('CONF_DB_USER', 'developer');
    define('CONF_DB_PASS', 'developer');
    define('CONF_DB_NAME', '');
}

define('PASSWORD_SALT', 'ewoiruqojfklajreajflajoer');
//define('CONF_HTML_EDITOR', 'tinymce');
define('CONF_HTML_EDITOR', 'innova');
define('CONF_CKEDITOR_PATH', CONF_WEBROOT_URL.'js/LiveEditor');
$nav_page_type=array(0=>'CMS Page',1=>'Custom HTML', 2=>'External Page');