
jQuery(document).ready(function(){
	slickInit();

	if (imageDots) {
		jQuery(".slick-dots li").each(function(i) {
			var val = jQuery(".slick-slide[data-slick-index='"+i+"'] img").attr('src');
			jQuery(this).css("background-image", "url('" + val + "')");
		});
	}
});

function slickInit() {
	jQuery('.austeve-gallery-images').slick({
		dots: true,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
		adaptiveHeight: true
	});

	//hide the directional arrows initially
	jQuery(".slick-slider button").hide(); 
}

//Show/hide directional arrows with mouse over events
jQuery(document).on('mouseenter', ".slick-slider", function() {
	jQuery(this).find("button").show();  
});

jQuery(document).on('mouseleave', ".slick-slider", function() {
	jQuery(this).find("button").hide(); 
});

//Show/hide the widget layover 
jQuery(document).on('mouseenter touchstart', ".widget_austeve_gallery_widget", function() {
	
	if (jQuery(this).find(".layover:visible").length != 1) {
		clearLayovers();
		jQuery(this).find(".layover").show(); 
	    jQuery(this).find(".bg-img").css('opacity', '0.5'); 
	}

});

jQuery(document).on('mouseleave', ".widget_austeve_gallery_widget", function() {
	jQuery(this).find(".layover").hide();   
    jQuery(this).find(".bg-img").css('opacity', '1');     
});

function clearLayovers() {
	jQuery(document).find(".layover").hide();
    jQuery(document).find(".bg-img").css('opacity', '1'); 
}

jQuery(document).on('click', ".action-url", function() {
	jQuery(this).find('i').removeClass('fa-arrow-circle-right').addClass('fa-refresh fa-spin')  ;
});
