/* -----------------------------------------------------------------
	Скрипт поддерживает импорт дополнительных файлов скриптов
------------------------------------------------------------------ */
import './custom.js';
/**
 * Функция находит все формы с классом .vi-mailer
 * Предотвращает отправку по умолчанию
 * Запускает функцию send()
 * @return {boolean}
 */
function formsHandler () {
	const forms = document.querySelectorAll ( '.vi-mailer' );

	if ( !forms ) return false;

	forms.forEach ( form => {
		form.setAttribute ( 'action', 'vi' );
		form.addEventListener ( 'submit', formSend );
	} );

	/* отправка формы */
	function formSend ( e ) {
		e.preventDefault ();
		send ( this ).then ( ()  => resetRecaptcha(this) );
	}
}

/* отправка */
async function send ( form ) {
	const submitBtn = form.querySelector('input[type="submit"]');
	const formData = new FormData ( form );

	/* блокируем повторное нажатие кнопки "Отправить" */
	submitBtn.disabled = true;

	formData.append ( 'form-name', form.dataset.name );

	const url = `${ location.origin }/wp-content/themes/theme-name/mailer/send.php`;

	const response = await fetch ( url, {
		method: 'POST',
		body: formData
	} );

	const result = await response.json (); // включить на проде

	console.log ( result );

	/**
	 * проверка на ошибки
	 * выводим сообщения с ошибками
	 */
	if ( result.errors === 1 ) {
		const errors = result;
		delete errors.errors;

		const errorWrapper = form.parentNode.querySelector ( `.w-form-fail` );
		errorWrapper.innerHTML = '';

		for ( let i in errors ) {
			const error = errors[i];
			showMessage ( errorWrapper, error );
		}
		/* включаем возможность по нажатию на "Отправить" */
		submitBtn.disabled = false;
	}

	/**
	 * Вывесит сообщение об успешной отправке
	 */
	if ( result.success === 1 ) {
		const redirect = result.redirect;
		const successMessage = result.successMessage;
		const successWrapper = form.parentNode.querySelector ( `.w-form-done` );

		successWrapper.innerHTML = '';

		if ( redirect !== '' ) {
			location.href = redirect;
		} else {
			showMessage ( successWrapper, successMessage );
			form.reset ();
		}
		form.reset ();

		/* включаем возможность по нажатию на "Отправить" */
		submitBtn.disabled = false;
	}
}

/**
 * Выводит сообщение об отправке или ошибке
 * @param wrapper
 * @param message
 */
function showMessage ( wrapper, message ) {
	wrapper.insertAdjacentHTML ( 'afterbegin', `<div>${ message }</div>` );
	wrapper.style.display = 'block';
	wrapper.style.opacity = '1';

	setTimeout ( () => {
		wrapper.style.opacity = '0';
		wrapper.style.display = 'none';
	}, 3000 );
}

/**
 * Сброс всех рекапч на странице
 * @param form
 */
function resetRecaptcha ( form ) {
	const reWidgets = document.querySelectorAll('.g-recaptcha');

	if (reWidgets) {
		for (let i = 0; i < reWidgets.length; i++) {
			grecaptcha.reset(i);
		}
	}
}

formsHandler ();
