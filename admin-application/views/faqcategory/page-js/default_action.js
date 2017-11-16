$(document).ready(function(){
	listfaqCategory();
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
        listfaqCategory();
    });

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('faqcategory', 'form'), 'id=' + id + '&outmode=html', function(t){
		
				var editors = oUtil.arrEditor;
				for (x in editors){
					eval('delete window.' + editors[x]);							
				}			
				oUtil.arrEditor = [];
			
		$('#form-div').html(t);
        $('#tab_a_2').click();
	});

}

function listfaqCategory(frm){
	
		
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('faqcategory', 'listing'), '', function(t){
	$('#listing-div').html(t);
		
	});
}
function submitsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('faqcategory', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function submitcategorySetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectcategory()
{
var loc=generateUrl('faqcategory','');
window.location.href=loc;
}


function disableCategory(faqcat_id,mode,ref) {
	if(!faqcat_id) return;
	$.systemMessage.processing();
	var data='faqcat_id='+faqcat_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('faqcategory', 'change_listing_status'), data, function(t){
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
		if(mode==1){
			mode = 0;
			$.systemMessage.success(ans.msg);	
			$(ref).html('<i class="ion-checkmark icon active "></i>');
			str += 'Activate';
		}
		else {
			mode = 1;
			$.systemMessage.success(ans.msg);
			$(ref).html('<i class="ion-checkmark icon inactive"></i>');
			str += 'Deactivate';
		}
			
		$(ref).attr('onclick','if(confirm(\'Do you want to '+ str +' this listing?\'))disableCategory('+faqcat_id+','+mode+',this);');
		
	});
}
