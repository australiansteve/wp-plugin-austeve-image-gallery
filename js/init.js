
jQuery(document).ready(function(){
	slickInit();
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
}

jQuery(document).on('mouseenter touchstart', ".widget_austeve_gallery_widget", function() {
	
	if (jQuery(this).find(".layover:visible").length != 1) {
		clearLayovers();
		jQuery(this).find(".layover").show(); 
	    jQuery(this).find(".bg-img").css('opacity', '0.5'); 
	}

    //var img = jQuery(this).find(".preview-img>img");
    //jQuery("#previewArea").html("<a href='" + img.attr('data-url') + "'><img src='" + img.attr('src') + "'/></a>");    
});


jQuery(document).on('click', ".action-url", function() {
	jQuery(this).find('i').removeClass('fa-arrow-circle-right').addClass('fa-refresh fa-spin')  ;
	//jQuery(this).find('i').addClass('fa-refresh fa-spin')  ;
});


jQuery(document).on('mouseleave', ".widget_austeve_gallery_widget", function() {
	jQuery(this).find(".layover").hide();   
    jQuery(this).find(".bg-img").css('opacity', '1');     
});

function clearLayovers() {
	jQuery(document).find(".layover").hide();
    jQuery(document).find(".bg-img").css('opacity', '1'); 
}