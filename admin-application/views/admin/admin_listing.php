<?php 
if (!SYSTEM_INIT) die('Invalid Access'); // avoid direct access. 

$arr_flds = array(
	'listserial'=>'S.N.',
	'admin_username'=>'Username',
	'action' => 'Action'
);
?>

<div id="form-div">
	<?php
	if (isset($frmAdmin)) {
		include dirname(__FILE__) . '/admin_form.php';
	}
	?>
</div>

<div class="tblheading">Admin Users</div>
<div id="listing-div">

<?php
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'tbl_listing'));
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
			case 'action':
				$td->appendElement('a', array('href'=>generateUrl('admin', 'admin_listing', array($row['admin_id'])), 'title'=>'Edit', 'class'=>'opt-button'), createButton('Edit'), true);
				$td->appendElement('a', array('href'=>'javascript:void(0);', 'onclick'=>"if(confirm('Are you sure you want to delete this user?')) location.href='".generateUrl('admin', 'delete_admin', array($row['admin_id']))."'", 'title'=>'Delete', 'class'=>'opt-button'), createButton('Delete'), true);
				break;
			default:
				$td->appendElement('plaintext', array(), $row[$key]);
				break;
		}
	}
}

if (count($arr_listing) == 0) $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), 'No records found');

echo $tbl->getHtml();
?>

</div>
<div style="float: right;">
<a href="<?php echo generateUrl('admin', 'admin_listing', array(0)); ?>">Add New Admin</a></div>
