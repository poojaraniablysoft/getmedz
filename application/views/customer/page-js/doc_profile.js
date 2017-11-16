$(document).ready(function(){
    
    $('input[type=radio].star').rating();
    
})
    



function Reply(question_id) {

    var question_id = question_id | 0;
    var url = generateUrl('customer', 'replies');

    var fetch_replies = function () {

        if (!question_id) {
            return false;
        }

        data = 'question_id=' + question_id;
        callAjax(url, data + '&outmode=html', function (t) {

            $('#question_reply').html(t);
        });


    }


    return  {fetch_replies: fetch_replies};

}


var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');
/* 
function uploadFile() {
    $('#uploadFileForm').ajaxSubmit({
        delegation: true,
        dataType: 'Json',
        beforeSend: function () {
            $("#file_progress").show();
            $(".progress-bar").css("width", "0%");
            $(".countvalue").text('0%');
            $(".up-btn").hide();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            $(".progress-bar").css('width', percentVal);
            $(".countvalue").text(percentVal);
        },
        success: function (data) {
            $("#file_progress").hide();
            $(".up-btn").show();
            test = data;
            $(".uploaded_files").append('<li><input checked=checked onclick="remove_file(this);" type="checkbox" name="uploaded_files[]" value="' + test.msg[1] + '">' + test.msg[0] + '</li>');
            $fid = $("#uploaded_files_id").val();
            if ($fid)
                $("#uploaded_files_id").val($fid + ',' + test.msg[1]);
            else
                $("#uploaded_files_id").val(test.msg[1]);
            if ($fid || test.msg[1] > 0) {
                $("#uploadedFiles").show();
            }
        },
    });
}
$(document).ready(function () {

    $("#add_attachment").click(function () {
        $("#fileupload").trigger('click');
    });

    $('input[name=fileupload]').change(function () {
        uploadFile();
    });
});
 */
 
 
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
            test =data;
            $(".uploaded_files").append('<li><label class="checkbox leftlabel"><input checked=checked onclick="remove_file(this);" type="checkbox" name="uploaded_files[]" value="' + test.msg[1] + '">' + test.msg[0] + '<i class="input-helper"></i></label></li>');
            $fid = $("#uploaded_files_id").val();
            if ($fid)
                $("#uploaded_files_id").val($fid + ',' + test.msg[1]);
            else
                $("#uploaded_files_id").val(test.msg[1]);
            if ($fid || test.msg[1] > 0) {
                $("#uploadedFiles").show();
            }
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
            $('.uploadedFiles').html('');
         //  $('html, body').animate({scrollTop:  $scrollTo.offset().top}, 'slow');
			 $.systemMessage.success(resp.msg);	
					
        }else{
            
                $.systemMessage.error(resp.msg);
         
        }
        
        
    });
    return false;
}/* 
function submitForm(frm, v) {
    v.validate();
    if (!v.isValid())
        return;
    var data = $(frm).serialize();
    showHtmlElementLoading($('#form-div'));
    var action = $(frm).attr('action');
    callAjax(action, data + '&outmode=html', function (t) {

        var resp = $.parseJSON(t);
        if (resp.status) {

            RepliesObj.fetch_replies();
            //     $('html, body').animate({scrollTop: '0 px'}, 'slow');
            $('input[type=text],textarea').val('');
            $('.uploadedFiles').html('');
            $('#msg_info').html(resp.msg);
        } else {

            $('#msg_info').html(resp.msg);

        }
        setTimeout(function () {
            $('.div_error').hide('slow', function () {
                $('.div_error').remove();
            });
            $('.div_msg').hide('slow', function () {
                $('.div_msg').remove();
            });
        }, 2000);

    });
    return false;
} */



function updateQuestionStatus($question_id, $status) {
 
    if (confirm("Are you sure you want to close this question")) {
        callAjax(generateUrl('question', 'updateQuestionStatus'), 'orquestion_id=' + $question_id + '&orquestion_status=' + $status, function (t) {
            var ans = parseJsonData(t);
            $(document).trigger('close.mbsmessage');
            if (ans == false) {
                alert('Oops! Internal error. Server says ' + t);
                return;
            }
            if (ans.status == 0) {
                $.facebox(ans.msg);
                return;
            } else {
                    reviewDoctor($question_id);
              // $('#rate_div').show();
            }

        //    $(frm).find("input[type=text], textarea").val(""); /* Reset form */

        });
    } else {
        return false;
    }
}