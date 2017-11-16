function CallPageTypePopulate()
{
	var st=$('#nl_type').val();
	$('#cms_page,#external_page,#custom_html').removeAttr('disabled', '');
	if (st=="0")
			$('#external_page,#custom_html').attr('disabled', 'true');
	else if (st=="1")
			$('#cms_page,#external_page').attr('disabled', 'true');
	else if (st=="2")
			$('#cms_page,#custom_html').attr('disabled', 'true');
	else 
	{
		
	}
}


function removeBulletImage(val)
{
	removeBulltImage(val,'hiddenimage','editimagediv');
}

function removeBulltImage(val,hiddenimage,divtoedit)
{
if(confirm('Do you really want to remove this Image?'))
{
	var file=document.getElementById(hiddenimage).value;
	$(document).ready(function()
	{
		var dataString = 'val='+ val+'&file='+file;
		$.ajax
		(	
		 {
			type: "POST",
			url: "remove_bullet_image.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				document.getElementById(divtoedit).innerHTML='';
			}
		});
	});
}
}


function saveDisplayOrder(Id, txtObj, divName )
	 {
		var newValue = txtObj.value;
			
		if(!checkNumericORFloat(newValue))
		{
		   alert("Please Enter Numeric or fractional Value !!");
		   txtObj.value=""; txtObj.focus();	   
		} 
		else
		{
		   //newValue = parseInt(newValue);
    		 callAjax('viewnavigationpages-ajax.php', 'id='+Id+'&val='+newValue, function(t)
			{
			 msg=t;
				document.getElementById(divName).innerHTML=t;
			});
					
		}	 
	 }

function checkNumericORFloat( value )
{
	if(value>=1){
		  // var pat=/(^\d+$)|(^\d+\.\d+$)/  
		  var pat=/(^\d+$)/ 
		  
		  var intFlag = 0;
		   
		  if (pat.test(value)){
			  intFlag=1;
			  return true;
		  }	  
		  
		  if(intFlag==0){
				if (/\./.test(value)) {
					var myval = value.split('.');
					if(myval[0]!='undefined' && myval[0]!='' && myval[1]!='undefined' && myval[1]!=''){
						if(checkNumericORFloat(myval[0]) && checkNumericORFloat(myval[1])){
							return true;
						}	
					}else{
						return false;
					}
				} else {
		
					return false;
		
				}
		  }
	}else{
		return false;
	}	  
	  
	  return false;   
}
	 
