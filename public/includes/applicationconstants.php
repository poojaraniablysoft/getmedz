<?php
class Applicationconstants{
    //public static $arr_user_types = array(1=>'Innovator', 2=>'Investor', 3=>'Resource');
     CONST SINGLE_QUETION =1     ;
     CONST UNLIMITED_QUETION =99999     ;
	/* Yes Or No Selection  */
	public static $arr_status = array(
		'1'=>'Active', 
		'0'=>'Inactive'
	);
	public static $post_status = array('0' => 'Draft', '1' => 'Published');
        
    public static $year_range_start=1901;
    public static $car_range_years=10;
        
        
    public static $cms_page_type=array(1=>'Left Footer Menu',2=>'Right Footer Menu');
	
	public static $arr_age_year = array(
		'0-3'=>'0-3',
		'4-9'=>'4-9',
		'10-17'=>'10-17',
		'18-35'=>'18-35',
		'36-45'=>'36-45',
		'46-55'=>'46-55',
		'56-65'=>'56-65',
		'66-75'=>'66-75',
		'76-85'=>'76-85',
		'86-100'=>'86-100'	
	);
	public static $arr_weight_kgs = array(
		'1-10'=>'1-10 Kgs',
		'10-20'=>'10-20 Kgs',
		'20-30'=>'20-30 Kgs',
		'30-40'=>'30-40 Kgs',
		'40-50'=>'40-50 Kgs',
		'50-60'=>'50-60 Kgs',
		'60-70'=>'60-70 Kgs',
		'70-80'=>'70-80 Kgs',
		'80-90'=>'80-90 Kgs',
		'90-100'=>'90-100 Kgs'	
	);
	
	public static $arr_gender = array(	
		'1'=>'Male',
		'2'=>'Female'		
	);
	
	public static $arr_yes_no = array(	
		'1'=>'Yes',
		'2'=>'No'		
	);
	public static $arr_exp_month = array(
	
		'01'=>'01',
		'02'=>'02',
		'03'=>'03',
		'04'=>'04',
		'05'=>'05',
		'06'=>'06',
		'07'=>'07',
		'08'=>'08',
		'09'=>'09',
		'10'=>'10',
		'11'=>'11',
		'12'=>'12',	
		
	);
	
	public static $arr_card_type = array(	
		'Visa'=>'Visa',
		'Master Card'=>'Master Card'		
	);
	
	public static $arr_reply_status = array(	
		'0'=>'Pending',
		'1'=>'Approved',		
		'2'=>'DisApproved'		
	);
        
        
        
	public static $paymentPlans=array(
	  '0'=>array('title'=>'OneQuestion - $14.95 today only' ,'price'=>'14.95'),
	  '1'=>array('title'=>'Unlimited Questions - $19.95 / month' ,'price'=>'19.95'),
	);
		
	  public static $arr_question_available=array(
	   '0'=>'Single Question',
	  '1'=>'Unlimited Questions',
	 
	);
	
	
	
}