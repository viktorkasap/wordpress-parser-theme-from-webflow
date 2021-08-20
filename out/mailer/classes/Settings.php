<?php

	namespace App;

	class Settings
	{
		/**
		 * @var array|mixed
		 */
		private mixed $form;

		public function __construct ()
		{
			$this -> form = $this -> getSettingsForm ();
		}

		public function required () : array
		{
			$required = $this -> form['form-required'];
			$required = str_replace ( ' ', '', $required );
			$required = explode ( ',', $required );

			return $required ?? [];
		}

		public function secret () : string
		{
			return $this -> form['form-secret'];
		}

		public function maxFilesSize () : int
		{
			return $this -> form['form-max-files-size'];
		}

		public function typeFiles () : string
		{
			return $this -> form['form-type-files'];
		}

		public function maxFilesCount () : int
		{
			return $this -> form['form-max-files-count'];
		}

		public function formName () : string
		{
			return $this -> form['form-name'];
		}

		public function emailTo () : string
		{
			return $this -> form['form-to'];
		}

		public function emailCopy () : string
		{
			return $this -> form['form-copy'];
		}

		public function getSuccessMessage () {
			return $this -> form['form-success-message'];
		}

		public function getRedirect () {
			return $this -> form['form-redirect'];
		}

		/**
		 * Настройки для формы
		 * Если настройки не заданы,
		 * то вернутся настройки по умолчанию
		 * @return array|mixed
		 */
		private function getSettingsForm ()
		{
			/* настройки из опций сайта (ACF) */
			$name = get_field ( 'form-name', 'option' );
			$to = get_field ( 'form-to', 'option' );
			$copy = get_field ( 'form-copy' );
			$required = get_field ( 'form-required', 'option' );
			$maxSize = get_field ( 'form-max-size', 'option' );
			$maxCount = get_field ( 'form-max-count', 'option' );
			$type = get_field ( 'form-type', 'option' );
			$successMessage = get_field ( 'form-success-message', 'option' );
			$redirect = get_field ( 'form-redirect', 'option' );

			/**
			 * настройки формы по умолчанию
			 * если в опциях сайта не заданы опции для формы по умолчанию
			 */
			$form = [
				'form-name' => $name ? $name : 'Письмо с сайта - ' . bloginfo ('name'),
				'form-to' => $to ? $to : get_option ( 'admin_email' ), // куда отправлять письмо
				'form-copy' => $copy ? $copy : '', // куда отправить копию письма
				'form-required' => $required ? $required : '',
				'form-max-files-size' => $maxSize ? $maxSize : 10000000,
				'form-max-files-count' => $maxCount ? $maxCount : 10,
				'form-type-files' => $type ? $type : 'jpeg|jpg|png|gif|pdf|svg|tiff|ico|bmp|zip',
				'form-success-message' => $successMessage ? $successMessage : 'Ваше сообщение успешно отправлено!',
				'form-redirect' => $redirect ? $redirect : ''
			];

			$forms = get_field ( 'forms-settings', 'options' );

			/**
			 * если форма по имени не найдена в массиве
			 * то применяться настройки по умолчанию
			 */
			if ( !empty( $forms ) && !empty( $_POST['form-name'] ) ) {
				foreach ( $forms as $settings ) {
					if ( in_array ( $_POST['form-name'], $settings ) ) {

						if ( empty( $settings['form-success-message'] ) ) {
							$settings['form-success-message'] = $form['form-success-message'] ;
						}

						$form = $settings;
					}
				}
			}

			$secret = get_field ( 'secret-recaptcha', 'option' ) ?? '';
			$form['form-secret'] = $secret;

			return $form;
		}

	}
