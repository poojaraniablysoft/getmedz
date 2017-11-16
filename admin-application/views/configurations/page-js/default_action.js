////////////////////////////////////////// Default Action /////////////////////////////


 
 function submitSettings(v){
	v.validate();
		
	if (!v.isValid()){
		
		return false;
	} 
	
	$('#frm_mbs_id_frmConfigurations').ajaxSubmit({ 
		delegation: true,
		success: function(json){
			json = $.parseJSON(json);
		
			$.systemMessage.success(json.msg);
			
			
		},
		
	}); 
 }
 
 function submitHomeSettings(v){
 v.validate();
		
	if (!v.isValid()){
		
		return false;
	} 
	$('#frm_mbs_id_frmHomeSettings').ajaxSubmit({ 
		delegation: true,
		success: function(json){
			json = $.parseJSON(json);
			
		
			 $.systemMessage.success(json.msg);
			
		}
	}); 
 }
 function submitPdfSettings(v){
 v.validate();
		
	if (!v.isValid()){
		
		return false;
	} 
	$('#frm_mbs_id_frmPdfSettings').ajaxSubmit({ 
		delegation: true,
		success: function(json){
			json = $.parseJSON(json);
			
		
			 $.systemMessage.success(json.msg);
			
		}
	}); 
 }
 
 function submitThirdPartySettings(v){
 v.validate();
		
	if (!v.isValid()){
		
		return false;
	} 
	$('#frm_mbs_id_frmThirdPartySettings').ajaxSubmit({ 
		delegation: true,
		success: function(json){
			json = $.parseJSON(json);
			
		
			$.systemMessage.success(json.msg);
			
		}
	}); 
 }