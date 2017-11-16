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

function loadForm(block_id){
	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('blocks', 'form'), 'block_id=' + block_id + '&outmode=html', function(t){
		//alert(t);
		$('#form-div').html(t).scrollTo();
	});

}

function listCms(){	
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('blocks', 'listing'), '', function(t){$('#listing-div').html(t);});
}

function submitCmsSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	
}
function disable(block_id,mode,ref) {
	if(!block_id) return;
	$.systemMessage.processing('Processing');
	var data='block_id='+block_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('blocks', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans == false){
			
			$.systemMessage.error(t,true);
			return;
		}
		if (ans.status == 0){
			//$("#msg_info").html();
			$.systemMessage.error(ans.msg);
			return;
		}
		$.systemMessage.success(ans.msg);
		var page=$('.pagination').find('.selected>a').text();
                
                if(!page)page=0;
                
		listCms(page);
	});
}

