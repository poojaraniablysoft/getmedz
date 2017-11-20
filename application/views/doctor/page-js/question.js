
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');

function uploadFile() {
    $('#uploadFileForm').ajaxSubmit({
        delegation: true,
        dataType: 'Json',
        beforeSend: function () {
            $(".file_progress-js").show();
            $(".progress-bar-js").css("width", "0%");
            $(".countvalue-js").text('0%');
            $(".up-btn-js").hide();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            $(".progress-bar-js").css('width', percentVal);
            $(".countvalue-js").text(percentVal);
        },
        success: function (data) {
            $(".file_progress-js").hide();
            $(".up-btn-js").show();
            ans =data;
			if(ans.status==1){
				
				$(".uploaded_files").append('<li><label class="checkbox leftlabel"><input checked=checked onclick="remove_file(this);" type="checkbox" name="uploaded_files[]" value="' + ans.msg[1] + '">' + ans.msg[0] + '<i class="input-helper"></i></label></li>');
				$fid = $("#uploaded_files_id").val();
				if ($fid)
					$("#uploaded_files_id").val($fid + ',' + ans.msg[1]);
				else
					$("#uploaded_files_id").val(ans.msg[1]);
				if ($fid || ans.msg[1] > 0) {
					$("#uploadedFiles").show();
				}
			}
			else{
				$.systemMessage.error(ans.msg);
				
			}
			$("input[name=fileupload]").val('');
        },
    });
}
$(document).ready(function () {

    $(document).on('click','.attachment-js',function () {
        $("#fileupload").trigger('click');
    });
	$(document).on('change','input[name=fileupload]',function () {
    
        uploadFile();
    });
	$("textarea").parent().removeClass('td_form_horizontal');
	
});

function remove_file(obj) {
    if (!obj) {
        return false;
    }
    var $fid = $("#uploaded_files_id").val();
    var files = $fid.split(",");
    $.each(files, function (index, value) {
        if (value == $(obj).val()) {
            $(obj).parent().remove();
            files.splice(index, 1);
        }


    })
    $("#uploaded_files_id").val(files.join(","));

    return true;
}


function submitForm(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
    var data = $("#frmReplyForm").serialize();
    //showHtmlElementLoading($('#form-div'));
    var action = $("#frmReplyForm").attr('action');
	 $.systemMessage.processing();
    callAjax(action, data , function (t) {

        var resp = $.parseJSON(t);
        if (resp.status==1) {
			
			reply_id =resp.reply_id;
			
            $('.replies-js').append(resp.response);
       //     $('html, body').animate({scrollTop: '0 px'}, 'slow');
             var editors = oUtil.arrEditor;
			for (x in editors){					
				$('#idContent'+editors[x]).contents().find("body").html('');				
			}
            $('.uploaded_files').html('');
         //  $('html, body').animate({scrollTop:  $scrollTo.offset().top}, 'slow');
			 $.systemMessage.success(resp.msg);	
					
        }else{
            
                $.systemMessage.error(resp.msg);
         
        }
        
        
    });
    return false;
}
function loadform(id){

	if (!id) id=0;	
	//showHtmlElementLoading($('#form-div'));
		$('#reply-status').hide();
	callAjax(generateUrl('doctor', 'loadform'), 'id=' + id + '&outmode=html', function(t){
		$('#form-div').html(t);
                  
	});
}

function listQuestions($type=''){
	
	callAjax(generateUrl('doctor', 'listQuestions'), 'type=' + $type + '&outmode=html', function(t){
		$('#form-div').html(t);
                  
	});
}
