function UpdateBannerStatus(id, el) {
	
	callAjax(generateUrl('banners', 'update_banner_status'), 'id=' + id, function(t){
		var ans = parseJsonData(t);
		if (ans === false){
			$.mbsmessage('<div class="div_error failure">Oops! There is some Error.</div>');
			//ShowJsSystemMessage('<div class="div_error failure">Oops! There is some Error.</div>')
			return false;
		}
		//alert(ans.msg);
		$.systemMessage.success(ans.msg);
		if(ans.status == 0) {
			return false;
		}
		
		
		if ($(el).children('i').hasClass('ion-checkmark icon inactive')) {
			 
			$(el).children('i').removeClass('ion-checkmark icon inactive').addClass('ion-checkmark icon active');
		}else {
			$(el).children('i').removeClass('ion-checkmark icon active').addClass('ion-checkmark icon inactive');
		}	
	});
}
function ConfirmBannerDelete(id, el) {
	var sure = confirm('Are you sure you want to delete this?');
    if (!sure) {
      return;
	}
	callAjax(generateUrl('banners', 'delete'), 'id=' + id, function(t){
		var ans = parseJsonData(t);
		if (ans === false){
			$.systemMessage.error(t,true);
			return false;
		}
		$.systemMessage.error(ans.msg);
		if(ans.status == 0) {
			return false;
		}$.systemMessage.success(ans.msg);	
		$(el).closest("tr").remove()
		
	});
}
