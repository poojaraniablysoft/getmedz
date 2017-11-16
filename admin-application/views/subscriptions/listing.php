
<section class="section">
	<div class="sectionhead"><h4>Subscriptions List </h4>

        
        </div>
                        
	<div class="sectionbody">

<?php 


$arr_flds = array(
	'listserial'=>'S.N.',	
	'subs_name'=>'Subscription Name',
	'subs_price'=>'Subscription Price',
	'subs_duration'=>'Subscription Duration(In Months)',
	
	'action'=>'Action'
);


$tbl = new HtmlElement('table', array('class'=>'table table-responsive', '', 'id'=>''));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key=>$val){  

		$th->appendElement('th', array(), $val);

} 


foreach ($arr_listing as $sn=>$row){
	$tr = $tbl->appendElement('tr');	
	 
	foreach ($arr_flds as $key=>$val){
		
		$td = $tr->appendElement('td', array('style'=>''));
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sn+$start_record);
				break;
						
			case 'subs_name':					
					$td->appendElement('plaintext', array(), $row['subs_name']  );					
			break;
			case 'subs_price':					
					$td->appendElement('plaintext', array(), $row['subs_price']  );					
			break;
		
			case 'subs_duration':					
					$td->appendElement('plaintext', array(), $row['subs_duration']  );					
			break;
		
		
			case 'action':
                            
                            
                            
                          $ul =$td->appendElement('ul',array('class'=>'actions'));
                              $li = $ul->appendElement('li');
                            	if( $row['subs_active'] == 0){
						$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Activate this Subscription?\')) disableSubscription('.$row['subs_id'].', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
					}else{
						$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Deactivate this Subscription?\')) disableSubscription('.$row['subs_id'].', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
						/* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */	
					}
                            
                            
                            
                             if($canEditSubscription){
                                $li=$ul->appendElement('li');
				$li->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm('. $row['subs_id'] .')','title'=>'edit'), '<i class="ion-edit icon"></i>',true);
                             }
                                if($canDeleteSubscription){
                                     $li=$ul->appendElement('li');
				$li->appendElement('a',array('href'=>'javascript:void(0);', 'onclick'=>'if(confirm(\'Are you sure you want to delete this Subscription?\')) document.location.href=\''.generateUrl('Subscriptions','delete_Subscription',array($row['subs_id'])).'\'', 'title'=>'Delete'), '<i class="ion-android-delete icon"></i>',true);
                                }
				break;
			default:
				$td->appendElement('plaintext', array(), $row[$key] );
				break;
		}		
	}	
}

if (count($arr_listing) == 0) $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds),'class'=>'records_txt'), 'No records found');
echo $tbl->getHtml(); 
?>
                    
</div>
    <?php include getViewsPath() . 'backend-pagination.php';  ?>
</section>