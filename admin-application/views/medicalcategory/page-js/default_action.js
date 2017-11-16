$(document).ready(function () {
    listMedicalCategory();
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
        listMedicalCategory();
    });
	

});

function loadForm(id) {
    if (!id)
        id = 0;
    showHtmlElementLoading($('#form-div'));
    callAjax(generateUrl('medicalcategory', 'form'), 'id=' + id + '&outmode=html', function (t) {
        $('#form-div').html(t);
        $('#tab_a_2').click();
		$('html, body').animate({scrollTop: $('#form-div').offset().top}, 'slow');
    });

}

function listMedicalCategory(page) {


    if (!page)
        page = 0;
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('medicalcategory', 'listing'), 'page=' + page, function (t) {
        $('#listing-div').html(t);
        //Table DND call
        /* $('#faqCattbl').tableDnD({
         onDrop: function(table, row) {
         
         var order = $.tableDnD.serialize('id');
         callAjax(generateUrl('medicalcategory', 'reorderFaqCategoryList'), order, function(t){
         $.mbsmessage('Reordering Update!',true);	
         });				
         }
         });  */

    });
}

function submitMedicalCategorySetup(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
}
function redirectMedicalCategory()
{
    var loc = generateUrl('medicalcategory', '');
    window.location.href = loc;
}
function submitsearch(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
    var data = $('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('medicalcategory', 'listing'), data, function (t) {
        $('#listing-div').html(t);

    });
    return false;
}

function disableCategory(category_id, mode, ref) {
    if (!category_id)
        return;
    
    var data = '&category_id=' + category_id + '&mode=' + mode + '&outmode=json';
    callAjax(generateUrl('medicalcategory', 'change_listing_status'), data, function (t) {
        var ans = parseJsonData(t);
        $(document).trigger('close.mbsmessage');
        if (ans == false) {
           $.systemMessage.error(t,true);
            return;
        }
        if (ans.status == 0) {
           $.systemMessage.error(ans.msg);
            return;
        }

        var str = '';
        var page = $('.pagination').find('.selected>a').text();

        if (!page)
            page = 0;
        $.systemMessage.success(ans.msg);	
        listMedicalCategory(page)

    });
}
