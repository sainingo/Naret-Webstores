function vw_storefront_menu_open_nav() {
	window.vw_storefront_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function vw_storefront_menu_close_nav() {
	window.vw_storefront_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   	});
});

jQuery(document).ready(function () {
	window.vw_storefront_currentfocus=null;
  	vw_storefront_checkfocusdElement();
	var vw_storefront_body = document.querySelector('body');
	vw_storefront_body.addEventListener('keyup', vw_storefront_check_tab_press);
	var vw_storefront_gotoHome = false;
	var vw_storefront_gotoClose = false;
	window.vw_storefront_responsiveMenu=false;
 	function vw_storefront_checkfocusdElement(){
	 	if(window.vw_storefront_currentfocus=document.activeElement.className){
		 	window.vw_storefront_currentfocus=document.activeElement.className;
	 	}
 	}
 	function vw_storefront_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.vw_storefront_responsiveMenu){
			if (!e.shiftKey) {
				if(vw_storefront_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				vw_storefront_gotoHome = true;
			} else {
				vw_storefront_gotoHome = false;
			}

		}else{

			if(window.vw_storefront_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.vw_storefront_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.vw_storefront_responsiveMenu){
				if(vw_storefront_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					vw_storefront_gotoClose = true;
				} else {
					vw_storefront_gotoClose = false;
				}
			
			}else{

			if(window.vw_storefront_responsiveMenu){
			}}}}
		}
	 	vw_storefront_checkfocusdElement();
	}
});

jQuery('document').ready(function($){
	jQuery(window).load(function() {
	    jQuery("#status").fadeOut();
	    jQuery("#preloader").delay(1000).fadeOut("slow");
	})
});

jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
	    if (jQuery(this).scrollTop() > 100) {
	        jQuery('.scrollup i').fadeIn();
	    } else {
	        jQuery('.scrollup i').fadeOut();
	    }
	});
	jQuery('.scrollup').click(function () {
	    jQuery("html, body").animate({
	        scrollTop: 0
	    }, 600);
	    return false;
	});
});