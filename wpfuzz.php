<?php
/**
 * Plugin Name: WPFuzz
 * Plugin URI: http://www.tmih-security.net/
 * Description: Generic fuzzer backend needed to scan plugins.
 * Version: 0.0.1
 * Author: TMIH
 * Author URI: http://www.tmih-security.net/
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


require( dirname(__FILE__) . "/libs/hooks.php" );



class WPFuzz {
	
	public $WPFuzzHooks;
	
	function __construct() {
		$this->WPFuzzHooks = new WPFuzzHooks();
		add_action( 'shutdown' , array( $this , 'loadHooks' ) );
	}
	
	function loadHooks() {
		global $wp_filter;
		
		return json_encode( $wp_filter );
		
	}
}

$wpfuzz = new WPFuzz();

