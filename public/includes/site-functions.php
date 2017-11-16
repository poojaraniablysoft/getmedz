<?php

/* function getViewsPath() {
    return CONF_THEME_PATH;
} */

function dieWithError($err) {
    global $post;
    if ($post['outmode'] == 'json')
        dieJsonError($err);
    die($err);
}

function dieWithSuccess($err) {
    global $post;
    if ($post['outmode'] == 'json')
        dieJsonSuccess($err);
    die($err);
}

function redirectUser($url = '') {
    if ($url == '')
        $url = $_SERVER['REQUEST_URI'];
    header("Location: " . $url, true, 301);
    exit;
}

function generateAbsoluteUrl($model = '', $action = '', $queryData = array(), $use_root_url = '', $url_rewriting = null) {
    return getUrlScheme() . generateUrl($model, $action, $queryData, $use_root_url, $url_rewriting);
}

function getUrlScheme() {
    $pageURL = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"];
    }
		
    return $pageURL;
}

function generateUrl($model = '', $action = '', $queryData = array(), $use_root_url = '', $url_rewriting = null) {
    if ($url_rewriting === null)
        $url_rewriting = CONF_URL_REWRITING_ENABLED;

    if ($use_root_url == '')
        $use_root_url = CONF_USER_ROOT_URL;

    foreach ($queryData as $key => $val)
        $queryData[$key] = rawurlencode($val);

    if ($url_rewriting) {
        $url = rtrim($use_root_url . strtolower($model) . '/' . strtolower($action) . '/' . implode('/', $queryData), '/ ');
        if ($url == '')
            $url = '/';
        return $url;
    }
    else {
        $url = rtrim($use_root_url . 'index.php?url=' . strtolower($model) . '/' . strtolower($action) . '/' . implode('/', $queryData), '/');
        return $url;
    }
}

function writeMetaTags() {
    echo '<title>' . CONF_WEBSITE_NAME . '</title>' . "\n";
}

function encryptPassword($pass) {
    return md5(PASSWORD_SALT . $pass . PASSWORD_SALT);
}

function getRandomPassword($n) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = '';
    for ($i = 0; $i < $n; $i++) {
        $pass .= substr($chars, rand(0, strlen($chars) - 1), 1);
    }
    return $pass;
}

/**
 * 
 * Saves an image
 * @param String $fl full path of the file
 * @param String $name name of file
 * @param String $response In case of success exact name of file will be returned in this else error message
 * @return Boolean
 */
function saveImage($fl, $name, &$response,$pathSuffix='') {
	
	$pathSuffix=getCurrUploadDirPath($pathSuffix);
	
			$dir = CONF_INSTALLATION_PATH . 'user-uploads/' . $pathSuffix;
			if(!is_writable($dir)){
				
				$response = "Directory $dir is not writable, or does not exist. Please check";
				return false;
			}
	$ext = pathinfo($name, PATHINFO_EXTENSION);	
	if($ext != 'svg')
	{
		$size = getimagesize($fl);
		
		if ($size === false) {
			$response = 'Image format not recognized. Please try with jpg, jpeg, gif or png file.';
			return false;
		}
	} 	
	
     $fname = preg_replace('/[^a-zA-Z0-9]/', '', $name);
	
    while (file_exists($dir  . $fname)) {
        $rand =  rand(10, 99).'_';
		$fname = $rand.$fname;
    } 
	//$fname = $name;

    if (!copy($fl, $dir  . $fname)) {
        $response = 'Could not save file.';
        return false;
    }

    $response = $fname;
	
    return true;
}

function isAjaxRequest() {
    $post = Syspage::getPostedVar();
    if (isset($post['is_ajax_request']) && strtolower($post['is_ajax_request']) == 'yes') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }
    return false;
}

