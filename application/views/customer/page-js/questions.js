$(document).ready(function () {
	list();    

    $('a[rel=form]').on('click', function () {
        showHtmlElementLoading($('#form-div'));
        callAjax($(this).attr('href'), '', function (t) {
            $('#form-div').html(t);
            $('html, body').animate({scrollTop: $('#form-div').offset().top}, 'slow');
        });
        return false;
    });

    $(".cancel_search").on('click', function () {
        $(document.searchForm).find("input[type=text], select").val(""); /* Reset form */
        list();
    });
	 $('input[type=radio].star').rating();
	 $( '.click-btn' ).click(function() {
  			$( '.hidden-qst' ).show( 500 );
			//$( this ).toggleClass( 'read-less' );
		});
		 $('.nav-area >li').click(function () {
        var val = $(this).find('input:radio').attr('checked') ? false : true;
        $(this).find('input:radio').attr('checked', val);
        $('.nav-area >li>a').removeClass('active');
        $(this).find('a').addClass('active');
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
function submitsearch(frm) {
    
    var data = $('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('customer', 'listing'), data, function (t) {
        $('#listing-div').html(t);

    });
    return false;
}


function list(page) {
    if (!page)
        page = 0;
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('customer', 'listing'), 'page=' + page, function (t) {
        $('#listing-div').html(t);

    });
}

function submitStatesSetup(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
}



function disableQuestion(reply_id, mode, ref) {
    if (!reply_id)
        return;
    $.mbsmessage('Processing....');
    var data = 'reply_id=' + reply_id + '&mode=' + mode + '&outmode=json';
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

        var str = '';
        var page = $('.pagination').find('.selected>a').text();

        if (!page)
            page = 0;
        list(page)

    });
}


