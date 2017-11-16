<script> var str = "<?php echo $step;   ?>"; </script>
<div class="qst-block six-pg">


<?php echo render_block('QUESTION_POST_STEP6_HEADING');?>

  
    <?php
    $questionFrm->setExtra('style="display:none"');
    echo $questionFrm->getFormHtml();
    ?> 




    <input type="button" value="Continue" class="ask" name="" onclick="$('#frmQuestionForm').submit();">

    </form>
</div>
<script>
 function submitForm(){}
</script>