// $to -> mail send to, $tpl -> tpl id, $vars -> replacement variables
function sendMail($to, $subject, $body, $extra_headers = '') {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From: ' . CONF_EMAILS_FROM . "\r\n";

    //Replace Common email vars

    $body = common_email_vars($body);


    if ($extra_headers != '')
        $headers .= $extra_headers;

    mail($to, $subject, $body, $headers);
    return true;
}

function common_email_vars($body) {

    $vars = array(
        '{website_name}' => CONF_WEBSITE_NAME,
        '{website_url}' => generateAbsoluteUrl()
    );

    return str_replace(array_keys($vars), array_values($vars), $body);
}

function generateBackendPagingStringHtml($pagesize, $total_records, $page, $pages, $function, $link) {
    $pagestring = '';
    $link = ($link == '') ? "javascript:void(0);" : $link;
    if ($pages > 1) {
        $pagestring .= '<div class="pagination"><ul><li><a href="javascript:void(0);">DISPLAYING RECORD ' . (($page - 1) * $pagesize + 1) .
                ' TO ' . (($page * $pagesize > $total_records) ? $total_records : ($page * $pagesize)) . ' OF ' . $total_records . '</a></li>';
        $pagestring .= getPageString('<li><a href="' . $link . '" onclick="' . $function . '">xxpagexx</a></li>'
                , $pages, $page, '<li class="selected"><a class="active" href="javascript:void(0);">xxpagexx</a></li>');
        $pagestring .= '</div>';
    }
    return $pagestring;
}

