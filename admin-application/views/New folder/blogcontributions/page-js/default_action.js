function searchContributions(frm){
	var data = getFrmData(frm);
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('blogcontributions', 'list_contributions'), data, function(t){
		$('#listing-div').html(t);
	});
}

function listPages(p){
	var frm = document.paginateForm;
	frm.page.value = p;
	searchContributions(frm);
}

$(document).ready(function(){
	searchContributions(document.frmSearchContri);
});

function clearSearch() {
	document.frmSearchContri.reset();
	searchContributions(document.frmSearchContri);
}