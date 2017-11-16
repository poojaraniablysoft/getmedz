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
