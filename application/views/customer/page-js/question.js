
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');

function uploadFile() {
    $('#uploadFileForm').ajaxSubmit({
        delegation: true,
        dataType: 'Json',
        beforeSend: function () {
            $("#file_progress").show();
         //   $(".progress-bar").css("width", "0%");
            $(".countvalue").text('0%');
            $(".up-btn").hide();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
          //  $(".progress-bar").css('width', percentVal);
            $(".countvalue").text(percentVal);
        },
        success: function (data) {
            $("#file_progress").hide();
            $(".up-btn").show();
            test = JSON.parse(data);
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
    var data = $(frm).serialize();
    showHtmlElementLoading($('#form-div'));
    var action = $(frm).attr('action');
    callAjax(action, data + '&outmode=html', function (t) {

        var resp = $.parseJSON(t);
        if (resp.status) {
            
            $('#response_table').find('tr:last').find('td').append(resp.response);
       //     $('html, body').animate({scrollTop: '0 px'}, 'slow');
            $('input[type=text],textarea').val('');
            $('.uploadedFiles').html('');
                    $('#msg_info').html(resp.msg);
        }else{
            
                $('#msg_info').html(resp.msg);
         
        }
        setTimeout(function(){
			$('.div_error').hide('slow', function() { $('.div_error').remove(); });
			$('.div_msg').hide('slow', function() { $('.div_msg').remove(); });
		}, 2000);	
        
    });
    return false;
}

function submitReviewSetup(frm, v){
	v.validate();
	if (!v.isValid()) return;
	$.mbsmessage('Processing....');
	var data = getFrmData(frm);
	die;
	//data += '&outmode=json';
	
	callAjax(generateUrl('customer', 'review_setup'), data, function(t){
		var ans = parseJsonData(t);
		//$(document).trigger('close.mbsmessage');
		if (ans == false){
			alert('Oops! Internal error. Server says ' + t);
			return;
		}
		if (ans.status == 0){
			$.facebox(ans.msg);
			return;
		}
		$.facebox(ans.msg);
		$(frm).find("input[type=text], textarea").val(""); /* Reset form */
		
	});
}

function updateQuestionStatus($question_id,$status){

	if( confirm("Are you sure you want to close this question") ){
		callAjax(generateUrl('question', 'updateQuestionStatus'), 'orquestion_id='+$question_id+'&orquestion_status='+$status, function(t){
			var ans = parseJsonData(t);
			$(document).trigger('close.mbsmessage');
			if (ans == false){
				alert('Oops! Internal error. Server says ' + t);
				return;
			}
			if (ans.status == 0){
				$.facebox(ans.msg);
				return;
			}else{
					
				  $('#rate_div').show();
			}
			
			$(frm).find("input[type=text], textarea").val(""); /* Reset form */
			
		});
	}else{
		return false;
	}
}