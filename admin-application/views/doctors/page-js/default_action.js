$(document).ready(function(){
	listDoctors();
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
        listDoctors();
    });
	

});

function loadForm(id){
	if (!id) id=0;	
	showHtmlElementLoading($('#form-div'));
	callAjax(generateUrl('doctors', 'form'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                 $('#tab_a_2').click();
	});

}
function submitsearch(frm, v){
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
    showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('doctors', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
    return false;
}
function listDoctors(page){
	if(!page) page=0;
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('doctors', 'listing'), 'page='+page, function(t){
	$('#listing-div').html(t);
		
	});
}

function submitSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
}
function redirectDoctors()
{
var loc=generateUrl('doctors','');
window.location.href=loc;
}


function disableDoctor(doctor_id,mode,ref) {
	if(!doctor_id) return;
	$.systemMessage.processing();
	var data='doctor_id='+doctor_id+'&mode='+mode+'&outmode=json';
	callAjax(generateUrl('doctors', 'change_listing_status'), data, function(t){
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
     	var page=$('.pagination').find('.selected>a').text();
        if(!page)page=0;                
		listDoctors(page);
		$.systemMessage.success(ans.msg);	
		
	});
}
$(".reset_form").click(function(){alert("DD");})

submitImage = function(){
	
		$('#uploadFileForm').ajaxSubmit({ 
			delegation: true,
			 beforeSubmit:function(){
					
				$.systemMessage.processing();
						}, 
			success:function(json){
				ans = $.parseJSON(json);
				
				if(ans.status == "1"){
					$('#user_profile_photo').attr('src',$('#user_profile_photo').attr('src')+'?'+Math.random()) ;
				
					$.systemMessage.success(ans.msg);			
				}
				else{
					$.systemMessage.error(ans.msg);
				}
			}
		}); 
	 
	 }