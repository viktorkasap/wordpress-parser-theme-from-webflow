<?php
	require_once "../vendor/autoload.php";

	use App\ParseUrl;
	use App\Services\ClearFolder;
	use App\Services\CreateZip;
	use App\Config\Snippet;

	define ( "PATH_ROOT", $_SERVER["DOCUMENT_ROOT"] );

	/**
	 * Запускаем удаление всех файлов
	 * кроме "/assets/styles/main.css" и "/assets/styles/custom.css"
	 */
	$clearFolder = new ClearFolder();
	$clearFolder->process ();

	/**
	 * Получаем список страниц
	 */
	$urls = $_POST;

	/**
	 * Сохраняем данные в корне темы
	 * в файл style.css
	 */
	$projectName = $urls['name'];
	$snippets = new Snippet();
	file_put_contents ( dirname ( __DIR__ ) . "/out/style.css", $snippets->getThemeDescription($projectName) );

	/**
	 * Удаляем из массива имя темы
	 * Остаются только урл для парcинга
	 */
	unset( $urls['name'] );

	/**
	 * Если нет страницы 404
	 * Сохраняем дефолтный контент для 404.php
	 */
	if (!array_key_exists('404', $urls) || !array_key_exists('page-not-found', $urls)) {
		file_put_contents ( dirname ( __DIR__ ) . "/out/404.php", $snippets ->get404Conent () );
	}

	/**
	 * Передаем урл в парсинг страницы
	 */
	foreach ( $urls as $name => $url ) {
		new ParseUrl( $name, $url, $name === 'home' );
	}

	/**
	 * Создаем архив
	 * сохраняем его в папке archives
	 */
	$zip = new CreateZip( $projectName );
	$zip -> create ();
	$zipName = '/archive/' . str_replace (' ', '-', mb_strtolower ($projectName)) . '.zip';

	echo json_encode ([
		'success' => 1,
		'link' => $zipName
	]);




