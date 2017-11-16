$(document).ready(function () {
    list();
    $('.cancel_form').live('click', function () {
        //loadForm();
    });

    $('a[rel=form]').live('click', function () {
        showHtmlElementLoading($('#form-div'));
        callAjax($(this).attr('href'), '', function (t) {
            $('#form-div').html(t);
            $('html, body').animate({scrollTop: $('#form-div').offset().top}, 'slow');
        });
        return false;
    });

    $(".cancel_search").live('click', function () {
        $(document.searchForm).find("input[type=text], select").val(""); /* Reset form */
        list();
    });

});

function loadForm(id) {
    if (!id)
        id = 0;
    showHtmlElementLoading($('#form-div'));
    callAjax(generateUrl('questions', 'form'), 'id=' + id + '&outmode=html', function (t) {
        $('#form-div').html(t);
        $('#tab_a_2').click();
    });

}
function submitsearch(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
    var data = $('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('questions', 'listing'), data, function (t) {
        $('#listing-div').html(t);
	

    });
    return false;
}
function list(page) {


    if (!page)
        page = 0;
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('questions', 'listing'), 'page=' + page, function (t) {
        $('#listing-div').html(t);

    });
}

function submitStatesSetup(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
}



function updateReply(orquestion_id, mode, ref) {
    if (!orquestion_id)
        return;
 
    var data = 'orquestion_id=' + orquestion_id + '&mode=' + mode + '&outmode=json';
    callAjax(generateUrl('questions', 'change_listing_status'), data, function (t) {
        var ans = parseJsonData(t);
       
        if (ans == false) {
            alert('Oops! Internal error. Server says ' + t);
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
$(function () {
		setTimeout(function(){
			$(".ques_status").selectbox();},500);
		});