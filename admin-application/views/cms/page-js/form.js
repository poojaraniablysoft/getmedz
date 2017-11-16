
function submitCmsSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	
}
$(document).ready(function(){
	$("textarea").parent().removeClass('td_form_horizontal');
	$(".meta-text").parent().removeClass('td_form_horizontal');
});

