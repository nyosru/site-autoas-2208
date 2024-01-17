jQuery(document).ready(function ($) {
	'use strict';

	const carusel_cfg = {
		infinite: true,

		slidesToShow: 3,
		slidesToScroll: 3,

		dots: false,

		speed: 2000,

		xcenterMode: true,

		centerPadding: '10px',
		centerMargin: '10px',

		arrows: false,

		autoplay: true,
		autoplaySpeed: 3000,

		// swipe: true,
		swipeToSlide: true,

		// row: 4,

		// lazyLoad: 'ondemand',
		// settings: "unslick",

		responsive: [
			{
				breakpoint: 1624,
				settings: {
					slidesToShow: 5,
					slidesToScroll: 2,
					// infinite: true,
					// dots: true
				},
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 2,
					// infinite: true,
					// dots: true
				},
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		],
	};

	$('.js-carousel-1').slick(carusel_cfg);
	carusel_cfg['autoplaySpeed'] = 3000;
	$('.js-carousel-2').slick(carusel_cfg);
	carusel_cfg['autoplaySpeed'] = 1800;
	$('.js-carousel-3').slick(carusel_cfg);
	carusel_cfg['autoplaySpeed'] = 4500;
	$('.js-carousel-4').slick(carusel_cfg);
	

	// banner carousel
	$('.js-banner1').slick({
		autoplay: true,
		autoplaySpeed: 4000,
		speed: 4000,
		arrows: false,
	});

});
