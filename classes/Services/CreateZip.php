<?php

	namespace App\Services;

	use ZipArchive;

	class CreateZip
	{
		private string $name;

		public function __construct ( $name )
		{
			$this -> name = str_replace ( ' ', '-', mb_strtolower ( $name ) );
		}

		public function create ()
		{
			$path = PATH_ROOT . DIRECTORY_SEPARATOR . 'out';
			$temp = PATH_ROOT . DIRECTORY_SEPARATOR . 'archive' . DIRECTORY_SEPARATOR . $this -> name . ".zip";

			$zip = new ZipArchive();

			$zip -> open ( $temp, ZipArchive::CREATE | ZipArchive::OVERWRITE );

			$this -> addFiles ( $zip, $path );
		}

		private function addFiles ( $zip, $dir, $start = '' )
		{
			if ( empty( $start ) ) {
				$start = $dir;
			}
			if ( $objs = glob ( $dir . '/*' ) ) {
				foreach ( $objs as $obj ) {
					if ( is_dir ( $obj ) ) {
						$this -> addFiles ( $zip, $obj, $start );
					} else {
						if ( str_replace ( $start . '/', '', $obj ) ) {
							$zip -> addFile ( $obj, str_replace ( $start . '/', '', $obj ) );
						}
					}
				}
			}
		}
	}

