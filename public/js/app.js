$( function() {
	
	/* Setup CSRF token for ajax calls */
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});

	/* Ajax checking budget entries on Dashboard */
	$('.dashboard-budget-table').on('click', 'input.check-entry', function(e) {
		/* TODO: AJAX toggle entry */
	});
});