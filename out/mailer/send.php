<?php
	require_once 'functions.php';
	use App\Mailer;
	use App\Settings;

	/* Получаем настройки для формы */
	$settings = new Settings();

	/**
	 * Создаем объект отправки
	 * Передаем в него объект с настройками
	 */
	$mailer = new Mailer( $settings );
	$checks = $mailer -> checks ();

	/**
	 * Валидация нанных
	 * В случае ошибка вернет json с описанием ошибки
	 */
	if ( ! empty ( $checks ) && $checks['errors'] === 1 ) {
		echo json_encode( $checks );
		exit();
	}

	/* Отправка форма */
	if ( $mailer -> send() ) {
		echo json_encode( [
			'success'        => 1,
			'successMessage' => $settings->getSuccessMessage(),
			'redirect'       => $settings->getRedirect()
		] );
	} else {
		echo json_encode( [ 'errors' => "Что-то пошло не так... Попробуйте позже." ] );
	}
