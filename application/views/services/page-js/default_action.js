$(document).ready(function () {
    listMedicalServices();
    
	

});



function listMedicalServices(page) {


    if (!page)
        page = 0;
    showHtmlElementLoading($('#listing-div'));
    callAjax(generateUrl('services', 'listing'), 'page=' + page, function (t) {
        $('#listing-div').html(t);
		
		      

    });
}
