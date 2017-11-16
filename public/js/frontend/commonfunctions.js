$(document).ready(function () {
    setInterval(function () {
        $.get(generateUrl('home', 'udpate_activity'), function () {



        });
    }, 180000);
    
    $( "input[type=radio].custom_radio" ).parent().wrapInner("<label class='radio'></label>");
   $( "input[type=radio].custom_radio" ).after("<i class='input-helper'></i>");
   
   /******
   show upload file name in front of browse option
   ********/
   $('.filefield :input').change(function(){			
			$(this).prev('.filename').html(this.value);
		}); 
		
});

$(document).ready(function() {	

// Doctors-list


function doctorSelection(doctor_id) {
/* $('.doctors_list li').on('click', function(){ */
	
    $('.doctors_list').removeClass('selected');
    $('.item__'+doctor_id).addClass('selected');
	rel = $(this).attr('rel');
	
	$('.team__doctors-intro').removeClass('active');
	$('.'+rel).addClass('active');


 
	
	
}	
//Fixed Header
if($(window).width() > 1024){
$(window).scroll(function() {
if ($(this).scrollTop() > 1){  
    $('.js-site-header').addClass("js-fixed-site-header");
  }
  else{
    $('.js-site-header').removeClass("js-fixed-site-header");
  }
});


}
if($(window).width()<767){
           $('.footer h5').click(function(){
		  $(this).toggleClass("active");
		  if($(window).width()<850)
		  $(this).siblings('.footer__links ul').slideToggle();
	  });
          } 
		  

//Responsive mobile -- mobile menu

$('.toggleMenu').click(function() {
            $(this).toggleClass("active");
			var el = $("body");
			if(el.hasClass('toggled-left')) el.removeClass("toggled-left");
			else el.addClass('toggled-left');
            return false; 
        });
        $('body').click(function(){
            if($('body').hasClass('toggled-left')){
                $('.toggleMenu').removeClass("active");
                $('body').removeClass('toggled-left');
            }
        });
    
        $('.leftoverlay').click(function(){
            if($('body').hasClass('toggled-left')){
                $('.toggleMenu').removeClass("active");
                $('body').removeClass('toggled-left');
            }
        });
		//Med Tabs -- Mobile
$('.js--dashboardToggle').click(function() {
			$(this).toggleClass("active");
                $('.dashboard_menu  ul').slideToggle("600");
        });	
//User options
$(".h__usersignedin").click(
  function () {
  $(this).toggleClass("active");
  }
);
//sidebar
$(".js-sidebarToggle").click(
  function () {
  $(this).toggleClass("active");
  $('.sidebar__content').toggle("fast");
  
  }
);

// Med-tabs	
var selector = '.med-tabs-navigation li a';

$(selector).on('click', function(){
    $(selector).removeClass('selected');
    $(this).addClass('selected');
	
});

//Med Tabs -- Mobile
$('.js-question--tab__trigger').click(function() {
			$(this).toggleClass("active");
                $('.med--tabs').slideToggle("600");
        });		
		
		
//Accordion

 $(".accordion h4:first").addClass("active");
	  $(".accordion .ans:not(:first)").hide();
	  $(" .accordion  h4").click(function(){
		$(this).next(".ans").show().addClass('fade')
		.siblings(".ans:visible").hide().removeClass('fade');
		$(this).toggleClass("active");
		$(this).siblings("h4").removeClass("active");
	});		
		
});

//med tabs --mobile
jQuery(document).ready(function($){
	var tabs = $('.med--tabs');
	
	tabs.each(function(){
		var tab = $(this),
			tabItems = tab.find('ul.med-tabs-navigation'),
			
			tabNavigation = tab.find('nav');

		

		//hide the .med-tabs::after element when tabbed navigation has scrolled to the end 
		checkScrolling(tabNavigation);
		tabNavigation.on('scroll', function(){ 
			checkScrolling($(this));
		});
	});
	
	$(window).on('resize', function(){
		tabs.each(function(){
			var tab = $(this);
			checkScrolling(tab.find('nav'));
			
		});
	});

	function checkScrolling(tabs){
		var totalTabWidth = parseInt(tabs.children('.med-tabs-navigation').width()),
		 	tabsViewport = parseInt(tabs.width());
		if( tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
			tabs.parent('.med--tabs').addClass('is-ended');
		} else {
			tabs.parent('.med--tabs').removeClass('is-ended');
		}
	}
	
//Custom input file
'use strict';

;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));















});
          