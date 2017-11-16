
<section class="section">
	<div class="sectionhead"><h4>State List </h4>
            
        
        </div>
                        
	<div class="sectionbody">

<?php 


$arr_flds = array(
	'listserial'=>'S.N.',	
	'state_name'=>'State Name',
	'state_active'=>'Status',
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
						
			case 'state_name':					
					$td->appendElement('plaintext', array(), $row['state_name']  );					
			break;
			case 'state_active':					
				    $td->appendElement('plaintext', array(),Applicationconstants::$arr_status[$row['state_active']]);		
			break;
		
			case 'action':
                               $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');
		if( $row['state_active'] == 0){
						$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Activate this State?\')) disableState('.$row['state_id'].', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);	
					}else{
						$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Deactivate  this State?\')) disableState('.$row['state_id'].', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);	
						/* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */	
					}
                             if($canEditStates){
                                  $li = $ul->appendElement('li');
				$li->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm('. $row['state_id'] .')', 'title' => 'Edit Profile'), '<i class="ion-edit icon"></i>', true);
                             }
                                if($canDeleteStates){
                                    $li = $ul->appendElement('li');
				$li->appendElement('a',array('href'=>'javascript:void(0);', 'onclick'=>'if(confirm(\'Are you sure you want to delete this State?\')) document.location.href=\''.generateUrl('states','delete_state',array($row['state_id'])).'\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
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