var curr = 0;
$(document).ready(function(){
	if ( $( '#newsticker' ).length > 0 ) {
		$( '.testimonial' ).show();
		show_testimonial();
		
		window.setInterval(function(){
			show_testimonial();
		}, 5000);
	}
});

function show_testimonial() {
	$( '#newsticker' ).fadeOut( 'dev', function(){
		if ( curr == newsticker.length-1 ) curr = 0;
		
		var testimonial = newsticker[curr][0];
		var html = '<p><a href="' + testimonial['link'] + '">' + testimonial['description']  + '</a> <small>en ' + testimonial['category'] + '</small>';
		
		$( this ).html( html ).fadeIn( 'dev' );
		
		curr++;
	});
}