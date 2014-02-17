jQuery(document).ready(function()
{
	jQuery(".pic-list").colorbox({rel:'pic-list', transition:"elastic", speed:600, maxWidth:"97%", maxHeight:"97%", fixed:true});
	
	//Agrego eventos a los iconos para modificar Cargos (a los que se cargan con el documento y a los que se cargan via Ajax)
	jQuery("body").delegate(".pic-list","click",function(){
		var pic=jQuery(this).attr("href");
		jQuery("#pic-single").attr("src",pic);
	});
	
	jQuery("body").delegate(".font-increase","click",function(){
		var tam_texto= parseInt(jQuery('#post-content').css("font-size"))+2; 
		jQuery('#post-content').animate({fontSize: tam_texto},10);
	});
	
	jQuery("body").delegate(".font-decrease","click",function(){
		var tam_texto= parseInt(jQuery('#post-content').css("font-size"))-2;
		tam_texto= (tam_texto < 12)? 12 : tam_texto; 
		jQuery('#post-content').animate({fontSize: tam_texto},10);
	});
});
