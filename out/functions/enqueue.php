<?php

//добавляем скрипты и стили
function vi_enqueue() {
	// отключаем старый jquery
	wp_deregister_script( 'jquery' );

	// подключаем новый jquery
	wp_register_script('jquery', get_template_directory_uri() . '/assets/scripts/libs/jquery-3.5.1.min.js' , false, '3.5.1', false);
	wp_enqueue_script( 'jquery' );

	// дефолтные стили темы
	wp_enqueue_style('vi-default-style', get_template_directory_uri() . '/assets/styles/default.css', false, '1.0.0');

	// дефолтный скрипт темы
	wp_enqueue_script('vi-default-script', get_template_directory_uri() . '/assets/scripts/default.js', ['jquery'], '1.0.0', true);

	// стили создаются упаковщиком parceljs
	wp_enqueue_style('vi-bundler-style', get_template_directory_uri() . '/assets/styles/styles.css', false, '1.0.0');

	// скрипты создаются упаковщиком parceljs
	wp_enqueue_script('vi-bundler-script', get_template_directory_uri() . '/assets/scripts/scripts.js', ['jquery'], '1.0.0', true);

	// скрипт почты
	wp_enqueue_script('vi-mailer-script', get_template_directory_uri() . '/mailer/assets/scripts/mail.js', [], '1.0.0', true);

	// кастомные стили
	wp_enqueue_style('vi-custom-style', get_template_directory_uri() . '/assets/custom/custom.css', false, '1.0.0');

	// кастомные скрипты
	wp_enqueue_script('vi-custom-script', get_template_directory_uri() . '/assets/custom/custom.js', ['jquery'], '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'vi_enqueue');

