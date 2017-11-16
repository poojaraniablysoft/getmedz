
<section class="section">
    <div class="sectionhead"><h4>Faq Category List</h4></div>

    <div class="sectionbody">

		<!--div class="grid_2">
			<a href="javascript:void(0);" onclick="redirectFaq(0);" class="addnew-button">Back to Faq Management</a>
			<a href="javascript:void(0);" onclick="loadForm(0);" class="addnew-button addNew">Add New Faq Category</a>
		</div>
	</div--> 

 
<?php 


$arr_flds = array(
	'listserial'=>'S.N.',	
	'faqcat_title'=>'Faq Category Title',	
	'action'=>'Action'
);


$tbl = new HtmlElement('table', array('class'=>'table table-responsive', 'width'=>'100%', 'id'=>'faqCattbl'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key=>$val){  
	if($key=='action'){ 
		$th->appendElement('th', array(), $val);
	}else if($key=='listserial'){
		$th->appendElement('th', array(), $val);
	} else if($key=='faqcat_title'){
		$th->appendElement('th', array(), $val);
	}else{
		$th->appendElement('th', array(), $val);
	}
	
} 


foreach ($arr_listing as $sn=>$row){
	$tr = $tbl->appendElement('tr', array('id'=>$row['faqcat_id']));	
	 
	foreach ($arr_flds as $key=>$val){
		
		$td = $tr->appendElement('td', array('style'=>'vertical-align:middle'));
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sn+$start_record);
				break;
						
			case 'faqcat_title':					
					$td->appendElement('plaintext', array(), getFieldFromRow( $row, $key ) );					
			break;
			
			
			case 'action':
				$toggle_active_text=($row['make_active'])?'Deactivate':'Activate';
				$td->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm('. $row['faqcat_id'] .')', 'class'=>'opt-button edit'), 'Edit' );				
				$td->appendElement('a',array('href'=>'javascript:void(0);', 'onclick'=>'if(confirm(\'Are you sure you want to delete this Faq Category?\')) document.location.href=\''.generateUrl('faqcategory','delete_faqCategory',array($row['faqcat_id'])).'\'', 'class'=>'opt-button del'), 'Delete');
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
        <?php include getViewsPath() . 'backend-pagination.php'; ?>
</section>