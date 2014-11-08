(function() {
	alert('something');
	$( "form" ).on( "submit", function( event ) {
	  event.preventDefault();
	});
	// $('form').on('submit', function(e) {
	// 	e.preventDefault();
	// 	alert('hello');
		// alert('this is in here');
		// e.preventDefault();
		// var form = $(this);
		// var method = form.find('input[name="_method"]').val() || 'POST';
		// var url = form.prop('action');

		// $.ajax({
		// 	type: method,
		// 	url: url,
		// 	data: form.serialize(),
		// 	success: function() {
		// 		alert('all done!');
		// 	}
		// });
		
	// });
})();