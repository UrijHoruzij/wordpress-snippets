<?php
function custom_customize_register($wp_customize)
{
	$transport = 'postMessage';

	$section  = 'footer';
	$wp_customize->add_section($section, [
		'title' => esc_html__('Footer', 'custom'),
		'description' => 'Внешний вид сайта'
		'priority' => 90,
	]);
	$setting = 'link_color';
	$wp_customize->add_setting($setting, [
		'default' => '#000000',
		'transport' => $transport,
	]);
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize, $setting, [
			'label' => 'Цвет ссылок',
			'section' => $section,
			'settings' => $setting,
		])
	);

	$section = 'display';
	$wp_customize->add_section($section, [
		'title' => 'Отображение',
		'description' => 'Внешний вид сайта',
		'priority' => 200, 
	]);
	$setting = 'display_header';
	$wp_customize->add_setting($setting, [
		'default' => 'true',
		'transport' => $transport,
	]);
	$wp_customize->add_control($setting, [
		'section' => $section,
		'label' => 'Отобразить заголовок?',
		'type' => 'checkbox',
	]);


	$setting = 'color_scheme';
	$wp_customize->add_setting($setting, [
		'default' => 'normal',
		'transport' => $transport,
	]);
	$wp_customize->add_control($setting, [
		'section' => $section,
		'label' => 'Цветовая схема',
		'type' => 'radio',
		'choices' => [
			'normal' => 'Светлая',
			'inverse' => 'Темная',
		],
	]);

	$setting = 'font';
	$wp_customize->add_setting($setting, [
		'default' => 'arial', 
		'type' => 'option',
		'transport' => $transport,
	]);
	$wp_customize->add_control($setting, [
		'section' => $section,
		'label' => 'Шрифт',
		'type' => 'select', 
		'choices' => [
			'arial' => 'Arial',
			'courier' => 'Courier New',
		],
	]);

	$setting = 'footer_copyright_text';
	$wp_customize->add_setting($setting, [
		'default' => 'Все права защищены',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => $transport,
	]);
	$wp_customize->add_control($setting, [
		'section' => $section, 
		'label' => 'Копирайт',
		'type' => 'text',
	]);


	$section = 'background-options';
	$wp_customize->add_section($section, [
		'title' => 'Настройки фона',
		'priority' => 201,
	]);
	$setting = 'bg_image';
	$wp_customize->add_setting($setting, [
		'default' => '',
		'transport' => $transport,
	]);
	$wp_customize->add_control(
		new WP_Customize_Image_Control($wp_customize, $setting, [
			'label' => 'Фон сайта',
			'settings' => 'bg_image',
			'section' => $section,
		])
	);
}
add_action('customize_register', 'custom_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customizer_js_file()
{
	wp_enqueue_script(
		'theme-customizer',
		get_stylesheet_directory_uri() . '/js/theme-customizer.js',
		['jquery', 'customize-preview'],
		null,
		true
	);
}
add_action('customize_preview_init', 'customizer_js_file');

// get_option()
