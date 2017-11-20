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

    listquestions('answered');
	
	
});
function listquestions($type='',data=''){
	if(data==undefined){
		data='';
	}
	callAjax(generateUrl('doctor', 'listquestions'), 'type=' + $type +'&'+data+'&outmode=html', function(t){
		$('#listing-div').html(t);
                  
	});
}

 function submitsearch(frm, v){
	 
 
     var data=$('#searchForm').serialize();
	 listquestions('answered',data);
    /* showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('doctors', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	}); */
    return false;
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
