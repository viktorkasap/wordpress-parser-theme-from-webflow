<!DOCTYPE html>
<html lang="ru-RU">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta charset="UTF-8">
	<meta content="development" name="description">
	<meta content="Vi" property="og:title">
	<meta content="development" property="og:description">
	<meta content="Vi" property="twitter:title">
	<meta content="development" property="twitter:description">
	<meta property="og:type" content="website">

	<!-- meta images -->
	<meta property="og:image" content="./assets/images/meta.png" />
	<meta property="og:image:secure_url" content="./assets/images/meta.png" />
	<meta property="og:image:type" content="image/png" />

	<!-- favicons -->
	<link href="./assets/images/32x32d.png" rel="shortcut icon" type="image/x-icon">
	<link href="./assets/images/256x256d.png" rel="apple-touch-icon">

	<!-- styles -->
	<link rel="stylesheet" href="./assets/styles/main.css">

	<title> Vi - Parser </title>
</head>

<body>

    <header>
        <div class="container">
            <h1>Vi - Parser</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <section>
	            <div class="form-wrap">
		            <form name="form-parse">
						<div class="form-row">
							<label for="name">
								<p>Название проекта:</p>
								<input type="text" id="name" name="name" placeholder="my Project" value="Vi Project">
							</label>

							<label for="source">
								<p>Источник:</p>
								<input type="text" name="source" id="source" placeholder="https://webflow.io/..." value="https://menu-store-e3d6cf.webflow.io/">
							</label>

							<label for="pages">
								<p>Страницы через запятую:</p>
								<textarea name="pages" id="pages" cols="50" rows="3">team, employee</textarea>
							</label>
						</div>

			            <div class="form-row">
				            <div class="wrp-buttons">
					            <div class="wrp-submit">
						            <div class="submit-overlay button"></div>
						            <input type="submit" value="Отправить" data-wait="..." class="button submit">
					            </div>

				            </div>

			            </div>
		            </form>
	            </div>

	            <div class="notice"></div>

            </section>
        </div>
    </main>

    <footer>
	    <div class="container">

	    </div>
    </footer>

<script src="./assets/scripts/main.js" type="module"></script>
</body>
</html>