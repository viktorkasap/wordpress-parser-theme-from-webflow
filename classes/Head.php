<?php

	namespace App;

	use App\Config\Snippet;
	use Wa72\HtmlPageDom\HtmlPageCrawler;

	class Head
	{
		/**
		 * @var Snippet
		 */
		private Snippet $snippet;
		/**
		 * @var Image
		 */
		private Image $image;
		/**
		 * @var Css
		 */
		private Css $css;


		public function __construct ( HtmlPageCrawler $head, $attrs = [] )
		{
			$this -> snippet = new Snippet();
			$this -> image = new Image();
			$this -> css = new Css();
			$this -> parse ( $head, $attrs );
		}

		private function parse ( $head, $attrs )
		{
			$this -> setMetaAttribute ( $head, 'charset', $this -> snippet -> metaCharSet () );

			$this -> addAfter ( $head, 'charset', $this -> snippet -> metaImage () );

			$this -> addAfter ( $head, 'charset', $this -> snippet -> titleDescription () );

			$this -> addAfter ( $head, 'charset', $this -> snippet -> metaHttpEquiv () );

			$this -> remove ( $head, '[content="Webflow"]' );

			$this -> setTitle ( $head );

			$this -> saveCss ( $head );

			$this -> saveFavicon ( $head );

			$this -> save ( $head, $attrs );
		}

		private function setMetaAttribute ( $head, $search, $attr )
		{
			$head -> filter ( "[$search]" ) -> setAttribute ( $search, $attr );

			return $head;
		}

		private function addAfter ( $head, $search, $metaTag )
		{

			$head -> filter ( "[$search]" ) -> after ( $metaTag );

			return $head;
		}

		private function remove ( $head, $search )
		{
			$head -> filter ( $search ) -> remove ();

			return $head;
		}

		private function setTitle ( $head )
		{
			$head -> filter ( 'title' ) -> setText ( $this -> snippet -> getTitle () );

			return $head;
		}

		private function saveCss ( $head )
		{
			$styles = $head -> filter ( '[type="text/css"]' );
			$this -> css -> process ( $styles );
			$styles -> remove ();

			return $head;
		}

		private function saveFavicon ( $head )
		{
			$favicons = [ '[rel="shortcut icon"]', '[rel="apple-touch-icon"]' ];
			$this -> image -> renamePath ( $head, 'href', $this -> snippet -> getTemplateUrl () . "/assets/images/", $favicons );
		}

		private function save ( $head, $attrs )
		{
			$out = $this -> snippet -> getDoctype ();
			$out .= $this -> snippet -> getHtmlTag ( $attrs );
			$out .= $head -> filter ( "head" ) -> append ( $this -> snippet -> wpHead () ) . "\n";
			$out = str_replace ( [ '&lt;', '&gt;', '%20' ], [ '<', '>', ' ' ], $out );

			file_put_contents ( dirname ( __DIR__ ) . "/out/header.php", $out );
		}
	}