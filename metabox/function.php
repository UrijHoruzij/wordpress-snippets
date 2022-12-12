<?php
add_action('admin_enqueue_scripts', 'landing_include_image_metabox');
 
function landing_include_image_metabox($hook) {
	if ( !did_action('wp_enqueue_media')){
		wp_enqueue_media();
	}
 	wp_enqueue_script( 'include_image_metabox', get_stylesheet_directory_uri() . '/admin.js', array('jquery'), null, false );
}

add_action( 'add_meta_boxes', 'add_metabox_landing' );
 
function add_metabox_landing() {
	add_meta_box(
		'landing_metabox', // ID нашего метабокса
		'Настройки поста', // заголовок
		'landing_metabox_callback', // функция, которая будет выводить поля в мета боксе
		'page', // типы постов, для которых его подключим
		'normal', // расположение (normal, side, advanced)
		'default' // приоритет (default, low, high, core)
	);
}

function landing_metabox_callback($post) {
    $metabox_text = get_post_meta($post->ID, 'text', true);
    $metabox_textarea = get_post_meta($post->ID, 'textarea', true);
    $metabox_checkbox = get_post_meta($post->ID, 'checkbox', true);
    $metabox_select = get_post_meta($post->ID, 'select', true);
    $metabox_radio = get_post_meta($post->ID, 'radio', true);

    $metabox_image = get_post_meta( $post->ID, 'image', true )
	$default = get_stylesheet_directory_uri() . '/placeholder.png';
	if( $landing_image && ( $image_attributes = wp_get_attachment_image_src($landing_image, array(150,110)))) {
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}
    ?>
    <table class="form-table">
		<tbody>
			<tr>
				<th><label for="metabox_text">Строка</label></th>
				<td>
                   <input id="metabox_text" class="regular-text" type="text" value="<?php esc_attr($metabox_text)?>" name="extra[text]"  style="width:50%" />
                </td>
			</tr>
			<tr>
				<th><label for="metabox_textarea">Текст</label></th>
				<td>
					<textarea type="text" id="metabox_textarea" name="extra[textarea]" style="width:50%;height:50px;"><?php esc_attr($metabox_textarea) ?></textarea>
				</td>
			</tr>
            <tr>
				<th><label for="metabox_checkbox">Чекбокс</label></th>
				<td>
                    <input type="hidden" name="extra[checkbox]" value="" />
                    <input type="checkbox" id="metabox_checkbox" name="extra[checkbox]" value="true" <?php checked( 'true', $metabox_checkbox )?> />
				</td>
			</tr>
            <tr>
				<th><label for="metabox_select">Селект</label></th>
				<td>
                    <select id="metabox_select" name="extra[select]">
                        <option value="0">----</option>
                        <option value="1" <?php selected($metabox_select, '1')?> >Выбери меня</option>
                        <option value="2" <?php selected($metabox_select, '2')?> >Нет, меня</option>
                        <option value="3" <?php selected($metabox_select, '3')?> >Лучше меня</option>
                    </select>
				</td>
			</tr>
            <tr>
				<th>Радио</th>
				<td>
                    <input type="radio" name="extra[radio]" value="" <?php checked( $metabox_radio, '' ); ?> /> index,follow
                    <input type="radio" name="extra[radio]" value="nofollow" <?php checked( $metabox_radio, 'nofollow' ); ?> /> nofollow
                    <input type="radio" name="extra[radio]" value="noindex" <?php checked( $metabox_radio, 'noindex' ); ?> /> noindex
                    <input type="radio" name="extra[radio]" value="noindex,nofollow" <?php checked( $metabox_radio, 'noindex,nofollow' ); ?> /> noindex,nofollow
                </td>
			</tr>
            <tr>
				<th><label for="metabox_image">Изображение</label></th>
				<td>
                    <img data-src="<?php echo $default ?>" src="<?php echo $src ?>" width="150" />
                    <div>
                        <input type="hidden" name="extra[image]" value="<?php esc_attr($metabox_image)?>" />
                        <button type="submit" class="upload_image_button button">Загрузить</button>
                        <button type="submit" class="remove_image_button button">×</button>
                    </div>
				</td>
			</tr>
		</tbody>
	</table>';
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}
add_action( 'save_post', 'landing_save_meta', 0 );

function landing_save_meta($post_id){
	if (empty($_POST['extra'])
		|| ! wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__)
		|| wp_is_post_autosave($post_id)
		|| wp_is_post_revision($post_id)
	){
        return false;
    }
	$_POST['extra'] = array_map('sanitize_text_field', $_POST['extra']); 
	foreach($_POST['extra'] as $key => $value){
		if(empty($value)){
			delete_post_meta($post_id, $key);
			continue;
		}
		update_post_meta($post_id, $key, $value);
	}
	return $post_id;
}

// get_post_meta( get_the_ID(), 'text', true )
// get_post_meta( get_the_ID(), 'textarea', true )
// get_post_meta( get_the_ID(), 'checkbox', true )
// get_post_meta( get_the_ID(), 'select', true )
// get_post_meta( get_the_ID(), 'radio', true )
// get_post_meta( get_the_ID(), 'image', true )


