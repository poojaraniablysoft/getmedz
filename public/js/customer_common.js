


function reviewDoctor(question_id) {

    var reviewUrl = generateUrl('customer', 'review_doctor');

    var data = 'question_id=' + question_id;
    callAjax(reviewUrl, data + '&outmode=html', function (t) {
	
			var ans = parseJsonData(t);
			console.log(ans);
			if(ans.status==0){
				$.systemMessage.error(ans.msg);
			}else{
				$.facebox(t)
			}
		
    });


}
function updateCustomQuestionStatus($question_id, $status,$oldStatus) {

    if ($oldStatus!==7 && confirm("Are you sure you want to close this question")===false) {
        return false;
    }
        callAjax(generateUrl('question', 'updateQuestionStatus'), 'orquestion_id=' + $question_id + '&orquestion_status=' + $status, function (t) {
            var ans = parseJsonData(t);
            $(document).trigger('close.mbsmessage');
            if (ans == false) {
                alert('Oops! Internal error. Server says ' + t);
                return;
            }
            if (ans.status == 0) {
                $.facebox(ans.msg);
                return;
            } else {
				
               reviewDoctor($question_id);
              // $('#rate_div').show();
            }

        //    $(frm).find("input[type=text], textarea").val(""); /* Reset form */

        });
    
}

