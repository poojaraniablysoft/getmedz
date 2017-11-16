$(document).ready(function(){
	listTemplates();
	$('.cancel_form').live('click',function(){
		$('#form-div').html('');
	});
});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('emailtemplates', 'form'), 'id='+id+'&outmode=html', function(t){
		$('#form-div').html(t).scrollTo();
	});
}

function listTemplates(page){
	if (!page) page=1;
	//if (frm.page) frm.page.value = page;
	//var data = getFrmData(frm);
	data = '';
	data += '&page=' + page;
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('emailtemplates', 'listing'), data, function(t){$('#listing-div').html(t);});
}

function submitEmailTemplatesSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	$.mbsmessage('Processing....');
	var data = getFrmData(frm);
	data += '&outmode=json';
	callAjax(generateUrl('emailtemplates', 'setup'), data, function(t){
		var ans = parseJsonData(t);
		$(document).trigger('close.mbsmessage');
		if (ans == false){
			alert('Oops! Internal error. Server says ' + t);
			return;
		}
		if (ans.status == 0){
			$.facebox(ans.msg);
			return;
		}
		$('#form-div').html(ans.msg);
		listTemplates();
	});
}
