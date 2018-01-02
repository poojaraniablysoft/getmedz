<?php
class PagejsandcssController{
	
	function js(){
		header('Content-Type: text/javascript');
		$arr_pth = func_get_args();
		$flname = $arr_pth[count($arr_pth)-1];
		unset($arr_pth[count($arr_pth)-1]);
		$fl = CONF_THEME_PATH . implode('/', $arr_pth) . '/page-js/' . $flname . '.js'; 
		if (file_exists($fl)) readfile($fl);
		exit;
	}
	
	function css(){
		header('Content-Type: text/css');
		$arr_pth = func_get_args();
		$flname = $arr_pth[count($arr_pth)-1];
		unset($arr_pth[count($arr_pth)-1]);
		$fl = CONF_THEME_PATH . implode('/', $arr_pth) . '/page-css/' . $flname . '.css';
		if (file_exists($fl)) readfile($fl);
		exit;
	}
}