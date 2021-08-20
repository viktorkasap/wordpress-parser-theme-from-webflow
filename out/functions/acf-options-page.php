<?php

	/**
	 * Добавляет "Общие настройки"
	 * в блок "Внешний вид"
	 */
	if ( function_exists ( 'acf_add_options_page' ) && current_user_can ( 'manage_options' ) ) {
		acf_add_options_page ( [
			'page_title' => 'Общие настройки',
			'menu_title' => 'Опции темы',
			'menu_slug' => 'theme-general-settings',
			'capability' => 'edit_posts',
			'parent_slug' => 'themes.php',
			'redirect' => false
		] );
	}

	/**
	 * Добавляет в админ бар ссылку на "Общие настройки"
	 */
	add_action ( 'admin_bar_menu', 'custom_general_settings_page', 999 );
	function custom_general_settings_page ( $wp_admin_bar )
	{
		$args = array (
			'id' => 'theme-general-settings',
			'title' => '| Общие настройки |',
			'href' => '/wp-admin/themes.php?page=theme-general-settings',
			'meta' => array (
				'class' => 'general-settings',
				'title' => 'Общие настройки'
			)
		);
		$wp_admin_bar -> add_node ( $args );
	}


