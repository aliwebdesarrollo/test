function ShowFilm(x)
{
	var indice=$( "#NavEstrenos p" ).index( x );
	$(".InfoShows").removeClass("activeShow");
	$("#Show"+indice).addClass("activeShow");
	$("#NavEstrenos p").removeClass("activeEstreno");
	$("#NavEstrenos p:eq("+indice+")").addClass("activeEstreno");
}

jQuery(document).ready( function() {
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",
		data: {'action': "an_estrenos"},
		dataType: 'json',
		success: function(data) {
			if(data.request=="success")
			{
				delete data.request;
				jQuery("#Cartelera").removeClass("LoadingBar");
				jQuery("#Cartelera").append("<nav id=\"NavEstrenos\"></nav>");
				jQuery.each(data,function(i,val)
				{
					jQuery("#NavEstrenos").prepend("<div class=\"InfoShows\" id=\"Show"+i+"\"></div>");
					jQuery("#Show"+i).append("<img src="+val.img+"><h4>"+val.titulo+"</h4>");
					jQuery("#NavEstrenos").append("<p onclick=\"ShowFilm(this)\">"+i+"</p>"); 
				});
				jQuery("#Show0").addClass("activeShow");
				jQuery("#NavEstrenos p:eq(0)").addClass("activeEstreno");		
			}else if(data.request=="error")
			{
				jQuery("#Cartelera").append("<div id='Estrenos_Error'>"+data.error+"</div>");
			}			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if(typeof console === "undefined") {
				console = {
					log: function() { },
					debug: function() { },
				};
			}
			if (XMLHttpRequest.status == 404) {
				console.log('Element not found.');
			} else {
				console.log('Error: ' + errorThrown);
				jQuery("#CntClima").remove();
			}
		}
	});
});