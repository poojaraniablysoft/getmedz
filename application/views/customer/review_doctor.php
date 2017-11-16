

        <div class="admin-cont-area"> 

            <div class="your-doc-block">
                <h2>Your <span>Doctor </span> </h2>
                <div class="left">
                    <p class="img"><img src="<?php echo generateUrl('image', 'getDoctorProfilePic', array(intval($question['doctor_id']), 139, 113), "/") ?>" alt=""></p>
                    <p> 
                        
                        <?php echo $question['doctor_name']?><br> Professional </p>
                </div>
                <div class="right" style="width:auto">
              
                    <?php echo $frm->getFormHtml() ?>
                </div>
            </div>  
            
        </div>
   
<script>
    
    function submitReviewSetup(frm, v) {
		
    v.validate();
    if (!v.isValid())
	{
        return;
	}
	
    //$.mbsmessage('Processing....');
    var data = getFrmData(frm);
    //data += '&outmode=json';

    callAjax(generateUrl('customer', 'review_setup'), data, function (t) {
        var ans = parseJsonData(t);
		
		console.log(ans);
        $(document).trigger('close.mbsmessage');
        if (ans == false) {
            alert('Oops! Internal error. Server says ' + t);
            return;
        }
        if (ans.status == 0) {
            $.facebox(ans.msg);
            return;
        }
        $.facebox(ans.msg);
        refreshReviewPage();
        $(frm).find("input[type=text], textarea").val(""); /* Reset form */

    });
}

function refreshReviewPage(){
    
    setTimeout(function(  ){   window.location.reload();},3000);
}
$(document).ready(function(){
    
    $('input[type=radio].star').rating();
    
})
    
</script>

