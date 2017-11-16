<?php
function getLabel($key, $namespace=''){
	
    if ($key=='') return ;
    global $lang_array;
    $key_original = $key;
    $key = strtoupper($key);
    if (isset($lang_array[$key])) return $lang_array[$key];

    $db = &Syspage::getdb();
    $val = '';
    $rs = $db->query("SELECT * FROM tbl_language_labels WHERE label_key = " . $db->quoteVariable($key) . "");
    if ($db->total_records($rs)>0 != false) {
        $row = $db->fetch($rs);
		$val = $row['label_caption_'.CONF_LANGUAGE];
    } else {
        $arr = explode('_', $key_original);
        array_shift($arr);
        //array_shift($arr);
        //$val = ucwords(strtolower(implode(' ', $arr) ) );
        $val = implode(' ', $arr);

        $db->insert_from_array('tbl_language_labels', array(
            'label_key' => $key,
            'label_caption_en' => $val,
			'label_caption_es' => $val,
            ));
    }
    return $lang_array[$key] = strip_javascript($val);
}
function strip_javascript($content='') {
	$javascript = '/<script[^>]*?>.*?<\/script>/si';
    $noscript = '';
    return preg_replace($javascript, $noscript, $content);
}
function renderHtml($content='',$stripJs=false,$decodeSpecial=true) {
	if($decodeSpecial)
    $str=html_entity_decode(htmlspecialchars_decode($content));
	else
	$str=html_entity_decode($content);
	$str=($stripJs==true)?strip_javascript($str):$str;
	return $str;
}
