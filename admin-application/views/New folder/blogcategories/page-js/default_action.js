function searchBlogCatogries(frm) {
    var data = "";

    if (typeof (frm) != "undefined") {
        var data = getFrmData(frm);

    }
	
	data += "&category_parent=" + catId;
    showHtmlElementLoading($('#category-type-list'));
	
    callAjax(generateUrl('blogcategories', 'list_blog_categories'), data, function (t) {
        $('#listing-div').html(t);
    });
}

function listPages(p) {
    var frm = document.paginateForm;
    frm.page.value = p;
    searchBlogCatogries(frm);
}

$(document).ready(function () {
    searchBlogCatogries();
});

function clearSearch() {
    document.frmSearch.reset();
    searchBlogCatogries();
}