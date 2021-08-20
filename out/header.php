<!DOCTYPE html> 
<html lang="<?php bloginfo( 'language' ); ?>" data-wf-page="<?php echo getWfPageAttr(); ?>" data-wf-site="6077159fe29683e0d2fdc0a4" > 
<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta content="<?php echo getSeoDescription() ?>" name="description">
		<meta content="<?php echo getSeoTitle(); ?>" property="og:title">
		<meta content="<?php echo getSeoDescription(); ?>" property="og:description">
		<meta content="<?php echo getSeoTitle(); ?>" property="twitter:title">
		<meta content="<?php echo getSeoDescription(); ?>" property="twitter:description">
		<meta property="og:type" content="website">

		<meta property="og:image" content="<?php echo getSeoMetaImage(); ?>">
		<meta property="og:image:secure_url" content="<?php echo getSeoMetaImage(); ?>">
		<meta property="og:image:type" content="image/<?php echo getTypeImg(); ?>">

		<title><?php echo getSeoTitle(). ' - ' . getSeoDescription(); ?></title>
		<meta content="width=device-width, initial-scale=1" name="viewport">
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
		<script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Oswald:200,300,400,500,600,700","Merriweather:300,300italic,400,400italic,700,700italic,900,900italic","Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic","Cormorant:300,300italic,regular,italic,500,500italic,600,600italic,700,700italic:cyrillic,latin"]  }});</script>
		<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif]-->
		<script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
		<link href="<?php echo get_bloginfo('template_url'); ?>/assets/images/6077163538486aa55c2996d3-5e33f80a43be9d1fef522a53-WBDS-logo20120(1).png" rel="shortcut icon" type="image/x-icon">
		<link href="<?php echo get_bloginfo('template_url'); ?>/assets/images/60771638d289755e9ee8a65b-5e33f7f9cb627fa7543699c5-WBDS-logo201.png" rel="apple-touch-icon">
	<?php wp_head (); ?> 
</head>
