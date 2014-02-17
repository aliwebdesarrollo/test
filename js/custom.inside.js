$(document).ready(function() {

	// selector string
	imagesLoaded( '#art-tree', function() {
		if($(window).width() <= 800){
			var percent="100%";
		}else
		{
			var percent="33%";
		}
		
		jQuery('#art-tree .col-lg-4').wookmark({
		  align: 'left',
		  autoResize: true,
		  comparator: null,
		  container: jQuery('#art-tree'),
		  ignoreInactiveItems: true,
		  itemWidth: percent,
		  fillEmptySpace: false,
		  flexibleWidth: true,
		  offset: 2,
		  onLayoutChanged: undefined,
		  outerOffset: 0,
		  resizeDelay: 0,
		  possibleFilters: []
		});
		
		var colH=parseInt(jQuery("#tree-main").css("height"));
		var asideH=parseInt(jQuery("aside").css("height"));
		if(colH > asideH){
			jQuery("aside").css("height",colH);
			jQuery("#tree-main").css("height",colH);
		}else if(asideH > colH){
			jQuery("#tree-main").css("height",asideH);
			jQuery("aside").css("height",asideH);
		}
	});
});