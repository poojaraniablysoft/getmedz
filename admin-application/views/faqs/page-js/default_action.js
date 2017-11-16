$(document).ready(function(){
	listFaqs();
	$('.cancel_form').live('click',function(){
		loadForm();
	});	
	
	$('a[rel=form]').live('click', function(){
        showHtmlElementLoading($('#form-div'));
        callAjax($(this).attr('href'), '', function(t){
            $('#form-div').html(t);
            $('html, body').animate({ scrollTop: $('#form-div').offset().top }, 'slow');
        });
        return false;
    });
   $(".cancel_search").live('click', function () {
        $(document.searchForm).find("input[type=text], select").val(""); /* Reset form */
        listFaqs();
    });

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('faqs', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                  $('#tab_a_2').click();
	});

}
function submitsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('faqs', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listFaqs(page){
	
		
	if(!page) page=0;
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('faqs', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitFaqsSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectStates()
{
var loc=generateUrl('faqs','');
window.location.href=loc;
}


function disableFaq(faq_id,mode,ref) {
	if(!faq_id) return;
	
	var data='faq_id='+faq_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('faqs', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		$(document).trigger('close.mbsmessage');
		if (ans == false){
			$.systemMessage.error(t,true);
			return;
		}
		if (ans.status == 0){
			$.systemMessage.error(ans.msg);
			return;
		}
		
		var str = '';
		var page=$('.pagination').find('.selected>a').text();
        if(!page)page=0;
          $.systemMessage.success(ans.msg);	      
		listFaqs(page);
		
	});
}
