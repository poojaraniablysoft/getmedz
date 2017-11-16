<style>
  body{font-family: "Open Sans",sans-serif;}

.pdf_logo {
    clear: both;
    display: block;
    padding: 10px 0;
    text-align: right;
    width: 100%;
	
}


.chat_title {
    color: #2196f3;
    font-size: 15px;
    margin: 0;
}
.pdf_chat p {
    font-size: 14px;
    margin: 2px 0 0px;
}
.patient_reply{border:1px solid #ddd;border-left:15px solid #2196f3;padding:10px;margin:0 0 15px 0;position:relative;}

.patient_reply::before {
    border: 6px solid transparent;
    border-left: 6px solid #2196f3;
    content: "";
    left: 0;
    position: absolute;
    top: 13px;
}
.doctor_reply::before {
    border: 6px solid transparent;
    border-left: 6px solid #EA1B64;
    content: "";
    left: 0;
    position: absolute;
    top: 13px;
}
.doctor_reply{border:1px solid #ddd;border-left:15px solid #EA1B64;padding:10px;margin:0 0 15px 25px;position:relative;}
.chat-footer {
    text-align: center;
	padding-top:40px;
}
.chat-footer span {
    font-size: 14px;
	display:block;
    margin: 2px 0 0px;
}

.pdf_chat {
    clear: both;
    padding:40px 0 0;
}
</style>
<div class="main_pdf_div" style="margin:0 auto;">
	 <div class="pdf_logo"><img style="float:right" src="http://askdoctor.4demo.biz/public/images/logo.png" alt="Test Image"  align="right"/> </div>
        
	
	 <div class="pdf_chat">
	  <?php  
		$vars=array(
        '{website_name}'=>CONF_WEBSITE_NAME,
        '{doctor_name}'=>$question_data['doctor_name'],
        '{user_name}'=>$question_data['user_name'],
        '{website_url}'=>  generateAbsoluteUrl(),
        '{doctor_email}'=>  CONF_WEBSITE_EMAIL,
        '{site_tel}'=>  CONF_CONTACT_PHONE

    );
	
    
   echo str_replace(array_keys($vars), array_values($vars),  CONF_PAGE_1_CONTENT); 
		
	?>
			
			
	 </div>
 
 </div>
 <div style="page-break-before: always;"></div>
 <div class="main_pdf_div" style="margin:0 auto;">
	 <div class="pdf_logo"><img style="float:right" src="http://askdoctor.4demo.biz/public/images/logo.png" alt="Test Image"  align="right"/> </div>
         <br>
         <br>
	 <div class="patient_details">
		<strong>Name:</strong><?php echo $question_data['user_name'];?> <br/>
		<strong>Order Date:</strong><?php echo  displayDate($question_data['order_date']) ;?><br/>
		<strong>Order No.:</strong> <?php echo  $question_data['order_id'] ;?> <br/>
		
	
	</div>
	
	<p>For Your Reference we are sending your question and the doctor's advice</p>
	
	 <div class="pdf_chat">
	    
		
		
		<div class="patient_reply"><h3 class="chat_title">Your Medical Question</h3><p><?php echo $replies[0]['orquestion_question'];?></p></div>
		 <?php
           if ($replies) { 
			foreach ($replies as $reply) {
				?>
				<div id="" <?php if ($reply['reply_by'] == Members::DOCTOR_USER_TYPE) echo'class="doctor_reply" style=""'; else{ echo'class="patient_reply" style=""';} ?>>
					 <?php if ($reply['reply_by'] == Members::DOCTOR_USER_TYPE) {?>
					 <h3 class="chat_title">Doctor Answer to your Medical Question</h3>
					 <?php } else{ ?>
					 <h3 class="chat_title">Your Medical Question</h3>
					 <?php } ?>
					
					
					
					<?php echo html_entity_decode($reply['reply_text']); ?>

	

				</div>
			<?php }
			}
			?>
			<div class="chat-signature"><?php echo CONF_PDF_CALL_TEXT;?></div>
			
			
	 </div>
 
 </div>