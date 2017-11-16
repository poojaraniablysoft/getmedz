<?php

function getViewsPath() {
    return CONF_APPLICATION_PATH . 'views/';
}

function getViewsSidebarPath() {
    return CONF_APPLICATION_PATH . 'views/_sidebar/';
}

function getViewsPartialPath() {
    return CONF_APPLICATION_PATH . 'views/_partial/';
}

function renderView($fname, $vars=array(), $return=true) {
	
    ob_start();
    extract($vars);
	
    include $fname;
	
    $contents = ob_get_clean();
	
    if ($return==true) {
        return $contents;
    } else {
        echo $contents;
    }
}
