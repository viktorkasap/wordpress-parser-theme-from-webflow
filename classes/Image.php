<?php

	namespace App;

	class Image
	{
		public function getName ( string $imageUrl ) : string
		{
			$path = parse_url ( $imageUrl )['path'];
			$name = explode ( '/', $path );
			$name = $name[ count ( $name ) - 1 ];
			$name = str_replace ( [ ' ', '_', '%20', '%D0', '%B2' ], '-', $name );

			return $name;
		}

		public function renamePath ( object $obj, string $attr, string $path, array $elements ) : object
		{
			foreach ( $elements as $el ) {
				$imageUrl = $obj -> filter ( $el ) -> attr ( $attr );
				$imageName = Image ::getName ( $imageUrl );
				Image ::save ( $imageUrl, $imageName );
				$obj -> filter ( $el ) -> setAttribute ( $attr, $path . $imageName );
			}

			return $obj;
		}

		static function save ( string $imageUrl, string $name )
		{
			file_put_contents ( dirname ( __DIR__ ) . "/out/assets/images/$name", fopen ( $imageUrl, 'r' ) );
		}
	}