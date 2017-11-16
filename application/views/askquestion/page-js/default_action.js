$(document).ready(function(){
	
	$(".prev-js").click(function(){
		
		$prevStep = $("#frmQuestionForm input[name=step]").val()-1;
	
		
		
		if($prevStep ==1){	
			frmQuestionForm_validator['requirements']['orquestion_term']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_med_history']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_name']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_gender']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_age']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_weight']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_email']={"required":false};
			frmQuestionForm_validator['requirements']['orquestion_state']={"required":false};
			
			$("#frmQuestionForm").attr('action',webroot);			
		
		}else if($prevStep ==2){	
		
			frmQuestionForm_validator['requirements']['orquestion_doctor_id']={"required":false};
			
		}else if($prevStep ==3){	
		
			frmQuestionForm_validator['requirements']['subscription_id']={"required":false};
			
		}
			$("#frmQuestionForm input[name=step]").val($prevStep-1);
			
			frmQuestionForm_validator.resetFields();
			
			$("#frmQuestionForm").submit();
		
	});
});