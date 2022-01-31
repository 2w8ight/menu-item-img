<?php
	/**
	 * Enqueue scripts and styles
	 * This file is to enqueue the scripts and styles both admin and front end
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	/**
	 * Enqueue front end CSS
	 */
	function menu_item_img_frontend_css() {
		wp_enqueue_style( 'menu-item-img-attachment', MENU_ITEM_IMG_PLUGIN_URL . 'css/img-attachment.css' );
	}

	add_action( 'wp_enqueue_scripts', 'menu_item_img_frontend_css' );