function printR($data) {

    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function verifyCaptcha($fld_name = 'security_code') {
    include_once(CONF_INSTALLATION_PATH . 'public/securimage/securimage.php');
    $post = Syspage::getPostedVar();
    $img = new Securimage();
    return $img->check($post[$fld_name]);
}

function getYearList() {

    $array = range(Applicationconstants::$year_range_start, Date('Y'));
    return array_combine($array, $array);
}

function getCardYearList() {

    return array_combine(range(Date('Y'), Date('Y') + Applicationconstants::$car_range_years), range(Date('Y'), Date('Y') + Applicationconstants::$car_range_years));
}

function captchaImgUrl() {
    return CONF_WEBROOT_URL . 'securimage/securimage_show.php';
}


function uploadContributionFile($file_tmp_name, $filename, &$response, $pathSuffix = '') {

    $finfo = finfo_open(FILEINFO_MIME_TYPE); /* will return mime type */
    $file_mime_type = finfo_file($finfo, $file_tmp_name);
    /* $accepted_files = array(
      'application/pdf',
      'application/octet-stream',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'application/msword',
      'text/plain',
      'application/zip',
      'application/x-rar'
      );

      if(!in_array(trim($file_mime_type), $accepted_files)){
      $response = "Upload  only pdf, doc, docx, txt, zip or rar files.";
      return false;
      } */

    $fname = preg_replace('/[^a-zA-Z0-9]/', '', $filename);
    while (file_exists(CONF_INSTALLATION_PATH . 'user-uploads/' . $pathSuffix . $fname)) {
        $fname .= '_' . rand(10, 999999);
    }

    if (!copy($file_tmp_name, CONF_INSTALLATION_PATH . 'user-uploads/' . $pathSuffix . $fname)) {
        $response = 'Could not save file.';
        return false;
    }
    $response = $pathSuffix . $fname;
    return true;
}

/* function renderView($file_path, $data = array(), $return = false) {

    ob_start();
    include $file_path;
    $contents = ob_get_clean();
    if ($return == true) {
        return $contents;
    } else {
        echo $contents;
    }
} */

function create_pdf($file, $content) {

    require_once CONF_INSTALLATION_PATH . 'public/dompdf/dompdf_config.inc.php';

    $dompdf = new DOMPDF();

    $html = $content;

    $dompdf->load_html($html);
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    $w = $canvas->get_width();
    $h = $canvas->get_height();
    //For Footer
    $footer = $canvas->open_object();
    $size = 8;
    $font = Font_Metrics::get_font("Arial", "bold");
    $date = date("Y-m-d H:i:s");
    $width = Font_Metrics::get_text_width(CONF_PDF_FOOTER_TEXT_LINE_1, $font, $size);
    $canvas->page_text($w / 2 - $width / 2, $h - 40, CONF_PDF_FOOTER_TEXT_LINE_1, $font, 8, array(.255, .255, .255));
    $width = Font_Metrics::get_text_width(CONF_PDF_FOOTER_TEXT_LINE_2, $font, $size);
    $canvas->page_text($w / 2 - $width / 2, $h - 30, CONF_PDF_FOOTER_TEXT_LINE_2, $font, 8, array(.255, .255, .255));
    $width = Font_Metrics::get_text_width(CONF_PDF_FOOTER_TEXT_LINE_3, $font, $size);
    $canvas->page_text($w / 2 - $width / 2, $h - 20, CONF_PDF_FOOTER_TEXT_LINE_3, $font, 8, array(.255, .255, .255));
    $canvas->close_object();
    $canvas->add_object($footer, "all");

    return $dompdf->stream($file);
}
function page_404(){
    
    redirectUser(generateAbsoluteUrl('site','notfound'));
    
}
function createStarRating($name, $default = 0) {
    $star_div = new HtmlElement('div');

    $name = $name;
    for ($i = 1; $i <= 5; $i++) {
        $stars = $star_div->appendElement('input', array('name' => $name, 'type' => 'radio', 'value' => $i, 'class' => 'star '));
        if ($i == $default)
            $stars->setAttribute('checked', 'checked');
        // $stars->setAttribute('disabled', 'disabled');
    }

    return $star_div->getHtml();
}

function createStar($name, $default = 0) {
    $star_div = new HtmlElement('div');

    $name = $name;
    for ($i = 1; $i <= 5; $i++) {
        $stars = $star_div->appendElement('input', array('name' => $name, 'type' => 'radio', 'value' => $i, 'class' => 'star '));
        if ($i == $default)
            $stars->setAttribute('checked', 'checked');
        $stars->setAttribute('disabled', 'disabled');
    }

    return $star_div->getHtml();
}

function generateCsv($headers = array(), $dataArray = array(), $delimiter = ',', $enclosure = '"') {
    if (count($dataArray) == 0) {
        return null;
    }
    ob_start();

    $df = fopen("php://output", 'w');

    fputcsv($df, array_keys($headers), $delimiter, $enclosure);
    foreach ($dataArray as $row) {

        $trimedArray = array_intersect_key($row, array_flip($headers));

        //$orderedArray = array_merge(array_flip($headers) + $trimedArray);
        
      
        fputcsv($df, $trimedArray, $delimiter, $enclosure);
    }
    fclose($df);
    return ob_get_clean();
}

function download_send_headers($filename) {

    //remove Spaces

    $filename = str_replace(" ", "_", $filename);

    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

function render_block($block_name) {

    $block = Block::getactiveBlockByName($block_name);


    $data = $block->fetch();
    return  $data['block_content'];
}

function redirectUserWithData($url, $data) {

    $ch = curl_init();
    $username = $password = "test";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $result = curl_exec($ch);
    curl_close($ch);
}

function getYtubeId($url) {
    $matches = array();
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);

    return $matches[0];
}

function renderYoutubeUrl($url, $autoplay = false) {
    $url = "http://www.youtube.com/embed/" . getYtubeId(CONF_HOMEPAGE_YOUTUBE_LINK) . "?autoplay=" . intval($autoplay);
    return $url;
}

/*
 * 
 * Replacement parms %Pagetitte% %PageLink%
 */

function renderMenu($itemHtml, $menuType) {

    if (intval($menuType) < 0) {
        return false;
    }

    $cmsPages = Cms::getactiveCms();
    $cmsPages->addCondition('cmsc_type', '=', $menuType);
	//echo $cmsPages->getQuery();
    $menu = "";
    foreach ($cmsPages->fetch_all() as $value) {
        $link = generateUrl('page', $value['cmsc_slug']);
        $params = array('%LINK%' => $link, '%PAGE_TITLE%' => $value['cmsc_title']);
        $menu.= str_replace(array_keys($params), array_values($params), $itemHtml);
    }

    return $menu;
}

 function isUploadedFileValidImage($files) {

	$valid_mime_types = preg_replace('~\r?\n~', "\n", CONF_IMAGE_MIME_ALLOWED);
	$valid_arr = explode("\n", $valid_mime_types);
	
	return (isset($files['name'])
	&& $files['error']==0
	&& in_array($files['type'], $valid_arr)
	&& $files['size']>0);
}
function getCurrUploadDirPath($pathSuffix=''){ 
			
			if(trim($pathSuffix)!=''){
				$pathSuffix=rtrim($pathSuffix,'/').'/';
			}
			$uploadPath=getFilepathOnDirectory().$pathSuffix;
			
			// get current directory use to upload file
			$confPathSuffix=CONF_CURR_PROD_UPLOAD_DIR; 
			$confPathSuffix=(trim($confPathSuffix)!='')?$confPathSuffix.'/':'';
			$currUploadPath=$uploadPath.$confPathSuffix;
			
			// Create Directory if not exist
			if (!file_exists($currUploadPath)){ 
				mkdir($currUploadPath, 0777, true);
			}
			
			try{
				$fi = new FilesystemIterator($currUploadPath, FilesystemIterator::SKIP_DOTS);			
				$fileCount= iterator_count($fi); 			
				if(isset($fileCount) && $fileCount>=CONF_UPLOAD_MAX_FILE_COUNT){
					$dest=CONF_CURR_PROD_UPLOAD_DIR+1;
					// Create Directory if not exist	
					if (!file_exists($currUploadPath.$dest)){ 
						mkdir($currUploadPath.$dest, 0777, true);
					}
					$arr=array('CONF_CURR_PROD_UPLOAD_DIR'=>$dest);	
					if($settingsObj->update($arr)){
						$currUploadPath=$uploadPath.CONF_CURR_PROD_UPLOAD_DIR.'/';
					}				
				}
			}catch(exception $e){	}
			
			$currUploadPath=CONF_CURR_PROD_UPLOAD_DIR;
			$currUploadPath=(trim($currUploadPath)!='')?$currUploadPath.'/':'';
			return $pathSuffix.$currUploadPath;
		}
		
function getUploadedFilePath($fname){
	if(trim($fname)=='') return;
	$currUploadPath=CONF_CURR_PROD_UPLOAD_DIR;
	$currUploadPath=(trim($currUploadPath)!='')?$currUploadPath.'~':'';
	return $currUploadPath.$fname;
}
function getFilepathOnDirectory($rs) {
			return CONF_USER_UPLOADS_PATH .'/'. $rs;
		}
		
function myTruncateCharacters($string, $limit, $break = " ", $pad = "...") {
    if (strlen($string) <= $limit)
        return $string;

    $string = substr($string, 0, $limit);
    if (false !== ($breakpoint = strrpos($string, $break))) {
        $string = substr($string, 0, $breakpoint);
    }
    return $string . $pad;
}
function getCurrUrl() {
 return getUrlScheme() . $_SERVER["REQUEST_URI"];
}


function redirectUserReferer() {
    if (!defined(REFERER)) {
        if (getCurrUrl()==$_SERVER['HTTP_REFERER'] || empty($_SERVER['HTTP_REFERER']))
            define('REFERER', CONF_WEBROOT_URL);
        else
            define('REFERER', $_SERVER['HTTP_REFERER']);
    }
    redirectUser(REFERER);
}




 $func = dirname(__FILE__).'/functions/';
include_once $func . 'html.php'; 
//include_once $func . 'email.php';
//include_once $func . 'file.php';
//include_once $func . 'form.php';

include_once $func . 'request.php';
//include_once $func . 'session.php';
include_once $func . 'template.php';
include_once $func . 'misc.php';
