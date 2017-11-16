$(document).ready(function(){
	listSubscriptions();
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
        listSubscriptions();
    });
});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('subscriptions', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                  $('#tab_a_2').click();
	});

}
function submitsubscriptionsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('subscriptions', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listSubscriptions(frm){
	
		
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('subscriptions', 'listing'), '', function(t){
	$('#listing-div').html(t);
		
	});
}

function submitSubscriptionsetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectsubscriptions()
{
var loc=generateUrl('subscriptions','');
window.location.href=loc;
}


function disableSubscription(subs_id,mode,ref) {
	if(!subs_id) return;
	
	var data='subs_id='+subs_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('subscriptions', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans == false){
			alert('Oops! Internal error. Server says ' + t);
			return;
		}
		if (ans.status == 0){
			$(".msg_info").html(ans.msg);
			return;
		}
		
		var str = '';
		if(mode==1){
			mode = 0;
			
			$(ref).html('<i class="ion-checkmark icon active "></i>');
				str += 'Deactivate';
		}
		else {
			mode = 1;
			
			$(ref).html('<i class="ion-checkmark icon inactive"></i>');
	
                        	str += 'Activate';
		}
			
		$(ref).attr('onclick','if(confirm(\'Do you want to '+ str +' this listing?\'))disableSubscription('+subs_id+','+mode+',this);');
		$.systemMessage.success(ans.msg);	
	});
}
