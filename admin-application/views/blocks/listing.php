<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access. 
?>
<section class="section">
	<div class="sectionhead"><h4>Blocks List </h4>
      
        
        </div>
                        
	<div class="sectionbody">
<?php
$arr_flds = array(
'listserial'=>'S.N.',

'block_identifier'=>'Identifier',
'block_active'=>'Status',
'action' => 'Action'
);


$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) $th->appendElement('th', array(), $val);

foreach ($arr_listing as $sn=>$row){
	$tr = $tbl->appendElement('tr');
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sn+1);
				break;
			
			
				
			  case 'block_active':
			$td->appendElement('plaintext', array(),Applicationconstants::$arr_status[$row['block_active']]);
                        break;
			case 'action':
                            
                            
                            
                            
                            
                               $ul = $td->appendElement('ul', array('class' => 'actions'));
                              
                        $li = $ul->appendElement('li');
                        if ($row['block_active'] == 0) {
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to  Activate this Block?\')) disable(' . $row['block_id'] . ', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);
                        } else {
                            $li->appendElement('a', array('onclick' => 'if(confirm(\'Do you want to Deactivate this Block?\')) disable(' . $row['block_id'] . ', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);
                            /* $td->appendElement('a', array('href'=> generateUrl('carlistings', 'change_listing_status' , array($row['carlist_id'], 0) ), 'class'=>'opt-button grant'), 'Enable' ); */
                        }

                            
                            if($canEdit){
                                 $li = $ul->appendElement('li');
			//$li->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm(\''. $row['block_id'] .'\')', 'title' => 'Edit'), '<i class="ion-edit icon"></i>', true);
			
			$li->appendElement('a', array('href'=>generateUrl('blocks', 'form', array($row['block_id'])), 'title' => 'Edit'), '<i class="ion-edit icon"></i>', true);
                            }
                            
                            
                       
				break;
			default:
				$td->appendElement('plaintext', array(), $row[$key]);
				break;
		}
	}
}


if (count($arr_listing) == 0) $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds),'class'=>'records_txt'), 'No records found');
echo $tbl->getHtml();
 ?>
        </div>
 	<?php //include getViewsPath() . 'backend-pagination.php';  ?>
</section>