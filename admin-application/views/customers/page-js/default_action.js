$(document).ready(function(){
	list();
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
        list();
    });

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('customers', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
        $('#tab_a_2').click();
	});

}
function submitsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('customers', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function list(page){
	if(!page) page=0;
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('customers', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectDoctors()
{
var loc=generateUrl('customers','');
window.location.href=loc;
}


function disable(user_id,mode,ref) {
	if(!user_id) return;
	$.systemMessage.processing();
	var data='user_id='+user_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('customers', 'change_listing_status'), data, function(t){
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
                
		list(page);
		
	});
}
$(".reset_form").click(function(){alert("DD");})