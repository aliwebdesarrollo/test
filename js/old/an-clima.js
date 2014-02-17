jQuery(document).ready( function() 
{
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",
		data: {'action': "an_clima_load"},
		dataType: 'json',
		success: function(data) {
			if(data.request=="success")
			{
				Pronostico_Clima(data.localidad);
			}else if(data.request=="error")
			{
				jQuery("#CntClima").remove();
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

function Pronostico_Clima(localidad)
{
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",
		data: {'action': "an_clima",'loc':localidad},
		dataType: 'json',
		success: function(data) {
			if(data.request=="success")
			{
				delete data.request;
				jQuery("#CntClima").removeClass("LoadingBar");
				jQuery("#CntClima").append("<p id='ClimaCity'>"+data.localidad+"</p>");
				delete data.localidad;
				jQuery.each(data,function(i,val)
				{
					jQuery("#CntClima").append("<div class='ClimaDays ClimaPron' id='Day" + i + "'></div>");
					jQuery("#Day"+i+".ClimaDays").append("<p class='ClimaFecha'>"+val.dia+"</p>");
					jQuery("#Day"+i+".ClimaDays").append("<div class='ClimaDayIco DayIco" + val.ico + "' title='" + val.estado + "'></div>");
					jQuery("#Day"+i+".ClimaDays").append("<p class='TempMin'>Min: "+val.Tmin+"°</p>");
					jQuery("#Day"+i+".ClimaDays").append("<p class='TempMax'>Max: "+val.Tmax+"°</p>");
				});		
				jQuery("#CntClima").append("<a id='ChangeCity' href='#' onclick='CambiodeLocalidad();return false;' title='Cambiar Ciudad'></a>")		
			}else if(data.request=="error")
			{
				jQuery("#CntClima").append("<div id='Clima_Error'>"+data.error+"</div>");
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
}


function CambiodeLocalidad()
{
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",
		data: {'action':'an_clima_change'},
		dataType: 'json',
		success: function(data){
			if(data.request=="success")
			{
				jQuery("#CoverCity").removeClass("LoadingCities");
				jQuery("#CoverCity").append("<div id='ClimaFlow'></div");
				jQuery("#ClimaFlow").append("<h1>Pronostico del Tiempo</h1>");
				jQuery("#ClimaFlow").append("<p>Selecciona la Ciudad de Argentina de la cual queres ver el pronostico</p>");
				jQuery("#ClimaFlow").append("<div id='CntCities'></div>");
				jQuery("#CntCities").append("<h3 class='CitiesTitle'>Seleccione la Provincia</h3>");
				jQuery("#CntCities").append("<select id='ListClimaP' class='ListaClima' onchange='LoadCities(this.value);'>");
				jQuery.each(data.provincias,function(i,val){
					jQuery("#ListClimaP").append("<option class='ClimaProv' value='"+i+"'>"+val+"</option>");
				});
				jQuery("#CntCities").append("<h3 class='CitiesTitle'>Seleccione la Localidad</h3>");
				jQuery("#CntCities").append("<select id='ListClimaL' class='ListaClima'>");
				jQuery.each(data.localidades,function(i,val){
					jQuery("#ListClimaL").append("<option class='ClimaProv' value='"+i+"'>"+val+"</option>");
				});
				jQuery("#ClimaFlow").append("<a onclick=\"return ChangeCity(jQuery('#ListClimaL').val());\" class='clima-button button-Skyblue' id='NewCity'>Seleccionar</a>");
				jQuery("#ClimaFlow").append("<a onclick='return CloseCities();' id='CloseClima'>X</a>");
			}else if(data.request=="error")
			{
				
			}else
			{
				jQuery("#CoverCity").remove();
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
			}else {
				console.log('Error: ' + errorThrown);
				jQuery("#CoverCity").remove();
			}
		},
		beforeSend: function(){
			jQuery('body').append("<div id='CoverCity' class='LoadingCity'></div>")
		}
	});
}

function CloseCities()
{
	jQuery("#CoverCity").remove();
	return false;
}

function LoadCities(provincia)
{
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",
		data: {'action':'an_clima_selloc','pid':provincia},
		dataType: 'json',
		success: function(data){
			if(data.request=="success")
			{	
				jQuery("#ListClimaL").empty();
				jQuery.each(data.localidades,function(i,val){
					jQuery("#ListClimaL").append("<option class='ClimaProv' value='"+i+"'>"+val+"</option>");
			});
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
		}
	}
	});
}

function ChangeCity(lid)
{
	jQuery.ajax({
		type: "POST",
		url: window.location.origin +"/DiarioUpdated/diario/wp-admin/admin-ajax.php",	
		data: {'action':'an_clima_NewLoc','lid':lid},
		dataType: 'json',
		success: function(data){
			if(data.request=="success")
			{	
				jQuery("#CoverCity").remove();
				jQuery("#CntClima").empty();
				jQuery("#CntClima").addClass("LoadingBar");
				Pronostico_Clima(data.localidad);
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
		}
	}
	});
}