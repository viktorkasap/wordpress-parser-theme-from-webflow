<?php

  /**
	 * Меняем ширину контента гутенбрега
	 * по умолчанию add_editor_style( 'editor-style.css' );
	 */
	function gutenberg_setup_theme(){
		add_editor_style( get_template_directory_uri() . '/assets/styles/gutenberg.css' );
	}
	add_action( 'after_setup_theme', 'gutenberg_setup_theme' );
