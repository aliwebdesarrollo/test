//Agrego al contenedor el nuevo cargo agregado - Schema
function RefreshCargoSchema(info_json)
{
	info_json.action="RefreshSchema";
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: info_json,
		dataType: 'json',		
		success: function(data) {
         if(data.request=="success")
         {
         	if ( typeof info_json.id == "undefined")
         	{    	
	         	jQuery("#cargos-details").append("<div class='cargo-detail-line' id='detail-line-"+data.id+"'></div>");
   	      	jQuery("#detail-line-"+data.id).append("<p class='cargo-name cargo-line'><span>Nombre: </span>"+info_json.name+"</p>");
      	   	jQuery("#detail-line-"+data.id).append("<p class='cargo-niv cargo-line'><span>Prioridad: </span>"+data.prior+"</p>");	
      	   	jQuery("#detail-line-"+data.id).append("<p class='cargo-est cargo-line'><span>Estado: </span>"+data.estado+"</p>");
         		jQuery("#detail-line-"+data.id).append("<a class='Staff-cargo-edit-icon' title='Editar Cargo' rel-id='"+data.id+"' rel-name='"+info_json.name+"' rel-prior='"+info_json.prior+"' rel-status='"+info_json.estado+"'></a>");
         	}else
         	{
         		jQuery("#detail-line-"+data.id+" .cargo-name").remove();
         		jQuery("#detail-line-"+data.id).append("<p class='cargo-name cargo-line'><span>Nombre: </span>"+info_json.name+"</p>");
         		jQuery("#detail-line-"+data.id+" .cargo-niv").remove();
      	   	jQuery("#detail-line-"+data.id).append("<p class='cargo-niv cargo-line'><span>Prioridad: </span>"+data.prior+"</p>");
      	   	jQuery("#detail-line-"+data.id+" .cargo-est").remove();	
      	   	jQuery("#detail-line-"+data.id).append("<p class='cargo-est cargo-line'><span>Estado: </span>"+data.estado+"</p>");
      	   	jQuery("#detail-line-"+data.id+" .Staff-edit-icon").remove();
         		jQuery("#detail-line-"+data.id).append("<a class='Staff-cargo-edit-icon' title='Editar Cargo' rel-id='"+data.id+"' rel-name='"+info_json.name+"' rel-prior='"+info_json.prior+"' rel-status='"+info_json.estado+"'></a>");
         	}
         	jQuery("#Staff-cover").remove();
        		jQuery("#cargo-empty").remove();
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
         }
         //}
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

//Agrego al sistema el nuevo cargo Schema
function AddNewCargo()
{
	var datos={
		'action': "CargosAddCargo", 
		'name':jQuery("#nameCargo").val(), 
		'prior':jQuery("select#priorCargo option:selected").val(), 
		'estado':jQuery("select#estadoCargo option:selected").val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){StaffFormWaiting();},		
		success: function(data) {
         if(data.request=="success")
         {
         	RefreshCargoSchema(datos);
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
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
	return false;
}


//Edito al sistema el nuevo cargo Schema
function EditCargo(CargoID)
{
	var datos={
		'action': "CargosEditCargo",
		'id':CargoID,  
		'name':jQuery("#nameCargo").val(), 
		'prior':jQuery("select#priorCargo option:selected").val(), 
		'estado':jQuery("select#estadoCargo option:selected").val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){StaffFormWaiting();},		
		success: function(data) {
         if(data.request=="success")
         {
         	RefreshCargoSchema(datos);
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
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
	return false;
}


//Agrego al contenedor el nuevo cargo agregado - Schema
function RefreshStaff(info_json,insid)
{
	info_json.action="RefreshStaff";
	if(insid!=-1)
	{
		info_json.id=insid;
	}
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: info_json,
		dataType: 'json',		
		success: function(data) {
         if(data.request=="success")
         {
         	//if ( typeof info_json.id == "undefined")
         	if(insid!=-1)
         	{    	
	         	jQuery("#staffs-details").append("<div class='staff-detail-line' id='detail-line-"+data.id+"'></div>");
   	      	jQuery("#detail-line-"+data.id).append("<p class='staff-name staff-line'><span>Nombre: </span>"+info_json.name+"</p>");
      	   	jQuery("#detail-line-"+data.id).append("<p class='staff-niv staff-line'><span>Cargo: </span>"+data.cargo+"</p>");	
      	   	jQuery("#detail-line-"+data.id).append("<p class='staff-est staff-line'><span>Estado: </span>"+data.estado+"</p>");
         		jQuery("#detail-line-"+data.id).append("<a class='Staff-edit-icon' title='Editar Staff' rel-id='"+data.id+"' rel-name='"+info_json.name+"' rel-cargo='"+info_json.cargo+"' rel-status='"+info_json.estado+"'></a>");
         	}else
         	{
         		jQuery("#detail-line-"+data.id+" .staff-name").remove();
	      		jQuery("#detail-line-"+data.id).append("<p class='staff-name staff-line'><span>Nombre: </span>"+info_json.name+"</p>");
   	   		jQuery("#detail-line-"+data.id+" .staff-niv").remove();
   		   	jQuery("#detail-line-"+data.id).append("<p class='staff-niv staff-line'><span>Cargo: </span>"+data.cargo+"</p>");
   	   		jQuery("#detail-line-"+data.id+" .staff-est").remove();	
   	   		jQuery("#detail-line-"+data.id).append("<p class='staff-est staff-line'><span>Estado: </span>"+data.estado+"</p>");
      	   	jQuery("#detail-line-"+data.id+" .Staff-edit-icon").remove();
	      		jQuery("#detail-line-"+data.id).append("<a class='Staff-edit-icon' title='Editar Staff' rel-id='"+data.id+"' rel-name='"+info_json.name+"' rel-cargo='"+info_json.cargo+"' rel-status='"+info_json.estado+"'></a>");
         	}
         	jQuery("#Staff-cover").remove();
        		jQuery("#staff-empty").remove();
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
         }else if(data.request=="nochange")
         {
         	jQuery("#Staff-form-cover").remove();
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

//Agrego al sistema el nuevo cargo Schema
function AddNewStaff()
{
	var datos={
		'action': "StaffsAddStaff", 
		'name':jQuery("#nameStaff").val(), 
		'cargo':jQuery("select#cargoStaff option:selected").val(), 
		'estado':jQuery("select#estadoStaff option:selected").val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){StaffFormWaiting();},		
		success: function(data) {
         if(data.request=="success")
         {
         	RefreshStaff(datos, data.lastid);
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
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
	return false;
}


//Edito al sistema el nuevo cargo Schema
function EditStaff(CargoID)
{
	var datos={
		'action': "StaffsEditStaff",
		'id':CargoID,  
		'name':jQuery("#nameStaff").val(), 
		'cargo':jQuery("select#cargoStaff option:selected").val(), 
		'estado':jQuery("select#estadoStaff option:selected").val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){StaffFormWaiting();},		
		success: function(data) {
         if(data.request=="success")
         {
         	RefreshStaff(datos,-1);
         }else if(data.request=="error")
         {
         	jQuery("#Staff-form-cover").remove();
         	alert(data.error);
         }else if(data.request=="nochange")
         {
         	jQuery("#Staff-cover").remove();
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
	return false;
}

//Cargando / Procesando
function StaffFormWaiting() 
{
	jQuery("#Cnt-edit-form").append("<div id='Staff-form-cover'></div>");
}

//Cargando / Procesando
function StaffWaiting() 
{
	
	jQuery(".staff-wrap").append("<div id='Staff-cover' class='Staff-cover-waiting'></div>");
}

//Agrego eventos a los iconos para modificar Cargos (a los que se cargan con el documento y a los que se cargan via Ajax)
jQuery("body").delegate(".Staff-cargo-edit-icon","click",function(){
	var info_json={
		'action': "CargosEdit", 
		'id':jQuery(this).attr("rel-id"), 
		'name':jQuery(this).attr("rel-name"), 
		'prior':jQuery(this).attr("rel-prior"), 
		'estado':jQuery(this).attr("rel-status")
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: info_json,
		dataType: 'html',
		beforeSend:function(){StaffWaiting();},
		success: function(data) {
			jQuery('#Staff-cover')
				.removeClass("Staff-cover-waiting");
			jQuery('#Staff-cover').append(data); // put our list of links into it					
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
});

//Agrego Evento al boton de cancelar para cerrar la ventana de Carga o Modificacion
jQuery("body").delegate("#Cancel-Edit","click",function(){
	jQuery("#Staff-cover").remove();
});	

//Agrego Evento al Boton Agregar Cargo - Schema
jQuery("body").delegate("#staff-cargo-add-new","click",function(){
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: {'action': "CargosAdd"},
		dataType: 'html',
		beforeSend:function(){StaffWaiting();},
		success: function(data) {
			jQuery('#Staff-cover').removeClass("Staff-cover-waiting");
			jQuery('#Staff-cover').append(data); // put our list of links into it					
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
});


//Agrego eventos a los iconos para modificar Staff (a los que se cargan con el documento y a los que se cargan via Ajax)
jQuery("body").delegate(".Staff-edit-icon","click",function(){
	var info_json={
		'action': "StaffEdit", 
		'id':jQuery(this).attr("rel-id"), 
		'name':jQuery(this).attr("rel-name"), 
		'cargo':jQuery(this).attr("rel-cargo"), 
		'estado':jQuery(this).attr("rel-status")
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: info_json,
		dataType: 'html',
		beforeSend:function(){StaffWaiting();},
		success: function(data) {
			jQuery('#Staff-cover')
				.removeClass("Staff-cover-waiting");
			jQuery('#Staff-cover').append(data); // put our list of links into it					
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
});

//Agrego Evento al Boton Agregar Staff
jQuery("body").delegate("#staff-add-new","click",function(){
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: {'action': "StaffsAdd"},
		dataType: 'html',
		beforeSend:function(){StaffWaiting();},
		success: function(data) {
			jQuery('#Staff-cover').removeClass("Staff-cover-waiting");
			jQuery('#Staff-cover').append(data); // put our list of links into it					
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
});