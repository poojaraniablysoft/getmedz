function CallPageTypePopulate($pageType = 0){
	if($pageType==0){
		$("#cms_page").parent().parent().show();
		$("#external_page").parent().parent().hide();
		$("#custom_html").parent().parent().hide();
		
	}else if($pageType==1){
		$("#cms_page").parent().parent().hide();
		$("#external_page").parent().parent().hide();
		$("#custom_html").parent().parent().show();
		
	}else if($pageType==2){
		$("#cms_page").parent().parent().hide();
		$("#external_page").parent().parent().show();
		$("#custom_html").parent().parent().hide();
		
	}
}