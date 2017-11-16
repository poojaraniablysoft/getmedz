<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access. 
?>
<section class="section">
	<div class="sectionhead"><h4>Cms Page List </h4>
		<?php if($canAdd):?>
		<a href="<?php echo generateUrl('cms', 'form'); ?> " class="themebtn btn-default waves-effect">Add New Page</a>
		<?php endif;?>
	
	</div>                        
	<div class="sectionbody">
		<?php
		$arr_flds = array(
		'listserial'=>'S.N.',

		'cmsc_title'=>'Page Title',
			'cmsc_slug'=>'Page Slug',
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
					
					case 'cmsc_title':					
							$td->appendElement('plaintext', array(),$row['cmsc_title'] ,true);					
					break;					
					
					case 'action':
							$ul = $td->appendElement('ul', array('class' => 'actions'));					$li = $ul->appendElement('li');
							if( $row['cmsc_content_active'] == 0){
								$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Activate this page?\')) disable('.$row['cmsc_id'].', 1,this);', 'title' => 'Inactive'), '<i class="ion-checkmark icon inactive"></i>', true);	
							}else{
								$li->appendElement('a', array('onclick'=>'if(confirm(\'Do you want to Deactivate  this page?\')) disable('.$row['cmsc_id'].', 0,this);', 'title' => 'Active'), '<i class="ion-checkmark icon active"></i>', true);	
								
							}       
									
							if($canEdit){
									 $li = $ul->appendElement('li');
									 /* $li->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>'loadForm(\''. $row['cmsc_id'] .'\')', 'title' => 'Edit'), '<i class="ion-edit icon"></i>', true); */
									 $li->appendElement('a', array('href'=>generateUrl('cms', 'form', array($row['cmsc_id'])), 'title' => 'Edit'), '<i class="ion-edit icon"></i>', true);
							}	
							if ($canDelete) {
							$li = $ul->appendElement('li');
							$li->appendElement('a', array('href' => 'javascript:void(0);', 'onclick' => 'if(confirm(\'Are you sure you want to delete this cms page?\')) document.location.href=\'' . generateUrl('cms', 'delete_cms', array($row['cmsc_id'])) . '\'', 'title' => 'Delete'), '<i class="ion-android-delete icon"></i>', true);
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
 	<?php include getViewsPath() . 'backend-pagination.php';  ?>
</section>