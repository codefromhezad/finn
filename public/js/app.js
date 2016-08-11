$( function() {
	
	/* Setup CSRF token for ajax calls */
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});

	/* Ajax checking budget entries on Dashboard */
	$('.dashboard-budget-table').on('change', 'input.check-entry', function(e) {
		$.post('/ajax_toggle_check_entry', {entry_id: $(this).attr('data-entry-id'), checked: $(this).is(':checked') ? 1 : 0}, function(data) {
			if( data.status == "ok" ) {
				var visible_update = data.visible_account_update;
				$('.visible-account-update').html(data.visible_account_update + ' €');
				if( data.visible_account_update > 0 ) {
					$('.visible-account-update').removeClass('text-danger').addClass('text-success');
				} else {
					$('.visible-account-update').removeClass('text-success').addClass('text-danger');
				}
			}
		}, 'json');
	});
});