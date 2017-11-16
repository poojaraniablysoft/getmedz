function checkEmail(obj) {

  
    var action=generateUrl('askquestion','checkUnique');
    var str = "email="+$(obj).val();
    callAjax(action, 'outmode=json&' +
            str, function (t) {
            var ans = parseJsonData(t);
            $(document).trigger('close.mbsmessage');
            if (ans == false) {
                alert('Oops! Internal error. Server says ' + t);
                return;
            }
            if (ans.status == 0) {
                $(obj).val('');
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
