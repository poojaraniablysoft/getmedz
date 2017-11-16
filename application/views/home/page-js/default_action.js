$(document).ready(function () {
    $('.med-tabs-navigation >li').click(function () {		
        $(this).find('input:radio').prop('checked', true).change();
        $(this).find('a').addClass('selected');
    });
    setInterval(function () {
        $.get(generateUrl('home', 'get_udpates'), function (t) {

            if ($('#doc_count')) {
                var resp = $.parseJSON(t);
                $('#doc_count').text(resp.docs);
            }

        });
    }, 60000)

/**/

$('.js-testimonial--slider').slick({
  dots: true,
  infinite: true,
  speed: 300,
  cssEase: 'linear',
  slidesToShow: 1,
  autoplay:true,
  adaptiveHeight: true,
  prevArrow: '<a data-role="none" class="slick-prev btn--arrow btn--next" aria-label="next"><img src="images/fixed/next-arrow.svg" alt=""></a>',
  nextArrow: '<a data-role="none" class="slick-next  btn--arrow btn--prev" aria-label="next"><img src="images/fixed/next-arrow.svg" alt=""></a>'
});

$('.js-slider--client').slick({
  dots: false,
  infinite: true,
  speed: 300,
  cssEase: 'linear',
  slidesToShow: 5,
  autoplay:true,
  arrows:false,
  adaptiveHeight: true,
   responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
   
  ]
  
});
// Standard Modal
$('.modaal-inline-content').modaal({
	
			type: 'inline',
			accessible_title: 'Modal title',
			before_open: function() {
				//console.log('log before open');
			},
			before_close: function() {
				//console.log('log before close');
			},
			after_open: function() {
				//console.log('log after open');
			},
			after_close: function() {
				//console.log('log after close');
			},
			should_open: function () {
				//console.log('just checking to see if we should open');
				return true;
			}
		});
		
	
$(".ask_question").click(function() {	
    $('html,body').animate({
        scrollTop: $("#ask-doc").offset().top},
        'slow');
});	

$(document).ready(function(){
	var teamSelector = '.doctors_list li';

	$(teamSelector).on('click', function(){
		rel = $(this).attr('rel');
		if(rel){			
			$('.team__item').removeClass('selected');
			$(this).addClass('selected');			
			$('.team__doctors-intro').removeClass('active');			
			$('.'+rel).addClass('active'); 
		}else{
			$.systemMessage.processing();
			window.location.href=$(this).find('a').attr('href');
		}
		
		
	});
});



/*function doctorSelection(doctor_id) {

	alert("doctors_list");
    $('.doctors_list).removeClass('selected');
    $('.item__'+doctor_id).addClass('selected');
	rel = $(this).attr('rel');
	console.log(rel);
	$('.team__doctors-intro').removeClass('active');
	$('.'+rel).addClass('active');


 
	
	
}	
*/


});

function getAnswer(){
	 $("html, body").animate({ scrollTop: $(".med--tabs__content").offset().top}, "slow");
	 $("#orquestion_question").focus();
	return false;
}

function show_video() {
	callAjax(generateUrl('home', 'youtube_video'), '', function(t){
		$.facebox(t);
	});	
	
	
}

$(document).ready(function(){
	
	$(document).on('click',".medical-categry-js li a",function(){
		
		var parentLi = $(this).parent().detach();
		 parentLi.prependTo('.med-tabs-navigation');	
		 $('.med-tabs-navigation >li>a').removeClass('selected');
		 $(this).addClass('selected');	
		 $('.med-tabs-navigation li:nth-child(2)').prependTo('.categories__box ul'); 
		 $('.med-tabs-navigation li:nth-child(1)').find('input:radio').prop('checked', true).change();
		 $('.modaal-close').click();
	});
	
	$(".team__item").click(function(e){
		
		e.preventDefault();
		return false;
		
	});
	
});

 

