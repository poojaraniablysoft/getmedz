
<section class="section">
	<div class="sectionhead"><h4>Question List </h4>
            
        
        </div>
                        
	<div class="sectionbody">

<?php 


$arr_flds = array(
    'order_id'=>'Order ID#',
	'user_id'=>'UserID#',	
	'customer_name'=>'Customer Name',
	'order_date'=>'Order Date',
        'orquestion_question'=>'Question',
        'reply_text'=>'Doctor Reply',
        'count_replies'=>'Replies',
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
		if($key=="action"){
		$td = $tr->appendElement('td', array('class'=>'ques_action'));
		}else{
			$td = $tr->appendElement('td', array('style'=>''));
		}
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sn+$start_record);
				break;
						
			
			case 'order_date':					
				    $td->appendElement('plaintext', array(),displayDate($row['order_date']));		
			break;
                    case 'orquestion_question':
                        	 $div=$td->appendElement('div', array('class' => 'scrolltext'));	
				  $div->appendElement('plaintext', array(), $row[$key]);
                                  break;
                    case 'reply_text':		
				 $div=$td->appendElement('div', array('class' => 'scrolltext'));	
				  $div->appendElement('plaintext', array(),  html_entity_decode($row[$key]),true);		
			break;	
                    
			case 'action':
			  $ul = $td->appendElement('ul', array('class' => 'actions'));
                        $li = $ul->appendElement('li');
				if(CONF_REQUIRED_REPLY_APPROVAL){
				
					if($row['orquestion_reply_status']==0){
							$add_class='pending';
						 }
						 elseif($row['orquestion_reply_status']==1){
							$add_class='approved';
						 }
						 else{
						 $add_class='disapproved';
						 }
						 
                    if($row['count_replies']>0){  
						$ul_div = $td->appendElement('div',array('id'=>'update_reply_'.$row['reply_id'],'class'=>'update_reply '.$add_class));
						 $ul2 = $ul_div->appendElement('select', array('class'=>'ques_status','onchange'=>"updateReply(".$row['orquestion_id'].",this.value,".$row['reply_id'].")"));
						 foreach(Applicationconstants::$arr_reply_status as $key=> $val){
						 if($key==$row['orquestion_reply_status']){
							$arr=array('value'=>$key,'selected'=>'selected');
						 }
						 else{
							$arr=array('value'=>$key);
						 }
						 
							$li2 = $ul2->appendElement('option',$arr,$val);
							
						}
						
							
					}
                         
				}
				 $li->appendElement('a', array('href'=>  generateUrl('Questions','view',array($row['orquestion_id'])), 'title' => 'View'), '<i class="ion-eye icon"></i>', true);
				
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
<script>
	$(document).ready(function(){ 
	setTimeout(function(){
<?php foreach ($arr_listing as $row){
		if($row['count_replies']>0){ 
			if($row['orquestion_reply_status']==0){
				$add_class='pending';
			 }
			 elseif($row['orquestion_reply_status']==1){
				$add_class='approved';
			 }
			 else{
			 $add_class='disapproved';
			 }
						
						 ?>
		$add_class='<?php echo $add_class;?>';
	$("#update_reply_"+<?php echo $row['reply_id'];?>).children().next().addClass($add_class);
		
						
<?php
	}
}
?>
},2000); 
 });
 </script>                   
</div>
    <?php include getViewsPath() . 'backend-pagination.php';  ?>
</section>
<script type="text/javascript">
		$(function () {
		setTimeout(function(){
			$(".ques_status").selectbox();},500);
		});
		</script>