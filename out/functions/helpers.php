<?php

	/*
	* Dump
	*/
	function qq ( $data )
	{
		echo "<!-- DUMP START --><pre style='max-width: 980px; padding: 20px; ;overflow: auto; '>";
		print_r ( $data );
		echo "</pre><!-- DUMP END -->";
		//die();
	}

	/**
	 * Проверят какая страница
	 * возвращает значение для data-wf-page в <head data-wf-page="..."
	 * @return string
	 */
	function getWfPageAttr () : string
	{

		$dataWfPage = "";

		switch ( true ) {
			case is_front_page () :
				$dataWfPage = "0000";
				break;

			case is_404 ():
				$dataWfPage = "0001";
				break;

			case is_page_template ( 'template-pages/file-name.php' ) :
				$dataWfPage = "0002";
				break;

			default:
				$dataWfPage = "0003";
		}

		return $dataWfPage;
	}

