

function updateReply(orquestion_id, mode, ref) {
    if (!orquestion_id)
        return;
    $.mbsmessage('Processing....');
    var data = 'orquestion_id=' + orquestion_id + '&mode=' + mode + '&outmode=json';
    callAjax(generateUrl('questions', 'change_listing_status'), data, function (t) {
        var ans = parseJsonData(t);
        $(document).trigger('close.mbsmessage');
        if (ans == false) {
            alert('Oops! Internal error. Server says ' + t);
            return;
        }
        if (ans.status == 0) {
            $("#msg_info").html(ans.msg);
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
		$("#update_reply_"+orquestion_id).children().next().removeClass('pending');
		$("#update_reply_"+orquestion_id).children().next().removeClass('approved');
		$("#update_reply_"+orquestion_id).children().next().removeClass('disapproved');
		
		$("#update_reply_"+orquestion_id).children().next().addClass($class); 
        if (!page)
            page = 0;
        //list(page)

    });
}
function redirectUser(url){
	window.location.href=url;
}