$(document).ready(function(){
	listdegrees();
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
        listdegrees();
    });
});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('degrees', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                  $('#tab_a_2').click();
				  $('html, body').animate({scrollTop: $('#form-div').offset().top-$('#header').height()}, 'slow');
	});

}
function submitdegreesearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('degrees', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listdegrees(page){
	
		if(!page) page=0;
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('degrees', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitdegreeSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectdegrees()
{
var loc=generateUrl('degrees','');
window.location.href=loc;
}


function disabledegree(degree_id,mode,ref) {
	if(!degree_id) return;
	
	var data='degree_id='+degree_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('degrees', 'change_listing_status'), data, function(t){
		var ans = parseJsonData(t);
		
		if (ans == false){
			$.systemMessage.error(t,true);	
			return;
		}
		if (ans.status == 0){
			$.systemMessage.error(ans.msg);
			return;
		}
		var page=$('.pagination').find('.selected>a').text();
                
                if(!page)page=0;
                $.systemMessage.success(ans.msg);	
		listdegrees(page);
	});
}
