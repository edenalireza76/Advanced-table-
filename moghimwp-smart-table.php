<?php
/**
 * Plugin Name: ویجت جدول قیمت هوشمند المنتور (مقیم وردپرس)
 * Description: ویجت حرفه‌ای و فوق سبک المنتور برای طراحی جداول قیمت، جدول برندها با قابلیت فیلتر تب‌دار، برچسب‌های وضعیت (Pills) و کاملاً ریسپانسیو.
 * Version: 1.1.0
 * Author: علیرضا مقیمیان | مقیم وردپرس
 * Author URI: https://alirezamoghimian.ir
 * Text Domain: moghimwp-table
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class MoghimWP_Smart_Table_Addon {

	const VERSION = '1.0.0';
	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		// بررسی فعال بودن المنتور
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// ثبت استایل و اسکریپت
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'register_assets' ] );

		// ثبت ویجت در المنتور
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_assets() {
		wp_register_style(
			'moghimwp-smart-table-css',
			plugins_url( 'assets/css/smart-table.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_script(
			'moghimwp-smart-table-js',
			plugins_url( 'assets/js/smart-table.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/class-smart-table-widget.php' );
		$widgets_manager->register( new \MoghimWP_Smart_Table_Widget() );
	}
}

MoghimWP_Smart_Table_Addon::instance();