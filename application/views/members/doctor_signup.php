<?php echo Message::getHtml(); ?>
<div id="basic_form" class="steps">
    <?php echo $basic_details->getFormHtml(); ?>
</div>

<div id="addressForm" style="display:none" class="steps">
    <?php echo $address_details->getFormHtml(); ?>
</div>



<script>

    function doc_next_form(v) {

        v.validate();
        if (!v.isValid())
            return false;

        displayForm("addressForm");

        return false;
    }

    function displayForm(id) {

        $('.steps').hide();
        $('#' + id).show();

    }

    function do_prev_form() {
        displayForm("basic_form");
    }

    function submitSetup( v) {
        
       
        v.validate();
        if (!v.isValid())
            return;
        var parmas = $('#frm_mbs_id_FrmDoc').serializeArray();

        var formID="frm_mbs_id_FrmDoc2";
        $.each(parmas, function (index, value) {

            appendToForm(formID, value);

        })


         $('#'+formID).submit();


    }





    function appendToForm(fromId, obj) {

        var input = document.createElement("input");

        input.setAttribute("type", "hidden");

        input.setAttribute("name", obj['name']);

        input.setAttribute("value", obj['value']);

        document.getElementById(fromId).appendChild(input);

    }


</script>