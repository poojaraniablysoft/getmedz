$(document).ready(function(){
	list();
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
	callAjax(generateUrl('countries', 'form'), 'id=' + id + '&outmode=html', function(t){
        $('#form-div').html(t).scrollTo();
	});

}

function list(frm){
	
		
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('countries', 'listing'), '', function(t){
	$('#listing-div').html(t);
		
	});
}

function submitSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirect()
{
var loc=generateUrl('countries','');
window.location.href=loc;
}



