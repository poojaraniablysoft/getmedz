<?php
/**
 * General Front End Configurations
 */

define('CONF_INSTALLATION_PATH', $_SERVER['DOCUMENT_ROOT'] . CONF_WEBROOT_URL);

define('CONF_APPLICATION_PATH', CONF_INSTALLATION_PATH . 'application/');
if (CONF_URL_REWRITING_ENABLED){
    define('CONF_USER_ROOT_URL', CONF_WEBROOT_URL);
}
else {
    define('CONF_USER_ROOT_URL', CONF_WEBROOT_URL . 'public/');
}

define('CONF_THEME_PATH', CONF_APPLICATION_PATH . 'views/');

define('CONF_DATE_FIELD_TRIGGER_IMG', CONF_WEBROOT_URL . 'images/iocn_clender.gif');

$_SESSION['WYSIWYGFileManagerRequirements'] = realpath(dirname(__FILE__) . '/WYSIWYGFileManagerRequirements.php');


define('CONF_MESSAGE_ERROR_HEADING','');
define('PAGESIZE',1);
define('YEAR_FROM',2014);

 $innova_settings = array('width'=>'800', 'height'=>'400', 'groups'=>' [
        ["group1", "", ["FontName", "FontSize", "Superscript", "ForeColor", "BackColor", "FontDialog", "BRK", "Bold", "Italic", "Underline", "Strikethrough", "TextDialog", "Styles", "RemoveFormat"]],
        ["group2", "", ["JustifyLeft", "JustifyCenter", "JustifyRight", "Paragraph", "BRK", "Bullets", "Numbering", "Indent", "Outdent"]],
        ["group3", "", ["TableDialog", "Emoticons", "FlashDialog", "BRK", "LinkDialog", "YoutubeDialog"]],
        ["group4", "", ["CharsDialog", "Line", "BRK", "ImageDialog", "CustomTag", "MyCustomButton"]],
        ["group5", "", ["SearchDialog", "SourceDialog", "BRK", "Undo", "Redo"]]]',
		'fileBrowser'=> '"'.CONF_WEBROOT_URL.'js/LiveEditor/assetmanager/asset.php"'); 
 

?>