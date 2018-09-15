			$(document).ready(function() {
				//FOR EASING EFFECT - NOT NEEDED
				$('.box_container2').hover(function() {

					var width = $(this).outerWidth() / 2;

					$(this).find('.left2').animate({
						right : width
					}, {
						easing : 'easeOutBounce',
						queue : false,
						duration : 1500
					});
					$(this).find('.right2').animate({
						left : width
					}, {
						easing : 'easeOutBounce',
						queue : false,
						duration : 1500
					});
				}, function() {

					$(this).find('.left2').animate({
						right : 0
					}, {
						easing : 'easeOutBounce',
						queue : false,
						duration : 2000
					});
					$(this).find('.right2').animate({
						left : 0
					}, {
						easing : 'easeOutBounce',
						queue : false,
						duration : 2000
					});

				});

			});