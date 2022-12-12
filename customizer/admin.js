jQuery(function ($) {
	// настройка
	wp.customize('link_color', function (value) {
		value.bind(function (newVal) {
			$('a').css('color', newVal);
		});
	});

	// настройка
	wp.customize('display_header', function (value) {
		value.bind(function (newVal) {
			false === newVal ? $('#header').hide() : $('#header').show();
		});
	});

	// настройка
	wp.customize('color_scheme', function (value) {
		value.bind(function (newVal) {
			if ('inverse' === newVal) {
				$('body').css({
					'background-color': '#000',
					color: '#fff',
				});
			} else {
				$('body').css({
					'background-color': '#fff',
					color: '#000',
				});
			}
		});
	});

	let sFont;
	wp.customize('font', function (value) {
		value.bind(function (newVal) {
			switch (newVal.toString().toLowerCase()) {
				case 'arial':
					sFont = 'Arial, Helvetica, sans-serif';
					break;
				case 'courier':
					sFont = 'Courier New, Courier';
					break;
				default:
					sFont = 'Arial, Helvetica, sans-serif';
					break;
			}
			$('body').css({
				fontFamily: sFont,
			});
		});
	});

	wp.customize('footer_copyright_text', function (value) {
		value.bind(function (newVal) {
			$('#copyright').text(newVal);
		});
	});

	wp.customize('bg_image', function (value) {
		value.bind(function (newVal) {
			0 === $.trim(newVal).length
				? $('body').css('background-image', '')
				: $('body').css('background-image', 'url( ' + newVal + ')');
		});
	});
});
