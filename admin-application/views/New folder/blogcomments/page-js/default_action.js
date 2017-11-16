function searchPost(frm){
	var data = getFrmData(frm);
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('blogcomments', 'list_comments'), data, function(t){
		$('#listing-div').html(t);
	});
}

function listPages(p){
	var frm = document.paginateForm;
	frm.page.value = p;
	searchPost(frm);
}

$(document).ready(function(){
	searchPost(document.frmComment);
});

function clearSearch() {
	document.frmComment.reset();
	searchPost(document.frmComment);
}