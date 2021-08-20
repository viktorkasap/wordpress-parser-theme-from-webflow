import parseOnSubmit from './services/parseOnSubmit.service.js';

const formParse = document.forms['form-parse'];
const url = './services/parse.service.php';
const wrpButtons = document.querySelector ( '.wrp-buttons' );
const wrpNotice = document.querySelector('.notice');

formParse.addEventListener ( 'submit', ( e ) => {
	e.preventDefault ();

	const name = formParse.name.value.trim ()
	const source = formParse.source.value.trim ().replace ( /\/$/g, '' );
	const pages = formParse.pages.value.trim ().replace ( /\s/g, '' ).split ( ',' );
	const downloadBtn = wrpButtons.querySelector('.download');
	const submitOverlay = wrpButtons.querySelector('.submit-overlay');

	if (downloadBtn) downloadBtn.remove();
	wrpNotice.innerHTML = '';

	submitOverlay.style.zIndex = '20';

	if ( source ) parseOnSubmit ( name, url, source, pages ).then ( response => {

		console.log ( response );
		if ( response.success ) {
			crateDownload (response.link);
			submitOverlay.style.zIndex = '-10';
		}

		if (response.error) {
			submitOverlay.style.zIndex = '-10';
			const msg = `<strong>${response.message}</strong> <br> ${response.description}`;
			showNotice(msg);
		}
	} );
} );


function crateDownload (link) {
	wrpButtons.insertAdjacentHTML('beforeend', `<a href="${location.origin}${link}" class="link button download">Скачать архив</a>`);
}

function showNotice (msg) {
	wrpNotice.innerHTML = msg;
}











