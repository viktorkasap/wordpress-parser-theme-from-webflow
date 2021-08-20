/**
 * @param name {string}
 * @param url {string}
 * @param source {string}
 * @param pages {Array}
 */
const parseOnSubmit = async (name, url, source, pages= []) => {
	const formData = new FormData();

	formData.append ( 'name', name );
	formData.append ( 'home', source );

	if (pages.length) {
		pages.forEach(page => {
			formData.append ( `${page}`, `${source}/${page}` );
		});
	}

	const response = await fetch ( url, {
		method: 'POST',
		body: formData
	} );

	return await response.json ();
}

export default parseOnSubmit;