<?php

class ImageController extends Controller{
    
    
   public function getDoctorProfilePic($doc_id, $w, $h) {

        $fls = new Files();

        if (intval($doc_id) < 1) {
            $doc_id = Members::getLoggedUserID();
        }
        $data = $fls->getFirstImage($doc_id, Files::DOCTOR_PROFILE);
		
        Image::displayImage(($data['file_path'] == '' ? 'doc_profile/no_doc_profile.png' : $data['file_path']), $w, $h);
    }
    
    public function getCustomerProfilePic($user_id, $w, $h) {

        $fls = new Files();
        
        if (intval($user_id) < 1) {
             $user_id = Members::getLoggedUserID();
        }
        $data = $fls->getFirstImage($user_id, Files::USER_PROFILE);
        
        Image::displayImage(($data['file_path'] == '' ? 'doc_profile/default_icon-user.jpg' : $data['file_path']), $w, $h);
    }  
	public function banner($banner_id, $w, $h)
	{
		
		$fls = new Files();
        
        if (intval($user_id) < 1) {
             $user_id = Members::getLoggedUserID();
        }
        $data = $fls->getFirstImage($banner_id, Files::BANNER_TYPE);
        
        Image::displayImage(($data['file_path'] == '' ? 'banners/default_icon-banner.png' : $data['file_path']), $w, $h);
		
	}
	
	public function testimonial_image($img = '',$type){
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'testimonials/default_icon-testimonial.png' : 'testimonials/'.$img), 100, 100);
			//return showImage($img, 100, 100,'testimonials/','default.jpg');
			break;
			default:
			return Image::displayImage(($img == '' ? 'testimonials/default_icon-testimonial.png' : 'testimonials/'.$img), 100, 100);
			//return showImage($img, 200, 200, 'testimonials/','default.jpg');
		}
	}
	/* public function banner($banner_id, $w, $h)
	{
		
		$fls = new Files();
        
        
        $data = $fls->getFirstImage($banner_id, Files::TESTIMONIAL_TYPE);
        
        Image::displayImage(($data['file_path'] == '' ? 'banners/default_icon-banner.png' : $data['file_path']), $w, $h);
		
	} */
	function post($type = 'large', $img = '') {
        switch (strtoupper($type)) {
            case 'THUMB':
				return Image::displayImage(($img == '' ? 'post-images/default_icon-blog.png' : 'post-images/'.$img), 120, 60);
               // return showImage($img, 120, 60, 'post-images/', 'no-img.jpg');
                break;
            case 'LARGE':
				return Image::displayImage(($img == '' ? 'post-images/default_icon-blog.png' : 'post-images/'.$img), 800, 400);
                
                break;
            default:
				return Image::displayImage(($img == '' ? 'post-images/default_icon-blog.png' : 'post-images/'.$img), 148, 148);
                
        }
    }
	
	function homebanner($img = '',$type){
		
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'banners/default_icon-banner.png' : 'banners/'.$img), 100, 50);				
			break;
			case 'NORMAL':
			return Image::displayImage(($img == '' ? 'banners/default_icon-banner.png' : 'banners/'.$img));				
			break;
			default:
			return Image::displayImage(($img == '' ? 'banners/default_icon-banner.png' : 'banners/'.$img), 100, 100);  
				
		}
	}
	
	function site_logo($img = '',$type){
		$img=$img!=""?$img:CONF_FRONT_LOGO;
		
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img),172,75);
			break;
			case 'MINI':
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img),80,80);
			break;
			default:
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img));
//return Utilities::showImage($img, 200, 300,'products/','product-no-image.jpg',true);
		}
	}
	
	function site_admin_logo($img = '',$type){
		$img=$img!=""?$img:CONF_ADMIN_LOGO;
		
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img),172,75);
			break;
			case 'MINI':
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img),80,80);
			break;
			default:
			return Image::displayImage(($img == '' ? 'images/dynamic/logo.png' : 'logo/'.$img));
//return Utilities::showImage($img, 200, 300,'products/','product-no-image.jpg',true);
		}
	}
	function site_footer_logo($img = '',$type){
		$img=$img!=""?$img:CONF_FOOTER_LOGO;
		
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'logo/'.$img),172,75);
			break;
			case 'MINI':
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'logo/'.$img),80,80);
			break;
			default:
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'logo/'.$img));
//return Utilities::showImage($img, 200, 300,'products/','product-no-image.jpg',true);
		}
	}
	
	
	
	public function medical_category($category_id, $w, $h)
	{
		
		$fls = new Files();        
        
        $data = $fls->getFirstImage($category_id, Files::MEDICAL_CATEGORY_TYPE);
        
        Image::displayImage(($data['file_path'] == '' ? 'medical_category/default_icon-category.png' : $data['file_path']), $w, $h);
		
	}
	public function social_platform_icon($img = '',$type){
		
		switch(strtoupper($type)){
			case 'THUMB':
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'socialplatforms/'.$img),172,75);
			break;
			case 'SMALL':
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'socialplatforms/'.$img),80,80);
			break;
			default:
			return Image::displayImage(($img == '' ? 'images/dynamic/footer-logo.png' : 'socialplatforms/'.$img));
		
		}
	}
    
    
    
    
    
    
}
