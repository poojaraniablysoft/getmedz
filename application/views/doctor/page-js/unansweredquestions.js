/* function change_question_status(que,status){
 
  if(status===undefined){
   return false; 
  }
  var postdata={qStatus:status,outmode:'json',_id:que};
  callAjax(generateUrl('doctor','updateQuestionStatus'),$.param(postdata),function(response){
    var data = JSON.parse(response);
    if(data.status){  
       $('#roundedbox_'+que).fadeOut().remove();
    }
    if($('.roundedbox').length<1){
        $('#listing-div').html('<section class="section"><section class="sectionbody space">You do not have any Unanswered questions</section></section>');
        
    }
        
      $('#msg_info').html(data.msg);
	  hide_msg();
  });
} */

$(document).ready(function () {

    listquestions('unanswered');
	
	
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
