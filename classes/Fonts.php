<?php

	namespace App;

	class Fonts
	{
		public function getName ( $fontUrl )
		{
			$pattern = '/_(.*\.(ttf|otf|eot|woff2?))/m';
			preg_match_all ( $pattern, $fontUrl, $matches, PREG_SET_ORDER, 0 );
			return $matches[0][1];
		}

		public function save ( $fontUrl, $name )
		{
			file_put_contents ( dirname ( __DIR__ ) . "/out/assets/fonts/$name", fopen ( $fontUrl, 'r' ) );
		}
	}