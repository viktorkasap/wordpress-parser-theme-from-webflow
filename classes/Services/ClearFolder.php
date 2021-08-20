<?php

	namespace App\Services;

	class ClearFolder
	{

		public function process ()
		{
			$path = PATH_ROOT . DIRECTORY_SEPARATOR . 'out';
			$folders = [
				$path . "/_origin",
				$path . "/assets/fonts",
				$path . "/assets/images",
				$path . "/assets/styles",
				$path . "/template-pages",
				$path . "/template-parts",
			];

			$this -> clear ( $folders );
		}

		private function clear ( $folders )
		{
			foreach ( $folders as $folder ) {
				$files = glob ( $folder . '/*' );

				foreach ( $files as $file ) {
					$pattern = '/\/styles\/(.*)\.css$/m';
					preg_match_all ( $pattern, $file, $matches, PREG_SET_ORDER );

					if (isset($matches) && !empty($matches)) {
						if ( $matches[0][1] === 'main' || $matches[0][1] === 'custom' ) continue;
					}

					if ( is_file ( $file ) ) unlink ( $file );
				}
			}
		}
	}