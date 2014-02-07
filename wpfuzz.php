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

define( '__WPFUZZ__' , dirname( __FILE__ ) );
define( '__LOGGINGLEVEL__' , E_ALL );

require( __WPFUZZ__ . "/libs/messages.php" );
require( __WPFUZZ__ . "/libs/hooks.php" );



class WPFuzz {
	
	public $WPFuzzHooks;
	
	function __construct() {
		$this->WPFuzzHooks = new WPFuzzHooks();
		add_action( 'shutdown' , array( $this , 'loadHooks' ) );
	}
	
	/**
	*	Loads every hook present in current WordPress hook stack and
	* looks for variances between regular WP actions and plugins one.
	*/
	function loadHooks() {
		$this->WPFuzzHooks->loadCurrentHooks();
	}
}

$wpfuzz = new WPFuzz();

