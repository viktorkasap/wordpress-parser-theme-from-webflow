<?php

	namespace App;

	class Css
	{
		/**
		 * @var Image
		 */
		private Image $image;
		private Fonts $fonts;

		public function __construct ()
		{
			$this -> image = new Image();
			$this -> fonts = new Fonts();
		}

		/**
		 * Получаем массив стилей, возвращает массив с именами стилей
		 * @param $styles
		 */
		public function process ( $styles )
		{
			$namesCss = [];
			foreach ( $styles as $style ) {
				$url = $style -> getAttribute ( 'href' );
				$name = $this -> getName ( $url );
				$namesCss[] = $name;
				$this -> save ( $url, $name );
			}

			$this -> updateImportNames ( $namesCss );
		}

		/**
		 * Сохраняем файл стилей
		 * @param $url string
		 * @param $name string
		 */
		private function save ( string $url, string $name )
		{
			$data = gzdecode ( file_get_contents ( $url ) );

			$this -> updateBackgroundImageUrl ( $data );

			$this -> updateUrlFont ( $data );

			file_put_contents ( dirname ( __DIR__ ) . "/out/assets/styles/$name", $data );
		}

		/**
		 * Получаем урл файла стилей
		 * Возвращаем имя файла
		 * @param $url string
		 * @return mixed|string
		 */
		private function getName ( string $url ) : string
		{
			$path = parse_url ( $url )['path'];
			$name = explode ( '/', $path );
			$name = $name[ count ( $name ) - 1 ];

			return $name;
		}

		/**
		 * Импортируем все файлы стилей в один файл
		 * @param $names array
		 */
		private function updateImportNames ( array $names )
		{
			$strImport = '';
			foreach ( $names as $name ) {
				$strImport .= "@import '$name'; \n";
			}
			file_put_contents ( dirname ( __DIR__ ) . "/out/assets/styles/default.css", $strImport );
		}

		/**
		 * Обновляем пути для картинок
		 * возвращаем обратно все стили
		 * @param $data string
		 */
		private function updateBackgroundImageUrl ( string &$data )
		{
			$images = [];

			$pattern = '/http[^;,]+(jpg|jpeg|png|gif|svg)/m';
			preg_match_all ( $pattern, $data, $matches, PREG_SET_ORDER, 0 );

			foreach ( $matches as $match ) {
				$imageUrl = $match[0];
				$imageName = $this -> image -> getName ( $imageUrl );
				$this -> image -> save ( $imageUrl, $imageName );
				$images[ $imageUrl ] = $imageName;

				$data = str_replace ( "$imageUrl", "../images/$imageName", $data );
			}
		}

		private function updateUrlFont ( &$data )
		{
			$pattern = "/http[^']+(ttf|otf|eot|woff2?)/i";
			preg_match_all ( $pattern, $data, $matches, PREG_SET_ORDER, 0 );

			foreach ( $matches as $match ) {
				$fontUrl = $match[0];

				/* Получаем имя шрифта */
				$name = $this -> fonts -> getName ( $fontUrl );

				/* Меняем пути в стилях для шрифтов */
				$data = str_replace ( "$fontUrl", "../fonts/$name", $data );

				/*  Сохраняем шрифт */
				$this -> fonts -> save ( $fontUrl, $name );
			}
		}
	}