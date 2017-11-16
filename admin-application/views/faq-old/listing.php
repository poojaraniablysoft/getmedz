<div class="content">

 	<div class="panels">
		<div class="grid_1"><h3>Faq List</h3></div>
		<div class="grid_2"><a href="javascript:void(0);" onclick="redirectFaq(0);" class="addnew-button">Faq Category Management</a>
		<a href="javascript:void(0);" onclick="loadForm(0);" class="addnew-button addNew">Add New Faq</a></div>
	</div>
<div class="clear"></div>
 
<?php 


$arr_flds = array(
	'listserial'=>'S.N.',	
	'faq_title'=>'Faq Title',
	'faq_title_lang_2'=>'Faq Title Arabic',
	'action'=>'Action'
);


$tbl = new HtmlElement('table', array('class'=>'tbl_listing', 'width'=>'100%', 'id'=>'faqtbl'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $key=>$val){  
	if($key=='action'){ 
		$th->appendElement('th', array(), $val);
	}else if($key=='listserial'){
		$th->appendElement('th', array(), $val);
	} else if($key=='faq_title'){
		$th->appendElement('th', array(), $val);
	}else if($key=='faq_title_lang_2'){
		$th->appendElement('th', array(), $val);
	}else{
		$th->appendElement('th', array(), $val);
	}
	
} 


foreach ($arr_listing as $sn=>$row){
	$tr = $tbl->appendElement('tr', array('id'=>$row['faq_id']));	
	 
	foreach ($arr_flds as $key=>$val){
		
		$td = $tr->appendElement('td', array('style'=>'vertical-align:middle'));
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sn+$start_record);
				break;
						
			case 'faq_title':					
					$td->appendElement('plaintext', array(), getFieldFromRow( $row, $key ) );					
			break;
			
			case 'faq_title_lang_2':
				$td->appendElement('plaintext',array(), getFieldFromRow( $row,'faq_title' ));
				
			break;
			
			case 'action':
				$toggle_active_text=($row['make_active'])?'Deactivate':'Activate';
				$td->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm('. $row['faq_id'] .')', 'class'=>'opt-button edit'), 'Edit' );				
				$td->appendElement('a',array('href'=>'javascript:void(0);', 'onclick'=>'if(confirm(\'Are you sure you want to delete this Faq?\')) document.location.href=\''.generateUrl('faq','delete_faq',array($row['faq_id'])).'\'', 'class'=>'opt-button del'), 'Delete');
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