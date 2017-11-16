$(document).ready(function () {

    $("#add_attachment").click(function () {
        $("#fileupload").trigger('click');
    });
    $('input[name=fileupload]').change(function () {
        uploadFile();
    });
});