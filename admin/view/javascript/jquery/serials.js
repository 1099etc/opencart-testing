$(function(){
	var order_id = $('#order_id').html();
	var token = $('#token').html();


	make_editable('.editable');

	// Serial key removal code
	$('.serialRemove').live('click', function(){
		var parent = $(this).parent();
		var me = $(this);

		// if button has been clicked don't allow second click
		if(me.hasClass('noClick')) return false;
		me.addClass('noClick');

		var id = parent.attr('rel');

		parent.append('&nbsp;<img src="view/image/loading.gif" id="ajax_spinner_' + id + '" />');

		$.getJSON(
			'index.php',
			{
				'route' : 'catalog/serial/removeOrderSerial',
				'token' : token,
				'order_id' : order_id,
				'serial_id' : id
			},
			function(data) {
					$('#ajax_spinner_' + data.serial_id).remove();
				if(data.error) {
					alert('ERROR REMOVING SERIAL KEY. PLEASE REFRESH THE SCREEN AND TRY AGAIN.');
				}else{
					$('div[rel*=' + data.serial_id + ']').fadeOut('slow',function(){
						$(this).remove();
					});
				}
			}
		)

		return false;
	});

	$('.serialAdd').click(function(){
		var product_id = $(this).attr('rel');
		var serial = $('#add_serial_' + product_id).val();
		serial = serial.replace(/^\s+|\s+$/, '');
		if(serial.length == 0) {
			alert('Please enter a valid serial key');
		}else{
			$('#add_serial_' + product_id).parent().append(' <img src="view/image/loading.gif" id="loading_' + product_id + '" />')
			$.getJSON(
				'index.php',
				{
					'route' : 'catalog/serial/addOrderSerial',
					'token' : token,
					'order_id' : order_id,
					'serial' : serial,
					'product_id' : product_id
 				},
				function(data) {
					$('#loading_' + data.product_id).remove();
					if(data.error) {
						alert('ERROR INSERTING KEY');
					} else {
						$('#add_serial_' + data.product_id).val('');
						$('#no_serials_' + data.product_id).remove();
						$('#serials_list_' + data.product_id).append('<div style="padding: 1px;" rel="' + data.serial_key_id +'" style="font-family: monospace;"><span>' + data.serial + '</span>' + data.featurecode + ' <b>KeyCode: </b> ' + data.keycode + ' <img src="view/image/delete.png" class="serialRemove" alt="" /></div>');

						make_editable('div[rel*=' + data.serial_key_id + '] > .editable');
					}
				}
			);
		}
		return false;
	});
});

function make_editable(selector) {
	$(selector).editable(function(value, settings) {

		var token = $('#token').html();
		var serial_id = $(this).parent().attr('rel');
		$.getJSON(
			'index.php',
			{
				'route'	: 'catalog/serial/updateOrderSerial',
				'serial_id' : serial_id,
				'serial' : value.toString(),
				'token' : token
			},
			function(data) {
				if(data.error) {
					alert('The serial was not updated');
				}
			}
		);
		return(value);
  	}, {
		submit  : 'Update',
	});
}
