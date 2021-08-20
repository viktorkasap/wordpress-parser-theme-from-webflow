<?php

	namespace App;

	class Mailer
	{
		private $settings;
		private $post;
		/**
		 * @var array
		 */
		private array $errors;

		public function __construct ( $settings )
		{
			$this -> post = $this -> toLowerKey ( $_POST );
			$this -> settings = $settings;
			$this -> errors = [];
			$this -> errors['errors'] = 0;
		}

		public function send ()
		{
			$to = $this -> settings -> emailTo ();
			$copy = $this -> settings -> emailCopy ();
			$subject = $this -> settings -> formName ();
			$host = $_SERVER['HTTP_HOST'];
			$message = "<br> <h3>$subject</h3> <hr> <br>" . $this -> fields ();
			$headers = [
				"From: " . get_bloginfo () . ": $subject <no-reply@$host>",
				// если мы просто получаем письма и не отвечаем на них
				// "From: " . $_POST['email'] . " <no-reply@kasapvictor.online>", // если нужно сразу ответить тому кто прислал сообщение
				"Cc: $copy",
				"content-type: text/html",
				"Reply-To: <" . $to . ">"
			];

			if ( !empty( $_FILES ) ) {
				$attachments = $this -> uploadFiles ();
			}

			if ( wp_mail ( $to, $subject, $message, $headers, $attachments ) ) {

				/* удаление всех файлов из папки attachments */
				if ( !empty( $_FILES ) ) {
					foreach ( $attachments as $attach ) {
						@unlink ( $attach );
					}
				}

				/*  Ответное сообщение пользователю */
				// $this->answer ();
				return true;

			} else {
				return false;
			}
		}

		// Автоответ пользователю
		private function answer ()
		{
			$to = $this->post['email'];
			$subject = "Спасибо за ваше сообщение";
			$host = $_SERVER['HTTP_HOST'];
			$message = $this->getContentTemplate();
			$headers = [
				"From: " . get_bloginfo () . " <no-reply@$host>",
				"content-type: text/html",
				"Reply-To: <" . $to . ">"
			];

			if ( wp_mail ( $to, $subject, $message, $headers ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Подключает шаблон письма для ответа
		 * @return false|string
		 */
		private function getContentTemplate () {
			ob_start();

			include __DIR__ . "/../templates/template.php";

			$out = ob_get_contents();

			ob_end_clean();

			return $out;
		}

		public function checks ()
		{
			// Проверка reCaptcha
			if ( isset( $this -> post['g-recaptcha-response'] ) ) {

				if ( !empty( $this -> post['g-recaptcha-response'] ) ) {
					$this -> checkRecaptcha ( $this -> settings -> secret (), $this -> post['g-recaptcha-response'] );
				} else {
					$this -> errors['errors'] = 1;
					$this -> errors[] = 'Error: reCAPTCHA';
				}
			}

			$this -> checkEmail ( $this -> post['email'] );

			$this -> checkRequired ( $this -> settings -> required () );

			if ( !empty( $_FILES ) ) {
				$this -> checkFiles ();
			}

			return $this -> errors;
		}

		private function toLowerKey ( $post ) : array
		{
			$arr = [];

			foreach ( $post as $k => $v ) $arr[ mb_strtolower ( $k ) ] = $v;

			return $arr;
		}

		private function checkRecaptcha ( $secret, $response )
		{
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptchaData = [
				'secret' => $secret,
				'response' => $response
			];

			$options = array (
				'http' => array (
					'header' => "Content-Type: application/x-www-form-urlencoded",
					'method' => 'POST',
					'content' => http_build_query ( $recaptchaData )
				)
			);

			$context = stream_context_create ( $options );
			$verify = file_get_contents ( $url, false, $context );
			$result = json_decode ( $verify ) -> success;

			if ( !$result ) {
				$this -> errors['errors'] = 1;
				$this -> errors[] = 'Error: reCAPTCHA';
			}
		}

		private function checkEmail ( $email )
		{
			if ( $email ) {
				$check = preg_match ( "/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email );

				if ( !$check ) {
					$this -> errors['errors'] = 1;
					$this -> errors[] = "Ошибка: неверный email!";
				}
			}
		}

		private function checkRequired ( $required )
		{
			foreach ( $required as $require ) {
				if ( empty( $this -> post[ $require ] ) ) {
					$this -> errors['errors'] = 1;
					$this -> errors[] = "Ошибка: '" . mb_strtolower ( $require ) . "' обязательно!";
				}
			}
		}

		private function checkFiles ()
		{
			$maxFilesSize = $this -> settings -> maxFilesSize ();
			if ( isset( $_FILES['attachments'] ) ) {
				$totalSize = 0;

				foreach ( $_FILES['attachments']['size'] as $attachmentSize ) {
					$totalSize += $attachmentSize;
				}

				if ( $totalSize > $maxFilesSize ) {
					$this -> errors[] = 'Максимальный объем файлов = 10Мб';
					$this -> errors['errors'] = 1;
				}

				/**
				 * Проверяем на количество файлов
				 * по умолчанию 10 шт
				 */
				$this -> checkCountFiles ( $this -> settings -> maxFilesCount () );

				/*
				 * Проверка на типы файлов
				 * по умолчанию 'jpeg|jpg|png|gif|pdf|svg|tiff|ico|bmp|zip'
				 */
				$this -> chekTypesFiles ( $this -> settings -> typeFiles () );
			}
		}

		private function checkCountFiles ( $limit )
		{
			if ( isset( $_FILES['attachments'] ) && !empty( $_FILES['attachments']['name'] ) ) {
				$count = count ( $_FILES['attachments']['name'] );
				if ( $count > $limit ) {
					$this -> errors[] = "Максимальное кол-во файлов: $limit";
					$this -> errors['errors'] = 1;
				}
			}
		}

		private function chekTypesFiles ( $types )
		{
			if ( isset( $_FILES['attachments'] ) && !empty( $_FILES['attachments']['name'][0] ) ) {
				$attachmentsNames = $_FILES['attachments']['name'];
				$pattern = "/.*\.($types)$/m";

				foreach ( $attachmentsNames as $name ) {
					preg_match ( $pattern, $name, $match );
					if ( empty( $match ) ) {
						$types = str_replace ( "|", ', ', $types );
						$this -> errors[] = "Допустимые форматы: $types";
						$this -> errors['errors'] = 1;
					}
				}
			}

		}

		private function uploadFiles () : array
		{
			$attachments = [];
			$uploadDir = realpath ( dirname ( __DIR__ . '../' ) ) . '/attachments/';

			$myFile = $_FILES['attachments'];
			$fileCount = count ( $myFile["name"] );

			for ( $i = 0; $i < $fileCount; $i++ ) {
				$uploadFile = $uploadDir . basename ( $_FILES['attachments']['name'][ $i ] );
				if ( !move_uploaded_file ( $_FILES['attachments']['tmp_name'][ $i ], $uploadFile ) ) {
					break;
				}
				$attachments[ $i ] = $uploadFile;
			}

			return $attachments;
		}

		private function fields () : string
		{
			$fields = "";

			/*  удаляем ответный ключ проверки recaptcha */
			unset( $this -> post['g-recaptcha-response'] );

			/* удаляем имя формы из массива $_POST */
			unset( $this -> post['form-name'] );

			/* заполняем $fields данными из формы  */
			foreach ( $this -> post as $key => $value ) {

				if ( $value === 'on' ) {
					$value = 'да';
				}

				if ( is_array ( $value ) ) {
					$fields .= str_replace (
							'_',
							' ',
							"<strong>" . mb_ucfirst ( $key ) . "</strong>" ) . ': <br>&nbsp;- ' . implode ( ', <br />&nbsp;- ', $value ) . '<br><br>';
				} else {
					if ( $value !== '' ) {
						$fields .= str_replace (
								'_',
								' ',
								"<strong>" . mb_ucfirst ( $key ) . "</strong>" ) . ': ' . $value . '<br><br>';
					}
				}
			}

			$fields .= "<br><hr><br>";

			return $fields;
		}
	}
