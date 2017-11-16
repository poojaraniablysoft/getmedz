$(document).ready(function(){
	listCms();
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

});

function loadForm(cmsc_id){
	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('cms', 'form'), 'cmsc_id=' + cmsc_id + '&outmode=html', function(t){
		$('#form-div').html(t).scrollTo();
	});

}

function listCms(){	
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('cms', 'listing'), '', function(t){$('#listing-div').html(t);});
}

function submitCmsSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	
}
function disable(cmsc_id,mode,ref) {
	if(!cmsc_id) return;
	$.systemMessage.processing();
	var data='cmsc_id='+cmsc_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('cms', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans == false){
			$.systemMessage.error(t,true);		
			return;
		}
		if (ans.status == 0){
			$.systemMessage.error(ans.msg);		
			return;
		}
		
		var str = '';
                   var page = $('.pagination').find('.selected>a').text();

        if (!page)
            page = 0;
		listCms(page);
		$.systemMessage.success(ans.msg);	
		
	});
}

