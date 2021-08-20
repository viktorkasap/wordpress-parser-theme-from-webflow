<?php
	require_once ( dirname ( __FILE__ ) . '/../../../../wp-load.php' );

	/* autoloader */
	spl_autoload_register ( 'simplarity_autoloader' );
	function simplarity_autoloader ( $class_name )
	{
		$className = str_replace ( "\\", "/", $class_name );
		$className = str_replace ( "App/", "", $className );
		$class = __DIR__ . "/classes/" . "{$className}.php";

		include_once ( $class );
	}

	/**
	 * Возвращает строку с заглавной буквой
	 * @param $str
	 *
	 * @return string
	 */
	function mb_ucfirst ( $str ) : string
	{
		$fc = mb_strtoupper ( mb_substr ( $str, 0, 1 ) );
		return $fc . mb_substr ( $str, 1 );
	}