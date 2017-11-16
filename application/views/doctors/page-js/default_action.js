
$(document).ready(function(){
	$('.js-medicalField__divisions').slick({
  dots: false,
  infinite: false,
  speed: 300,
  cssEase: 'linear',
  slidesToShow: 8,
  slidesToScroll: 1,
  autoplay:false,
  variableWidth:true,
  draggable:false,
  prevArrow: '<a data-role="none" class="slick-prev btn--arrow btn--prev" aria-label="next"><img src="/images/fixed/singlenext-arrow.svg" alt=""></a>',
  nextArrow: '<a data-role="none" class="slick-next  btn--arrow btn--next" aria-label="next"><img src="/images/fixed/singlenext-arrow.svg" alt=""></a>',
  arrows:true,
 adaptiveHeight: true,
   responsive: [
    {
      breakpoint: 1050,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        dots: false,
		 infinite: false,
		draggable:true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
		 infinite: false,
		draggable:true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		 infinite: false,
		draggable:true,
		variableWidth:false
		
      }
    }
   
  ]
  
});
	listing(1);
});
 function listing(page,postdata='')
 {
	
	 //var data=$('#searchForm').serialize();
	 if(!page) page=1;
	 var data = '';
	 data = data+"page="+page;
   
	
	 var category=$('.medicalField__content a.selected').attr('id');
	 
    if (typeof category != 'undefined'  )
		data=data+"&doctor_med_category="+category;
	
	 var sort_by =  $( "#sort_by").val();
		 
    if (typeof(sort_by) != "undefined"){
			
			data = data+"&sort_order="+sort_by;
	}
	if(postdata != '')
	{
		data = data+'&'+postdata;
	}
	else
	{
		var postdata=$('#searchForm').serialize();
		data = data+'&'+postdata;
	}
	
	showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('doctors', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	});
	 
		 
	 
 }
 function select_sort_by(val)
 {
	
	 listing();
 }
 function submitsearch(frm, v){
	 
  v.validate();
	if (!v.isValid()) return;
     var data=$('#searchForm').serialize();
	 
	 listing(1,data);
    /* showHtmlElementLoading($('#listing-div'));
	callAjax(generateUrl('doctors', 'listing'),data, function(t){
	$('#listing-div').html(t);
		
	}); */
    return false;
}