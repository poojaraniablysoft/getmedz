$(document).ready(function(){
	listreviews();
	$('.cancel_form').live('click',function(){
	$(".tabs_nav_container").hide();
	$("#form-div").html('');
		//loadForm();
              
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
        listreviews();
    });
});

function loadForm(id){
	if (!id) id=0;	
	$(".tabs_nav_container").show();
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('reviews', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                  $('#tab_a_1').click();
                  	$('html, body').animate({scrollTop: $('#form-div').offset().top-$('#header').height()}, 'slow');
	});

}
function submitreviewssearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('reviews', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listreviews(page){
	
		if(!page) page=0;
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('reviews', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitreviewsSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectdegrees()
{
var loc=generateUrl('degrees','');
window.location.href=loc;
}


function disablereviews(review_id,mode,ref) {
	if(!review_id) return;
	$.mbsmessage('Processing....');
	var data='review_id='+review_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('reviews', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		$(document).trigger('close.mbsmessage');
		if (ans == false){
			alert('Oops! Internal error. Server says ' + t);
			return;
		}
		if (ans.status == 0){
			$("#msg_info").html(ans.msg);
			return;
		}
		var page=$('.pagination').find('.selected>a').text();
                
                if(!page)page=0;
                
		listdegrees(page);
	});
}
