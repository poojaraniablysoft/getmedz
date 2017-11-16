$(document).ready(function(){
	listFaqCategory();
	$('.cancel_form').live('click',function(){
		$('#form-div').html('');
	});	
	
	$('a[rel=form]').live('click', function(){
        showHtmlElementLoading($('#form-div'));
        callAjax($(this).attr('href'), '', function(t){
            $('#form-div').html(t);
            $('html, body').animate({ scrollTop: $('#form-div').offset().top }, 'slow');
        });
        return false;
    });
	
	setInterval(function(){ 
		$('.div_msg').hide("slow");
		$('.div_error').hide("slow");
	}, 10000);

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('faqcategory', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t).scrollTo();
	});

}

function listFaqCategory(frm){
	
		
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('faqcategory', 'listing'), '', function(t){
	$('#listing-div').html(t);
	//Table DND call
	$('#faqCattbl').tableDnD({
			onDrop: function(table, row) {
				
				var order = $.tableDnD.serialize('id');
				callAjax(generateUrl('faqcategory', 'reorderFaqCategoryList'), order, function(t){
					$.mbsmessage('Reordering Update!',true);	
				});				
			}
		}); 
		
	});
}

function submitFaqSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectFaq()
{
var loc=generateUrl('faq','');
window.location.href=loc;
}


