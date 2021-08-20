<?php
	/**
	 * В этот файл нужно добавить верстку шаблона для автоответа
	 * Создать настройку в на странице опций в ACF 'auto-answer'
	 * для ввода своего сообщения пользователем
	 */
	$answerText = get_field('auto-answer', 'option');
	?>

	<div style="padding:30px;">
		<div style="padding:30px; border:1px solid #ccc; border-radius: 10px;"><?php echo $answerText; ?></div>
	</div>

