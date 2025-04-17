jQuery(document).ready(function ($) {
    $('.event-slideshow').slick({
        arrows: true,
        dots: false,
        infinite: true,
        speed: 2000,
	autoplaySpeed: 6000,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        autoplay: true,
        fade: true,
    });
});
