function UpdatePublicidad(action,PubID)
{
	var datos={
		'action': action,
		'id':PubID,  		 
		'size':jQuery("select#Pub-Size-"+PubID+" option:selected").val(), 
		'img':jQuery("#banner-"+PubID).val(),
		'url':jQuery("#banner-url-"+PubID).val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){FormWaiting(PubID);},		
		success: function(data) {
         if(data.request=="success")
         {
         	jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
         }else if(data.request=="error")
         {
         	jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
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
			jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
		}
	});
}


function UpdateAdSense(PubID)
{
	var datos={
		'action': 'UpdAdSenseContent',
		'id':PubID,  		 
		'size':jQuery("select#Pub-Size-"+PubID+" option:selected").val(), 
		'code':jQuery("#code-"+PubID).val()
	};
	jQuery.ajax({
		type: "POST",
		url: "admin-ajax.php",
		data: datos,
		dataType: 'json',
		beforeSend:function(){FormWaiting(PubID);},		
		success: function(data) {
         if(data.request=="success")
         {
         	jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
         }else if(data.request=="error")
         {
         	jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
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
			jQuery("#Ads-"+PubID+".Cnt-Ads .WaitingForm").remove();
		}
	});
}


function FormWaiting(id)
{
	jQuery("#Ads-"+id+".Cnt-Ads").append("<div class='WaitingForm'></div>");
	
}