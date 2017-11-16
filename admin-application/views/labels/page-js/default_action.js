$(document).ready(function() {
	var href=generateUrl("labels", "updateLabelField");
	$('div.editmessage').click(function() {
        var lang=$(this).data('lang');
        var id=$(this).data('labelid');
		$(this).editable(href, {
			loadurl  : generateUrl('labels', 'getlabelcontent', [id, lang], userwebroot),
			submit    : 'OK',
			type      : 'textarea',
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			rows: 5,
			cols: 100,
			cssclass : 'web_form'
		});
	 
	}); 

});

 $(".cancel_search").live('click', function () {
        $(document.frmSearchLabels).find("input[type=text], select").val(""); /* Reset form */
        searchLabels(document.frmSearchLabels);
    });
	
function submitSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	data= $(frm).serialize();
	callAjax(generateUrl('labels', 'setup'), data, function(t){
			var ans = parseJsonData(t);
			if(t.status==1)
		$.systemMessage.success(ans.msg);	
	else
		$.systemMessage.error(ans.msg);
		searchLabels(document.frmSearchLabels);
	});
	return false;
}
function searchLabels(frm){
	var data = getFrmData(frm);
	showHtmlElementLoading($('#listing-div')); 
	callAjax(generateUrl('labels', 'listing'), data, function(t){
		$('#listing-div').html(t);
	});
}
function listLabels(p){
	var frm = document.paginateForm;
	if(frm)
	frm.page.value = p;
	searchLabels(frm);
}
$(document).ready(function(){
		searchLabels(document.frmSearchLabels);
});


function loadForm(id){
	if (!id) {
		return
	}
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('labels', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
        $('#tab_a_2').click();
	});

}