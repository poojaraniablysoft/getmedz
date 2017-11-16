$(document).ready(function(){
	listStates();
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
        listStates();
    });

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('states', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                 $('#tab_a_2').click();
				 $('html, body').animate({scrollTop: $('#form-div').offset().top}, 'slow');
	});

}
function submitsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('states', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listStates(page){
	
		
	if (!page)
        page = 0;
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('states', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitStatesSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectStates()
{
var loc=generateUrl('states','');
window.location.href=loc;
}


function disableState(state_id,mode,ref) {
	if(!state_id) return;

	var data='state_id='+state_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('states', 'change_listing_status'), data, function(t){
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
		$.systemMessage.success(ans.msg);	
listStates(page)
		
	});
}
