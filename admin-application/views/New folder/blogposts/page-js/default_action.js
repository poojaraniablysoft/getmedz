function searchPost(frm){
	var data = getFrmData(frm);
	showHtmlElementLoading($('#listing-div')); 
	callAjax(generateUrl('blogposts', 'listblogposts'), data, function(t){
	
		$('#listing-div').html(t);
	});
}

function listPages(p){
	var frm = document.paginateForm;
	frm.page.value = p;
	searchPost(frm);
}

$(document).ready(function(){
	searchPost(document.frmPostSearch);
});
  
function clearSearch() {
	document.frmPostSearch.reset();
	searchPost(document.frmPostSearch);
}