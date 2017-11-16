<?php
class Image {

    /**
     *
     * Saves an image
     * @param String $fl full path of the file
     * @param String $name name of file
     * @param String $response In case of success exact name of file will be returned in this else error message
     * @return Boolean
     */
    function saveImage($fl, $name, $extra_path = '', &$response) {
        $size = getimagesize($fl);
        if ($size === false) {
            $response = 'Image format not recognized. Please try with jpg, jpeg, gif or png file.';
            return false;
        }
        $fname = preg_replace('/[^a-zA-Z0-9]/', '', $name);
        while (file_exists(CONF_INSTALLATION_PATH . 'user-uploads/' . ($extra_path == '' ? '' : $extra_path . '/') . $fname)) {
            $fname .= '_' . rand(10, 99);
        }

        if (!copy($fl, CONF_INSTALLATION_PATH . 'user-uploads/' . ($extra_path == '' ? '' : $extra_path . '/') . $fname)) {
            $response = 'Could not save file.';
            return false;
        }

        $response = $extra_path . '/' . $fname;
        return true;
    }

    /*public static function displayImage($img, $w = 0, $h = 0, $crop_method = 2) {
        $w = intval($w);
        $h = intval($h);
       $pth = CONF_INSTALLATION_PATH . 'user-uploads/' . $img;

        if (!is_file($pth)) {
            $pth = CONF_INSTALLATION_PATH . 'public/images/no-image.png';
        }

        if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($pth))) {
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pth)) . ' GMT', true, 304);
            exit;
        }
        header("Expires: " . date("r", time() + (60 * 60 * 24 * 30)));
        header('Cache-Control: public');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pth)) . ' GMT', true, 200);
        $size = getimagesize($pth);

        if ($w == 0 && $h == 0) {

            $size = getimagesize($pth);


            if ($size === false) {
                echo 'INVALID_FILE';
                return false;
            }
         
            header("Content-Type: " . $size['mime']);
            readfile($pth);
        }

        $obj = new imageResize($pth);
        $obj->setMaxDimensions($w, $h);

        $obj->setResizeMethod($crop_method); 
        
        header("Content-Type: image/jpeg");
        echo $obj->displayImage();
    } */
	
	public static function displayImage($img, $w = 0, $h = 0, $crop_method = 2) {
		ob_end_clean();
        $w = intval($w);
        $h = intval($h);
       $pth = CONF_INSTALLATION_PATH . 'user-uploads/' . $img;

        if (!is_file($pth)) {
            $pth = CONF_INSTALLATION_PATH . 'public/images/no-image.png';
        }
		
		$file_extension = substr($pth,strlen($pth)-3,strlen($pth)); 
						if ($file_extension=="svg"){
							
							header("Content-type: image/svg+xml");
							header('Cache-Control: public');
							header("Pragma: public");
							header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime( $pth)).' GMT', true, 200);
							header("Expires: " . date('r', strtotime("+30 Day")));
							
							echo file_get_contents($pth);
							exit;
						}
						else{
						
       if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($pth))) {
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pth)) . ' GMT', true, 304);
            exit;
        }
         header("Expires: " . date("r", time() + (60 * 60 * 24 * 30)));
        header('Cache-Control: public');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pth)) . ' GMT', true, 200);
        $size = getimagesize($pth); 
		
			 if ($w == 0 && $h == 0) {

					$size = getimagesize($pth);


					if ($size === false) {
						echo 'INVALID_FILE';
						return false;
					}
				 
					header("Content-Type: " . $size['mime']);
					readfile($pth);
			} 
		}
		
		$img = new ImageResize($pth);
        $img->setResizeMethod($crop_method);
		//$img->setResizeMethod(ImageResize::IMG_RESIZE_RESET_DIMENSIONS);		
		if( $w && $h ){
			$img->setMaxDimensions($w, $h);
		}
		
		$img->displayImage();
        /* $img->setMaxDimensions($w, $h);

        $img->setResizeMethod($crop_method);
        
       // header("Content-Type: image/jpeg");
        echo $img->displayImage(); */
    }

}
