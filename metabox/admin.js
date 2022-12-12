jQuery(function ($) {
	$('.upload_image_button').click(function (event) {
		event.preventDefault();
		const button = $(this);
		const customUploader = wp.media({
			title: 'Выберите изображение',
			library: {
				uploadedTo: wp.media.view.settings.post.id,
				type: 'image',
			},
			button: {
				text: 'Выбрать изображение',
			},
			multiple: false,
		});
		customUploader.on('select', function () {
			const image = customUploader.state().get('selection').first().toJSON();
			button.parent().prev().attr('src', image.url);
			button.prev().val(image.id);
		});
		customUploader.open();
	});

	$('.remove_image_button').click(function (event) {
		event.preventDefault();
		if (true == confirm('Уверены?')) {
			const src = $(this).parent().prev().data('src');
			$(this).parent().prev().attr('src', src);
			$(this).prev().prev().val('');
		}
	});
});
