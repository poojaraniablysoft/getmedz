<?php echo Message::getHtml(); ?> 
<div id="basic_form" class="my-prof-block">
    <h1>Login </h1>
    <?php
    echo $customerfrm->getFormHtml();
    ?>
</div>

<script>
function submitlog(frm,v){
 v.validate();
	if (!v.isValid()) return false;
  

  
   var action = $('#frmCustomerLogin').attr('action');
 
    var str = $('#frmCustomerLogin').serialize();
  
    callAjax(action, 'outmode=json&' +
            str, function (t) {
               
            var ans = parseJsonData(t);
            $(document).trigger('close.mbsmessage');
            if (ans == false) {
                alert('Oops! Internal error. Server says ' + t);
                return false;
            }
           
            if (ans.status == 1) {
                $(document).trigger('close.facebox')
                window.location.reload();
                return false;
            } else {
                $('#validationsummary_frmCustomerLogin').html(ans.msg);
                   return false;
            }
              
              
             
            });
  return false;
  
}
</script>
