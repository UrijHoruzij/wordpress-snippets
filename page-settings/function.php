<?php
class OptionsPage
{
	public $page_slug;
	public $option_group;
	function __construct()
	{
		$this->page_slug = 'true_slider';
		$this->option_group = 'true_slider_settings';
		add_action('admin_menu', [$this, 'add'], 25);
		add_action('admin_init', [$this, 'settings']);
		add_action('admin_notices', [$this, 'notice']);
	}

	function add()
	{
		add_menu_page(
			'Настройки слайдера',
			'Слайдер',
			'manage_options',
			$this->page_slug,
			[$this, 'display'],
			'dashicons-images-alt2',
			20
		);
	}

	function display()
	{
		echo '<div class="wrap">
        <h1>' .
			get_admin_page_title() .
			'</h1>
        <form method="post" action="options.php">';
		settings_errors('true_slider_settings_errors'); // ярлык – любой
		settings_fields($this->option_group); // название настроек
		do_settings_sections($this->page_slug); // ярлык страницы, не более
		submit_button(); // функция для вывода кнопки сохранения
		echo '</form></div>';
	}

	function settings()
	{
		// регистрируем опцию
		register_setting(
			$this->option_group, // название настроек из предыдущего шага
			'number_of_slider_slides', // ярлык опции
			[$this, 'validate'] // функция валидации
		);
		add_settings_section(
			'slider_settings_section_id', // ID секции, пригодится ниже
			'', // заголовок (не обязательно)
			'', // функция для вывода HTML секции (необязательно)
			$this->page_slug // ярлык страницы
		);
		add_settings_field(
			'number_of_slider_slides',
			'Количество слайдов в слайдере',
			[$this, 'field'], // название функции для вывода
			$this->page_slug, // ярлык страницы
			'slider_settings_section_id', // ID секции, куда добавляем опцию
			[
				'label_for' => 'number_of_slider_slides',
				'class' => 'misha-class', // для элемента <tr>
				'name' => 'number_of_slider_slides', // любые доп параметры в колбэк функцию
			]
		);
	}

	function field($args)
	{
		// получаем значение из базы данных
		$value = get_option($args['name']);
		printf(
			'<input type="number" min="1" id="%s" name="%s" value="%d" />',
			esc_attr($args['name']),
			esc_attr($args['name']),
			absint($value)
		);
	}

	function validate($input)
	{
		// сначала можно сразу же очистить
		$input = absint($input);
		if ($input < 2) {
			// добавляем свои условия валидация
			add_settings_error(
				'true_slider_settings_errors',
				'malo-slides', // часть ID, добавляемый к сообщению об ошибке id="setting-error-malo-slides"
				'В слайдере должно быть хотя бы два слайда иначе это и не слайдер вовсе!',
				'error' // может быть success, warning, info
			);
			// получаем и возвращаем старое значение поля, если валидация не прошла
			$input = get_option('number_of_slider_slides');
		}
		return $input;
	}

	function notice()
	{
		$settings_errors = get_settings_errors('true_slider_settings_errors');
		// если они есть, то уведомление о сохранении выводить не будем
		if (!empty($settings_errors)) {
			return;
		}
		if (
			isset($_GET['page']) &&
			$this->page_slug == $_GET['page'] &&
			isset($_GET['settings-updated']) &&
			true == $_GET['settings-updated']
		) {
			echo '<div class="notice notice-success is-dismissible"><p>Слайдер сохранён!</p></div>';
		}
	}
}

new OptionsPage();

// $num_slides = get_option( 'number_of_slider_slides' );
