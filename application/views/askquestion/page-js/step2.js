$(document).ready(function(){
	
	$(".prev-js").click(function(){
		
		$prevStep = $("#frmQuestionForm input[name=step]").val()-1;
		if($prevStep ==1){
			
			$("#frmQuestionForm").attr('action','');
			$("#frmQuestionForm").submit();
		}
		
	});
});