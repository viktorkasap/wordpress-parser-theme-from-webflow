<?php

/*
 * Запуск функции перед выводом отрывка поста
 * добавляет к отрывку ссылку "Читать далее"
 */
function vi_read_more_links ($excerpt) {
	$out = $excerpt;
	$out .= " <a href='";
	$out .= get_permalink() . "'";
	$out .= "class='read-more'>";
	$out .= "Читать дальше</a>";
	return $out;
}

add_filter('get_the_excerpt', 'vi_read_more_links', 10);

/*
 * Запуск функции перед выводом отрывка поста
 * меняет в конце отрывка [...] на ...
 */
function vi_excerpt ($excerpt) {
	return str_replace(['[', ']'], '', $excerpt);
}
add_filter('get_the_excerpt', 'vi_excerpt', 10);

/*
 * Запуск функции перед выводом отрывка поста
 * сокращает длину отрывка до 90
 */
function vi_excerpt_length($length){
	return 90;
}
add_filter( 'excerpt_length', 'vi_excerpt_length', 999 );

/* Добавляет type="module" в vi-mailer-script.js */
function vi_mail_script_add_module($tag, $handle, $src) : string {
	if ( 'vi-mailer-script' !== $handle) return $tag;

	$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';

	return $tag;
}
add_filter('script_loader_tag', 'vi_mail_script_add_module' , 10, 3);

/* Добавляет type="module" в custom.js */
function vi_custom_script_add_module($tag, $handle, $src) : string {
	if ( 'vi-custom-script' !== $handle) return $tag;

	$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';

	return $tag;
}
add_filter('script_loader_tag', 'vi_custom_script_add_module' , 10, 3);