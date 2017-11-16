function searchTestimonials(frm){
	var data = getFrmData(frm);
	showHtmlElementLoading($('#listing-div')); 
	callAjax(generateUrl('testimonials', 'list_testimonials'), data, function(t){
		$('#listing-div').html(t);
	});
}
function listPages(p){
	var frm = document.paginateForm;
	if(frm)
	frm.page.value = p;
	searchTestimonials(frm);
}
$(document).ready(function(){
		searchTestimonials(document.frmSearchTestimonials);
});
  
function clearSearch() {
	document.frmSearchTestimonials.reset();
	$("#frmSearchTestimonials input[type=hidden]").val("");
	searchTestimonials(document.frmSearchTestimonials);
}
function ConfirmDelete(id, el) {
	var sure = confirm('Are you sure you want to delete this?');
    if (!sure) {
      return;
	}
	callAjax(generateUrl('testimonials', 'delete'), 'id=' + id, function(t){
		var ans = parseJsonData(t);
		if (ans === false){
			//$.mbsmessage('<div class="div_error failure">Oops! There is some Error.</div>');
			$.mbsmessage('Oops! There is some Error');
			return false;
		}
		$.mbsmessage(ans.msg);
		if(ans.status == 0) {
			return false;
		}
		searchTestimonials(document.frmSearchTestimonials);
	});
}

function disable(testimonial_id,mode,ref) {
	if(!testimonial_id) return;
	$.systemMessage.processing();
	var data='testimonial_id='+testimonial_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('testimonials', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);		
		if (ans == false){
			$.systemMessage.error(t,true);
			return;
		}
		if (ans.status == 0){
			$.systemMessage.error(ans.msg);	
			return;
		}
		$.systemMessage.success(ans.msg);	
		var str = '';
     	var page=$('.pagination').find('.selected>a').text();
                
         if(!page)page=0;
                
		listPages(page);
		
	});
}