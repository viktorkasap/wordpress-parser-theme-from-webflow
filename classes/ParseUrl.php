<?php

	namespace App;

	use \Wa72\HtmlPageDom\HtmlPage;

	class ParseUrl
	{
		private string $name;
		/**
		 * @var HtmlPage
		 */
		private HtmlPage $content;

		public function __construct ( $name, $url, $isHome = false )
		{
			$this -> name = $name;
			$this -> content = $this -> getPage ( $url );
			$this -> getHead ( $isHome );
			$this -> getBody ( $isHome );
		}

		/**
		 * Получает весь контент страницы
		 * @param $url string
		 * @return HtmlPage
		 */
		private function getPage ( string $url ) : HtmlPage
		{
			$content = @file_get_contents ( $url );

			if ( !strpos ( $http_response_header[0], "200" ) ) {
				echo json_encode ([
					'error' => 1,
					'message' => "Ошибка URL",
					'description' => "Такого адреса не существует: $url"
				]);
				die();
			};

			$content = new HtmlPage( $content );
			try {
				$content -> indent () -> save ();
			} catch ( \Exception $e ) {
				echo $e -> getMessage ();
			}

			$out = html_entity_decode ($content, ENT_NOQUOTES,'UTF-8');
			$out = str_replace ([" ", "><"], [" ", ">\n<"], $out);

			file_put_contents ( dirname ( __DIR__ ) . "/out/_origin/$this->name.html", $out ); // html_entity_decode (rawurldecode ($content), ENT_QUOTES)

			return $content;
		}

		/**
		 * Получаем <head>
		 * @param boolean $isHome
		 */
		private function getHead ( bool $isHome )
		{
			$attrs = [
				'data-wf-page' => '<?php echo getWfPageAttr(); ?>',
				'data-wf-site' => $this -> content -> filter ( 'html' ) -> attr ( 'data-wf-site' )
			];

			if ( $isHome ) {
				new Head( $this -> content -> filter ( 'head' ), $attrs );
			}
		}

		private function getBody ( $isHome )
		{
			new Body( $this -> content -> filter ( 'body' ), $this -> name, $isHome );
		}
	}