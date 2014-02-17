jQuery(document).ready(function()
{
	jQuery(".pic-list").colorbox({rel:'pic-list', transition:"elastic", speed:600, maxWidth:"97%", maxHeight:"97%", fixed:true});
	
	//Agrego eventos a los iconos para modificar Cargos (a los que se cargan con el documento y a los que se cargan via Ajax)
	jQuery("body").delegate(".pic-list","click",function(){
		var pic=jQuery(this).attr("href");
		jQuery("#pic-single").attr("src",pic);
	});
});