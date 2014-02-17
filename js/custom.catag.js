$(document).ready(function() {

	jQuery('body').css('padding-top',$('#top-menu-navbar').height()+10)	

	var IdArray=[];
	var i=0;
	jQuery(".art-line").each(function(){
		//alert(jQuery(this).attr("rel-id"));
		if(jQuery(this).attr("rel-id")!=undefined)
		{
			IdArray[i]=jQuery(this).attr("rel-id");
			i++;
		}
	});
	
	var datos={
		'action': "FacebookComments", 
		'ids':IdArray
	};
	jQuery.ajax({
		type: "POST",
		url: "http://localhost/wordpress3.8/wp-admin/admin-ajax.php",
		data: datos,
		dataType: 'json',		
		success: function(data) {
         if(data.request=="success")
         {
         	jQuery.each(data.comments,function(id,val)
				{
					if(val.comment_count!=0)
					{
         			jQuery("#post-"+id+" .thumbnail .panel-footer .text-right").append("<span class='fa fa-comment'></span> "+val.comment_count);
         		}
         	})
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
	
	// selector string
	imagesLoaded( '#articles-row', function() {
		if($(window).width() <= 800){
			var percent="100%";
		}else
		{
			var percent="49.5%";
		}

		jQuery('#articles-row .col-md-6').wookmark({
		  align: 'left',
		  autoResize: false,
		  comparator: null,
		  container: jQuery('#articles-row'),
		  ignoreInactiveItems: true,
		  itemWidth: percent,
		  fillEmptySpace: false,
		  flexibleWidth: true,
		  offset: 2,
		  onLayoutChanged: undefined,
		  outerOffset: 0,
		  resizeDelay: 50,
		  possibleFilters: []
		});
		
	});
});