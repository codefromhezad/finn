$( function() {
	
	/* Setup CSRF token for ajax calls */
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});

	/* Setup UI datepicker */
	$.fn.datepicker.dates['fr'] = {
		days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
		daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
		daysMin: ["D", "L", "Ma", "Me", "J", "V", "S", "D"],
		months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
		monthsShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"],
		today: "Aujourd'hui",
		weekStart: 1
	};
	$('#new-date').datepicker({
		format: 'dd/mm/yyyy',
		weekStart: 1,
		autoclose: true,
		language: 'fr'
	}).on('changeDate', function() {
		$('#new-label').focus();
	});

	/* Ajax checking budget entries on Dashboard */
	$('.dashboard-budget-table').on('change', 'input.check-entry', function(e) {
		$.post('/ajax_toggle_check_entry', {entry_id: $(this).attr('data-entry-id'), checked: $(this).is(':checked') ? 1 : 0}, function(data) {
			if( data.status == "ok" ) {
				if( data['widget-situation'] ) {
					$('.widget-situation').html(data['widget-situation']);
				}

				if( data['widget-carte'] ) {
					$('.widget-carte').html(data['widget-carte']);
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
				
				if( data['widget-situation'] ) {
					$('.widget-situation').html(data['widget-situation']);
				}

				if( data['widget-carte'] ) {
					$('.widget-carte').html(data['widget-carte']);
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
				
				if( data['widget-situation'] ) {
					$('.widget-situation').html(data['widget-situation']);
				}

				if( data['widget-carte'] ) {
					$('.widget-carte').html(data['widget-carte']);
				}

				$tr.remove();
				$source.replaceWith(data['line-entry']);
			}
		}, 'json');


		return false;
	});

});