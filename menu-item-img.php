<?php

	/**
	 * Plugin Name:       Menu Item IMG
	 * Description:       Adding an image to menu item.
	 * Version:           1.0.0
	 * Author:            David
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       menu-item-img
	 * Domain Path:       /languages
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * Global variables
	 */
	define( 'MENU_ITEM_IMG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'MENU_ITEM_IMG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

	/**
	 * Includes
	 */
	include( MENU_ITEM_IMG_PLUGIN_PATH . 'functions/enqueue.php' );

	/**
	 * Creat admin menu item fields
	 */
	function menu_item_icon( $item_id, $item ) {
		$menu_item_icon = get_post_meta( $item_id, '_menu_item_icon', true );
		?>
        <p class="description description-wide">
            <label for="menu-item-icon-<?php echo $item_id; ?>"><?php _e( "Icon url", 'menu-item-icon' ); ?><br>
                <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>"/>
                <input type="text" name="menu_item_icon[<?php echo $item_id; ?>]"
                       id="menu-item-icon-<?php echo $item_id; ?>" class="widefat"
                       value="<?php echo esc_attr( $menu_item_icon ); ?>"/>
            </label>
        </p>
		<?php
	}

	add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_icon', 10, 2 );

	function menu_item_flag( $item_id, $item ) {
		$menu_item_flag = get_post_meta( $item_id, '_menu_item_flag', true );
		?>
        <p class="description description-wide">
            <label for="menu-item-flag-<?php echo $item_id; ?>"><?php _e( "Flag img url", 'menu-item-flag' ); ?><br>
                <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>"/>
                <input type="text" name="menu_item_flag[<?php echo $item_id; ?>]"
                       id="menu-item-flag-<?php echo $item_id; ?>" class="widefat"
                       value="<?php echo esc_attr( $menu_item_flag ); ?>"/>
            </label>
        </p>
		<?php
	}

	add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_flag', 10, 2 );

	/**
	 * Save admin menu item fields
	 */
	function save_menu_item_icon( $menu_id, $menu_item_db_id ) {
		if ( isset( $_POST['menu_item_icon'][ $menu_item_db_id ] ) ) {
			$sanitized_data = sanitize_text_field( $_POST['menu_item_icon'][ $menu_item_db_id ] );
			update_post_meta( $menu_item_db_id, '_menu_item_icon', $sanitized_data );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_icon' );
		}
	}

	add_action( 'wp_update_nav_menu_item', 'save_menu_item_icon', 10, 2 );

	function save_menu_item_flag( $menu_id, $menu_item_db_id ) {
		if ( isset( $_POST['menu_item_flag'][ $menu_item_db_id ] ) ) {
			$sanitized_data = sanitize_text_field( $_POST['menu_item_flag'][ $menu_item_db_id ] );
			update_post_meta( $menu_item_db_id, '_menu_item_flag', $sanitized_data );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_flag' );
		}
	}

	add_action( 'wp_update_nav_menu_item', 'save_menu_item_flag', 10, 2 );

	/**
	 * Show menu item Icon/Flag fields in front end
	 */
	function show_menu_item_img( $title, $item ) {
		if ( is_object( $item ) && isset( $item->ID ) ) {
			$menu_item_icon = get_post_meta( $item->ID, '_menu_item_icon', true );
			$menu_item_flag = get_post_meta( $item->ID, '_menu_item_flag', true );

			if ( ! empty( $menu_item_icon ) ) {
				$title = '<img src="' . $menu_item_icon . '" class="menu-item-img-icon menu-item-icon-' . $item->ID . '"><p class="menu-item-img-title">' . $title . '</p>';
			}

			if ( ! empty( $menu_item_flag ) && empty( $menu_item_icon ) ) {
				$title = '<p class="menu-item-img-title">' . $title . '</p><img src="' . $menu_item_flag . '" class="menu-item-img-flag menu-item-flag-' . $item->ID . '">';
			} else {
				$title .= '<img src="' . $menu_item_flag . '" class="menu-item-img-flag menu-item-flag-' . $item->ID . '">';
			}
		}

		return $title;
	}

	add_filter( 'nav_menu_item_title', 'show_menu_item_img', 10, 2 );

	/**
	 * Add menu item classes
	 */
	function add_menu_item_css_classes( $classes, $item ) {
		if ( is_object( $item ) && isset( $item->ID ) ) {
			$menu_item_icon = get_post_meta( $item->ID, '_menu_item_icon', true );
			$menu_item_flag = get_post_meta( $item->ID, '_menu_item_flag', true );
			if ( ! empty( $menu_item_icon ) || ! empty( $menu_item_flag ) ) {
				$classes[] = 'menu-item-img menu-item-img-' . $item->ID;
			}
		}

		return $classes;
	}

	add_filter( 'nav_menu_css_class', 'add_menu_item_css_classes', 10, 4 );

