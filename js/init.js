
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

jQuery(document).on('mouseenter', ".widget_austeve_gallery_widget", function() {
	
	jQuery(this).find(".layover").show(); 
    jQuery(this).find(".bg-img").css('opacity', '0.5'); 
    
    var img = jQuery(this).find(".preview-img>img");
    jQuery("#previewArea").html("<a href='" + img.attr('data-url') + "'><img src='" + img.attr('src') + "'/></a>");    
});

jQuery(document).on('mouseleave', ".widget_austeve_gallery_widget", function() {
	jQuery(this).find(".layover").hide();   
    jQuery(this).find(".bg-img").css('opacity', '1');     
});