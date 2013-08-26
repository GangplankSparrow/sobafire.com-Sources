// PREVENT FLICKER ON INITIAL LOAD
//=================================================================================================================================

document.write('<style type="text/css">body{display:none}</style>');
	jQuery(function($) {
		$('body').css('display','block');
});

// HOMEPAGE SLIDER
//=================================================================================================================================

$(function(){
	$('#slides').slides({
		play: 7000,
		hoverPause: false,
		fadeSpeed: 500,
		effect: 'fade',
		crossfade: true,
		generatePagination: false
	});
});

// COLORBOX
//=================================================================================================================================

$(document).ready(function(){
	$(".gallery a").colorbox({rel:'gallery', transition:"elastic", maxWidth:"95%", maxHeight:"95%"});
	$("a[rel='colorbox']").colorbox({transition:"elastic", maxWidth:"95%", maxHeight:"95%"});
});