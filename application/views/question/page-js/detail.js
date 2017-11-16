
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');
   
function uploadFile(){
	$('#uploadFileForm').ajaxSubmit({ 
			delegation: true,
			dataType:'Json',
			beforeSend: function() {
			$(".progresscounter").show();
			$(".pbar").css("width","0%");
			$(".up-btn").hide();
			
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			$(".pbar").html(percentVal);
			
		},
		success: function(data) {
			$(".pbar").hide();
			$(".up-btn").show();
			test=JSON.parse(data);
			$(".uploaded_files").append('<li><input checked=checked type="checkbox" name="uploaded_files[]" value="'+test.msg[1]+'">'+test.msg[0]+'</li>');
			$fid= $("#uploaded_files_id").val();
			if($fid)
			$("#uploaded_files_id").val($fid+','+test.msg[1]);
			else
			$("#uploaded_files_id").val(test.msg[1]);
			if($fid || test.msg[1]>0){ $("#uploadedFiles").show();}
		},
   });
}
$(document).ready(function(){

$("#add_attachment").click(function(){$("#fileupload").trigger('click');});
$('input[name=fileupload]').change(function() {
  uploadFile(); 
});
});