<?php
	namespace App\Config;

	class Snippet {
		public function getDoctype () : string
		{
			return "<!DOCTYPE html> \n";
		}

		public function getHtmlTag ($attrs = []) : string
		{
			$out = '<html lang="<?php bloginfo( \'language\' ); ?>" ';

			if (!empty($attrs)) {
				foreach ( $attrs as $attrName => $attrValue ) {
					$out .= $attrName . '="' . $attrValue . '" ';
				}
			}
			return $out . "> \n";
		}

		public function getTitle () : string
		{
			$out = "<";
			$out .= "?php echo getSeoTitle(). ' - ' . getSeoDescription(); ?";
			$out .= ">";
			return $out;
		}

		public function getBody ($cls) : string
		{
			$out = "<body <?php body_class(";
			$out .= $cls;
			$out .= "); ?>";

			return $out;
		}

		public function getTemplateUrl () : string
		{
			$out = "<";
			$out .= "?php echo get_bloginfo('template_url'); ?";
			$out .= ">";
			return $out;
		}

		public function metaCharSet () : string
		{
			$out = "<";
			$out .= "?php bloginfo('charset'); ?";
			$out .= ">";
			return $out;
		}

		public function metaHttpEquiv () : string
		{
			return "\n\t\t" . '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
		}

		public function titleDescription () : string
		{
			$out = 	"\n\t\t" . '<meta content="<?php echo getSeoDescription() ?>" name="description" />';
			$out .= "\n\t\t" . '<meta content="<?php echo getSeoTitle(); ?>" property="og:title"/>';
			$out .= "\n\t\t" . '<meta content="<?php echo getSeoDescription(); ?>" property="og:description" />';
			$out .= "\n\t\t" . '<meta content="<?php echo getSeoTitle(); ?>" property="twitter:title" />';
			$out .= "\n\t\t" . '<meta content="<?php echo getSeoDescription(); ?>" property="twitter:description" />';
			$out .= "\n\t\t" . '<meta property="og:type" content="website" />' . "\n";

			return $out;
		}

		public function metaImage () : string
		{
			$out =  "\n\t\t" . '<meta property="og:image" content="<?php echo getSeoMetaImage(); ?>" />';
			$out .=  "\n\t\t" . '<meta property="og:image:secure_url" content="<?php echo getSeoMetaImage(); ?>" />';
			$out .=  "\n\t\t" . '<meta property="og:image:type" content="image/<?php echo getTypeImg(); ?>" />' . "\n";

			return $out;
		}

		public function wpHead () : string
		{
			$out = "<";
			$out .= "?php wp_head (); ?";
			$out .= "> \n";
			return $out;
		}

		public function wpGetHeader ($name) : string
		{
			$name = ucfirst($name);

			$out = <<<EOT
					<?php
					/**
					 * Template Name: $name
					 */
					EOT;
			$out .= "\n";
			$out .= "get_header (); \n";
			$out .= "?> \n";
			return $out;
		}

		public function getTemplatePart ($name) : string
		{
			$out = "\n <";
			$out .= "?php get_template_part ( 'template-parts/$name' ); ?";
			$out .= "> \n";
			return $out;
		}

		public function wpFooter () : string
		{
			$out = "\n <";
			$out .= "?php wp_footer (); ?";
			$out .= "> \n";
			$out .= "</body> \n";
			$out .= "</html> \n";
			return $out;
		}

		public function wpBodyClass ($cls) : string
		{
			$out = "body <";
			$out .= "?php body_class('$cls'); ?";
			$out .= ">";
			return $out;
		}

		public function wpGetFooter () {
			$out = "<";
			$out .= "?php get_footer (); ?";
			$out .= "> \n";
			return $out;
		}

		public function getThemeDescription ($themeName) {
			$description = <<<EOT
				/*
				Theme Name: $themeName
				Theme URI:
				Author: Kasap Victor
				Author URI: https://kasapvictor.ru
				Description: Creator Kasap Victor for $themeName
				Version: 1.0
				Text Domain: vi
				License: GNU General Public License v2 or later
				License URI: http://www.gnu.org/licenses/gpl-2.0.html
				This theme, like WordPress, is licensed under the GPL.
				Use it to make something cool, have fun, and share what you've learned with others.
				*/
				EOT;

			return $description;
		}

		public function get404Conent () {
			$out = <<<EOT
				<?php
					/**
					 * Template Name: 404
					 */
					get_header ();
				?>
				
				<?php get_footer (); ?>
				EOT;

			return $out;
		}
	}
