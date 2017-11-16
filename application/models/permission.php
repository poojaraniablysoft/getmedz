<?php

class Permission extends Model {
    /*
     * Countries State Management
     */

    public static function canAddStates($user_id) {
        return true;
    }

    public static function canEditStates($user_id) {
        return true;
    }

    public static function canDeleteStates($user_id) {
        return true;
    }

    public static function canChangeStatusofStates($user_id) {
        return true;
    }

    /*
     * Medical Catgories Management
     */

    public static function canAddMedicalCategory($user_id) {
        return true;
    }

    public static function canEditMedicalCategory($user_id) {
        return true;
    }

    public static function canDeleteMedicalCategory($user_id) {
        return true;
    }

    public static function canChangeStatusofMedicalCategory($user_id) {
        return true;
    }

    /*
     * Doctors Catgories Management
     */

    public static function canAddDoctor($user_id) {
        return true;
    }

    public static function canEditDoctor($user_id) {
        return true;
    }

    public static function canDeleteDoctor($user_id) {
        return true;
    }

    public static function canChangeStatusofDoctor($user_id) {
        return true;
    }

    /*
     * User  Management
     */

    public static function canAddUser($user_id) {
        return true;
    }

    public static function canEditUser($user_id) {
        return true;
    }

    public static function canDeleteUser($user_id) {
        return true;
    }

    public static function canChangeStatusofUser($user_id) {
        return true;
    }

    /*
     * Deegree  Management
     */

    public static function canAddDegree($user_id) {
        return true;
    }

    public static function canEditDegree($user_id) {
        return true;
    }

    public static function canDeleteDegree($user_id) {
        return true;
    }

    public static function canChangeStatusofDegree($user_id) {
        return true;
    }

    /*
     * FAQ Catgeory  Management
     */

    public static function canAddFaqCategory($user_id) {
        return true;
    }

    public static function canEditFaqCategory($user_id) {
        return true;
    }

    public static function canDeleteFaqCategory($user_id) {
        return true;
    }

    public static function canChangeStatusofFaqCategory($user_id) {
        return true;
    }

    /*
     * FAQ   Management
     */

    public static function canAddFaqs($user_id) {
        return true;
    }

    public static function canEditFaqs($user_id) {
        return true;
    }

    public static function canDeleteFaqs($user_id) {
        return true;
    }

    public static function canChangeStatusofFaqs($user_id) {
        return true;
    }

    /*
     * Cms  Management
     */

    public static function canEditCmsPage($user_id) {
        return true;
    }

    public static function canAddCmsPage($user_id) {
        return true;
    }

    public static function canDeleteCmsPage($user_id) {
        return true;
    }

    public static function canChangeStatusofCmsPage($user_id) {
        return true;
    }
	/*
     * Cms  Management
     */

    public static function canEditTestimonialPage($user_id) {
        return true;
    }

    public static function canAddTestimonialPage($user_id) {
        return true;
    }

    public static function canDeleteTestimonialPage($user_id) {
        return true;
    }

   

    /*
     * Blocks  Management
     */

    public static function canEditBlocks($user_id) {
        return true;
    }

    public static function canChangeStatusofBlocks($user_id) {
        return true;
    }

    /*
     * Subscription   Management
     */

    public static function canAddSubscription($user_id) {
        return true;
    }

    public static function canEditSubscription($user_id) {
        return true;
    }

    public static function canDeleteSubscription($user_id) {
        return true;
    }

    public static function canChangeStatusofSubscription($user_id) {
        return true;
    }

    public static function canCustomerAddReview($user_id) {
        return true;
    }

    public static function canEditreviews($user_id) {
        return true;
    }

    public static function canviewreviews($user_id) {
        return true;
    }
	/******
	Blog Section management
	**/
	public static function canViewBlog($admin_id = 0) {
        return true;
    }

    public static function canAddBlog($admin_id = 0) {
        return true;
    }

    public static function canEditBlog($admin_id = 0) {
        return true;
    }
	/******
	Social Section management
	**/
	public static function canViewSocial($admin_id = 0) {
        return true;
    }

    public static function canAddSocial($admin_id = 0) {
        return true;
    }

    public static function canEditSocial($admin_id = 0) {
        return true;
    }

}
