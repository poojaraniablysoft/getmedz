$(document).ready(function () {
    list();
    $('.cancel_form').live('click', function () {
        loadForm();

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
        $(".cancel_form2").live('click', function () {
        $('#form-div').html('');
     
    });
});

function loadForm(id) {
    if (!id)
        id = 0;
    showHtmlElementLoading($('#form-div'));
    callAjax(generateUrl('transactions', 'form'), 'id=' + id + '&outmode=html', function (t) {
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
    callAjax(generateUrl('transactions', 'listing'), data, function (t) {
        $('#listing-div').html(t);

    });
    return false;
}
function list(frm) {



    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('transactions', 'listing'), '', function (t) {
        $('#listing-div').html(t);

    });
}

function submitsetup(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
}
function redirecttransactions()
{
    var loc = generateUrl('transactions', '');
    window.location.href = loc;
}


function edit(tran_id) {
    if (!tran_id)
        return;
    $.systemMessage.processing('Processing');
    var data = 'id=' + tran_id + '&outmode=json';
    callAjax(generateUrl('transactions', 'form'), data, function (t) {
       $.systemMessage.close();
        $('#form-div').html(t);
    });
}
