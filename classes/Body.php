<?php

	namespace App;

	use App\Config\Snippet;
	use Wa72\HtmlPageDom\HtmlPageCrawler;

	class Body
	{
		private string $name;
		/**
		 * @var Snippet
		 */
		private Snippet $snippet;
		private bool $isHome;
		/**
		 * @var Image
		 */
		private Image $image;

		public function __construct ( HtmlPageCrawler $body, $name, $isHome )
		{
			$this -> isHome = $isHome;
			$this -> snippet = new Snippet();
			$this -> image = new Image();
			$this -> name = $name;
			$this -> parse ( $body );
		}

		private function parse ( $body )
		{
			$this -> saveImages ( $body );

			$this -> savePart ( $body );

			$this -> saveFooter ( $body );

			$body = $this -> changeClsBody ( $body );

			$body = $this -> snippet -> wpGetHeader ( $this -> name ) . $body;

			$body = $this -> saveJs ( $body );

			$body = $this -> removeLinksJs ( $body );

			$body = $this -> removeCloseTagBody ( $body );

			$this -> save ( $body );
		}

		private function saveImages ( $body )
		{
			$body = $body -> filter ( 'img' ) -> each (
				function ( $image, $index ) use ( $body ) {
					$image -> removeAttribute ( 'srcset' );
					$image -> removeAttribute ( 'sizes' );
					$image -> setAttribute ( 'alt', $this -> snippet -> getTitle () );

					$imageUrl = $image -> getAttribute ( 'src' );
					$imageName = $this -> image -> getName ( $imageUrl );
					$this -> image -> save ( $imageUrl, $imageName );

					$image -> setAttribute ( 'src', $this -> snippet -> getTemplateUrl () . '/assets/images/' . $imageName );
				}
			);
			return $body;
		}

		/**
		 * Сохраняет все узлы с атрибутом data-part
		 * в файл в папке template-parts/[name].php
		 * data-part - часть контента которая используется на всех страницах
		 * @param $body
		 * @return void
		 */
		private function savePart ( $body ) : void
		{
			$body -> filter ( '[data-part]' ) -> each (
				function ( $part ) use ( $body ) {
					$namePart = $part -> attr ( 'data-part' );
					$node = $part -> removeAttr ( 'data-part' );

					$node = html_entity_decode ( $node, ENT_NOQUOTES, 'UTF-8' );
					$node = str_replace ( [ "&lt;", "&gt;", "%20", " ", "><" ], [ "<", ">", " ", " ", ">\n<" ], $node );

					/**
					 * Проверка существует ли уже этот файл
					 * если не существует, то сохранить этот блок
					 */
					$files = scandir ( dirname ( __DIR__ ) . '/out/template-parts/' );
					$partExist = in_array ( "$namePart.php", $files );

					if ( !$partExist ) {
						file_put_contents ( dirname ( __DIR__ ) . "/out/template-parts/$namePart.php", $node );
					}

					/**
					 * Удаляем часть блока
					 * добавляем на это место get_template_part ( 'template-parts/$name' )
					 */
					$part -> after ( $this -> snippet -> getTemplatePart ( "$namePart" ) ) -> remove ();
				}
			);
		}

		private function saveFooter ( $body )
		{
			$pattern = '/<.*><script.*><.*>/m';
			preg_replace ($pattern, '', $body);

			$footer = $body -> filter ( 'footer' );
			$footer .= "\n" . '<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->';
			$footer .= "\n" .  "<!--[if lte IE 9]><script src='" . $this -> snippet->getTemplateUrl() . "/assets/scripts/libs/placeholders.min.js'></script><![endif]-->";
			$footer .= $this -> snippet -> wpFooter ();

			$footer = html_entity_decode ( $footer, ENT_NOQUOTES, 'UTF-8' );
			$footer = str_replace ( [ "&lt;", "&gt;", "%20", " " ], [ "<", ">", " ", " " ], $footer );

			if ( $this -> isHome ) {
				file_put_contents ( dirname ( __DIR__ ) . "/out/footer.php", $footer );
			}

			$body -> filter ( 'footer' ) -> after ( $this -> snippet -> wpGetFooter () ) -> remove ();

			return $body;
		}

		private function changeClsBody ( $body )
		{
			$cls = $body -> getAttribute ( "class" );
			$pattern = '/body\s?class=".*"/m';

			$replacement = $this -> snippet -> wpBodyClass ( $cls );

			$body = preg_replace ( $pattern, $replacement, $body );

			return $body;
		}

		private function saveJs ( $body )
		{
			$pattern = '/<script src="(https:\/\/u.*.js)"/m';
			preg_match_all ( $pattern, $body, $matches, PREG_SET_ORDER, 0 );

			$urlJs = $matches[0][1];
			$data = gzdecode ( file_get_contents ( $urlJs ) );

			if ( $this -> isHome ) {
				file_put_contents ( dirname ( __DIR__ ) . "/out/assets/scripts/default.js", $data );
			}

			return $body;
		}

		private function removeLinksJs ( $body )
		{
			$pattern = '/(<\!--.*)?<script.*>.*<\/script>(<.*-->)?/m';
			return preg_replace ( $pattern, "", $body );
		}

		private function removeCloseTagBody ( $body )
		{
			return str_replace ( "</body>", '', $body );
		}

		private function save ( $body )
		{
			$body = html_entity_decode ( $body, ENT_NOQUOTES, 'UTF-8' );

			$body = str_replace ( [ "&lt;", "&gt;", "%20", " ", "><" ], [ "<", ">", " ", " ", ">\n<" ], $body );

			if ( $this -> name === 'page-not-found' ) {
				file_put_contents ( dirname ( __DIR__ ) . "/out/404.php", $body );
			} else {
				file_put_contents ( dirname ( __DIR__ ) . "/out/template-pages/$this->name.php", $body );
			}
		}
	}