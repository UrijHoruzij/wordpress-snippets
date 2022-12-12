<?php
add_action('init', 'register_new_post_type');
function register_new_post_type()
{
	// добавление категорий
	register_taxonomy(
		'news_cat',
		['news'],
		[
			'label' => 'Тип новостей',
			'labels' => [
				'name' => 'Типы новостей',
				'singular_name' => 'Тип новостей',
				'search_items' => 'Искать тип новостей',
				'all_items' => 'Все типы новостей',
				'parent_item' => 'Родит. тип новостей',
				'parent_item_colon' => 'Родит. тип новостей:',
				'edit_item' => 'Ред. тип новостей',
				'update_item' => 'Обновить тип команды',
				'add_new_item' => 'Добавить тип новостей',
				'new_item_name' => 'Новый тип новостей',
				'menu_name' => 'Типы новостей',
			],
			'description' => 'Типы новостей',
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => true,
			'show_admin_column' => true,
			'show_in_rest' => true,
		]
	);

	register_post_type('news', [
		'label' => __('Новости', 'news-blog'),
		'labels' => [
			'name' => __('Новости', 'news-blog'),
			'singular_name' => __('Новость', 'news-blog'),
			'add_new' => __('Добавить новость', 'news-blog'),
			'add_new_item' => __('Добавить новость', 'news-blog'),
			'edit_item' => __('Изменить новость', 'news-blog'),
			'new_item' => __('Новая новость', 'news-blog'),
			'view_item' => __('Просмотр новости', 'news-blog'),
			'search_items' => __('Найти новость', 'news-blog'),
			'not_found' => __('Новости не найдены', 'news-blog'),
			'not_found_in_trash' => __('В корзине нет новостей', 'news-blog'),
			'parent_item_colon' => __('Родительская новость', 'news-blog'),
			'all_items' => __('Все новости', 'news-blog'),
			'archives' => __('Новости', 'news-blog'),
			'menu_name' => __('Новости', 'news-blog'),
			'name_admin_bar' => __('Новость', 'news-blog'),
			'view_items' => __('Просмотр новости', 'news-blog'),
			'attributes' => __('Свойства новости', 'news-blog'),

			'insert_into_item' => __('Вставить в новость', 'news-blog'),
			'uploaded_to_this_item' => __('Загружено для этой новости', 'news-blog'),
			'featured_image' => __('Изображение новости', 'news-blog'),
			'set_featured_image' => __('Установить изображение новости', 'news-blog'),
			'remove_featured_image' => __('Удалить изображение новости', 'news-blog'),
			'use_featured_image' => __('Использовать как изображение новости', 'news-blog'),

			'item_updated' => __('Новость обновлёна.', 'news-blog'),
			'item_published' => __('Новость добавлена.', 'news-blog'),
			'item_published_privately' => __('Новость добавлена приватно.', 'news-blog'),
			'item_reverted_to_draft' => __('Новость сохранёна как черновик.', 'news-blog'),
			'item_scheduled' => __('Публикация новости запланирована.', 'news-blog'),
		],
		'hierarchical' => true,
		'description' => '',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'exclude_from_search' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-megaphone',
		'has_archive' => 'news',
		'rewrite' => ['slug' => 'news'],
		'query_var' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'show_in_rest' => true,
		'supports' => ['title', 'editor', 'thumbnail'],
		'taxonomies' => ['news_cat'],
	]);
}
