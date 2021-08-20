<?php

	/**
	 * Возвращает title
	 * @return mixed
	 */
	function getSeoTitle () {
		$hasCustomTitle = get_field('title');
		$title = $hasCustomTitle ? $hasCustomTitle : get_the_title();

		return $title ? $title : get_bloginfo();
	}

	/**
	 * Возвращает описание [description]
	 * @return mixed
	 */
	function getSeoDescription () {
		$hasCustomDescription = get_field('description');

		return $hasCustomDescription ? $hasCustomDescription : get_bloginfo('description');
	}

	/**
	 * Возвращает url картинки для мета
	 * @return string
	 */
	function getSeoMetaImage () : string
	{
		$hasMetaImage = get_field('meta-image');
		$thumbnail = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : '';

		return $hasMetaImage ? $hasMetaImage : $thumbnail;
	}

	/**
	 * Возвращает расширение изображения
	 * @param string $imgUrl
	 * @return string|string[]
	 */
	function getTypeImg($imgUrl = '') {

		if ($imgUrl === '') return 'jpg';

		$ext = pathinfo($imgUrl, PATHINFO_EXTENSION);

		return $ext;
	}