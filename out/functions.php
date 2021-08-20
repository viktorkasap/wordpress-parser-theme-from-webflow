<?php

	/*
	 * разные функции
	 */
	require get_template_directory() . '/functions/helpers.php';

	/*
	 * стили и скрипты
	 */
	require get_template_directory() . '/functions/enqueue.php';

	/*
	 * опции ACF
	 */
	require get_template_directory() . '/functions/acf-options-page.php';

	/*
	 * настройки форм ACF
	 */
	require get_template_directory () . '/functions/acf-forms-settings.php';

	/*
	 * меню
	 */
	require get_template_directory() . '/functions/menu.php';

	/*
	 * изображения
	 */
	require get_template_directory() . '/functions/add_theme_support.php';

	/*
	 * хуки
	 */
	require get_template_directory() . '/functions/actions.php';

	/*
	 * фильтры
	 */
	require get_template_directory() . '/functions/filters.php';

	/*
	 * мета атрибуты для head.php
	 */
	 require get_template_directory() . '/functions/seo.php';

 /*
	* Включение поддержки шаблонов старниц woocommerce
	*/
	require get_template_directory() . '/functions/woocommerce-support.php';

