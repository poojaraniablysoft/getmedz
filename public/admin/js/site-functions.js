
function getFrmDataForUrl(frm, remove_el_arr) {

    if (remove_el_arr == undefined)
        remove_el_arr = [];

    if ($.browser.msie && parseInt($.browser.version, 10) === 8) { /* IE8 Not able create url, Make Sure JQ browser detection works if updating jquery  */
        var data = createIE8Arr($(frm).serialize());
    } else {
        var data = [];
        frm.each(function () {
            if ($(this).val() == '')
                return true;
            data.push($(this).attr('name'));
            data.push($(this).val());
        });
        if (remove_el_arr.length > 0) {
            $.each(remove_el_arr, function (key, value) {
                if (typeof value != typeof undefined) {
                    if (data.indexOf(value) > -1) {
                        data.splice(data.indexOf(value), 2);
                    }
                }
            });
        }
    }
    return data;
}
function generateUrl(model, action, others, use_root_url) {
    if (!use_root_url)
        use_root_url = userwebroot;
    if (url_rewriting_enabled == 1) {
        var url = use_root_url + model + '/' + action;
        if (others) {
            for (x in others)
                others[x] = encodeURIComponent(others[x]);
            url += '/' + others.join('/');
        }

        return url;
    }
    else {
        var url = use_root_url + 'index.php?url=' + model + '/' + action;
        if (others) {
            for (x in others)
                others[x] = encodeURIComponent(others[x]);
            url += '/' + others.join('/');
        }
        return url;
    }
}
function showHtmlElementLoading(el) {
    el.html('<img src="' + webroot + 'images/facebox/loading.gif" >');
}
$(document).ready(function(){
	
	setTimeout(function(){$(".div_error").fadeOut('1000')},10000);
	
	
});
