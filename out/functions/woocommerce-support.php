<?php

/*
 * включает поддержку страниц шаблонов woocommerce
 * без этого экшена всегда будет подключаться page.php
 */

function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'woocommerce_support' );