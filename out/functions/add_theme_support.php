<?php

/*
 * Поддержка изображений
 * Например - миниатюры только для постов блога
 * add_theme_support('post-thumbnails', ['post']);
 */
add_theme_support('post-thumbnails');

/*
 * Новый размер для изображений 1024 на 800
 */
add_image_size('1024x800', 1024, 800, true);

/*
 * Включает поддержку html5 разметки
 */
add_theme_support( 'html5', array(
	'comment-list',
	'comment-form',
	'search-form',
	'gallery',
	'caption',
	'script',
	'style',
) );


/*
 * Добавляет ссылки на RSS фиды постов и комментариев
 * в head часть HTML документа.
 */
add_theme_support( 'automatic-feed-links' );


/*
 * Чтобы изменить размер содержимого
 * и сохранить его соотношение сторон
 */
add_theme_support( 'responsive-embeds' );

