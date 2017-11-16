var SITE_URL = '';

$(document).ready(function () {
    setInterval(function () {
        $.get(generateUrl('home', 'udpate_activity'), function () {



        });
    }, 180000);
    
    $( "input[type=radio].custom_radio" ).parent().wrapInner("<label class='radio'></label>");
   $( "input[type=radio].custom_radio" ).after("<i class='input-helper'></i>");
   
   /******
   show upload file name in front of browse option
   ********/
   $('.filefield :input').change(function(){			
			$(this).prev('.filename').html(this.value);
		});
});
function callAjax(strURL, strPostData, thefunction) {
    if (callAjaxExecuting) {
        addToCallAjaxQ(strURL, strPostData, thefunction);
        return;
    }
    callAjaxExecuting = true;
    var xmlHttpReq = false;
    var self = this;
    var msg = "";
    // Mozilla/Safari

    var www = (window.location.href.toLowerCase().indexOf("//www.") > 0) ? "http://www." : "http://";
    var strURL = strURL.replace("http://", www);

    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.setRequestHeader('X-REQUESTED-WITH', 'xmlhttprequest');
    self.xmlHttpReq.onreadystatechange = function () {

        if (self.xmlHttpReq.readyState == 4)
        {
            callAjaxExecuting = false;
            if (self.xmlHttpReq.status != 200 && !userLeavingPage) {
                alert('OOPS! Connection Error.\nPlease Check your Internet Connection.');
                return;
            }
            if ($.trim(self.xmlHttpReq.responseText) == '{"status":0,"msg":"Your Session seems to have expired. Please try refreshing the page to login again."}') {
                alert('Your Session seems to have expired. Please try refreshing the page to login again.');
                thefunction('');
                return;
            }
            thefunction(self.xmlHttpReq.responseText);
            setTimeout('executeFromCallAjaxQ();', 5);
        }
        else
        {
            //alert(self.xmlHttpReq.readyState);
        }
    }

    self.xmlHttpReq.send(strPostData);
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
    el.html('<img src="' + webroot + 'images/facebox/loading.gif">');
}

function paginate(page) {
	

    if (!page)
        page = 1;


    var action = $('#paginateForm').attr('action');
	
    $('#paginateForm [name=page]').val(page);
	
    var str = $('#paginateForm').serialize();
	
    callAjax(action, 'outmode=html&' +
            str, function (t) {
				
                $('#listing-div').html(t);
            });


}
function pagination(page) {

    if (!page)
        page = 1;


    var action = $('#paginateForm').attr('action');
    $('#paginateForm [name=page]').val(page)
    var str = $('#paginateForm').serialize();
    callAjax(action, 'outmode=html&' +
            str, function (t) {
                $('.row').html(t);
            });


}
function hide_msg() {
    setTimeout(function () {
        $('.div_msg').hide("slow");
        $('.div_error').hide("slow");

    }, 6000);

}

function checkEmail(value) {
 
    var action=generateUrl('askquestion','checkUnique');
    var str = "email="+value;
    callAjax(action, 'outmode=json&' +
            str, function (t) {
            var ans = parseJsonData(t);
            $(document).trigger('close.mbsmessage');
            if (ans == false) {
                alert('Oops! Internal error. Server says ' + t);
                return;
            }
            if (ans.status == 0) {
                login_ajax();
                return;
            } else {
                return true;
            }
            });


}

function login_ajax(){
      var action=generateUrl('askquestion','login');
    var str = "";
     callAjax(action, 'outmode=html&' +
            str, function (t) {
                  $.facebox(t);
            }); 
  
}
