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

	/* Ajax delete budget entries on Dashboard */
	$('.dashboard-budget-table').on('click', '.delete-entry', function(e) {
		e.preventDefault();

		var $this = $(this);
		$.post('/ajax_delete_entry', {entry_id: $(this).attr('data-entry-id')}, function(data) {
			if( data.status == "ok" ) {
				
				var visible_update = data.visible_account_update;
				$('.visible-account-update').html(data.visible_account_update + ' €');
				if( data.visible_account_update > 0 ) {
					$('.visible-account-update').removeClass('text-danger').addClass('text-success');
				} else {
					$('.visible-account-update').removeClass('text-success').addClass('text-danger');
				}

				var real_update = data.real_account_update;
				$('.real-account-update').html(data.real_account_update + ' €');
				if( data.real_account_update > 0 ) {
					$('.real-account-update').removeClass('text-danger').addClass('text-success');
				} else {
					$('.real-account-update').removeClass('text-success').addClass('text-danger');
				}

				$this.closest('tr').remove();
			}
		}, 'json');

		return false;
	});

	/* Ajax edit budget entries on Dashboard */
	$('.dashboard-budget-table').on('click', '.edit-entry', function(e) {
		e.preventDefault();

		var $this = $(this);
		var $tr = $this.closest('tr');

		var tr_id = $tr.attr('data-line-id');
		var $editor = $('.dashboard-budget-table tr.edit-line-template[data-line-id='+tr_id+']');

		$tr.hide();
		$editor.show();
	});

	/* Cancel AJAX edition */
	$('.dashboard-budget-table').on('click', '.edit-line-template .cancel', function(e) {
		e.preventDefault();

		var $this = $(this);
		var $tr = $this.closest('tr');

		var tr_id = $tr.attr('data-line-id');
		var $source = $('.dashboard-budget-table tr.read-line[data-line-id='+tr_id+']');

		$tr.hide();
		$source.show();

		return false;
	});

	/* Save AJAX edition */
	$('.dashboard-budget-table').on('click', '.edit-line-template .save', function(e) {
		e.preventDefault();

		var $this = $(this);
		var $tr = $this.closest('tr');

		var tr_id = $tr.attr('data-line-id');
		var $source = $('.dashboard-budget-table tr.read-line[data-line-id='+tr_id+']');

		var send_data = {
			entry_id: $this.attr('data-entry-id'),
			date: $tr.find('#edit-date').val(),
			label: $tr.find('#edit-label').val(),
			'amount-debit': $tr.find('#edit-amount-debit').val(),
			'amount-credit': $tr.find('#edit-amount-credit').val(),
			channel_id: $tr.find('#edit-channel_id').val()
		};

		$.post('/ajax_edit_entry', send_data, function(data) {
			if( data.status == "ok" ) {
				
				$tr.hide();
				$source.show();
			}
		}, 'json');


		return false;
	});

});