function handleFiles(obj, files) {
  var allowedFiles = $(obj).attr('accept');
    if (files) {

        for (var i = 0; i < files.length; i++) {
			 var name=files[i].name;
            var fileType = files[i].type;
            var name= name.split(".");
            var ext=name.pop();         
           // var fileType = files[i].type;
            if (allowedFiles.search(ext) < 0) {
                //reset the file
                $(obj).val('');
                alert('File Format not Allowed');
                return false;
            }

            var filename = files[i].name;

            readURL(obj)

        }
    }



}
function openFile(id) {


var element = document.getElementById('fileupload');
if(element.click){
 
    element.click();
}
else if(document.createEvent)
{
	var element = document.getElementById('fileupload');
    var eventObj = document.createEvent('MouseEvents');
    eventObj.initEvent('click',true,true);
    element.dispatchEvent(eventObj);
}
}
function readURL(input) {
    if (input.files && input.files[0]) {
		if(window.FileReader) {
		        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
		}

      
        //$('#frmpass').submit();
    }
}

