
$(document).ready(function () {

    listquestions('');
	
	
});

function listquestions($type=''){
	
	callAjax(generateUrl('doctor', 'listquestions'), 'type=' + $type + '&outmode=html', function(t){
		$('#listing-div').html(t);
                  
	});
}

function acceptQuestion($questionId,redirect){
	if(redirect==undefined|| redirect==''){
		redirect = false;
	}
	$.systemMessage.processing();
	callAjax(generateUrl('doctor', 'acceptquestion'), 'questionId=' + $questionId, function(t){
		var ans = parseJsonData(t);
		if(ans.status==1){
			$.systemMessage.success(ans.msg);
			listquestions('');	
			if(redirect){				
				setTimeout(function(){window.location.href= generateUrl('doctor','question',[$questionId])},200);			
			}
		}else{
			$.systemMessage.error(ans.msg);
			return false;
		}
                  
	});
}

function esclateQuestion($questionId,redirect){
	if(redirect==undefined|| redirect==''){
		redirect = false;
	}
	$.systemMessage.processing();
	callAjax(generateUrl('doctor', 'esclatequestion'), 'questionId=' + $questionId, function(t){
		var ans = parseJsonData(t);
		if(ans.status==1){
			$.systemMessage.success(ans.msg);
			listquestions('');	
			
		}else{
			$.systemMessage.error(ans.msg);
			return false;
		}
                  
	});
}
