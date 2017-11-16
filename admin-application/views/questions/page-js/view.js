

function updateReply(orquestion_id, mode, ref) {
    if (!orquestion_id)
        return;
  $.systemMessage.processing(ans.msg);
    var data = 'orquestion_id=' + orquestion_id + '&mode=' + mode + '&outmode=json';
    callAjax(generateUrl('questions', 'change_listing_status'), data, function (t) {
        var ans = parseJsonData(t);
      
        if (ans == false) {
            $.systemMessage.error(t,true);
            return;
        }
        if (ans.status == 0) {
            $.systemMessage.error(ans.msg);
            return;
        }
		if(mode==0) $class='pending';
		else if(mode==1)$class='approved';
		else $class='disapproved';
        var str = '';
        var page = $('.pagination').find('.selected>a').text();
	/* 	$(".sbHolder").removeClass('pending');
		$(".sbHolder").removeClass('approved');
		$(".sbHolder").removeClass('disapproved');
	
		$(".sbHolder").addClass($class);*/	
			
		$("#update_reply_"+ref).children().next().removeClass('pending');
		$("#update_reply_"+ref).children().next().removeClass('approved');
		$("#update_reply_"+ref).children().next().removeClass('disapproved');
		
		$("#update_reply_"+ref).children().next().addClass($class); 
        if (!page)
            page = 0;
        //list(page)

    });
}
